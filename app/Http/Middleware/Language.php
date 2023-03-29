<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\Language as Lang;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Foundation\Application;

class Language {

    public function __construct(Application $app, Redirector $redirector, Request $request) {
        $this->app = $app;
        $this->redirector = $redirector;
        $this->request = $request;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $locales = [];
        $cache = cache();


        if (!$cache->has('LANGUAGES')) {
            $languages = Lang::get()->toArray();
            foreach ($languages as $key => $lang) {
                $locales[] = $lang['short_code'];
            }
           
            $expiresAt = Carbon::now()->addHours(env('HOURS_TO_EXPIRE_LANGUAGES_CACHE'));
            $cache->put('LANG', $locales, $expiresAt);

            $cache->put('LANGUAGES', $languages, $expiresAt);
        }
        else {
            $locales = $cache->get('LANG');
        }
        $locale = $request->segment(1);
       

        if (!in_array($locale, $locales)) {
            $segments = array_merge([config('settings.default_language') ? config('settings.default_language') : $this->app->config->get('app.fallback_locale') ], $request->segments());

            if ($this->request->expectsJson()) {
//                return response()->json(['Invalid/missing language parameter!']);
                return responseBuilder()->error('Invalid/missing language parameter!');
            }
            else {
                return $this->redirector->to(implode('/', $segments));

            }
        }
        $this->app->setLocale($locale);
        return $next($request);


//         $locales = $this->app->config->get('app.locales');
//         $locale = $request->segment(1);
//         if (!in_array($locale, $locales)) {
//             $segments = array_merge([$this->app->config->get('app.fallback_locale')], $request->segments());

//             if ($this->request->expectsJson()) {
// //                return response()->json(['Invalid/missing language parameter!']);
//                 return responseBuilder()->error('Invalid/missing language parameter!');
//             }
//             else {
//                 return $this->redirector->to(implode('/', $segments));

//             }
//         }
//         $this->app->setLocale($locale);
//         return $next($request);
    }

}
