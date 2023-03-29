@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <main class="articles spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-detail-mt">
                        <h2 class="primary-headline mb-6">
                            {{__('Latest Articles')}}
                        </h2>
                    </div>
                </div>
                @forelse($articles as $key => $article)
                    <div class="col-md-12">
                        <div class="article-card-main">
                            <a href="{{ route('front.article.detail', $article->slug) }}">
                                <div class="article-card d-flex">
                                    <div class="article-img-block">
                                        <img src="{!! imageUrl(url($article->image_url),197,200,100,1) !!}"
                                             alt="article-img" class="img-fluid article-img">
                                    </div>
                                    <div class="arti-desc-block">
                                        <h3 class="arti-title">
                                            {!! translate($article->name) !!}
                                        </h3>
                                        <div class="primary-text-p">
                                            {!!  Illuminate\Support\Str::limit(translate($article->content), 300, $end='...')  !!}
                                        </div>
                                        <span dir="ltr" class="arti-date">
                    {{date('F d, Y',$article->created_at)}}
                  </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    @include('front.common.alert-empty',['message'=>__('No Article found.')])
                @endforelse
                {{ $articles->links('front.common.pagination', ['paginator' => $articles]) }}
            </div>
        </div>
    </main>

@endsection
