{!! Form::model($user, ['url' => $action, 'method' => 'post', 'id' => 'storeForm', 'role' => 'form', 'class' => 'col s12', 'enctype' => 'multipart/form-data']) !!}
{!! Form::hidden('user_type', old('user_type', 'supplier'), ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => __('e.g John'), 'required' => 'required']) !!}
{!! Form::hidden('terms_conditions', old('terms_conditions', '1'), ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => __('e.g John'), 'required' => 'required']) !!}
<input type="hidden" value="PUT" name="_method">
<input type="hidden" value="{!! $user->id ?? 0 !!}" name="user_id">

{{-- @dd(session()->all()) --}}
<div class="m-portlet__body">
    <?php $x=0; ?>
    @foreach ($languages as $key => $language )
    @if($key==config('settings.default_language') || $key=='en')
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Supplier Name In {{$language['title']}}
            <span class="text-danger">*</span>
        </label>

        <div class="col-9">
            {!! Form::text('supplier_name['.$key.']', old('supplier_name['.$key.']', $user->supplier_name[$key]), ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => 'Supplier Name In '.$language['title'].'', 'required' => 'required']) !!}
        </div>
    </div>
    @if($x==1)
    {{-- <button type="button" class="Add-new-field">More Answer Translations</button> --}}
   
    @endif
    <?php $x++; ?>
    @else
    <div class="lang-new-input ">
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Supplier Name In {{$language['title']}}
           
        </label>

        <div class="col-9">
            {!! Form::text('supplier_name['.$key.']', old('supplier_name['.$key.']', $user->supplier_name[$key]), ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => 'Supplier Name In '.$language['title'].'']) !!}
        </div>
    </div>
    </div>
    @endif
@endforeach
    {{-- <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Supplier Name Arabic --}}
            {{-- <span class="text-danger">*</span> --}}
        {{-- </label>

        <div class="col-9">
            {!! Form::text('supplier_name[ar]', old('supplier_name[ar]', $user->supplier_name['ar']), ['class' => 'form-control', 'id' => 'first_name', 'placeholder' => 'Supplier Name In Arabic']) !!}
        </div>
    </div> --}}


    @include('admin.common.upload-image',[
    'image_name'=> 'image',
    'new_image' =>old('image', $user->image),
    'current_image'=>imageUrl(old('image', $user->image_url), 100,100,90,1),
    'title'=>'Display picture',
    'image_size'=>'',
    'image_number'=>1
    ])

    @include('admin.common.upload-supplier-image',[
    'image_name'=> 'trade_license_image',
    'new_image' =>old('image', $user->trade_license_image),
    'current_image'=>imageUrl(old('image', $user->trade_license_image_url), 100,100,90,1),
    'title'=>'Trade License Image',
    'image_size'=>'',
    'image_number'=>2,
    'current_light_image' =>old('image', $user->trade_license_image_url),
    ])
<div class="form-group m-form__group row">
    <label for="example-text-input" class="col-3 col-form-label">
        Is Approved
        <span class="text-danger"></span>
    </label>
    <div class="col-9">
        <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c">
            <input type="radio" {!! old('is_id_card_verified', $user->is_id_card_verified) == '1' ? 'checked' : '' !!} name="is_id_card_verified" @checked(true) value="1">
            <span class="log checkmark"></span>Yes
        </label>
        <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c">
            <input type="radio" {!! old('is_id_card_verified', $user->is_id_card_verified) == '0' ? 'checked' : '' !!} name="is_id_card_verified" value="0">
            <span class="log checkmark"></span>No
        </label>
    </div>
