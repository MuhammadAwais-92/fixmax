<?php

use App\Http\Libraries\Uploader;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use App\Http\Libraries\ResponseBuilder;
use App\Models\Notification;
use App\Models\User;
use App\Models\Fcm;
use Illuminate\Pagination\LengthAwarePaginator;


function imageUrl($path, $width = NULL, $height = NULL, $quality = NULL, $crop = NULL)
{
    if (!$width && !$height) {
        return $url = env('IMAGE_URL') . $path;
    } else {
        if (is_string($path)) {
            if (str_contains($path, url('/'))) {
                $path = str_replace(url('/'), '', $path);
            }
                    //    $url = env('APP_URL') . '/images/timthumb.php?src=' . env('APP_URL') . $path; // for IMAGE_LOCAL_PATH
            $url = env('APP_URL') . '/images/timthumb.php?src=' . $path; // for IMAGE_LIVE_PATH
            if (isset($width)) {
                $url .= '&w=' . $width;
            }
            if (isset($height) && $height > 0) {
                $url .= '&h=' . $height;
            }
            if (isset($crop)) {
                $url .= "&zc=" . $crop;
            } else {
                $url .= "&zc=1";
            }
            if (isset($quality)) {
                $url .= '&q=' . $quality . '&s=0';
            } else {
                $url .= '&q=95&s=0';
            }
            // $url = env('APP_URL') . $path; // for IMAGE_LIVE_PATH

            return $url;
        }
    }
}

// function translate(array $data)
// {
//     $locale = app()->getLocale();
//     if (isset($data['en']) && isset($data['ar'])) {
//         if ($locale == 'ar' && $data['ar'] == '') {
//             return $data['en'];
//         } else {
//             return $data[$locale];
//         }
//     } else {
//         return 'Error! data not correctly set';
//     }
// }
function translate(array $data)
{
    $locale = app()->getLocale();
    if (isset($data[$locale]) && $data[$locale]!='') {

            return $data[$locale];
        
    } else {
        return $data['en'];
    }
}
function deleteImage($path = '')
{
    // $fullPath = env('PUBLIC_PATH') . $path;
    if (File::exists($path)) {
        unlink($path);
    } else {
        return false;
    }
}

function responseBuilder()
{
    $responseBuilder = new ResponseBuilder();
    return $responseBuilder;
}

/**
 * @throws Exception
 */
