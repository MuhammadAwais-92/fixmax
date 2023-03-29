@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="login-sec spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-detail-mt">
                        <div class="commen-title"><span>{{__('Sub')}}</span> <span>{{__('Categories')}}</span></div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="sub-cate-box">
                        <div class="sub-cat-imgBox">
                            <img src="{{ url($category->image) }}" alt="sub-cat-img" class="img-fluid sub-cat-img">
                        </div>
                        <h3 class="cate-name">
                            {{ translate($category->name) }}
                        </h3>
                    </div>
                </div>
                @foreach ($category->subCategories as $subcategory)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-6-ctm cate-col">
                        <div class="category-card">
                            <a href="{!! route('front.suppliers',['subCategory'=>$subcategory->id]) !!}">
                                <div class="service-icon-card">
                                    <div class="img-fluid card-img-block">
                                        <img src="{!! imageUrl(url($subcategory->image_url),97, 97, 95, 1) !!}"
                                             alt="card-img" class="img-fluid card-img">
                                    </div>
                                    <div class="card-title">
                                        {{ translate($subcategory->name) }}
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </main>
@endsection
