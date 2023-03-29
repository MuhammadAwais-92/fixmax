<?php

namespace App\Http\Controllers\Front\Auth;

use App\Http\Dtos\UserRegisterDto;
use App\Http\Repositories\UserRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Repositories\CityRepository;
use App\Http\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class RegisterController extends Controller
{
    protected $redirectTo = '/verification';
    protected UserRepository $userRepository;
    protected CityRepository $cityRepository;
    protected CategoryRepository $categoryRepository;


    public function __construct(UserRepository $userRepository, CityRepository $cityRepository,  CategoryRepository $categoryRepository)
    {
        $this->middleware('guest');
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->userRepository->setFromWeb(true);
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];

    }

    public function showRegistrationPage(){
        $this->breadcrumbTitle = __('Register');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Register')];
        $this->cityRepository->setSelect([
            'id',
            'name'
        ]);
        $cities = $this->cityRepository->all(true);
        $this->categoryRepository->setSelect([
            'id',
            'name'
        ]);
        $categories = $this->categoryRepository->all(true);
        return view('front.auth.register', [
            'cities' => $cities,
            'categories' => $categories,
        ]);
    }

    public function showRegistrationForm($type)
    {
        $this->breadcrumbTitle = __('Register as user');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Register as user')];
        if ($type == 'supplier'){
            $this->breadcrumbTitle = __('Register as supplier');
            $this->breadcrumbs['javascript: {};'] = ['title' => __('Register as supplier')];
        }

        $cities = $this->cityRepository->all();
        return view('front.auth.register', [
            'cities' => $cities,
            'type' => $type,
        ]);
    }

    public function register(UserRequest $request)
    {
        try {
            $registerData = UserRegisterDto::fromRequest($request);
            $user = $this->userRepository->save($registerData);
            Auth::guard()->login($user);
            if (!$user->isVerified()){
                $this->userRepository->sendEmailVerification('verification',$user->email);
            }
            $user = $user->getFormattedModel(true, true);
            session()->flash('status', __('Registration successful.'));
            return redirect(route('front.dashboard.index'));

        } catch (\Exception $e) {
            return redirect()->back()->with('err',$e->getMessage())->withInput();
        }

    }


}
