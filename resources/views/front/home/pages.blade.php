@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <main class="login-sec spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="page-detail-mt">
                        <div class="commen-title"> {{ translate($page->name) }}</div>
                        <div class="page-detail-p">
                            <p>
                                {!! translate($page->content) !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection


