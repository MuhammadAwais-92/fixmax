@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="portfolio manage-equipment spacing-y">
        <div class="container">
            <div class="row">
                @include('front.dashboard.common.left-sidebar')
                <div class="col-xl-9 col-lg-8">
                    <div class="manage-equipment-content">
                        <div class="row">
                            <div class="col-md-12">
                                <div
                                    class="title-btnz-row d-flex justify-content-end align-items-center flex-wrap mb-3">
                                    <a href="{{ route('front.dashboard.equipment.create') }}"
                                       class="secondary-btn add-project-btn">
                                        <svg id="AddIcon" xmlns="http://www.w3.org/2000/svg" width="23.143"
                                             height="23.143"
                                             viewBox="0 0 23.143 23.143">
                                            <path id="AddIcon-2" data-name="AddIcon"
                                                  d="M18.321,23.321a.971.971,0,0,1-.964.964H13.5v3.857a.971.971,0,0,1-.964.964H10.607a.971.971,0,0,1-.964-.964V24.286H5.786a.971.971,0,0,1-.964-.964V21.393a.971.971,0,0,1,.964-.964H9.643V16.571a.971.971,0,0,1,.964-.964h1.929a.971.971,0,0,1,.964.964v3.857h3.857a.971.971,0,0,1,.964.964Zm4.821-.964A11.571,11.571,0,1,0,11.571,33.929,11.574,11.574,0,0,0,23.143,22.357Z"
                                                  transform="translate(0 -10.786)" fill="#022c44"/>
                                        </svg>
                                        {{__('Add New Equipment')}}
                                    </a>
                                </div>
                            </div>
                            @forelse($equipments as $equipment)
                                @if($equipment->service)
                                    <div class="col-md-4 col-lg-6 col-xl-4 col-sm-6 col-6-ctm ">
                                        <div class="portfolio-add-card">
                                            <div class="img-add-del-btn">
                                                <div class="img-block">
                                                    <img
                                                        src="{!! imageUrl(url($equipment->image_url), 300, 193, 100, 1) !!}"
                                                        alt="portfolio-img"
                                                        class="img-fluid portfolio-img">
                                                </div>
                                                <div class="desc-block">
                                                    <div
                                                        class="edit-del-block d-flex align-items-center justify-content-center">
                                                        <a
                                                            href="{{ route('front.dashboard.equipment.edit', $equipment->id) }}">
                                                            <button class="edit-del-btn">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                        </a>
                                                        <span class="seprater"></span>


                                                        <button class="deleteEquipment edit-del-btn"
                                                                data-id="{{ $equipment->id }}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                            <h3 class="price text-truncate">
                                                {{__('AED')}}{{ $equipment->price }}
                                            </h3>
                                            <h3 class="title text-truncate">
                                                {{ translate($equipment->name) }}
                                            </h3>
                                            <h3 class="title text-truncate">
                                                {{ $equipment->equipment_model }} - {{ $equipment->make }}
                                            </h3>
                                            <h3 class="title text-truncate service">{{ translate($equipment->service->name) }}
                                            </h3>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="col-12">
                                    <div class="alert alert-danger w-100" role="alert">
                                        {{ __('No Equipment Found') }}
                                    </div>
                                </div>
                            @endforelse
                            {{ $equipments->links('front.common.pagination', ['paginator' => $equipments]) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('scripts')
    <script>
        $(".deleteEquipment").on('click', function (e) {
            let id = $(this).attr('data-id');
            $(".deleteEquipment").attr('disabled', 'disabled');
            swal({
                    title: "{{ __('Do you want to delete this equipment?') }}",
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

                            url: window.Laravel.baseUrl + "dashboard/equipment-delete/" + id,
                            success: function (data) {
                                toastr.success("{{ __('success') }}",
                                    "{{ __('Equipment removed successfully') }}")
                                location.reload();
                            }
                        })

                    } else {
                        $(".deleteEquipment").attr('disabled', false);
                        swal.close()
                    }
                });
        });
    </script>
@endpush
