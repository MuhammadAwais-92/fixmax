<section class="banner-bread-section d-flex align-items-center"
         style="background-image: url('{{asset('assets/front/img//breadcrumb-img.jpg')}}');">
    <div class="container-max">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="banner-desc">
                        <div class="banner-title-bread">
                            @if(!empty($breadcrumbTitle))
                                {{$breadcrumbTitle}}
                            @endif
                        </div>

                        <ul class="breadcrumb-link d-flex">
                            @foreach($breadcrumbs as $url => $bc)
                                @if(array_key_exists("url",$bc))
                                    @if(!$loop->last)
                                        <li class="item"><a class="link" href="{{$bc["url"]}}">{{__($bc['title'])}}</a>
                                        </li>
                                    @else
                                        <li class="item">{{__($bc['title'])}}</li>
                                    @endif
                                @else
                                    @if($loop->first)
                                        <li class="item"><a class="link" href="{{$url}}">{{__($bc['title'])}}</a></li>
                                    @else
                                        <li class="item">{{__($bc['title'])}}</li>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
