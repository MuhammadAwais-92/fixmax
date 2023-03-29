<?php

namespace App\Http\Controllers\Api;


use App\Http\Dtos\UserPasswordChangeDto;
use App\Http\Dtos\UserProfileUpdateDto;
use App\Http\Dtos\UserRegisterDto;
use Exception;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Repositories\UserRepository;
use App\Http\Repositories\CityRepository;
use App\Http\Repositories\FcmRepository;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserArea;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;


class UsersController extends Controller
{
    public $userRepository;

    public function __construct(UserRepository $userRepository, CityRepository $cityRepository,FcmRepository $fcmRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->fcmRepository  =$fcmRepository;
    }

    public function login(UserRequest $request)
    {
        try {
            $token = NULL;
            $user = NULL;
            $customClaims = ['fcm_token' => $request->get('fcm_token', '')];
            if (!empty($request->email) && !empty($request->password)) {
                $credentials = $request->only(['email', 'password']);
                $token  = JWTAuth::attempt($credentials);
            } else {   // login with google / facebook
                $socialLoginColumn = 'google_id';
                if (!empty($request->facebook_id)) {
                    $socialLoginColumn = 'facebook_id';
                }
                // check if user exists
                $userExists = User::where([$socialLoginColumn => $request->$socialLoginColumn])->first();
                if (!empty($userExists)) {
                    $user = $userExists;
                    $customClaims['user_id'] = $user->id;
                    $token = JWTAuth::fromUser($user, $customClaims);
                } else {
                    // try to find with email
                    $userExists = User::where(['email' => $request->email])->first();
                    if (!empty($userExists)) {
                        $userExists->$socialLoginColumn = $request->$socialLoginColumn;
                        $userExists->save();
                        $user = $userExists;
                        $customClaims['user_id'] = $user->id;
                        $token = JWTAuth::fromUser($user, $customClaims);
                    } else {
                        // create user
                        return responseBuilder()->error(__('please register'));
                    }
                }
            }

            if ($token) {
                $user = JWTAuth::setToken($token)->toUser();
                $user->checkIfActive();
                if ($request->has('fcm_token')) {
                    $user->update(['fcm_token' => $request->get('fcm_token')]);
                    $this->fcmRepository->save($request, $user, $id = null);
                }
                if (auth()->user()->isSupplier()) {
                    $this->userRepository->setRelations(['city']);
                    $coveredAreas = null;
                    $coveredAreas = UserArea::where('user_id', auth()->user()->id)->with('area')->get();
                    return responseBuilder()->success(__('Login successful'), ['user' => $user->getFormattedModel(true, false), 'coveredAreas' => $coveredAreas]);
                }
                return responseBuilder()->success(__('Login successful'), ['user' => $user->getFormattedModel(true, false)]);
            }
            throw new Exception(__('Credentials does not match our records'));
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function register(UserRequest $request)
    {
        try {
           
            $userDto = UserRegisterDto::fromRequest($request);
    
            $user = $this->userRepository->save($userDto);
            if (!$user->isVerified()) {
                $this->userRepository->sendEmailVerification('verification', $user->email);
            }
            return responseBuilder()->success(__('User Register Successfully'), ['user' => $user->getFormattedModel(true, false)]);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function verifyEmail(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->emailVerification($request->get('verification_code'));
            if ($user) {
                DB::commit();
                return responseBuilder()->success(__('Email verified'), ['user' => $user]);
            }
            throw new Exception(__('Verification code does not match'));
        } catch (Exception $e) {
            DB::rollBack();
            return responseBuilder()->error($e->getMessage());
        }
    }
    public function destroy()
    {
        $user = auth()->user();
        if($user)
        {
            $user=$this->userRepository->destroy(auth()->user()->id);
            return responseBuilder()->success(__('Profile Deleted Successfully.'));
        }
        return responseBuilder()->error(__('Something Went Wrong'));

    }
    public function resendVerificationCode()
    {
        try {
            $email = $this->userRepository->sendEmailVerification();
            if ($email) {
                return responseBuilder()->success(__('Verification code resent successfully.'));
            }
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function forgotPassword(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $user = $this->userRepository->sendEmailVerification('forgot_password', $request->get('email'));
            if ($user) {
                DB::commit();
                return responseBuilder()->success(__('Password reset code has been sent'));
            }
        } catch (Exception $e) {
            DB::rollBack();
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function resetPassword(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'verification_code' => ['required'],
                'email' => ['required', 'email'],
                'password' => ['required', 'confirmed'],
            ]);
            $this->userRepository->resetPassword($request->get('verification_code'), $request->get('email'), $request->get('password'));
            DB::commit();
            return responseBuilder()->success(__('Password reset successfully.'));
        } catch (\Exception $e) {
            DB::rollBack();
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function changePassword(UserRequest $request)
    {
        DB::beginTransaction();
        try {
            $passwordDto = UserPasswordChangeDto::fromRequest($request);
            $this->userRepository->changeUserPassword($passwordDto);
            DB::commit();
            return responseBuilder()->success(__('Password successfully updated'));
        } catch (Exception $e) {
            DB::rollBack();
            return responseBuilder()->error($e->getMessage());
        }
    }

    public function editProfile()
    {
        $user = auth()->user();
        if ($user->isSupplier()) {
            $coveredAreas = null;

            $this->userRepository->setRelations(['city']);
            $coveredAreas = UserArea::where('user_id', $user->id)->with('area')->get();

            $this->cityRepository->setRelations(['areas']);

            $this->cityRepository->setSelect([
                'id',
                'name',
            ]);
            $this->cityRepository->setPaginate(0);
            $city = $this->cityRepository->get($user->city_id);
            return responseBuilder()->success(__('Logged in user'), ['user' => $user->getFormattedModel(true, false), 'coveredAreas' => $coveredAreas, 'city' => $city]);
        }


        return responseBuilder()->success(__('Logged in user'), ['user' => $user->getFormattedModel(true, false)]);
    }
    public function notiCount()
    {
        Notification::where(['receiver_id' => auth()->user()->id])->update(['is_seen' => 1, 'is_read' => 1]);
    }
    public function updateProfile(UserRequest $request)
    {
        try {
            $request->merge(['user_id' => auth()->id()]);
            $userDto = UserProfileUpdateDto::fromRequest($request);
            $user = $this->userRepository->save($userDto);
            return responseBuilder()->success(__('Profile Updated Successfully'), ['user' => $user->getFormattedModel(true)]);
        } catch (Exception $e) {
            return responseBuilder()->error(__('Something Went Wrong'));
        }
    }
    public function logout(Request $request)
    {
        try {
            $userId = auth('api')->user()->id;
            $user = $this->userRepository->logout($userId,$request->fcm_token);
            return responseBuilder()->success(__('Logout Successfully'), ['user' => null]);
        } catch (Exception $e) {
            return responseBuilder()->error($e->getMessage());
        }
    }
}
