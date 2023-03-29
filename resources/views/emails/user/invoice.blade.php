<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"> --}}
    <title>{{__('Fix Max Invoice')}}</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .sm-w-full {
            width: 100% !important;
        }

        a {
            text-decoration: none;
        }

    </style>
</head>

<body style="margin: 0;">
    <div style="width: 640px; margin: 0 auto; height: 100vh; position: relative;">
        <!-- top header background -->
        <table style="background-color: #022C44; padding: 15px; width: 100%;">
        </table>
        <div class="wrap" style="padding: 30px 30px;">
            <div>
                <!-- logo and title table -->
                <table style=" width: 100%; padding-bottom:50px;">
                    <tr>
                        <td>
                            <a href="#">
                                <img src="{{ asset('assets/front/img/invoice-logo.png') }}" alt="logo">
                            </a>
                        </td>
                        <td>
                            <table style="width:100%; margin-right: left; text-align: right;">
                                <tr>
                                    <td class="lats-tab--"
                                        style="font-weight: bold; font-size: 35px; color: #022C44;">
                                        {{__('Invoice')}}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="lats-tab--"
                                        style="font-weight: bold; font-size: 16px; color: #022C44;">
                                        {{__('Invoice No')}}: <span style="color: #444444;">#
                                            {{ $data['order']->order_number }}</span>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- contact information table -->
                <table style="width: 100%; padding-bottom:50px; color: #022C44;">
                    <tr>
                        <td style="font-size: 18px; font-weight: bold;">
                            {{ $data['order']->user->user_name }}
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px;font-weight: 400; color: #707070;">
                            {{__('Phone Number')}}:
                            <a style="font-size: 15px;font-weight: 400; color: #707070;" href="tel:971 41239842">
                                {{ $data['order']->user->phone }}
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 15px;font-weight: 400; color: #707070;">
                            {{__('Email')}}:
                            <a style="font-size: 15px;font-weight: 400; color: #707070;"
                                href="mailto:john.doe@mail.com">
                                {{ $data['order']->user->email }}
                            </a>
                        </td>
                    </tr>
                </table>

            </div>
            <!-- items table -->
            @if ($data['order']->status == 'completed')
                <div class="overflow-x">
                    <table style="width: 100%; border-collapse: collapse; padding-bottom: 40px;">
                        <thead style="background-color: #022C44 ; padding: 10px 0; height: 40px; margin-bottom: 20px;">
                            <tr style="text-align: center;">
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Service')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Equipment')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Service Fees')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Equipment Fees')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Quantity')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Payment Method')}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="height: 20px; width: 100%;"></tr>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($data['order']->orderItems as $item)
                                <tr style="height: 35px; background-color: #ffe52c1f;">

                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                        @if ($i == '0')
                                            {{ translate($data['order']->service_name) }}
                                        @endif
                                    </td>

                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                        {{ translate($item->name) }}
                                    </td>

                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                        @if ($i == '0')
                                            AED {{ $data['order']->quoated_price }}
                                        @endif
                                    </td>

                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                        AED {{ $item->price }}
                                    </td>
                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                        {{ $item->quantity }}
                                    </td>
                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                        @if ($i == '0')
                                            {{__('PayPal')}}
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach


                        </tbody>
                    </table>
                </div>
            @else
                <div class="overflow-x">
                    <table style="width: 100%; border-collapse: collapse; padding-bottom: 40px;">
                        <thead style="background-color: #022C44 ; padding: 10px 0; height: 40px; margin-bottom: 20px;">
                            <tr style="text-align: center;">
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Service')}}
                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Equipment')}}

                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Service Fees')}}

                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Equipment Fees')}}

                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Quantity')}}

                                </th>
                                <th style="font-size: 14px;font-weight: 400;color: #fff; text-align:center;">
                                    {{__('Payment Method')}}

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="height: 20px; width: 100%;"></tr>
                            @if ($data['order']->issue_type == 'konw')
                                @php
                                    $i = 0;
                                @endphp
                                @foreach ($data['order']->orderItems as $item)
                                    <tr style="height: 35px; background-color: #ffe52c1f;">

                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            @if ($i == '0')
                                                {{ translate($data['order']->service_name) }}
                                            @endif
                                        </td>

                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            {{ translate($item->name) }}
                                        </td>

                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            @if ($i == '0')
                                                AED {{ $data['order']->quoated_price }}
                                            @endif
                                        </td>

                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            AED {{ $item->price }}
                                        </td>
                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            {{ $item->quantity }}
                                        </td>
                                        <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">
                                            @if ($i == '0')
                                                {{__('PayPal')}}
                                            @endif
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            @else
                                <tr style="height: 35px; background-color: #ffe52c1f;">

                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">

                                        {{ translate($data['order']->service_name) }}

                                    </td>

                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">

                                    </td>

                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">

                                    </td>

                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">

                                    </td>
                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">

                                    </td>
                                    <td style="font-size: 14px;font-weight: 400;color: #444; text-align:center;">

                                        {{__('PayPal')}}

                                    </td>
                                </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            @endif
            <!-- Amount summery table -->
            <div class="overflow-x">
                <table
                    style="background-color: #fff;border-radius: 15px; box-shadow: 0 3px 30px #00000029; padding: 16px 20px 16px; width: 70%;margin-left: auto; margin-top: 40px;">
                    <thead>
                        <tr>
                            <td>
                                <h5
                                    style="font-size: 18px; font-weight: bold; color: #022C44; margin: 0; text-align: left; margin-bottom: 15px; line-height: 22px;">
                                    {{__('Amount Summary')}}
                                </h5>
                            </td>
                        </tr>
                    </thead>
                    @if ($data['order']->status == 'completed')
                        <tbody>
                            <tr>
                                <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">
                                    {{__('Equipment
                                    Charges')}}</td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $data['order']->subtotal }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">{{__('Visit
                                    Fee')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $data['order']->visit_fee }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">{{__('Service
                                    Charges')}}</td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $data['order']->quoated_price }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">{{__('VAT')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $data['order']->vat_1 + $data['order']->vat_2 }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">{{__('Total')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $data['order']->total_amount }}</td>
                            </tr>
                        </tbody>
                    @else
                        <tbody>
                            @if ($data['order']->issue_type == 'know')
                                <tr>
                                    <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">
                                        {{__('Equipment
                                        Charges')}}</td>
                                    <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">
                                        AED
                                        {{ $data['order']->subtotal }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">{{__('Visit
                                    Fee')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $data['order']->visit_fee }}</td>
                            </tr>
                            @if ($data['order']->issue_type == 'know')
                            <tr>
                                <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">{{__('Service
                                    Charges')}}</td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $data['order']->quoated_price }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">{{__('VAT')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $data['order']->vat_1 + $data['order']->vat_2 }}</td>
                            </tr>
                            <tr>
                                <td style="font-size: 16px; font-weight: 400; color: #999999; text-align: left;">{{__('Total')}}
                                </td>
                                <td style="font-size: 16px; font-weight: 400; color: #444444; text-align: right;">AED
                                    {{ $data['order']->amount_paid }}</td>
                            </tr>
                        </tbody>
                    @endif
                </table>
            </div>

        </div>
        <!-- footer table -->

        <table style="width: 100%;background-color: #022C44; height: 70px; position: absolute; bottom: 0;">
          <tr style="background-image: url({{ asset('assets/front/img/yellow-bg-01.png') }}); background-position: center; background-repeat: no-repeat; display: flex; justify-content: center; align-items: center; height: 60px; margin-top: -31px;">
            <td style="text-align: center; font-size: 15px; color: #022C44; font-weight: 400;">{{__('Copyright')}} © <a href="#" style="font-size: 15px; color: #022C44; font-weight: 400;">FixMax</a> - All Rights Reserved</td>
          </tr>
      </table>
    </div>
</body>

</html>
