<?php


namespace App\Http\Repositories;
use App\Http\Dtos\ReviewSaveDto;
use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Review;

class ReviewRepository extends Repository
{

    protected $reviews;
    protected $userRepository;
    protected $orderRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->orderRepository = new OrderRepository(new UserRepository,new CouponRepository,new AddressRepository,new OrderItemsRepository);
        $this->setModel(new Review());
    }
    public function save(ReviewSaveDto $params)
    {
        $user = $this->userRepository->get($params->user_id);
        $data = $params->except('id')->toArray();
        $query = $this->getQuery();
        $review = $query->updateOrCreate(['id' => $params->id], $data);

        if ($params->is_reviewed){
            $query = $this->getQuery();
            $order = $this->orderRepository->get($params->order_id);
            if ($params->supplier_id > 0){
                $averageRating = $query->where('supplier_id', $params->supplier_id)->where('is_reviewed', true)->avg('rating');
                if (is_null($averageRating)){
                    $averageRating = 0;
                }
                $userQuery = $this->userRepository->getquery();
                $userQuery->where('id', '=', $params->supplier_id)->update(['rating' => $averageRating]);
                sendNotification([
                    'sender_id' => $user->id,
                    'receiver_id' => $order->supplier_id,
                    'extras->supplier_id' => $order->supplier_id,
                    'extras->service_name' => $order->service_name,
                    'title->en' => 'New Rating Given',
                    'title->ar' => 'تقييم جديد معطى', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                    'title->ru' => 'Дан новый рейтинг',
                    'title->ur' => 'نئی ریٹنگ دی گئی۔',
                    'title->hi' => 'नई रेटिंग दी गई',
                    'description->en' => '<p class="p-text">A buyer has given a new rating to you. Please visit Rating and Reviews page for latest rating.</p>',
                    'description->ar' => '<p class="p-text">أعطى المشتري تصنيفًا جديدًا لك. يرجى زيارة صفحة التقييم والمراجعات للحصول على أحدث التقييمات.</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                    'description->ru' => '<p class="p-text">Покупатель дал вам новую оценку. Пожалуйста, посетите страницу рейтинга и отзывов для последней оценки.</p>',
                    'description->ur' => '<p class="p-text">ایک خریدار نے آپ کو ایک نئی درجہ بندی دی ہے۔ تازہ ترین درجہ بندی کے لیے براہ کرم درجہ بندی اور جائزے کا صفحہ دیکھیں۔</p>',
                    'description->hi' => '<p class="p-text">एक खरीदार ने आपको एक नई रेटिंग दी है। नवीनतम रेटिंग के लिए कृपया रेटिंग और समीक्षा पृष्ठ पर जाएं।</p>',                    
                    'action' => 'SUPPLIER_REVIEWED'
                ]);

            }else{
                $averageRating = $query->where('service_id', $params->service_id)->where('is_reviewed', true)->avg('rating');
                if (is_null($averageRating)){
                    $averageRating = 0;
                }
                $serviceRepository = new ServiceRepository();
                $serviceQuery = $serviceRepository->getQuery();
                $serviceQuery->where('id', '=', $params->service_id)->update(['average_rating' => $averageRating]);
                sendNotification([
                    'sender_id' => $user->id,
                    'receiver_id' =>  $order->supplier_id,
                    'extras->service_id' =>  $order->supplier_id,
                    'extras->service_slug' => $order->service->slug,
                    'extras->service_name' => $order->service_name,
                    'title->en' => 'New Rating On a service' ,
                    'title->ar' => 'تصنيف جديد على خدمة', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                    'title->ru' => 'Новый рейтинг на сервисе' ,
                    'title->ur' => 'سروس پر نئی درجہ بندی' ,
                    'title->hi' => 'एक सेवा पर नई रेटिंग' ,                   
                    'description->en' => '<p class="p-text">A buyer has given a new rating to your service <span>'.translate($order->service_name).'</span>. Please visit service page to check latest rating.</p>',
                    'description->ar' => '<p class="p-text">منح المشتري تقييمًا جديدًا لخدمتك <span>'.translate($order->service_name).'</span>. يرجى زيارة صفحة الخدمة للتحقق من أحدث تقييم.</p>', // TODO:: NOTIFICATION_TRANSLATION_REQUIRED
                    'description->ru' => '<p class="p-text">Покупатель дал новую оценку вашей услуге <span>'.translate($order->service_name).'</span>. Пожалуйста, посетите страницу службы, чтобы проверить последний рейтинг.</p>',
                    'description->ur' => '<p class="p-text">ایک خریدار نے آپ کی سروس کو ایک نئی درجہ بندی دی ہے <span>'.translate($order->service_name).'</span>۔ تازہ ترین درجہ بندی چیک کرنے کے لیے براہ کرم سروس کا صفحہ دیکھیں۔</p>',
                    'description->hi' => '<p class="p-text">एक खरीदार ने आपकी सेवा <span>'.translate($order->service_name).'</span> को एक नई रेटिंग दी है। नवीनतम रेटिंग की जांच के लिए कृपया सेवा पृष्ठ पर जाएं।</p>',                    
                    'action' => 'SERVICE_REVIEWED'
                ]);
            }
        }
        return $review;

    }
    public function all($user_id = 0, $supplier_id = 0, $service_id = 0,$order_id=0, $is_reviewed = false)
    {
        $query = $this->getQuery()->where('is_reviewed', $is_reviewed);
        if ($user_id > 0){
            $query->where('user_id', $user_id);
        }
        if ($supplier_id > 0){
            $query->where('supplier_id', $supplier_id);
        }
        if ($service_id > 0){
            $query->where('service_id', $service_id);
        }
        if ($order_id > 0){
            $query->where('order_id', $order_id);
        }
        if ($this->getPaginate() > 0){
            return  $query->orderBy('id','DESC')->select($this->getSelect())->with($this->getRelations())->paginate($this->getPaginate(),['*'],'reviews');
        }else{
            return $query->orderBy('id','DESC')->select($this->getSelect())->with($this->getRelations())->get();
        }

    }
    public function get($id = 0)
    {
        $param = null;
        if ($id > 0) {
            $param = $this->getModel()->with($this->getRelations())->find($id);
        }
        return $param;
    }
    public function getBars($reviewBars)
    {
        $r=0;
        $r1=0;
        $r2=0;
        $r3=0;
        $r4=0;
        $r5=0;
        $rewBar=array();
        if($reviewBars->isNotEmpty())
        {
            $r=$reviewBars->count();
            foreach($reviewBars as $review)
            {
                if($review->rating > 0  && $review->rating <= 1)
                {
                    $r1=$r1+1;
                }
                if($review->rating > 1  && $review->rating <= 2)
                {
                    $r2=$r2+1;

                }
                if($review->rating > 2  && $review->rating <= 3)
                {
                    $r3=$r3+1;
                }
                if($review->rating > 3  && $review->rating <= 4)
                {
                    $r4=$r4+1;
                }
                if($review->rating > 4  && $review->rating <= 5)
                {
                    $r5=$r5+1;
                }
            }
            $rewBar['0']=($r1/$r)*100;
            $rewBar['1']=($r2/$r)*100;
            $rewBar['2']=($r3/$r)*100;
            $rewBar['3']=($r4/$r)*100;
            $rewBar['4']=($r5/$r)*100;
        }
  

        return $rewBar;
    }
}
