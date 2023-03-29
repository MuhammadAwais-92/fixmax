<?php


namespace App\Http\Repositories;


use App\Events\newNotifications;
use App\Http\Repositories\BaseRepository\Repository;
use App\Models\Conversation;
use App\Models\ConversationUser;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use stdClass;


class ConversationRepository extends Repository
{
    protected $messageRepository;
    public function __construct(Conversation $conversation, MessageRepository $messageRepository)
    {
        $this->model = $conversation;
        $this->messageRepository = $messageRepository;
    }

    public function list()
    {
        $userId = $this->getUser()->id;
        $conversationUsersCallback = function ($query) use ($userId) {
            return $query->where(['user_id' => $userId, 'deleted' => 0]);
        };
        $serviceCallback = function ($q) {
            $q->select('id', 'name', 'user_id', 'min_price','max_price','service_type','discount')->with(['supplier:id,supplier_name']);
        };
        $lastMessageCallback = function ($query) use ($userId) {
            $query->where('deleted_by', '!=', $userId);
        };
        $conversations = $this->model->wherehas('conversationUsers.category')->whereHas('conversationUsers', $conversationUsersCallback)
            ->with([
                'service' => $serviceCallback,
                'conversationUsers.category',
                'conversationUsers' => function ($query) use ($userId) {
                    $query->where('id', '!=', $userId);
                    $query->select('id','category_id', 'user_name', 'supplier_name', 'user_type', 'image');
                },
                'latestMessage' => $lastMessageCallback
            ])
            ->where(function ($query) use ($userId) {
                $query->Where('user1_deleted', '!=', $userId)->Where('user2_deleted', '!=', $userId);
            })
            ->select('id', 'created_at', 'service_id', 'updated_at', DB::raw('(select created_at from messages where conversation_id  =   conversations.id order by id desc limit 1) as last_message_created_at'))
            ->orderBy('last_message_created_at', 'DESC')
            ->get()->toJson();

        $conversations = json_decode($conversations);
//        dd($conversations);
        foreach ($conversations as $key => $conversation) {
            if (is_null($conversation->service)) {
                $conversation->service = new stdClass();
            }
            if (is_null($conversation->latest_message)) {
                $conversation->latest_message = new stdClass();
            }

            if(count($conversation->conversation_users) > 0){
                $conversation->receiver = $conversation->conversation_users[0];
            }else{
                $conversation->receiver = new stdClass();
            }
            unset($conversation->conversation_users);
        }
        return $conversations;
    }

    public function createOrGet($request)
    {
        $userId = $this->getUser()->id;
        $usersArray = [$request->supplier_id, $userId];
        $conversationUsersCheckCallback = function ($q) use ($usersArray) {
            $q->whereIn('user_id', $usersArray);
        };
        $query = $this->model->query();
        if (!$request->has('id')) {
            $query->whereHas('users', $conversationUsersCheckCallback, '=', count($usersArray));
            if ($request->service_id) {
                $query->where('service_id', $request->service_id);
            } else {
                $query->where('service_id', 0);
            }
        } else {

            $query->where('id', $request->id);
        }
        $query->with([
            'service',
            'conversationUsers' => function ($query) use ($userId) {
                $query->where('id', '!=', $userId);
                $query->select('id', 'user_name', 'supplier_name', 'user_type', 'image');
            },
            'latestMessage'
        ]);
        $conversation = $query->first();
        if (!$conversation) {
            $data = [];
            if ($request->service_id) {
                $data = ['service_id' => $request->service_id];
            }
            $data['user1_deleted'] = 0;
            $data['user2_deleted'] = 0;
            $conversation = $this->model->create($data);
            $conversation->conversationUsers()->sync($usersArray);
            $conversation = $this->model->with([
                'service',
                'conversationUsers' => function ($query) use ($userId) {
                    $query->where('id', '!=', $userId);
                    $query->select('id', 'user_name', 'supplier_name', 'user_type', 'image');
                },
                'latestMessage'
            ])->where(['id' => $conversation->id])->first();
        }

        if ($userId == $conversation->user1_deleted ){
            $conversation->update(['user1_deleted'=> 0]);

        }
        if ($userId == $conversation->user2_deleted){
            $conversation->update(['user2_deleted'=> 0]);

        }
         $conversation = json_decode($conversation);

        if (is_null($conversation->service)) {
            $conversation->service = new stdClass();
        }
        if (is_null($conversation->latest_message)) {
            $conversation->latest_message = new stdClass();
        }
        $conversation->receiver = $conversation->conversation_users[0];
        unset($conversation->conversation_users);
//        dd($conversation->product);
        return $conversation;
    }

    function delete($id)
    {


        $user = $this->getUser();
        $userId = $this->getUser()->id;
        $conversation = $this->model->where('id',$id)->first();
//        dd($id,$conversation && !$conversation->user2_deleted,$conversation , $conversation->user2_deleted);
        if ($conversation && !$conversation->user2_deleted && $user->user_type=="supplier"){
            $conversation->update(['user2_deleted'=>$userId]);
        }else{
            $conversation->update(['user1_deleted'=>$userId]);
        }


        $query = $this->messageRepository->getquery();

        if ($user->user_type=="supplier"){
            $query->where('conversation_id','=',$id)->update([
                'user2_deleted'=>$userId,
            ]);
        }else{
            $query->where('conversation_id','=',$id)->update([
                'user1_deleted'=>$userId,
            ]);
        }

    }

    public function revertDeletedConversation($conversationId)
    {
        $this->model->find($conversationId)->update([
            'user1_deleted' => 0,
            'user2_deleted' => 0
        ]);
    }

    public function isUserHaveAccess($id)
    {
        $userId = $this->getUser()->id;

        $conversationUsersCallback = function ($query) use ($userId, $id) {
            $query->where(['user_id' => $userId, 'deleted' => 0, 'conversation_id'=>$id]);
        };
        $conversations = $this->model->whereHas('conversationUsers', $conversationUsersCallback)->get();
        if (count($conversations) > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    function deleteAll()
    {

        $user = $this->getUser();
        $userId = $this->getUser()->id;
        $conver=ConversationUser::where('user_id',$user->id)->get();
        if ($conver->count()>0){
            foreach ($conver as $key=>$delConversation){
                $id=$delConversation->conversation_id;
                $conversation = $this->model->where('id',$id)->first();
                if ($conversation && !$conversation->user2_deleted && $user->user_type=="supplier"){

                    $conversation->update(['user2_deleted'=>$userId]);
                }else{
                    $conversation->update(['user1_deleted'=>$userId]);
                }
                $query = $this->messageRepository->getquery();
                if ($user->user_type=="supplier"){
                    $query->where('conversation_id','=',$id)->update([
                        'user2_deleted'=>$userId,
                    ]);
                }else{
                    $query->where('conversation_id','=',$id)->update([
                        'user1_deleted'=>$userId,
                    ]);
                }
            }
        }



    }

}