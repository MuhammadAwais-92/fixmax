@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="chat-message spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="chat-main">
                        <div class="row">
                            <div class="col-md-12 mt-3 mt-md-0" v-cloak>
                                @if (isset($conversationId))
                                    <div class="message-content d-lg-flex">
                                        <chats selected-conversation="{{$conversationId}}"></chats>
                                        <messages conversation="{{$conversationId}}"></messages>
                                    </div>
                                @else
                                    <div class="message-content">
                                        <chats></chats>
                                    </div>
                                @endIf
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
