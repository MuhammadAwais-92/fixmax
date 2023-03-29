<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class EmailVerified {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $user = auth()->user();
        if (!$user->isVerified()){
            return redirect(route('front.auth.verification'));
        }
        $message = __('Your account has been suspended. Please contact the admin.');
        if(!$user->isActive()){
            auth()->logout();
            session()->forget('USER_DATA');
            throw ValidationException::withMessages([
                'email' => [$message],
            ]);
        }
        return $next($request);
    }

}
