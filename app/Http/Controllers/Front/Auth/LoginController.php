<?php

namespace App\Http\Controllers\Front\Auth;


use App\Http\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Google\Service\Fitness\Session;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */
//    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $userRepository;

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->breadcrumbTitle = 'Sitemap';
        parent::__construct();
        $this->userRepository = new UserRepository;
        $this->userRepository->setFromWeb(true);
    }
    protected function login(Request $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);
            if (auth()->attempt($credentials)) {
                $user = auth()->user();
                $user->checkIfActive();
                $user->getFormattedModel(true,true);
                if($user->isSupplier())
                {
                
                    if($user->visit_fee)
                    {
                        session()->flash('status', __('Login Successful.'));
                    }
                    else
                    {
                        session()->flash('status', __('Login Successful. Please Add visit fee from profile'));
                    }
                
                }
                else
                {
                    if(session()->get('slug')!=null)
                    {
                        session()->flash('status', __('Login Successful.'));
                        $slug=session()->get('slug');
                        session()->put('slug','');
                        return redirect(route('front.service.detail',$slug));
                    }

                    session()->flash('status', __('Login Successful.'));
                }
                return redirect(route('front.dashboard.index'));
            }else{
                throw new \Exception(__('credentials did not match'));
            }
        }catch (\Exception $e){
            throw ValidationException::withMessages([
                'email' => [$e->getMessage()],
            ]);
        }

    }
    public function logout(Request $request)
    {
//        $user = session('USER_DATA');
//        if (isset($user['token'])){
//            $tokenId = explode('|',$user['token'])[0];
//            auth()->user()->tokens()->where('id', $tokenId)->delete();
//        }

        auth()->logout();
        session()->flash('status', __('Logout Successfully!'));
        session()->forget('USER_DATA');
        return redirect('/' . config('app.locale'));
    }
    public function showLoginForm()
    {
        $this->breadcrumbTitle = __('Login or Create An Account');
        $this->breadcrumbs[route('front.index')] = ['title' => __('Home')];
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Account')];
//            dd("welcome to show login form");
        // $countries = $this->countryRepository->all(true,true);

        return view('front.auth.login');
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }
    public function redirectTo()
    {
        return config('app.locale') . '/dashboard';
    }

}
