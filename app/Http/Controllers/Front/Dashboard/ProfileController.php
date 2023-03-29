<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Dtos\UserPasswordChangeDto;
use App\Http\Dtos\UserProfileUpdateDto;
use App\Http\Dtos\UserRegisterDto;
use App\Http\Repositories\CityRepository;
use App\Http\Repositories\UserRepository;
use App\Http\Controllers\Controller;

use App\Http\Requests\UserRequest;
use App\Models\UserArea;
use App\Models\Withdraw;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    protected object $userRepository, $cityRepository,$withDrawRepository;

    public function __construct(UserRepository $userRepository, CityRepository $cityRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->withDrawRepository = $userRepository;
        $this->userRepository->setFromWeb(true);
        $this->cityRepository->setFromWeb(true);
        $this->withDrawRepository->setFromWeb(true);

        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
    }

    public function index()
    {
        $this->breadcrumbTitle = __('Profile');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Profile')];
        $this->userRepository->setSelect([
            'id',
            'city_id',
            'rating',
            'email',
            'phone',
            'user_type',
            'address',
            'latitude',
            'longitude',
            'image',
            'id_card_images',
            'about',
            'expiry_date',
            'user_name',
            'supplier_name',
            'visit_fee',
            'trade_license_image'

        ]);
        $coveredAreas = null;
        if ($this->user->isSupplier()) {
            $this->userRepository->setRelations(['city']);
            $coveredAreas = UserArea::where('user_id', $this->user->id)->with('area')->get();
        }
        $user = $this->userRepository->get($this->user->id);
        return view('front.dashboard.profile.index', ['user' => $user->getFormattedModel(), 'coveredAreas' => $coveredAreas]);
    }

    public function edit()
    {
        $this->breadcrumbTitle = __('Edit Profile');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Edit Profile')];
        $this->userRepository->setSelect([
            'id',
            'city_id',
            'email',
            'phone',
            'user_type',
            'address',
            'latitude',
            'longitude',
            'image',
            'trade_license_image',
            'about',
            'expiry_date',
            'supplier_name',
            'visit_fee',
            'user_name',
        ]);
        $coveredAreas = null;
        if ($this->user->isSupplier()) {
            $this->userRepository->setRelations(['city']);
            $coveredAreas = UserArea::where('user_id', $this->user->id)->with('area')->get();
        }
        $user = $this->userRepository->get($this->user->id);

        $this->cityRepository->setRelations(['areas']);

        $this->cityRepository->setSelect([
            'id',
            'name',
        ]);
        $this->cityRepository->setPaginate(0);
        $city = $this->cityRepository->get($this->user->city_id);
        return view('front.dashboard.profile.form', ['user' => $user->getFormattedModel(), 'coveredAreas' => $coveredAreas, 'city' => $city]);
    }

    public function update(UserRequest $request)
    {
        // dd($request->all());
        try {
            $request->merge(['user_id' => $this->user->id]);
            $userDto = UserProfileUpdateDto::fromRequest($request);
            $this->userRepository->save($userDto);
            return redirect(route('front.dashboard.index'))->with('status', __('Profile Updated Successfully'));
        } catch (Exception $e) {
            return redirect()->back()->with('err', __('Something Went Wrong'));
        }
    }

    public function editPassword()
    {
        $this->breadcrumbTitle = __('Change password');
        $this->breadcrumbs['javascript:{};'] = ['icon' => 'fa fa-fw fa-money', 'title' => __('Change password')];
        return view('front.dashboard.password.form');
    }

    public function updatePassword(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $passwordDto = UserPasswordChangeDto::fromRequest($request);
            $this->userRepository->changeUserPassword($passwordDto);
            DB::commit();
            return redirect(route('front.dashboard.index'))->with('status', __('Password successfully updated'));
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('err', $e->getMessage());
        }
    }
    public function payment()
    {
        $this->breadcrumbs[url(route('front.index'))] = ['title' => __('home')];
        $this->breadcrumbTitle = __('Payment Profile');
        $this->breadcrumbs['javascript: {};'] = ['title' => 'Payment Profile'];

        $withdraws = Withdraw::where('user_id', auth()->user()->id)->get();

        $amount = 0;
        if (count($withdraws) > 0) {
            foreach ($withdraws as $key => $withdraw) {
                if ($withdraw->status == 'complete') {
                    $amount += $withdraw->amount;
                }
            }
        }

        return view('front.dashboard.payment.index',['withdraws'=>$withdraws, 'amount'=>$amount]);
    }
    public function paymentUpdate(Request $request)
    {
        $request->validate([
            'client_id' => 'required',
            'secret_id' => 'required',
        ]);
        try {

            $isUserValid = $this->withDrawRepository->checkPaypalValidation($request->get('client_id'), $request->get('secret_id'));
            if ($isUserValid) {

                $this->userRepository->getQuery()->where('id',auth()->user()->id)->update(['client_id' => $request->get('client_id'), 'secret_id' => $request->get('secret_id')]);

                return redirect()->back()->with('status', __('Payment profile updated successfully.'));
            }
            return redirect()->back()->with('err', __('Credential is not Valid.'));
        } catch (Exception $e) {
            return redirect()->back()->with('Something went wrong');
        }
    }
    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required'
        ]);
        if ($request->amount > auth()->user()->available_balance) {
            return redirect()->back()->with('err', __('Amount is greater than available amount.'));
        }
        $withdraw = $this->withDrawRepository->save($request, $fromWeb = true);
        if ($withdraw == false) {
            return redirect()->back()->with('err', __('One request already in queue.'));
        }
        if ($withdraw) {
            return redirect()->back()->with('status', __('Withdraw request successful.'));
        }

        return redirect()->back()->with('err', __('Something went wrong.'));
    }
}
