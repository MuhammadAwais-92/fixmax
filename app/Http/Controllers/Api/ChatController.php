<?php

namespace App\Http\Controllers\Api;

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
        $this->middleware('jwt.verify', ['except' => []]);
        $this->conversationRepository = $conversationRepository;
        $this->messageRepository = $messageRepository;
        $this->conversationRepository->setFromWeb(false);
    }

    public function getConversations()
    {
     
        $conversations  = $this->conversationRepository->list();
        return responseBuilder()->success('conversations', $conversations);
    }

    public function startConversation(Request $request)
    {
//        $this->validate($request, ['product_id' => 'required','store_id' => 'required']);
     
        $conversation  = $this->conversationRepository->createOrGet($request);
        return responseBuilder()->success('conversation', ['conversation' => $conversation]);
    }

    public function getMessages(Request $request)
    {
//        $this->validate($request, ['conversation_id' => 'required']);
 
        $messages = $this->messageRepository->list($request);
        return responseBuilder()->success('messages', $messages);
    }

    public function sendMessage(Request $request)
    {
//        $this->validate($request, ['conversation_id' => 'required','mime_type' => 'required' ]);
 
//        $this->validate(request(),[
//            'conversation_id' => 'required|exists:conversations,id',
//            'message_type' => 'required|in:text,file',
//            'message' => 'required_if:message_type,text',
//            'file' => 'required_if:message_type,file|image'
//        ]);
        $message = $this->messageRepository->create($request);
        $this->conversationRepository->revertDeletedConversation($request->conversation_id);
        return responseBuilder()->success('messages', $message->toArray());
    }

    public function conversationDelete($id)
    {
        $conversation = $this->conversationRepository->delete($id);
//        if($conversation){
        return responseBuilder()->success(__('Conversation deleted.'));
//        }
//        return responseBuilder()->error('Something went wrong');
    }
    public function deleteAll()
    {
        $conversation = $this->conversationRepository->deleteAll();
//        if($conversation){
        return responseBuilder()->success('All Conversation deleted');
//        }
//        return responseBuilder()->error('Something went wrong');
    }


}
