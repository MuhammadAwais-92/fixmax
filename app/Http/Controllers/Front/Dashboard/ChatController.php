<?php

namespace App\Http\Controllers\Front\Dashboard;

use App\Http\Repositories\ConversationRepository;
use App\Http\Repositories\MessageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChatController extends Controller
{
    public  $conversationRepository;
    public  $messageRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ConversationRepository $conversationRepository, MessageRepository $messageRepository) {
        parent::__construct();
        $this->breadcrumbs[0] = ['url'=> route('front.dashboard.index'),'title' => __('Home')];
        $this->conversationRepository = $conversationRepository;
        $this->messageRepository = $messageRepository;
        $this->conversationRepository->setFromWeb(true);
    }

    public function index()
    {
        $this->breadcrumbTitle = __('Conversations');
        $this->breadcrumbs[1]  = ['url'=> '','title' => __('Conversations')];
        $conversation  = $this->conversationRepository->list();
        if ($conversation){
            return view('front.dashboard.chat.chat', ['conversationId' => $conversation[0]->id]);
        }else{
            return view('front.dashboard.chat.chat');
        }
    }

    public function conversation($id)
    {
         $this->breadcrumbTitle = __('Messages');
        $this->breadcrumbs[1]  = ['url'=> '','title' => __('Messages')];

        if (!$this->conversationRepository->isUserHaveAccess($id)){
            return redirect()->back()->with('err', __('Something went wrong'));
        }

        return view('front.dashboard.chat.chat', ['conversationId' => $id]);
    }

    public function getConversations()
    {
        $conversations  = $this->conversationRepository->list();
        return responseBuilder()->success('conversations', $conversations);
    }

    public function createOrGet(Request $request)
    {
        if ($this->user->type == 'supplier' && $request->service_id == 0){
            return redirect()->back()->with('err', __('Something went wrong'));
        }
        $conversation  = $this->conversationRepository->createOrGet($request);
//        $messages = $this->messageRepository->list($request);
        return redirect(route('front.dashboard.conversation.messages', ['id'=>$conversation->id]));
    }

    public function getMessages(Request $request)
    {
//        $this->validate(request(),[
//            'conversation_id' => 'required|exists:conversations,id',
//            'skip' => 'required|numeric'
//        ]);
        $messages = $this->messageRepository->list($request);

        return responseBuilder()->success('messages', $messages);
    }

    public function messageSend(Request $request)
    {

        $message = $this->messageRepository->create($request);
        return responseBuilder()->success('messages', $message->toArray());
    }

    public function conversationDelete($id)
    {
        $conversation = $this->conversationRepository->delete($id);
//        if($conversation){
            return responseBuilder()->success('Conversation deleted.');
//        }
//        return responseBuilder()->error('Something went wrong');
    }


}
