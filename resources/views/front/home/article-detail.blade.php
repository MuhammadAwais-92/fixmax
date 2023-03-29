@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <main class="articles spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="article-dt-img-block float-md-left">
                        <img src="{!! imageUrl(url($article->image_url),458,465,90) !!}" alt="article-dt-img"
                             class="img-fluid article-dt-img">
                    </div>
                    <div class="article-dt-desc">
            <span dir="ltr" class="arti-date">
                {{date('F d, Y',$article->created_at)}}
            </span>
                        <h3 class="article-title">
                            {!! translate($article->name) !!}
                        </h3>
                        <div class="primary-text-p">
                            {!! translate($article->content) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
