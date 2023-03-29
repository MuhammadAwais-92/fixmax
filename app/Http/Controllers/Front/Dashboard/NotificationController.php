<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Models\Notification;
use App\Http\Controllers\Controller;
use App\Http\Repositories\NotificationRepository;

class NotificationController extends Controller
{
    private $notificationRepository;

    public function __construct() {
        parent::__construct();
        $this->notificationRepository  = new NotificationRepository();
        $this->breadcrumbs[route('front.dashboard.index')] = ['title' => __('Profile')];
        $this->notificationRepository->setFromWeb(true);
    }

    public function index(){
        $page = request('page', 1);
        $this->breadcrumbTitle = __('Notifications');
        $this->breadcrumbs['javascript: {};'] = ['title' => __('Notifications')];
        $this->notificationRepository->setPaginate(20);

        $notifications = $this->notificationRepository->list();
        return view('front.dashboard.notifications.notification', ['notifications' => $notifications, 'page' => $page]);
    }
}
