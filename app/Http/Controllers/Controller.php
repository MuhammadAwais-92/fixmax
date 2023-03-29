<?php

namespace App\Http\Controllers;

use App\Http\Repositories\CityRepository;
use App\Http\Repositories\NotificationRepository;
use App\Models\City;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $user, $breadcrumbs, $breadcrumbTitle;

    public function __construct($userDataKey = 'userData', $guard = null, $getUserCallback = null)
    {

        $this->middleware(function ($request, $next) use ($guard, $getUserCallback) {
            $this->user = ($guard == 'admin') ? session('ADMIN_DATA') : session('USER_DATA');
            if ($getUserCallback) {
                $getUserCallback($this->user);
            }
            return $next($request);
        });

        View::composer('*', function ($view) use ($userDataKey, $guard) {
            $languages = [];
            $segments = request()->segments(1);
            $queryParams = explode('?', request()->fullUrl());

            foreach (cache('LANGUAGES') as $lang) {
                if( $lang['short_code']==config('settings.default_language') || $lang['short_code']=='en' )

                {
                    $segments[0] = $lang['short_code'];
                    $languages[$lang['short_code']] = [
                        'title' => $lang['title'],
                        'url' => url(implode('/', $segments). ((count($queryParams) > 1) ? '?'.$queryParams[1]:'')),
                        'is_rtl' => $lang['is_rtl']
                    ];
                }
           
            }
            foreach (cache('LANGUAGES') as $lang) {
                if($lang['short_code']!='en' || $lang['short_code']!=config('settings.default_language'))

                {
                    $segments[0] = $lang['short_code'];
                    $languages[$lang['short_code']] = [
                        'title' => $lang['title'],
                        'url' => url(implode('/', $segments). ((count($queryParams) > 1) ? '?'.$queryParams[1]:'')),
                        'is_rtl' => $lang['is_rtl']
                    ];
                }
            }
        
            $notificationCount = 0;
            $notifications    = new Collection();
            if (\Auth::check()) {
                $notificationRepository = new NotificationRepository();
                $notificationRepository->setFromWeb(true);
                $notificationCount = $notificationRepository->count();
                $notifications = $notificationRepository->list();
            }
            $cityRepository = new CityRepository();
            $cityRepository->setFromWeb(true);
            $cityRepository->setRelations(['areas']);
            $cityRepository->setSelect([
                'id',
                'name'
            ]);
            $cities = $cityRepository->allCities(true);
            if (!$guard) {
                $cities = City::where('parent_id', 0)->where('deleted_at', null)->get();
                $view->with([
                    'userData' => $this->user,
                    'locale' => config('app.locale'),
                    'currency' => config('app.currency'),
                    'maintenance_mode' => session('maintenanceMode', 1),
                    'locales' => cache()->get('LANG'),
                    'fronCities' => $cities,
                    'notificationCount' => $notificationCount,
                    'notifications'     => $notifications,
                    'breadcrumbs' => $this->breadcrumbs,
                    'cities' => $cities,
                    'languages'=>$languages,
                    'breadcrumbTitle' => $this->breadcrumbTitle,
                ]);
            } else {
                $view->with([
                    'maintenance_mode' => session('maintenanceMode', 1),
                    'breadcrumbs' => $this->breadcrumbs,
                    'breadcrumbTitle' => $this->breadcrumbTitle,
                    'locale' => config('app.locale'),
                    'admin' => $this->user,
                    'adminData' => $this->user,
                    'locales' => config('app.locales'),
                    'languages'=>$languages,

                ]);
            }
        });
    }
}
