@extends('admin.layouts.app')
@section('breadcrumb')
    @include('admin.common.breadcrumbs')
@endsection

@push('stylesheet-page-level')
    <link href="//www.amcharts.com/lib/3/plugins/export/export.css" rel="stylesheet" type="text/css"/>
@endpush

@push('script-page-level')
    <script>
        var dailyVisitors = ''
        var countryWiseVisitors = ''
        var browserWiseVisitors = ''
    </script>
    <script src="{{asset('assets/admin/js/adv_datatables/csrf_token.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/admin/js/charts/amcharts/charts.js')}}" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/amcharts.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/serial.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/radar.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/pie.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/tools/polarScatter/polarScatter.min.js"
            type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/animate/animate.min.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/plugins/export/export.min.js" type="text/javascript"></script>
    <script src="//www.amcharts.com/lib/3/themes/light.js" type="text/javascript"></script>
@endpush

@section('content')
    <!--begin:: Widgets/Stats-->
    <div class="my-admin-block-bg">
        <div class="m-portlet__body  m-portlet__body--no-padding my-admin-block">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Users
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Users
                            </span>
                            <span class="m-widget24__stats m--font-info">
                                {!! $users !!}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Total Services
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Services
                            </span>
                            <span class="m-widget24__stats m--font-info ">
                                {!! $totalProducts !!}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Suppliers
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Suppliers
                            </span>
                            <span class="m-widget24__stats m--font-info">
                                {!! $stores !!}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Orders-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                               Completed Orders
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                                Total Completed Orders
                                            </span>
                            <span class="m-widget24__stats m--font-info">
                                                {!! $orders !!}
                                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Orders-->
                </div>
                <div class="col-md-12 col-lg-6 col-xl-3">
                    <!--begin::New Feedbacks-->
                    <div class="m-widget24">
                        <div class="m-widget24__item">
                            <h4 class="m-widget24__title">
                                Categories
                            </h4>
                            <br>
                            <span class="m-widget24__desc">
                                Total Categories
                            </span>
                            <span class="m-widget24__stats m--font-info">
                                {!! $categories !!}
                            </span>
                            <div class="m--space-10"></div>

                        </div>
                    </div>
                    <!--end::New Feedbacks-->
                </div>
            </div>
        </div>
        <div class="m-portlet__body  m-portlet__body--no-padding my-admin-block">
            <div class="row m-row--no-padding m-row--col-separator-xl">
                <div class="col-md-6">
                    <div id="operationg-systems"></div>
                </div>
                <div class="col-md-6">
                    <div id="new-old"></div>
                </div>
                <div class="col-md-6">
                    <div id="daily-sessions"></div>
                </div>
                <div class="col-md-6">
                    <div id="country-users"></div>
                </div>
            </div>
        </div>
        <div class="m-portlet__body  m-portlet__body--no-padding my-admin-block">

            <h2 class="text-center mb-4">Page Statistics</h2>
            <table class="table" id="page-stat">
                <thead>
                <tr>
                    <th>Page View</th>
                    <th>Unique Page View</th>
                    <th>Time On Page</th>
                    <th>Bounce Rate</th>
                    <th>Entrance</th>
                    <th>Exists</th>
                    <th>Average Session</th>
                </tr>
                </thead>
                <tbody>
                @if(!is_null($pageStatistics))
                    @foreach($pageStatistics as $pageStatistic)
                        <tr>
                            <td>{{$pageStatistic[1]}}</td>
                            <td>{{$pageStatistic[2]}}</td>
                            <td>{{$pageStatistic[3]}}</td>
                            <td>{{$pageStatistic[4]}}</td>
                            <td>{{$pageStatistic[5]}}</td>
                            <td>{{$pageStatistic[6]}}</td>
                            <td>{{$pageStatistic[7]}}</td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('custom_js')
    <script src="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://code.highcharts.com/maps/highmaps.js"></script>
    <script>
        $(document).ready(function () {
            $('#page-stat').DataTable({
                "searching": false,
                "lengthChange": false
            });
        });
        // OPERATIONG SYSTEMS GRAPGH //
        Highcharts.chart('operationg-systems', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Operating Systems'
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}<br/>'
            },

            series: [
                {
                    name: "Operating System",
                    colorByPoint: true,
                    data: {!! $operatingSystem !!}
                }
            ],
        });
    </script>

    <script>
        // NEW AND OLD USERS //
        Highcharts.chart('new-old', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'New & Old Users'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Users',
                colorByPoint: true,
                data: {!! $newOld !!}
            }]
        });
    </script>
    <script>
        // NEW AND OLD USERS //
        Highcharts.chart('country-users', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'Country Users'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            series: [{
                name: 'Users',
                colorByPoint: true,
                data: {!! $countryUsers !!}
            }]
        });
    </script>

    <script>
        Highcharts.chart('daily-sessions', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Daily Users Session'
            },
            xAxis: {
                categories: {!! $dailySessionDates !!}
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Users',
                data: {!! $dailySessionUsers !!}
            }]
        });
    </script>

    <script>

        // var t = $(".manage-stores").mDatatable({
        //     data: {
        //         type: "remote",
        //         source: {read: {url: window.Laravel.baseUrl + "admin/list/suppliers"}},
        //         pageSize: 10,
        //         saveState: {cookie: !0, webstorage: !0},
        //         serverPaging: !0,
        //         serverFiltering: !0,
        //         serverSorting: !0,
        //
        //     },
        //     layout: {theme: "default", class: "", scroll: !1, footer: !1},
        //     sortable: !0,
        //     filterable: !1,
        //     pagination: !0,
        //     columns:
        //         [
        //             {field: "store_image", title: "Image", width: 150},
        //             {field: "title", title: "Title", width: 150},
        //             {field: "first_name", title: "User Name", width: 150},
        //             {field: "rating", title: "Rating", width: 150},
        //             {field: "store_phone", title: "Contact", width: 150},
        //             {field: "created_at", title: "Created_at", width: 150},
        //             {field: "updated_at", title: "Updated_at", width: 150},
        //             {field: "actions", title: "Action", width: 100}
        //         ]
        // });
    </script>
@endsection
