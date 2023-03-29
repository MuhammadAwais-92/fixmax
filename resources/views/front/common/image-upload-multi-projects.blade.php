<div class="uploder-ss-m">
    @if($required)
        <input type="text" name="images" class="" required id="initial_images" style="opacity: 0;">
    @endif
    <div class="input-style1">
        <label class="d-block input-label">{{__($imageTitle) }} @if($isRequired) <span
                class="text-danger">*</span>@endif</label>
        <label class="d-block text-danger">{{__("Recommended Size 262 × 222")}}</label>
    </div>
    <div class="upload-sec d-flex">
        <!-- image upload -->

        <div class="qust-filed mr-2" id="push_loader">
            <div class="form-control" id="previous_html">
                <input multiple type="file" id="choose-file-{{$imageNumber}}" class="input-file d-none">
                <label for="choose-file-{{$imageNumber}}"
                       class="btn-tertiary js-labelFile d-flex align-items-center flex-column">
                    <svg id="AddIcon" xmlns="http://www.w3.org/2000/svg" width="23.143"
                         height="23.143" viewBox="0 0 23.143 23.143">
                        <path id="AddIcon-2" data-name="AddIcon"
                              d="M18.321,23.321a.971.971,0,0,1-.964.964H13.5v3.857a.971.971,0,0,1-.964.964H10.607a.971.971,0,0,1-.964-.964V24.286H5.786a.971.971,0,0,1-.964-.964V21.393a.971.971,0,0,1,.964-.964H9.643V16.571a.971.971,0,0,1,.964-.964h1.929a.971.971,0,0,1,.964.964v3.857h3.857a.971.971,0,0,1,.964.964Zm4.821-.964A11.571,11.571,0,1,0,11.571,33.929,11.574,11.574,0,0,0,23.143,22.357Z"
                              transform="translate(0 -10.786)" fill="#022c44"/>
                    </svg>
                    <span class="js-fileName heading Poppins-Regular">{{__('Upload Media')}}</span>
                </label>
            </div>
        </div>

        <div id="multiple" class="d-flex align-items-center justify-content-center row">
            @if(!empty($displayImageSrc))

                @forelse($displayImageSrc as $key => $src)
                    {{--                <p>{{$src['file_default']}}</p>--}}
                    {{--    start code--}}

                    @if ($src['file_type'] == 'video')
                        <div class="more-view-image">
                            <div class="uploads d-flex align-items-center justify-content-center">
                                @if(!empty($src['file_path']))
                                    <video width="320" height="240" controls muted>
                                        <source src="{{env('APP_URL') . $src['file_path']}}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                            </div>

                            @if($src['file_default'] == 1 || $src['file_default'] == '1'|| $src['file_default'] == true)
                                <i class="fas fa-check d-flex align-items-center justify-content-center placeholder-remove-2"></i>
                                <a href="javascript:void(0)" data-id="uploads/front/media/article-img-1-1655810890.jpg"
                                   class="d-flex align-items-center justify-content-center delete-image-js">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11.001" height="11.003"
                                         viewBox="0 0 11.001 11.003">
                                        <path id="Forma_1" data-name="Forma 1"
                                              d="M1028.345,545.163l-3.333,3.335,3.333,3.334a1.27,1.27,0,1,1-1.795,1.8l-3.334-3.335-3.334,3.335a1.27,1.27,0,0,1-1.795-1.8l3.333-3.334-3.333-3.335a1.269,1.269,0,0,1,1.795-1.8l3.334,3.335,3.334-3.335a1.269,1.269,0,0,1,1.8,1.8Z"
                                              transform="translate(-1017.715 -542.996)" fill="#fff"></path>
                                    </svg>
                                </a>

                            @else
                                <a href="javascript:void(0)"
                                   class="placeholder-remove d-flex align-items-center justify-content-center delete-image-js"
                                   data-id="{{$src['file_path'] ?? ''}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11.001" height="11.003"
                                         viewBox="0 0 11.001 11.003">
                                        <path id="Forma_1" data-name="Forma 1"
                                              d="M1028.345,545.163l-3.333,3.335,3.333,3.334a1.27,1.27,0,1,1-1.795,1.8l-3.334-3.335-3.334,3.335a1.27,1.27,0,0,1-1.795-1.8l3.333-3.334-3.333-3.335a1.269,1.269,0,0,1,1.795-1.8l3.334,3.335,3.334-3.335a1.269,1.269,0,0,1,1.8,1.8Z"
                                              transform="translate(-1017.715 -542.996)" fill="#fff"></path>
                                    </svg>
                                </a>
                            @endif
                            <input type="hidden" class="user-image selected-image"
                                   name="{{$inputName}}[{{$key+15}}][file_path]"
                                   value="{{$src['file_path'] ?? ''}}" required>
                            <input type="hidden" class="user-image selected-image"
                                   name="{{$inputName}}[{{$key+15}}][file_type]"
                                   value="{{$src['file_type'] ?? ''}}" required>
                            @if($src['file_default'] == 1 || $src['file_default'] == '1'|| $src['file_default'] == true)
                                <input type="hidden" class="user-image selected-image default-img"
                                       name="{{$inputName}}[{{$key+15}}][file_default]"
                                       value="{{empty(old('file_default')) ? (!empty($src['file_default']) ? $src['file_default'] : old('file_default')) :old('file_default')}}">
                            @else
                                <input type="hidden" class="user-image selected-image default-img"
                                       name="{{$inputName}}[{{$key+15}}][file_default]"
                                       value="0">
                            @endif
                        </div>
                    @else
                        <div class="more-view-image">
                            <div
                                {{--                            class="uploads d-flex align-items-center justify-content-center {{ $src['file_default'] == 1 ? 'border-default' : '' }}">--}}
                                class="uploads d-flex align-items-center justify-content-center">
                                @if(!empty($src['file_path']))
                                    <img src="{{imageUrl($src['file_path'],145, 115, 95, 1)}}" class="img-fluid img"
                                         alt="">
                                @endif
                            </div>
                            @if($src['file_default'] == 1 || $src['file_default'] == '1'|| $src['file_default'] == true)
                                <i class="fas fa-check d-flex align-items-center justify-content-center placeholder-remove-2"></i>
                                <a href="javascript:void(0)" data-id="uploads/front/media/article-img-1-1655810890.jpg"
                                   class="d-flex align-items-center justify-content-center delete-image-js">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11.001" height="11.003"
                                         viewBox="0 0 11.001 11.003">
                                        <path id="Forma_1" data-name="Forma 1"
                                              d="M1028.345,545.163l-3.333,3.335,3.333,3.334a1.27,1.27,0,1,1-1.795,1.8l-3.334-3.335-3.334,3.335a1.27,1.27,0,0,1-1.795-1.8l3.333-3.334-3.333-3.335a1.269,1.269,0,0,1,1.795-1.8l3.334,3.335,3.334-3.335a1.269,1.269,0,0,1,1.8,1.8Z"
                                              transform="translate(-1017.715 -542.996)" fill="#fff"></path>
                                    </svg>
                                </a>

                            @else
                                <a href="javascript:void(0)"
                                   class="placeholder-remove d-flex align-items-center justify-content-center delete-image-js"
                                   data-id="{{$src['file_path'] ?? ''}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11.001" height="11.003"
                                         viewBox="0 0 11.001 11.003">
                                        <path id="Forma_1" data-name="Forma 1"
                                              d="M1028.345,545.163l-3.333,3.335,3.333,3.334a1.27,1.27,0,1,1-1.795,1.8l-3.334-3.335-3.334,3.335a1.27,1.27,0,0,1-1.795-1.8l3.333-3.334-3.333-3.335a1.269,1.269,0,0,1,1.795-1.8l3.334,3.335,3.334-3.335a1.269,1.269,0,0,1,1.8,1.8Z"
                                              transform="translate(-1017.715 -542.996)" fill="#fff"></path>
                                    </svg>
                                </a>
                            @endif

                            <input type="hidden" class="user-image selected-image"
                                   name="{{$inputName}}[{{$key+15}}][file_path]"
                                   value="{{$src['file_path'] ?? ''}}" required>
                            <input type="hidden" class="user-image selected-image"
                                   name="{{$inputName}}[{{$key+15}}][file_type]"
                                   value="{{$src['file_type'] ?? ''}}" required>
                            <input type="hidden" class="user-image selected-image default-img"
                                   name="{{$inputName}}[{{$key+15}}][file_default]"
                                   value="{{$src['file_default'] ?? 0 }}" required>
                        </div>
                    @endif
                    {{--    end code--}}
                @empty
                @endforelse
            @endif
        </div>

        <!-- image upload -->
    </div>
    @include('front.common.alert', ['input' => $inputName.'.*'])
