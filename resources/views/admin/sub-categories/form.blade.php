{!! Form::model($category, ['url' => $action, 'method' => 'post',  'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<?php $x = 0; ?>

@foreach ($languages as $key => $language )
@if($key==config('settings.default_language') || $key=='en')

<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Name In  {{$language['title']}}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('name['.$key.']',old('name['.$key.']', $category->name[$key]), ['class' => 'form-control', 'placeholder' => 'Title', 'required'=>'required']) !!}
        </div>
    </div>
</div>
@if ($x == 1)
{{-- <button type="button" class="Add-field">More Question Translations</button> --}}
@endif
<?php $x++; ?>
@else
<div class="lang-input d-none">

<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Name In  {{$language['title']}}
   
        </label>
        <div class="col-7">
            {!! Form::text('name['.$key.']',old('name['.$key.']', $category->name[$key]), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
        </div>
    </div>
</div>
</div>
@endif
@endforeach
<div class="m-portlet__body">
    {{-- <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Name in Arabic') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-7">
            {!! Form::text('name[ar]',old('name[ar]', $category->name['ar']), ['class' => 'form-control', 'placeholder' => 'Title','required'=>'required']) !!}
        </div>
    </div> --}}
    <input type="hidden" name="parent_id" value="{{$category->parent_id?$category->parent_id:$parent}}">
    @include('admin.common.upload-image',['image_name'=> 'image','new_image' =>old('image', $category->image), 'current_image'=>imageUrl(old('image', $category->image_url), 100,100,90,1), 'title'=>'image', 'image_size'=>'','image_number'=>1])

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">

            <input type="hidden" value="PUT" name="_method">
{{--            <input type="hidden" name="language_id" value="{!! $languageId !!}">--}}
            <div class="col-4"></div>
            <div class="col-7">
                @if($categoryId == 0)
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                        Add Sub Category
                    </button>
                @else
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-3">
                        Update Sub Category
                    </button>
                @endif
                <a href="{!! route('admin.dashboard.categories.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
<script>
    $(document).ready(function () {
        $('.select_image').hide();
    });

    $(document).ready(function () {
        $(document).on('change', '.btn-file :file', function () {
            var input = $(this),
                label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function (event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if (input.length) {
                input.val(log);
            } else {
                if (log) alert(log);
            }

        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#img-upload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function () {
            readURL(this);
        });
    });
</script>
