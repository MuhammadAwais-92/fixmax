@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')


    <main class="login-sec spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-detail-mt">
                        <div class="commen-title"><span>{{__('Categories')}}</span></div>
                    </div>
                </div>
                @forelse ($categories as $category)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6-ctm cate-col">
                        <div class="category-card">
                            <a href="{{route('front.sub-categories',$category->id)}}">
                                <div class="service-icon-card">
                                    <div class="img-fluid card-img-block">
                                        <img src="{!! imageUrl(url($category->image_url),97, 97, 95, 1) !!}"
                                             alt="card-img" class="img-fluid card-img">
                                    </div>
                                    <div class="card-title">
                                        {{ translate($category->name) }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    @include('front.common.alert-empty', [
                        'message' => __('No Category found.'),
                    ])
                @endforelse
                {{ $categories->links('front.common.pagination', ['paginator' => $categories]) }}

            </div>
        </div>
    </main>
@endsection
