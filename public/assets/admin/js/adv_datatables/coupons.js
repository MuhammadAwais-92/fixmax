var DatatableRemoteAjaxDemo = function () {
    console.log("🚀 ~ file: coupons.js ~ line 7 ~ t ~ window.Laravel.baseUrl+list/coupons", window.Laravel.baseUrl+"list/coupons")
    var t = function () {
        var t = $(".manage-products").mDatatable({
            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/coupons"}},
                pageSize: 10,
                saveState: {cookie: !0, webstorage: !0},
                serverPaging: !0,
                serverFiltering: !0,
                serverSorting: !0,
            },
            layout: {theme: "default", class: "", scroll: !1, footer: !1},
            sortable: false,
            ordering: false,
            filterable: !1,
            pagination: !0,
            columns:
                [
                    {field: "id", title: "#",  width: 100 },
                    {field: "name", title: "Coupon Title",  width: 150},
                    {field: "coupon_code", title: "Coupon Code",  width: 150},
                    {field: "discount", title: "Discount",  width: 100},
                    {field: "coupon_type", title: "Type",  width: 150},
                    {field: "coupon_number", title: "Number",  width: 150},
                    {field: "status", title: "Status",  width: 70},
                    {field: "end_date", title: "Expiry Date",  width: 150},
                    {field: "actions", title: "Action",  width: 150}
                ]
        });
        t.on('m-datatable--on-layout-updated', function(params){
            $('.delete-record-button').on('click', function(e){
                var url = $(this).data('url');
                swal({
                        title: "Are you sure you want to delete this?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Delete",
                        cancelButtonText: "No",
                        closeOnConfirm: true,
                        closeOnCancel: true
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                type: 'delete',
                                url: url,
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                                }
                            }).done(function(res){ toastr.success("Coupon deleted successfully!"); location.reload(); })
                                .fail(function(res){ toastr.success("Coupon Failed!"); t.reload();  });
                        } else {
                            swal.close()
                        }
                    });
            });
            $('.restore-record-button').on('click', function(e){
                var url = $(this).data('url');
                swal({
                        title: "Are You Sure You Want To Restore This?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Restore",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                type: 'get',
                                url: url,
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                                }
                            })
                                .done(function(res){ toastr.success("Agency restored !");
                                    $('#show-trashed-users').click();
                                    location.reload(); })
                                .fail(function(res){ toastr.success("Agency restored!"); t.reload();  });
                        } else {
                            swal.close()
                        }
                    });
            });

            $('.toggle-status-button').on('click', function(e) {
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
                        .done(function(res){ toastr.success("Your action is successfully!"); t.reload(); })
                        .fail(function(res){ toastr.success("Your action is successfully!"); t.reload(); });
                }
            });
            $('.m-datatable__table tbody').on('click', 'tr', function(e) {
                var elem = $(this).children(':nth-child(8)').find('a');
                if (elem.length==1) {
                    e.preventDefault();
                    e.stopPropagation();
                    window.location.href = $(elem[0]).attr('href');
                    return false;
                }
            })

        });
        $("#manage-product-search").on("submit", function (a) {
            a.preventDefault();
            var searchParams = $('#manage-product-search').serializeObject();

            t.setDataSourceQuery(searchParams),
                t.load()
        });
        $('#show-trashed-users').on('change', function(){
            $('#manage-agency-search').submit();
            if ($(this).is(":checked")){
                $('#user-deleted-at').show(50,function(){
                    $('#user-created-at').hide('slow');
                    $('#user-updated-at').hide('slow');
                });
            }else{
                $('#user-deleted-at').hide(50,function(){
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
            dataTable.coupon_code = '';
            dataTable.name = '';
            dataTable.status = '';
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
            dataTable.trashedPages=null;
            $(this).closest('form').find("input[type=text]").val("");
            t.setDataSourceQuery(dataTable);
            t.load()
        });
    };
    return {
        init: function () {
            t()
        }
    }
}();
jQuery(document).ready(function () {
    DatatableRemoteAjaxDemo.init()

});


