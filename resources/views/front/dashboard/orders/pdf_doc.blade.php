<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__('Adil Alrooh')}}</title>
    <style type="text/css">
        ul {
            list-style-type: none;
        }

        li {
            list-style-type: decimal;
        }

        .my-table-list li {
            margin-bottom: 10px;
        }

        .my-table-list li td {
            font-weight: 500;
            text-transform: capitalize;
        }

        .my-table-list li:last-chlid {
            margin-bottom: 0px
        }

        .expenses-t-d .expenses-t-d th,
        .expenses-t-d td {
            border: 3px solid white;
            border-collapse: collapse;
            text-align: left;

        }

        .expenses-t-d th {
            background-color: #801818;
            height: 40px;
            padding: 0 10px;
            text-transform: capitalize;
            color: #d5ae6c;
        }

        .expenses-t-d td {
            height: 40px;
            color: #222;
            padding: 0 10px;
        }
    </style>
</head>

<body>
    <header class="clearfix" style="background-color: #801818;text-align: center;padding: 30px 0;">
        <div id="logo">
            <img src="{{asset('pdf/headerlogo-100.png')}}" alt="">
            {{-- <img src="https://alpha.mytechnology.ae/arooh013/frontassets/images/hlogo.png" alt="">--}}
        </div>
    </header>
    <section style="margin: 30px 0;text-align: center;background-color: #fff;border: 1px solid #ddd; height: 50px;padding-top: 35px;">
        <span class="date-span" style="font-size: 16px;color: #666; font-family:Arial, Helvetica, sans-serif,'XB Riyaz'">
            @if($locale == 'en')
            {{__('From')}}
            @else
            من
            @endif
           {{__('to')}} </span>
        <span class="b-line">-</span>
        <span class="price-span" style="font-size: 16px;color: #801818; font-weight: 600; font-family:'XB Riyaz',Arial, Helvetica, sans-serif;">
            @if($locale == 'en')
            {{__('AED')}}
            @else
            د. إ
            @endif
            </span>
    </section>
    <main>
       

    </main>
</body>

</html>