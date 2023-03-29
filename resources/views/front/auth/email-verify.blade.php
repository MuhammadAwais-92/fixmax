
@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')

    <main class="login-sec spacing-y">
        <div class="container">
          <div class="row">
            <div class="col-md-6 mx-auto">
              <div class="login-text">
                <div class="title">{{__('Enter Code')}}</div>
                <div class="title-des">{{__('Please enter verification code you received at')}} <span>{{$userData->email}}</span></div>
              </div>
              <form method="post" action = "{{route('front.auth.verification.submit')}}" id="verificationForm">
                @csrf
              <div class="common-input">
                <label class="input-label">{{__('Code')}}</label>
                <input type="text" name="verification_code" placeholder="{{__('4539')}}" minlength="4" maxlength="4" required>
                @include('front.common.alert', ['input' => 'verification_code'])
              </div>
              <button class="login-btn w-100">{{__('Submit')}}</button>
              <div class="forgot-password float-right">
                {{__("Didn't receive the code?")}}
                <a href="#" class="forgot-password verify-btn-resend register-p">{{__('Resend')}}</a>
               </div>
            </form>
            </div>
          </div>
        </div>
      </main>
@endsection

@push('scripts')

    <script>
         $('#verificationForm').validate({
          errorPlacement: function(error, element) {
            error.insertAfter(element);
          }
        });
    </script>
<script>
    $(document).ready(function () {
        $('.verify-btn-resend').on('click',function () {
            $.ajax({
                url: window.Laravel.baseUrl+"verification-resend",
                success: function (res) {
                   if(res.success == true){
                       toastr.success(res.message, '{{__("Success")}}');
                   }
                   else{
                       // toastr.error('Something went wrong');
                   }
                }
            })
        })
    })
</script>


@endpush
