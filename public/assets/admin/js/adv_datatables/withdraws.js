var DatatableRemoteAjaxDemo = function () {
    var t = function () {
        
        var url_string = window.location.href;
        var url        = new URL(url_string);
        var store_id   = url.searchParams.get("store_id");
        var send_url   = '';

        if (store_id == null || store_id == undefined) {
            send_url = window.Laravel.baseUrl + "list/withdraws";
        } else {
            send_url = window.Laravel.baseUrl + "list/withdraws/" + store_id;
        }

        var t = $(".manage-withdraws").mDatatable({

            data: {
                type: "remote",
                source: {
                    read: {
                        url: send_url
                    }
                },
                pageSize: 10,
                saveState: {
                    cookie    : false,
                    webstorage: false
                },
                serverPaging   : !0,
                serverFiltering: !0,
                serverSorting  : !0,
            },
            layout: {
                theme: "default",
                class: "",
                scroll: !1,
                footer: !1
            },
            sortable: !1,
            filterable: !1,
            pagination: !0,
            columns: [
                //                    {field: "id", title: "#",  width: 50, selector: {class: "m-checkbox--solid m-checkbox--brand"}, textAlign: "center"},
                {
                    field: "index",
                    title: "Index",
                    width: 50
                },
                {
                    field: "supplier_name",
                    title: "Suppplier name",
                    width: 200
                },
                {
                    field: "amount",
                    title: "Amount",
                    width: 200
                },
                {
                    field: "status",
                    title: "Status",
                    width: 100
                },
                // {field: "additional_details", title: "Additional Details",  width: 200},
                {
                    field: "created_at",
                    title: "Sent At",
                    width: 150
                },
                {
                    field: "actions",
                    title: "Action",
                    width: 200
                }
            ]
        });
        t.on('m-datatable--on-layout-updated', function (params) {
            $('.reject-record-button').on('click', function (e) {
                var url = $(this).data('url');
                swal({
                        title: "Are You Sure You Want To Reject This?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#1C4670",
                        confirmButtonText: "Reject",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                    type: 'put',
                                    url: url,
                                    dataType: 'json',
                                    headers: {
                                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                                    }
                                })
                                .done(function (res) {
                                    toastr.success("Payment Request Rejected!");
                                    location.reload();
                                })
                                .fail(function (res) {
                                    toastr.success("Payment Request Rejected!");
                                    t.reload();
                                });
                        } else {
                            swal.close()
                        }
                    });
            });
            $('.restore-record-button').on('click', function (e) {
                var url = $(this).data('url');
                swal({
                        title: "Are You Sure You Want To Restore This?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#1C4670",
                        confirmButtonText: "Restore",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                    type: 'get',
                                    url: url,
                                    dataType: 'json',
                                    headers: {
                                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                                    }
                                })
                                .done(function (res) {
                                    toastr.success("Agency restored !");
                                    $('#show-trashed-users').click();
                                    location.reload();
                                })
                                .fail(function (res) {
                                    toastr.success("Agency restored!");
                                    t.reload();
                                });
                        } else {
                            swal.close()
                        }
                    });
            });

            $('.toggle-status-button').on('click', function (e) {
                var url = $(this).data('url');
                if (url.length > 0) {
                    $.ajax({
                            url: url,
                            type: 'PUT',
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': window.Laravel.csrfToken
                            }
                        })
                        .done(function (res) {
                            toastr.success("Your action is successfully!");
                            t.reload();
                        })
                        .fail(function (res) {
                            toastr.success("Your action is successfully!");
                            t.reload();
                        });
                }
            });
            $('.m-datatable__table tbody').on('click', 'tr', function (e) {
                var elem = $(this).children(':nth-child(8)').find('a');
                if (elem.length == 1) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.href = $(elem[0]).attr('href');
                    return false;
                }
            });


        });
        $("#manage-product-search").on("submit", function (a) {
            a.preventDefault();
            var searchParams = $('#manage-product-search').serializeObject();

            t.setDataSourceQuery(searchParams),
                t.load()
        });
        $('#show-trashed-users').on('change', function () {
            $('#manage-agency-search').submit();
            if ($(this).is(":checked")) {
                $('#user-deleted-at').show(50, function () {
                    $('#user-created-at').hide('slow');
                    $('#user-updated-at').hide('slow');
                });
            } else {
                $('#user-deleted-at').hide(50, function () {
                    $('#user-created-at').show('slow');
                    $('#user-updated-at').show('slow');
                });

            }
        });
        $("#manage-agency-search").on("submit", function (a) {
            a.preventDefault();
            var searchParams = $('#manage-agency-search').serializeObject();

            console.log(searchParams)
            t.setDataSourceQuery(searchParams),
                t.load()
        });


        $("#page-reset").on("click", function (a) {
            a.preventDefault();
            var dataTable = t.getDataSourceQuery();
            dataTable.supplier_name = '';
            dataTable.createdAt = '';
            dataTable.updatedAt = '';
            dataTable.speedIndex = 0;
            $('#speedIndex').val(0);
            $('#brand').val(0);
            dataTable.brand = 0;
            dataTable.carModelId = 0;
            $('#carModelId').val(0);
            $('#vehicle').val(0);
            dataTable.vehicle = 0;
            dataTable.size = '';
            dataTable.season = '';
            $('#season').val('');
            dataTable.trashedPages = null;
            $(this).closest('form').find("input[type=text]").val("");
            $("#store_name").val('').trigger('change');
            $("#show-withdraw-status option:eq(0)").prop("selected", true);
            $('#manage-agency-search').submit();
            t.setDataSourceQuery(dataTable);
            t.load()
        });
    };
    return {
        init: function () {
            t();
        }
    };
}();
jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init()
});