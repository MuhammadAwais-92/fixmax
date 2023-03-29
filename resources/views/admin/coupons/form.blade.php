{!! Form::model($coupon, ['url' => $action, 'method' => 'post', 'role' => 'form', 'class' => 'col s12', 'enctype' => 'multipart/form-data']) !!}

<input type="hidden" name="type" value="store">
<div class="m-portlet__body mt-3">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title (English)') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            {!! Form::text('name->en', old('name->en', $coupon->name['en']), ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => __('Coupon Name'), 'required' => 'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Title (Arabic)') !!}
            <span class="text-danger">*</span>
        </label>


        <div class="col-9">

            {!! Form::text('name->ar', old('name->ar', $coupon->name['ar']), ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => __('Coupon Name'), 'required' => 'required']) !!}
        </div>
    </div>


    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Coupon Code') !!}
            <span class="text-danger">*</span>
        </label>


        <div class="col-9">
            @if (!empty($coupon->id))
                {!! Form::text('coupon_code', old('coupon_code', $coupon->coupon_code), ['class' => 'form-control', 'readonly', 'placeholder' => __(' Coupon Code'), 'required' => 'required']) !!}

            @else
                {!! Form::text('coupon_code', empty(old('coupon_code', $coupon->coupon_code)) ? generateRandomString() : old('coupon_code', $coupon->coupon_code), ['class' => 'form-control', 'id' => 'coupon_code', 'readonly', 'placeholder' => __(' Coupon Code'), 'required' => 'required']) !!}

                {{-- generateRandomString --}}
            @endif
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Discount In Percentage') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-9">

            {!! Form::number('discount', old('discount', $coupon->discount), ['class' => 'form-control', 'id' => 'first_name', 'type' => 'number', 'min' => '1', 'max' => '99', 'placeholder' => __(' Discount'), 'required' => 'required']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Coupon Type') !!}
            <span class="text-danger">*</span>
        </label>


        <div class="col-9">
            <select id="brand_id" name="coupon_type" class="form-control category_id" required>
                <option selected=disabled="disabled" value="">{{ __('Select Coupon Type') }}</option>

                <option @php echo ($coupon->coupon_type=="infinite")? "selected": "";    @endphp value="infinite">{{ __('Infinite') }}</option>

                <option @php echo ($coupon->coupon_type=="number")? "selected": "";    @endphp value="number">{{ __('Number') }}</option>

            </select>
        </div>
    </div>

    <div class="form-group m-form__group row ">
        <label for="example-text-input" class="col-3 col-form-label js-toggle-class" style="display:@php echo ($coupon->coupon_type=="infinite")? 'none': 'block';    @endphp">
            {!! __('No of Coupon') !!}
            <span class="text-danger">*</span>
        </label>

        <div class="col-9 js-toggle-class" style="display:@php echo ($coupon->coupon_type=="infinite")? 'none': 'block';    @endphp">
            {!! Form::number('coupon_number', old('coupon_number', $coupon->coupon_number), ['class' => 'form-control', 'id' => 'coupon_number', 'min' => '0', 'type' => 'number', 'placeholder' => __(' No of Coupons'), 'required' => 'required']) !!}
        </div>

    </div>


    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            {!! __('Expiry Date') !!}
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            {!! Form::text('end_date', old('end_date',Carbon\Carbon::parse($coupon->end_date)->format('m/d/Y')), ['class' => 'form-control ', 'autocomplete' => 'off', 'id' => 'end_date', 'placeholder' => __(' Expiry Date'), 'required' => 'required']) !!}
        </div>
    </div>
</div>
<div class="m-portlet__foot m-portlet__foot--fit">
    <div class="m-form__actions">
        <div class="row">
            <input type="hidden" value="PUT" name="_method">
            <input type="hidden" value="{!! $coupon->id !!}" name="user_id">
            <div class="col-4"></div>
            <div class="col-7 mb-5 mt-5">
                @if ($coupon->id > 0)
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Update Coupon
                    </button>
                @else
                    <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                        Add Coupon
                    </button>
                @endif
                <a href="{!! route('admin.dashboard.coupons.index') !!}"
                    class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>

            </div>
        </div>
    </div>
</div>
{!! Form::close() !!}
