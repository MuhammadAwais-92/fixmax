@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="portfolio spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="portfolio-main-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="title-btnz-row d-flex justify-content-between align-items-center flex-wrap">
                                    <div class="title">
                                        {{ translate($project->name) }}
                                    </div>
                                    <div class="ctm-btnz-block d-flex flex-wrap">
                                        <div class="w-50 pr-05">
                                            <button data-id="{{ $project->id }}"
                                                    class="deleteProject secondary-btn border-btn mw-100">
                                                {{__('Delete')}}
                                            </button>
                                        </div>
                                        <div class="w-50 pl-05">
                                            <a href=" {{ route('front.dashboard.project.edit', $project->id) }}">
                                                <button class="secondary-btn mw-100">
                                                    {{__('Edit')}}
                                                </button>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                <p class="text-desc">
                                    {{ translate($project->description) }}
                                </p>
                            </div>
                            @foreach ($project->images as $image)
                                <div class="col-md-4 col-lg-6 col-xl-4 col-sm-6 col-6-ctm ">
                                    <div class="portfolio-card">
                                        <img src="{!! imageUrl(url($image->image_url), 300, 193, 100, 1) !!}"
                                             alt="portfolio-img"
                                             class="img-fluid portfolio-img">
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        $(".deleteProject").on('click', function (e) {
            let id = $(this).attr('data-id');
            $(".deleteProject").attr('disabled', 'disabled');
            swal({
                    title: "{{ __('Do you want to delete this project?') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "{{ __('Yes') }}",
                    cancelButtonText: "{{ __('Cancel') }}",
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {

                        $.ajax({

                            url: window.Laravel.baseUrl + "dashboard/project-delete/" + id,
                            success: function (data) {
                                toastr.success("{{ __('success') }}",
                                    "{{ __('Project removed successfully') }}")
                                window.location.href = window.Laravel.baseUrl +
                                    "dashboard/projects/all";
                            }
                        })

                    } else {
                        $(".deleteProject").attr('disabled', false);
                        swal.close()
                    }
                });
        });
    </script>
@endpush