</div>
    <div class="form-group m-form__group row align-items-start" id="div_pak_show">
        <label for="example-text-input" class="col-form-label col-3">
            Subscription Package
            {{-- <span class="text-danger">*</span> --}}
        </label>
        <div class="col-lg-9 col-md-9 col-12">
            <select name="package_id" class="form-control" id="dropdown"
                @if ($user->expiry_date != null) disabled @endif>
                <option value="">Select Subscription Package</option>
                @forelse($packages as $package)
                    <option value="{{ $package->id }}"
                        {{ old('package_id', $userSubscriptionId) == $package->id ? 'selected' : '' }}>
                        {{ $package->name['en'] }}</option>
                @empty
                @endforelse
                @if (count($packages) == 0)
                    <option selected="true" disabled="disabled" value="">No Subscription Packages have been created
                    </option>
                @endif
            </select>
            <input type="text" name="remove_package" value="0" id="remove-package" hidden>

            @if ($user->expiry_date != null)
                <div class="d-flex align-items-center my-2">
                    <button type="button" id="del_pak" @if ($user->expiry_date == null) disabled="disabled" @endif
                        class="btn btn-accent m-btn m-btn--air m-btn--custom upload-id-card-image mr-2">
                        Delete Package
                    </button>
                    @if ($user->expiry_date != null)
                        <p id="delete_msg" class="text-danger smaller-font-size my-0">Package Expiry
                            Date: {{ Carbon\Carbon::parse($user->expiry_date)->format('d/m/Y') }}</p>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Email
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            {!! Form::text('email', old('email', $user->email), ['class' => 'form-control', 'id' => 'email', 'placeholder' => __('e.g johndoe@mail.com '), 'required' => 'required']) !!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Is email verified
            <span class="text-danger"></span>
        </label>
        <div class="col-9">
            <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c">
                <input type="radio" {!! old('is_verified', $user->is_verified) == '1' ? 'checked' : '' !!} name="is_verified" checked value="1">
                <span class="log checkmark"></span>Yes
            </label>
            <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c">
                <input type="radio" {!! old('is_verified', $user->is_verified) == '0' ? 'checked' : '' !!} name="is_verified" value="0">
                <span class="log checkmark"></span>No
            </label>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Address
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            {!! Form::text('address', old('address', $user->address), ['class' => 'form-control', 'placeholder' => 'Address', 'id' => 'searchmap']) !!}
            {!! Form::hidden('longitude', old('longitude', $user->longitude), ['class' => 'form-control', 'placeholder' => 'Address', 'id' => 'longitude']) !!}
            {!! Form::hidden('latitude', old('latitude', $user->latitude), ['class' => 'form-control', 'placeholder' => 'Address', 'id' => 'latitude']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Change Position
            <span class="text-danger"></span>
        </label>
        <div class="col-9">
            <div id="map" style="height:400px; width:100%;margin-top: 48px"></div>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Categories
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            <select id="category_id" name="category" class="form-control category_id" required>
                <option selected="true" disabled="disabled" value="">Select Catgeory</option>
                @forelse($categories as $category)
                    <option value="{{ $category->id }}" @if (old('category', $user->category_id) == $category->id) selected @endif>
                        {!! translate($category->name) !!}</option>
                @empty
                    <option selected="true" disabled="disabled" value="">No Catgeories have been created</option>
                @endforelse
            </select>
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            City
            <span class="text-danger">*</span>
        </label>
        <div class="col-9">
            @if ($user && $user->city_id)
                <select id="city_id" name="city" class="form-control category_id" required>
                    {{-- <option selected="true" disabled="disabled" value="">Select City</option> --}}
                    @forelse($cities as $city)
                        <option value="{{ $city->id }}" @if (old('city', $user->city_id) == $city->id) selected @endif>
                            {!! translate($city->name) !!}</option>
                        {{-- @if ($user->city_id == $city->id)
                        @break
                    @endif --}}
                @empty
                    <option selected="true" disabled="disabled" value="">No cities have been created</option>
                @endforelse
            </select>
        @else
            <select id="city_id" name="city" class="form-control category_id" required>
                <option selected="true" disabled="disabled" value="">Select City</option>
                @forelse($cities as $city)
                    <option value="{{ $city->id }}" @if ( $user->city_id == $city->id) selected @endif>
                        {!! translate($city->name) !!}</option>
                @empty
                    <option selected="true" disabled="disabled" value="">No cities have been created</option>
                @endforelse
            </select>
        @endif

    </div>
</div>
<div class="form-group m-form__group row">
    <label for="example-text-input" class="col-3 col-form-label">
    </label>
    <div class="col-9" id="area">

    </div>
</div>
<div class="form-group m-form__group row">
    <label for="example-text-input" class="col-3 col-form-label">
       Visit Fee
        <span class="text-danger">*</span>
    </label>
    <div class="col-9">
        {!! Form::number('visit_fee', old('visit_fee', $user->visit_fee), ['class' => 'form-control',  'max' => '999999',  'placeholder' => __('e.g 20 AED'), 'required' => 'required']) !!}
    </div>
</div>
<div class="form-group m-form__group row">
    <label for="example-text-input" class="col-3 col-form-label">
        Phone
        <span class="text-danger">*</span>
    </label>
    <div class="col-9">
        <input  class="form-control " name="phone" type="tel" id="phone" value="{{ old('phone', $user->phone) }}" placeholder="895632542" required autocomplete="off"
        maxlength="14" minlength="11">
        <div class="phone_number"></div>   
    </div>
</div>

<div class="form-group m-form__group row">
    <label for="example-text-input" class="col-3 col-form-label">
        Is Active
        <span class="text-danger"></span>
    </label>
    <div class="col-9">
        <label class="check text-capitalize black gothic-normel option-g mr-3 mb-0 p-c">
            <input type="radio" {!! old('is_active', $user->is_active) == '1' ? 'checked' : '' !!} name="is_active" checked value="1">
            <span class="log checkmark"></span>Yes
        </label>
        <label class="check mr-3 text-capitalize black gothic-normel option-g mb-0 p-c">
            <input type="radio" {!! old('is_active', $user->is_active) == '0' ? 'checked' : '' !!} name="is_active" value="0">
            <span class="log checkmark"></span>No
        </label>
    </div>
</div>

@if ($user->id < 1)
    <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            Password
            @if ($user->id == 0)
                <span class="text-danger">*</span>
            @endif
        </label>
        <div class="col-9">
            @if ($user->id > 0)
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => __('******')]) !!}
            @else
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'password', 'placeholder' => __('******'), 'required' => 'required']) !!}
            @endif
        </div>
    </div>

