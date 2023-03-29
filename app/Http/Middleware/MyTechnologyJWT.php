<?php

namespace App\Http\Middleware;

use App\Http\Libraries\ResponseBuilder;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;


class MyTechnologyJWT extends BaseMiddleware {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $routName = '';
        if($request->route()->uri !== 'en/broadcasting/auth'){
            $routName = $request->route()->action['as'];
        }

        $notAuthorizedRoutes =[
            'api.subscription-package',
            'api.supplier-detail',
            'api.service.detail',
        ];

        if (!$token = $this->auth->setRequest($request)->getToken() ) {
            if(!in_array($routName,$notAuthorizedRoutes)){
                return (new ResponseBuilder(401, __('Token not provided')))->build();
            }else{
                return $next($request);
            }
        }
        try {
            JWTAuth::parseToken()->authenticate();
        }catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                logger('Invaid Err =>',[$e]);
                return responseBuilder()->error(__('Token is Invalid'));
            }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                return responseBuilder()->error(__('Token is Expired'));
            }else{
                return responseBuilder()->error(__('Authorization Token not found'));
            }
        }

//        $request->request->add(['jwt' => ['user' => $user, 'token' => $token]]);

        return $next($request);
    }

}
