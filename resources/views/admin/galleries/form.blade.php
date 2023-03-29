{!! Form::model($gallery, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'col s12', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
 
    @include('admin.common.upload-image',[
        'image_name'=> 'image',
        'new_image' =>old('image', $gallery->image),
        'current_image'=>imageUrl(old('image', $gallery->image_url), 360,360,90,1),
        'title'=>'Image',
        'image_size'=>'Recommended size 360 x 360',
        'image_number'=>2
        ])

</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{!! $languageId !!}" name="language_id">
            <div class="col-4"></div>
            <div class="col-7">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom button-margin">
                    @if($galleryId == 0)
                        Add Image
                    @else
                        Save Changes
                    @endif
                </button>
                <a href="{!! route('admin.dashboard.galleries.index') !!}"
                   class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}



