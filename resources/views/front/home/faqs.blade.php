@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <main class="articles spacing-y">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-detail-mt">
                        <h2 class="primary-headline mb-5">
                            {{__('Frequently Asked Questions')}}
                        </h2>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="faqs-accordian mx-auto">
                        <div id="accordion">
                            @forelse ($faqs as $key => $faq)
                                <div class="card">
                                    <div class="card-header" id="heading-{{ $faq->id }}">
                                        <h5 class="mb-0">
                                            <button
                                                class="d-flex align-items-start justify-content-between collapsed w-100"
                                                data-toggle="collapse" data-target="#collapse-{{ $faq->id }}"
                                                aria-expanded="{!! $key == 0?'true':'false' !!}"
                                                aria-controls="collapseOne">
                                                <p class="text-p">    {!! translate($faq->question) !!}</p>
                                                <i class="fas fa-plus"></i>
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </h5>
                                    </div>

                                    <div id="collapse-{{ $faq->id }}" class="collapse {!! $key == 0?'show':'' !!}"
                                         aria-labelledby="heading-{{ $faq->id }}" data-parent="#accordion" style="">
                                        <div class="card-body">
                                            <p class="primary-text-p p-0 mb-0">
                                                {!! translate($faq->answer) !!}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                @include('front.common.alert-empty', [
                                    'message' => __('No Faq found.'),
                                ])
                            @endforelse


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
