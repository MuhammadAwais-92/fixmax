<?php

namespace App\Http\Controllers\Api;

use App\Http\Libraries\ResponseBuilder;
use App\Http\Repositories\NotificationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{

    /**
     * @var NotificationRepository
     */
    private $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {
        parent::__construct();
        $this->notificationRepository = $notificationRepository;

    }

    public function notifications(Request $request)
    {
        $this->notificationRepository->setPaginate(10);
        $notifications = $this->notificationRepository->list();

        $response = new ResponseBuilder(200, 'Notifications', $notifications);
        return $response->build();
    }

    public function notificationCount($type = '')
    {
        $notificationCount = $this->notificationRepository->count();
        $response = new ResponseBuilder(200, 'Notifications count', ['notificationCount' =>$notificationCount]);
        return $response->build();
    }

    public function isSeen()
    {
        $this->notificationRepository->seenAll();
        $response = new ResponseBuilder(200, 'notification seen');
        return $response->build();
    }

    public function isViewed($notificationId)
    {
        $this->notificationRepository->read($notificationId);
        $response = new ResponseBuilder(200, 'notification viewed');
        return $response->build();
    }

    public function deleteNotification(Request $request)
    {
        $this->notificationRepository->delete($request);
        $response = new ResponseBuilder(200, 'notification deleted', []);
        return $response->build();
    }

}