<div class="form-group m-form__group row">
    <label for="example-text-input" class="col-3 col-form-label">
        Confirm Password
        @if ($user->id == 0)
            <span class="text-danger">*</span>
        @endif
    </label>
    <div class="col-9">
        @if ($user->id > 0)
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'placeholder' => __('******')]) !!}
        @else
            {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'password_confirmation', 'placeholder' => __('******'), 'required' => 'required']) !!}
        @endif
    </div>
</div>
@endif
{{-- <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            About in English --}}
{{-- <span class="text-danger">*</span> --}}
{{-- </label>
        <div class="col-9">
            {!! Form::textarea('about[en]', old('about[en]', $user->about['en']), ['class' => 'form-control', 'placeholder' => 'About In English']) !!}
        </div>
    </div> --}}

{{-- <div class="form-group m-form__group row">
        <label for="example-text-input" class="col-3 col-form-label">
            About in Arabic --}}
{{-- <span class="text-danger">*</span> --}}
{{-- </label>
        <div class="col-9">
            {!! Form::textarea('about[ar]', old('about[ar]', $user->about['ar']), ['class' => 'form-control', 'placeholder' => 'About In Arabic']) !!}
        </div>
    </div> --}}


</div>
<div class="m-portlet__foot m-portlet__foot--fit">
<div class="m-form__actions">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-7 mb-3 mt-3">
            @if ($user->id > 0)
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                    Update Supplier
                </button>
            @else
                <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom mx-4">
                    Add Supplier
                </button>
            @endif
            <a href="{!! route('admin.dashboard.suppliers.index') !!}"
                class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</a>
        </div>
    </div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $userId = '<?php echo $user->id; ?>';
        if ($userId) {
            var countryId = $('#city_id').val();
            $.ajax({
                url: window.Laravel.baseUrl + "get-areas/" + countryId + '/' + $userId,
                type: "get",
                success: function(response) {
                    $('#area').append(response.data);
                },
            });
        } else {
            $('#city_id').on('change', function(e) {
                var countryId = this.value;
                $('#area').html('');
                $.ajax({
                    url: window.Laravel.baseUrl + "get-areas/" + countryId,
                    type: "get",
                    success: function(response) {
                        $('#area').append(response.data);
                    },
                });
            });
        }

    });
</script>
<script>
    $("#del_pak").on("click", function(e) {
        e.preventDefault();
        $("#dropdown").prop('disabled', false);
        $("#dropdown").val("");
        $("#del_pak").prop('disabled', true);
        $("#delete_msg").css('display', 'block');
        $("#remove-package").val("1");


    });
    $("#dropdown").on("change", function(e) {
        e.preventDefault();
        $("#delete_msg").css('display', 'none');


    });
</script>
{!! Form::close() !!}
