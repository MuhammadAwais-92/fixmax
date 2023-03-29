@extends('admin.layouts.app')

@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
@endpush

@section('content')
    <section class="sec-custom-us-mh-all">
        <div class="dashborad-ses">
            <div class="container-2">
                <div class="row">
                    <div class="col-lg-9 col-md-8">
                        <div class="review-total d-flex align-items-center justify-content-between mb-3">
                            <div class="title">{{__('Supplier Reviews')}}</div>
                            <div class="review-cot d-flex align-items-center">
                                <div class="count-view mr-2">
                                    ({{ $reviews->count() }} {{__('Reviews')}})
                                </div>
                                <div class="star-rating-area review-page-mt d-flex align-items-center">
                                    <div class="rating-static clearfix" rel="{{getStarRating($store->rating)}}">
                                        <label class="full" title="{{__('Awesome - 5 stars')}}"></label>
                                        <label class="half" title="{{__('Pretty good - 4.5 stars')}}"></label>
                                        <label class="full" title="{{__('Pretty good - 4 stars')}}"></label>
                                        <label class="half" title="{{__('Meh - 3.5 stars')}}"></label>
                                        <label class="full" title="{{__('Meh - 3 stars')}}"></label>
                                        <label class="half" title="{{__('Kinda bad - 2.5 stars')}}"></label>
                                        <label class="full" title="{{__('Kinda bad - 2 stars')}}"></label>
                                        <label class="half" title="{{__('Meh - 1.5 stars')}}"></label>
                                        <label class="full" title="{{__('Sucks big time - 1 star')}}"></label>
                                        <label class="half" title="{{__('Sucks big time - 0.5 stars')}}"></label>
                                    </div>
                                    <div class="ratilike ng-binding mt-0 ml-1">
                                        ({{number_format($store->rating,1)}})
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @forelse($reviews as $review)
                                    <div class="review-list-box d-flex mb-3 pb-3 border-bottom">
                                        <div class="review-img mr-2">
                                            <img src="{{imageUrl($review->user->image,92,92,100,1)}}" class="img-fluid"
                                                 alt="">
                                        </div>
                                        <div class="review-detail-box w-100">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="title">{{$review->user->user_name}}</div>
                                                <div
                                                    class="reviw-time">{{\Carbon\Carbon::parse($review->updated_at)->timezone('Asia/Karachi')->since()}}</div>
                                            </div>
                                            <div class="star-rating-area">
                                                <div class="rating-static clearfix"
                                                     rel="{{getStarRating($review->rating)}}">
                                                    <label class="full" title="{{__('Awesome - 5 stars')}}"></label>
                                                    <label class="half"
                                                           title="{{__('Pretty good - 4.5 stars')}}"></label>
                                                    <label class="full" title="{{__('Pretty good - 4 stars')}}"></label>
                                                    <label class="half" title="{{__('Meh - 3.5 stars')}}"></label>
                                                    <label class="full" title="{{__('Meh - 3 stars')}}"></label>
                                                    <label class="half" title="{{__('Kinda bad - 2.5 stars')}}"></label>
                                                    <label class="full" title="{{__('Kinda bad - 2 stars')}}"></label>
                                                    <label class="half" title="{{__('Meh - 1.5 stars')}}"></label>
                                                    <label class="full"
                                                           title="{{__('Sucks big time - 1 star')}}"></label>
                                                    <label class="half"
                                                           title="{{__('Sucks big time - 0.5 stars')}}"></label>
                                                </div>
                                                <div class="ratilike ng-binding">({{$review->rating}})</div>
                                            </div>

                                            <div class="des clearfix">
                                                {{$review->review}}
                                            </div>
                                        </div>
                                        <a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button"
                                           href="javascript:{};"
                                           data-url="{{route('admin.dashboard.suppliers.reviews.destroy', $review->id)}}"
                                           title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>
                                    </div>
                                @empty
                                    <div class="col-12">
                                        <div class="alert alert-danger w-100" role="alert">
                                            No record found
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                            {{--   {{ $reviews->withQueryString()->links('front.common.pagination', ['paginator' => $reviews]) }}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-page-level')
    <script>
        $('.delete-record-button').on('click', function (e) {
            var url = $(this).data('url');
            swal({
                    title: "Are you sure you want to delete this?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#1C4670",
                    confirmButtonText: "Delete",
                    cancelButtonText: "No",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: 'post',
                            url: url,
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            }
                        })
                            .done(function (res) {
                                toastr.success("Review deleted successfully!");
                                location.reload();
                            })
                            .fail(function (res) {
                                toastr.success("Review deleted  successfully!");
                                t.reload();
                            });
                    } else {
                        swal.close()
                    }
                });
        });
    </script>
@endpush

