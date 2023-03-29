@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="notification-page spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <notifications calledfrom="dashboard" currentpagenumber="{{ $page }}"
                               usersettings="{{ auth()->user()->settings }}"
                               v-on:notifications-loaded="showNotifications = true">
                </notifications>
                <template v-if="showNotifications">
                    {{ $notifications->appends(request()->query())->links('front.common.pagination') }}
                </template>
            </div>
        </div>
    </main>
@endsection
