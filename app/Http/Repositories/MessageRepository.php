<?php


namespace App\Http\Repositories;



use App\Events\SendMessage;
use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Message;
use Carbon\Carbon;

class MessageRepository extends Repository
{
    public function __construct(Message $message)
    {
        $this->setModel(new Message());
    }

    public function list($request){
        $user=$this->getUser();
//        dd($user);
        if ($user->user_type=="supplier"){
            $check='user2_deleted';
        }else{
            $check='user1_deleted';
        }

        $messages = Message::orderBy('created_at', 'desc')
            ->where('conversation_id', $request->conversation_id)
            ->where($check, null)
            ->select('id','conversation_id','mime_type','message','file','sender_id','created_at')
            ->skip($request->skip)
//            ->take(20)
            ->paginate(100);
//        $collection =
//        $messages = $messages->reverse();
        foreach($messages as $message)
        {
            $message->time = Carbon::parse($message->created_at)->diffForHumans();

        }
        return $messages;
    }

    public function create($request){
        $data = $request->only('conversation_id', 'mime_type', 'message');
        $data['sender_id'] =$this->getUser()->id;
        if ($request->has('file') && $request->file != ''){
            $data['file'] = $request->file;
            $data['mime_type'] = 'file';
        }
        $userId=$this->getUser()->id;
        $conversationUserCallBack = function ($user) use ($userId){
            $user->where('user_id','!=', $userId);
        };
        $message = Message::create($data);
        $message->load(['conversation.users' => $conversationUserCallBack]);
        $message->time = carbon::parse($message->created_at)->diffForHumans();
        sendNotification([
            'sender_id' =>$this->getUser()->id,
            'receiver_id' => $message->conversation->users[0]->user_id,
            'extras->conversation_id' => $message->conversation->id,
            'title->en' => 'New Message Received',
            'title->ar' => 'تم استلام رسالة جديدة',
            'title->ru' => 'Получено новое сообщение',
            'title->ur' => 'نیا پیغام موصول ہوا۔',
            'title->hi' => 'नया संदेश प्राप्त हुआ',
            'description->en' => '<p class="p-text">You have Received A new Message. Please visit chat page to check latest messages.</p>',
            'description->ar' => '<p class="p-text">لقد تلقيت رسالة جديدة. يرجى زيارة صفحة الدردشة للتحقق من أحدث الرسائل.</p>',
            'description->ru' => '<p class="p-text">Вы получили новое сообщение. Пожалуйста, посетите страницу чата, чтобы проверить последние сообщения.</p>',
            'description->ur' => '<p class="p-text">آپ کو ایک نیا پیغام موصول ہوا ہے۔ تازہ ترین پیغامات چیک کرنے کے لیے براہ کرم چیٹ کا صفحہ دیکھیں۔</p>',
            'description->hi' => '<p class="p-text">आपको एक नया संदेश प्राप्त हुआ है। नवीनतम संदेशों की जांच के लिए कृपया चैट पेज पर जाएं।</p>',
            'action' => 'OPEN_CONVERSATION'
        ]);
        event(new SendMessage($message, $message->conversation->users[0]->user_id));
        event(new SendMessage($message, $userId));
        $message->time = Carbon::parse($message->created_at)->diffForHumans();
        unset($message->conversation);
        return $message;
    }




}