</div>



@push('scripts')
    <script>
        var disSrc = <?php echo json_encode($displayImageSrc); ?>;

        $("#initial_images").val(disSrc);
        let images = [];
        let indexCount = 0;
        $(document).on('change', '#choose-file-' + '{{ $imageNumber }}', function () {
            if ({{$numberOfImages}} > 0) {
                let totalCount = $('.delete-image-js').length + $(this).prop("files").length;
                if (totalCount > {{$numberOfImages}}) {
                    toastr.error('{{ __('Error') }}', '{{__('You can only upload')}}' + ' ' + '{{$numberOfImages}}' + ' ' + '{{__('images')}}');
                    return false;
                }
            }
            let url = window.Laravel.apiUrl + 'upload-multi-image';
            let fileData = $(this).prop("files");
            if (fileData[0] !== undefined) {
                let formData = new FormData();
                if (!{{$allowVideo}}) {
                    let filteredFilesData = Object.values(fileData).filter((value) => {
                        if (value.type.includes('video')) {
                            return true;
                        }
                        return false;
                    });
                    if (filteredFilesData.length > 0) {
                        toastr.error('{{ __('Error') }}', '{{__('You can only upload images')}}');
                        return false;
                    }
                }

                // let html_loader = `<div class="form-control py-2 d-flex align-items-center justify-content-center" id="loader_div"><div class="gif-loader-imageee"><img src="{{asset('/assets/front/img/ajax-loader.gif')}}" alt="image-loader"></div></div>`;
                // $("#loader_div").remove();
                // $("#previous_html").addClass('preview_html_remove');
                // $("#push_loader").append(html_loader);

                Object.values(fileData).map((value, index) => {
                    formData.append("images[]", fileData[index]);
                });

                $(".add_btn").prop('disabled', true);

                if (url.length > 0) {
                    jQuery.ajax({
                        url: url,
                        type: 'post',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': window.Laravel.csrfToken
                        },
                    }).done(function (res) {
                        if (res.success == false) {
                            toastr.error(res.message);
                        } else {
                            // $("#loader_div").addClass('loader_html_remove');
                            // $("#previous_html").removeClass('preview_html_remove');
                            console.log("Images => ", images);

                            if (disSrc.length != 0) {
                                // images = [];
                                images.push(...res.data.collection);
                            } else {
                                images.push(...res.data.collection);
                            }


                            let html = '';
                            // if (disSrc.length === 0) {
                            //     $("#multiple").empty();
                            // }
                            console.log("Images => ", images)

                            images.map((image, index) => {
                                if (index >= indexCount) {
                                    if (image.file_name.includes('.mp4')) {
                                        html += `<div class="more-view-image">
            <div class="uploads d-flex align-items-center justify-content-center">
                                 <video width="320" height="240" controls muted> <source src="` + window.Laravel.base + image.file_name + `" type="video/mp4"> Your browser does not support the video tag. </video>
                                </div>
                                <a href="javascript:void(0)" class="placeholder-remove d-flex align-items-center justify-content-center delete-image-js" data-id=` + image.file_name + `>
                <svg xmlns="http://www.w3.org/2000/svg" width="11.001" height="11.003" viewBox="0 0 11.001 11.003">
                    <path id="Forma_1" data-name="Forma 1" d="M1028.345,545.163l-3.333,3.335,3.333,3.334a1.27,1.27,0,1,1-1.795,1.8l-3.334-3.335-3.334,3.335a1.27,1.27,0,0,1-1.795-1.8l3.333-3.334-3.333-3.335a1.269,1.269,0,0,1,1.795-1.8l3.334,3.335,3.334-3.335a1.269,1.269,0,0,1,1.8,1.8Z" transform="translate(-1017.715 -542.996)" fill="#fff"></path>
                </svg>
            </a>
            <input type="hidden" class="user-image selected-image" name="{{$inputName}}[` + index + `][file_path]" value="` + image.file_name + `" required>
            <input type="hidden" class="user-image selected-image" name="{{$inputName}}[` + index + `][file_type]" value="` + image.type + `">
            <input type="hidden" class="user-image selected-image default-img" name="{{$inputName}}[` + index + `][file_default]" value="0">
        </div>`;
                                    } else {
                                        html += `<div class="more-view-image">
            <div class="uploads d-flex align-items-center justify-content-center">
                               <img src="` + imageUrl(image.file_name, 145, 115, 95, 1) + `" class="img-fluid img" alt="">
                                </div>
                                <a href="javascript:void(0)" class="placeholder-remove d-flex align-items-center justify-content-center delete-image-js" data-id=` + image.file_name + `>
                <svg xmlns="http://www.w3.org/2000/svg" width="11.001" height="11.003" viewBox="0 0 11.001 11.003">
                    <path id="Forma_1" data-name="Forma 1" d="M1028.345,545.163l-3.333,3.335,3.333,3.334a1.27,1.27,0,1,1-1.795,1.8l-3.334-3.335-3.334,3.335a1.27,1.27,0,0,1-1.795-1.8l3.333-3.334-3.333-3.335a1.269,1.269,0,0,1,1.795-1.8l3.334,3.335,3.334-3.335a1.269,1.269,0,0,1,1.8,1.8Z" transform="translate(-1017.715 -542.996)" fill="#fff"></path>
                </svg>
            </a>
            <input type="hidden" class="user-image selected-image" name="{{$inputName}}[` + index + `][file_path]" value="` + image.file_name + `" required>
            <input type="hidden" class="user-image selected-image" name="{{$inputName}}[` + index + `][file_type]" value="` + image.type + `">
            <input type="hidden" class="user-image selected-image default-img" name="{{$inputName}}[` + index + `][file_default]" value="0">
        </div>`;
                                    }
                                    indexCount++;
                                }
                            });
                            $("#multiple").append(html);

                            $("#initial_images").val(html);
                            $(".add_btn").removeAttr("disabled");
                            //remove uploaded images from img
                            $('#choose-file-' + '{{ $imageNumber }}').val(null);


                            toastr.success(res.message);
                            let image_count = $('.more-view-image').length;

                            let image_def_boolean = false;
                            $('.default-img').each(function (index, item) {
                                if (item.value == 1) {
                                    image_def_boolean = true;
                                }
                            });

                            if (image_count >= 1 && !image_def_boolean) {
                                let selected_el = $("[name='project_images[0][file_default]']");
                                selected_el.val(1);
                                selected_el.closest('.more-view-image').find('.uploads').click();
                            }

                            // if (image_count >= 1 && image_def_boolean === false) {
                            //     let selected_el = $("[name='stadium_images[0][file_default]']");
                            //     selected_el.val(1);
                            //     selected_el.closest('.more-view-image').find('.uploads').click();
                            // }
                        }
                    }).fail(function (res) {
                        alert('{{ __('Something went wrong, please try later.') }}');
                    });
                }
            }

        });

        $(document).on('click', '.delete-image-js', function () {
            if (disSrc.length !== 0) {
                images = [];
            }
            let imagePath = $(this).data("id");
            let parentDive = $(this).parent();
            if (imagePath.length > 0) {
                @if($allowDeleteApi)
                let url = window.Laravel.apiUrl + 'remove-image';
                $.ajax({
                    url: url,
                    type: 'post',
                    data: 'image= ' + imagePath,
                    headers: {
                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                    },
                }).done(function (res) {
                    if (res.success == false) {
                        toastr.error(res.message);
                    } else {
                        toastr.success(res.message);
                        parentDive.remove();
                        if (images.length > 0) {
                            images.forEach(function (item, arrayItem) {
                                if (item.file_name === imagePath) {
                                    images.splice(arrayItem, 1);
                                }
                            });
                        }
                    }
                }).fail(function (res) {
                    toastr.error("{{ __('Something went wrong, please refresh.') }}");
                });
                @else
                parentDive.remove();
                @endif
            }
        });

        $(document).on('click', '.uploads', function () {
            // make all default values to zero
            $('.default-img').val(0);
            let newDefaultImgInput = $(this).closest('.more-view-image').find('.default-img');
            newDefaultImgInput.val(1);

            // remove and add border-default class
            let htm = '<i class="fas fa-check d-flex align-items-center justify-content-center placeholder-remove-2"></i>';
            // $('.uploads').removeClass('border-default');
            // $('.uploads').find('.fa-check').remove();
            $(".placeholder-remove-2").remove();
            // $(this).addClass('border-default');
            $(this).find('img').parent().after(htm);

            // remove and add delete icon
            $('.delete-image-js').addClass('placeholder-remove');
            $(this).closest('.more-view-image').find('.placeholder-remove').removeClass('placeholder-remove');
        });

    </script>
@endpush
