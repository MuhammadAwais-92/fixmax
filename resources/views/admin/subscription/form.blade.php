{!! Form::model($package, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'm-form m-form--fit m-form--label-align-right', 'enctype' => 'multipart/form-data']) !!}
<div class="m-portlet__body">
    <?php $x = 0; ?>

    @foreach ($languages as $key => $language )
    @if($key==config('settings.default_language') || $key=='en')
    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Title In {{$language['title']}}
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            {!! Form::text('name['.$key.']', old('name['.$key.']', $package->name[$key]), ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required']) !!}
        </div>
    </div>
    @if($x==1)
    {{-- <button type="button" class="Add-field">More Question Translations</button> --}}
   
    @endif
    <?php $x++; ?>
    @else
    <div class="lang-input ">
    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Title In {{$language['title']}}
    
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            {!! Form::text('name['.$key.']', old('name['.$key.']', $package->name[$key]), ['class' => 'form-control', 'placeholder' => 'Title']) !!}
        </div>
    </div>
    </div>
    @endif
    @endforeach
{{-- 
    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Title Arabic
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            {!! Form::text('name[ar]', old('name[ar]', $package->name['ar']), ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required']) !!}
        </div>
    </div> --}}

    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Price
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">

            {!! Form::number('price', old('price',$package->price), ['class' => 'form-control','type'=>'number', 'placeholder' => '240', 'max'=>999999, 'required' => 'required', 'min'=>'1']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                {!! __('Duration') !!}
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            <!-- <div class="d-flex align-items-center flex-wrap"> -->
            <div class="subscripton-number mb-2">
                @if(old('duration_type', $package->duration_type) == 'years' )
                {!! Form::number('duration', old('duration',$package->duration), ['class' => 'form-control duration_number','type'=>'number', 'id'=>'duration_number','max'=>9,'placeholder' => 'Duration', 'required' => 'required', 'min'=>'1']) !!}
                @else
                {!! Form::number('duration', old('duration',$package->duration), ['class' => 'form-control duration_number','type'=>'number', 'id'=>'duration_number','max'=>99,'placeholder' => 'Duration', 'required' => 'required', 'min'=>'1']) !!}
                @endif
            </div>
            <div class="subscripton-checkbox">
                <input type="radio" class="duration_day" id="duration_day" {{old('duration_type',$package->duration_type) == 'days'? 'checked':''}} name="duration_type" value="days"> {!! __('Days') !!}&nbsp;&nbsp;&nbsp;
                <input type="radio" class="duration_month" id="duration_month" {{old('duration_type',$package->duration_type) == 'months'? 'checked':''}}  name="duration_type" value="months"> {!! __('Months') !!}&nbsp;&nbsp;&nbsp;
                <input type="radio" class="duration_year" id="duration_year" {{old('duration_type',$package->duration_type) == 'years'? 'checked':''}} name="duration_type" value="years"> {!! __('Years') !!}
            </div>
            <!-- </div> -->
        </div>

    </div>

    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Type
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            <select id="city_id" name="subscription_type" class=" form-control dropdown custom-drop-down-uss" required>
                <option selected="true" disabled="disabled" value="">Select Type</option>
                <option value="supplier" {{old('type',$package->subscription_type) == 'supplier'? 'selected': ''}}>
                    For Supplier
                </option>
                <option value="featured" {{old('type',$package->subscription_type) == 'featured'? 'selected': ''}}>
                   For Feature Services
                </option>
                {{-- <option value="free" {{old('type',$package->subscription_type) == 'free'? 'selected': ''}}>
                    Free
                </option> --}}
            </select>
            @include('front.common.alert', ['input' => 'type'])
        </div>

        <div class="col-5">
        </div>
    </div>
    <?php $x=0; ?>

    @foreach ($languages as $key => $language )
    @if($key==config('settings.default_language') || $key=='en')
    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Description {{$language['title']}}
                <span class="text-danger">*</span>
            
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            {!! Form::textarea('description['.$key.']', old('description['.$key.']', $package->description[$key]), ['class' => 'form-control', 'placeholder' => 'Description']) !!}
        </div>
    </div>
    @if($x==1)
    {{-- <button type="button" class="Add-new-field">More Answer Translations</button> --}}
   
    @endif
    <?php $x++; ?>
    @else
 <div class="lang-new-input ">

    <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Description {{$language['title']}}
            
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            {!! Form::textarea('description['.$key.']', old('description['.$key.']', $package->description[$key]), ['class' => 'form-control', 'placeholder' => 'Description']) !!}
        </div>
    </div>
 </div>
    @endif
@endforeach
    {{-- <div class="form-group m-form__group row">
        <div class="col-lg-3 col-md-3">
            <label for="example-text-input" class="col-form-label">
                Description Arabic
                <span class="text-danger">*</span>
            </label>
        </div>
        <div class="col-lg-7 col-md-7">
            {!! Form::textarea('description[ar]', old('description[ar]', $package->description['ar']), ['class' => 'form-control', 'placeholder' => 'Description']) !!}
        </div>
    </div> --}}


</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" name="package_id" value="{!! $packageId !!}">
            <!-- <div class="col-4"></div> -->
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-2">
                    @if($packageId ==0)
                    Add Package
                    @else
                    Update Package
                    @endif
                </button>
                <a href="{!! route('admin.dashboard.subscriptions.index') !!}" class="btn btn-secondary m-btn m-btn--air m-btn--custom mx-2">Cancel</a>
            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