function uploadImage($file, $path = 'media', $input = 'image')
{
    try {
        $imageUploadedPath = '';
        $uploader = new Uploader();
        $uploader->setFile($file);
        if ($uploader->isValidFile()) {
            $uploader->upload($path, $uploader->fileName);
            if ($uploader->isUploaded()) {
                $imageUploadedPath = $uploader->getUploadedPath();
            }
        }
        if (!$uploader->isUploaded()) {
            throw new Exception(__('Something went wrong'));
        }
        $data['file_name'] = $imageUploadedPath;
        $data['file_path'] = url($imageUploadedPath);

        return $data;
    } catch (Exception $e) {
        throw new Exception($e->getMessage());
    }
}
function sendNotification($data)
{
    $receiver = User::where(['id' => $data['receiver_id']])->first();
    if ($receiver) {
        if ($receiver->settings == 1) {
            $notification = Notification::create($data);

            $fcmTokens = Fcm::where('user_id', $receiver->id)->get();
            foreach ($fcmTokens as $token) {
                sendFCM([
                    'fcm_token' => $token->fcm_token,
                    'title'     => $notification->title['en'],
                    'body'      => $notification->description['en'],
                    'data'      => $notification,
                ]);
            }
            event(new \App\Events\NewNotifications($notification));
        }
    }
}
function sendFCM($data)
{
    if (!empty($data['fcm_token'])) {
        logger('=========FCM RESULT Data============', [$data]);
        $fields = array(
            'to' => $data['fcm_token'],
            'content_available' => true,
            'priority' => "high",
            'notification' => array('title' => $data['title'], 'body' => $data['body'], 'sound' => 'default'),
            'data' => $data['data'],
        );

       return pushFCMNotification($fields);
    }
}
function generateRandomString($length = 8)
{
    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString     = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function pushFCMNotification($fields)
{
    $headers = array(
        env('FCM_URL'),
        'Content-Type: application/json',
        'Authorization: key=' . env('FCM_SERVER_KEY')
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, env('FCM_URL'));
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    $result = curl_exec($ch);
    logger('=========FCM RESULT============', [$result]);
    curl_close($ch);

    if ($result === FALSE) {
        return false;
    }
    $res = json_decode($result);

    logger('=========FCM============', [$res]);
    if (isset($res->success)) {
        return $res;
    } else {
        return '$result';
    }
}
function multiImageUpload(array $params = [], $path = 'media')
{
    $notImage = false;
    $imgData = [];

    $imgArray = null;
    $carOriginal = null;
    if (isset($data['images']) && count($data['images']) > 0) {
        $uploader = new Uploader();
        foreach ($data['images'] as $key => $img) {
            if (is_object($img)) {
                $uploader->setFile($img);
                if ($uploader->isValidFile()) {
                    $uploader->upload($path, $uploader->fileName);
                    if (!$uploader->isUploaded()) {
                        return responseBuilder()->error(__('Something went Wrong'));

                        $imgArray[$key]['f_name'] = $uploader->fileName;
                        $imgArray[$key]['db_path'] = $uploader->getUploadedPath();
                        $imgArray[$key]['url'] = url($uploader->getUploadedPath());
                    }
                }
            }
        }
    }

    return $imgArray;
}

function getPrice($price, $currency = 'AED')
{
    return $currency . ' ' . $price;
}
function set_alert($type, $message)
{
    session()->flash('alert_type', $type);
    session()->flash('alert_message', $message);
}
function unixTODateformate($date)
{
    return Carbon::parse(gmdate("Y-m-d H:i:s", $date))->addHours(24)->format('Y-m-d');
}
function DateToUnixformat($date)
{

    $dateTime = new DateTime($date);

    $timestamp = $dateTime->format('U');

    return $timestamp;
}
function unixTODateformateForHuman2($date)
{
    return Carbon::createFromTimestamp($date)->diffForHumans();
    // return Carbon::parse(gmdate("Y-m-d", $date))->diffForHumans();
}
function Check_is_in_polygon($count_point, $polygon_x, $polygon_y, $long, $lat)
{
  
    $i = $j = $c = 0;
    for ($i = 0, $j = $count_point; $i < $count_point; $j = $i++) {
        if ((($polygon_y[$i] > $lat != ($polygon_y[$j] > $lat)) &&
            ($long < ($polygon_x[$j] - $polygon_x[$i]) * ($lat - $polygon_y[$i]) / ($polygon_y[$j] - $polygon_y[$i]) + $polygon_x[$i])))
            $c = !$c;
    }
    return $c;
}
function unixConversion($duration_type, $duration, $created_at)
{
    $hours = 24;
    $minutes = 60;
    $sec = 60;
    if ($duration_type == "years") {
        $days = 365;
        $total_days = $duration * $days;
        $total_hours_in_days = $hours * $total_days;
        $total_hours_in_min = $minutes * $total_hours_in_days;
        $total_hours_in_sec = $sec * $total_hours_in_min;
        $unixTime = $total_hours_in_sec + $created_at;
    } elseif ($duration_type == "months") {
        $months_of_Days = 30;
        $total_days = $duration * $months_of_Days;
        $total_hours_in_days = $hours * $total_days;
        $total_hours_in_min = $minutes * $total_hours_in_days;
        $total_hours_in_sec = $sec * $total_hours_in_min;
        $unixTime = $total_hours_in_sec + $created_at;
    } elseif ($duration_type == "days") {
        $total_days = $duration;
        $total_hours_in_days = $hours * $total_days;
        $total_hours_in_min = $minutes * $total_hours_in_days;
        $total_hours_in_sec = $sec * $total_hours_in_min;
        $unixTime = $total_hours_in_sec + $created_at;
    }
    return $unixTime;
}

function getUsdPrice($price)
{
    $price = $price * getConversionRate();
    return number_format($price, 2, '.', '');
}
function getConversionRate()
{
    return config('settings.aed_to_usd', 0.2665916655);
}
function paginate($items, $url, $perPage = 10, $removeKeys = false)
{
    $page = LengthAwarePaginator::resolveCurrentPage();
    $productCollection = collect($items);
    if ($removeKeys) {
        $currentPageproducts = $productCollection->slice(($page * $perPage) - $perPage, $perPage)->values()->all();
    } else {
        $currentPageproducts = $productCollection->slice(($page * $perPage) - $perPage, $perPage)->all();
    }
    $paginatedproducts = new LengthAwarePaginator($currentPageproducts, count($productCollection), $perPage, $page);
    $paginatedproducts->setPath($url);
    return $paginatedproducts;
}
function getLanguage($code)
{
    foreach (cache('LANGUAGES') as $lang) 
    {
        if($lang['short_code']==$code)
        {
            return $lang['title'];
        }
    }
}

function getStarRating($value)
{
    $star_rate = $value;
    if ($value > 0 && $value < 0.5) {
        $star_rate = 0.5;
    }
    if ($value > 0.5 && $value < 1) {
        $star_rate = 1.0;
    }
    if ($value > 1 && $value < 1.5) {
        $star_rate = 1.5;
    }
    if ($value > 1.5 && $value < 2) {
        $star_rate = 2.0;
    }
    if ($value > 2 && $value < 2.5) {
        $star_rate = 2.5;
    }
    if ($value > 2.5 && $value < 3) {
        $star_rate = 3.0;
    }
    if ($value > 3 && $value < 3.5) {
        $star_rate = 3.5;
    }
    if ($value > 3.5 && $value < 4) {
        $star_rate = 4;
    }
    if ($value > 4 && $value < 4.5) {
        $star_rate = 4.5;
    }
    if ($value > 4.5 && $value < 5) {


        $star_rate = 5.0;
    }
    if ($value > 5) {
        $star_rate = 5.0;
    }

    return $star_rate;
}
