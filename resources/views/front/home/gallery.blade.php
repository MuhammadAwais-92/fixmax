@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="articles spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-detail-mt">
                        <h2 class="primary-headline mb-5">
                            {{__('Image Gallery')}}
                        </h2>
                    </div>
                </div>

                @forelse ($images as $image)
                    <div class="col-md-4 col-sm-6 col-6-ctm">
                        <button class="gallery-btn" type="button">
                            <div class="img-gallery-card">
                                <a href="{!! imageUrl(url($image->image_url),360,360,90,1) !!}" data-lightbox="photos">
                                    <img data-lightbox="photos"
                                         src="{{ imageUrl(url($image->image_url),360,360,90,1) }}" alt="gallery-img"
                                         class="img-fluid gallery-img">
                                </a>
                            </div>
                        </button>
                    </div>
                @empty
                    @include('front.common.alert-empty',['message'=>__('No record found.')])
                @endforelse
                {{ $images->links('front.common.pagination', ['paginator' => $images]) }}
            </div>
        </div>
    </main>
    {{-- <div class="modal fade image-gallery-modal" id="gallery-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="img/gallery-modal-img.jpg" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="img/gallery-modal-img.jpg" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="img/gallery-modal-img.jpg" alt="First slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
            <span class="no-of-slides">
              04/52
            </span>
            <button data-dismiss="modal" class="close-gal-modal">
              <svg id="CloseIcon" xmlns="http://www.w3.org/2000/svg" width="26.048" height="26.043" viewBox="0 0 26.048 26.043">
                <path id="CloseIcon-2" data-name="CloseIcon" d="M-5558.975,12824.389l-10.654,10.652-2.371-2.365,10.657-10.658-10.652-10.652,2.366-2.367,10.654,10.652,10.651-10.652,2.371,2.367-10.654,10.652,10.654,10.652-2.371,2.371Z" transform="translate(5572 -12808.998)" fill="#fff"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
    </div> --}}
@endsection
