<!doctype html>
<html lang="zxx" >

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css?family=Noto+Sans&subset=devanagari" rel="stylesheet">   <!-- hindi language font cdn -->
  
    <title>{{__('Fix Max Invoice')}}</title>
    <style>
        
        .rtl{
            direction: {{$locale=='ar' || $locale=='ur' ? 'rtl' : 'ltr'}};
            
        }
        @if(  $locale=='ru' || $locale=='ar')
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        @elseif($locale=='hi')
        body {
            font-family: Noto Sans, sans-serif;
        }
        @elseif($locale=='ur')
        body {
             font-family:  DejaVu Sans, serif;

        }
        @else
        body {
            font-family: Poppins, sans-serif;
        }
        @endif

        .sm-w-full {
            width: 100% !important;
        }

        a {
            text-decoration: none;
        }
    </style>
</head>

<body class="{{$locale=='ar' || $locale=='ur' ? 'rtl' : 'ltr'}}" style="margin: 0;">
    <div style="width: 640px; margin: 0 auto; height: 100vh; position: relative;">
        <!-- top header background -->
        <table style="background-color: #022C44; padding: 0; width: 100%;">
           <p style="color:#fff; font-weight: bold; font-size: 16px; text-align:center;"> {{ config('settings.company_name') }}</p>
        </table>
        <div class="wrap" style="padding: 30px 30px;">
            <div>
                <!-- logo and title table -->
                <table style=" width: 100%; padding-bottom:50px;">
                    <tr >
                        <td style="vertical-align: middle">
                            <a href="#">
                                <img style="max-width:78px; width:100%" src="{{ asset('assets/front/img/invoice-logo.png') }}" alt="logo">
                            </a>
                        </td>
                        <td style="vertical-align: middle; ">
                            <table style="width:100%; margin-right: left; text-align: right; ">
                                <tr>
                                    <td class="lats-tab--"
                                        style="font-weight: {{$locale=='hi' ? '' : 'bold'}}; font-size: 35px; color: #022C44; ">
                                        {{__('Invoice')}} 
                                    </td>
                                </tr>
                                <tr>
                                    <td class="lats-tab--"
                                        style="font-weight: {{$locale=='hi' ? '' : 'bold'}}; font-size: 16px; color: #022C44; direction: {{$locale=='ar' || $locale=='ur' ? 'rtl' : 'ltr'}}">
                                        {{__('Invoice No')}}: <span style="color: #444444;"># {{ $order->order_number }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- contact information table -->
                <table style="width: 100%; text-align:left; padding-bottom:50px; color: #022C44;text-align: {{$locale=='ar' || $locale=='ur' ? 'right' : 'left'}}">
                    <tr>
                        <td style="font-size: 18px; font-weight: bold;">
                            {{ $order->user->user_name }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px;font-weight: 400; color: #707070;">
                            {{__('Phone Number')}}:
                            <a style="font-size: 15px;font-weight: 400; color: #707070;" href="tel:971 41239842">
                                {{ $order->user->phone }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px;font-weight: 400; color: #707070;">
                            {{__('Email')}}:
                            <a style="font-size: 15px;font-weight: 400; color: #707070;"
                                href="mailto:john.doe@mail.com">
                                {{ $order->user->email }}
                            </a>
                        </td>
                    </tr>
                </table>

            </div>
            <!-- items table -->
            @if ($order->status == 'completed')
            <p>  {{__('Paymnet Method')}} :{{__('Paypal')}}</p>
          
                <div class="overflow-x">
                    <table style="width: 100%; border-collapse: collapse; padding-bottom: 40px;">
                        <thead style="background-color: #022C44 ; padding: 10px 0; height: 40px; margin-bottom: 20px;">
                            <tr style="text-align: center;">
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Service')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Service Charges')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Visit Fee')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="height: 20px; width: 100%;"></tr>
                            <tr style="height: 35px; background-color: #ffe52c1f;">
                                <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                    {{ translate($order->service_name) }}
                                </td>
                                <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                    AED {{ $order->quoated_price }}
                                </td>
                                <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                    AED {{ $order->visit_fee }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if ($order->orderItems->isNotEmpty())
                    <div class="overflow-x">
                        <table style="width: 100%; border-collapse: collapse; padding-bottom: 40px;">
                            <thead
                                style="background-color: #022C44 ; padding: 10px 0; height: 40px; margin-bottom: 20px;">
                                <tr style="text-align: center;">
                                    <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                        {{__('Equipment')}}
                                    </th>
                                    <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                        {{__('Equipment Fees')}}
                                    </th>
                                    <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                        {{__('Quantity')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="height: 20px; width: 100%;"></tr>
                                @foreach ($order->orderItems as $item)
                                    <tr style="height: 35px; background-color: #ffe52c1f;">
                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            {{ translate($item->name) }}
                                        </td>
                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            AED {{ $item->price }}
                                        </td>
                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            {{ $item->quantity }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @else
            <p>  {{__('Paymnet Method')}} :{{__('Paypal')}}</p>
                <div class="overflow-x">
                    <table style="width: 100%; border-collapse: collapse; padding-bottom: 40px;">
                        <thead style="background-color: #022C44 ; padding: 10px 0; height: 40px; margin-bottom: 20px;">
                            <tr style="text-align: center;">
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Service')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Service Charges')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Visit Fee')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="height: 20px; width: 100%;"></tr>
                            <tr style="height: 35px; background-color: #ffe52c1f;">
                                <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                    {{ translate($order->service_name) }}
                                </td>
                                <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                    AED {{ $order->min_price }} - AED {{ $order->max_price }}
                                </td>
                                <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                    AED {{ $order->visit_fee }} 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @if ($order->issue_type == 'know')
                    <div class="overflow-x">
                        <table style="width: 100%; border-collapse: collapse; padding-bottom: 40px;">
                            <thead
                                style="background-color: #022C44 ; padding: 10px 0; height: 40px; margin-bottom: 20px;">
                                <tr style="text-align: center;">
                                    <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                        {{__('Equipment')}}
                                    </th>
                                    <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                        {{__('Equipment Fees')}}
                                    </th>
                                    <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                        {{__('Quantity')}}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr style="height: 20px; width: 100%;"></tr>
                                @foreach ($order->orderItemsBought as $item)
                                    <tr style="height: 35px; background-color: #ffe52c1f;">
                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            {{ translate($item->name) }}
                                        </td>
                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            AED {{ $item->price }}
                                        </td>
                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            {{ $item->qty_1 }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif
            <!-- Amount summery table -->
            <div class="overflow-x">
                <table
                    style="background-color: #fff;border-radius: 15px; box-shadow: 0 3px 30px #00000029; padding: 16px 20px 16px; width: 70%;margin-left: auto; margin-top: 40px;">
                    <thead>
                        <tr>
                            <td>
                                <h5
                                    style="font-size: 18px;font-weight: {{$locale=='hi' ? '' : 'bold'}}; color: #022C44; margin: 0; text-align: left; margin-bottom: 15px; line-height: 22px;">
                                    {{__('Amount Summary')}}
                                </h5>
                            </td>
                        </tr>
                    </thead>
                    @if ($order->status == 'completed')
                        <tbody>
                            @if ($order->orderItems->isNotEmpty())
                                <tr>
                                    <td ">
                                        {{__('Equipment Charges')}}</td>
                                    <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">
                                        AED
                                        {{ $order->subtotal }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td ">{{__('Visit Fee')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $order->visit_fee }}</td>
                            </tr>
                            <tr>
                                <td ">{{__('Service Charges')}}</td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $order->quoated_price }}</td>
                            </tr>
                            <tr>
                                <td ">{{__('VAT')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $order->vat_1 + $order->vat_2 }}</td>
                            </tr>
                            <tr>
                                <td ">{{__('Coupon Discount')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">-AED
                                    {{ $order->discount }}</td>
                            </tr>
                            <tr>
                                <td ">{{__('Total')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $order->total_amount }}</td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                            @if ($order->issue_type == 'know')
                                <tr>
                                    <td ">
                                        {{__('Equipment Charges')}}</td>
                                    <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">
                                        AED
                                        {{ $order->subtotal }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td >{{__('Visit Fee')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $order->visit_fee }}</td>
                            </tr>
                            <tr>
                                <td >{{__('VAT')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $order->vat_1 + $order->vat_2 }}</td>
                            </tr>
                            <tr>
                                <td >{{__('Total')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $order->amount_paid }}</td>
                            </tr>
                        </tbody>
                    @endif
                </table>
            </div>

        </div>
        <!-- footer table -->

        <table style="width: 100%;background-color: #022C44;  position: absolute; bottom: 50px; padding:10px 20px">
          {{-- <tr style="background-image: url({{ asset('assets/front/img/yellow-bg-01.png') }}); background-position: center; background-repeat: no-repeat; padding:15px;  height: 60px; margin-top: -31px;">
            <td style="text-align: center; font-size: 15px; color: #022C44; font-weight: 400;">Copyright © <a href="#" style="font-size: 15px; color: #022C44; font-weight: 400;">FixMax</a> - All Rights Reserved</td>
          </tr> --}}
          <tr>
            <td style="font-size: 15px;font-weight: 400; color: #fff;">
                {{__('Email')}}:
                <a style="font-size: 15px;font-weight: 400; color: #fff;" href="tel:971 41239842">
                    {{ config('settings.email') }}
                </a>
            </td>
            <td style="font-size: 15px;font-weight: 400; color: #fff; text-align:right;">
                {{__('Phone')}}:
                <a style="font-size: 15px;font-weight: 400; color: #fff;"
                    href="mailto:john.doe@mail.com">
                    {{ config('settings.contact_number') }}
                </a>
            </td>
          </tr>
          <tr>
            <td style="font-size: 15px;font-weight: 400; color: #fff;">
                {{__('Address')}}:
                 <a style="font-size: 15px;font-weight: 400; color: #fff;"
                     href="mailto:john.doe@mail.com">
                     {{ config('settings.address') }}
                 </a>
             </td>
          </tr>
            

      </table>
    </div>
</body>

</html>
