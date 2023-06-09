var DatatableRemoteAjaxDemo = function () {
    var t = function () {
        var t = $("#manage-pages").mDatatable({
            data: {
                type: "remote",
                source: {read: {url: window.Laravel.baseUrl+"list/quotations"}},
                pageSize: 10,
                saveState: {cookie: false, webstorage: false},
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
                    // {field: "id", title: "#", sortable: !1, width: 50, selector: {class: "m-checkbox--solid m-checkbox--brand"}, textAlign: "center"},
                    {field: "id", title: "#",  width: 30},
                    {field: "order_number", title: "Quotation Number",  width: 150},
                    {field: "user_name", title: "User Name",  width: 150},
                    {field: "service_name", title: "Service Name",  width: 150},
                    {field: "status", title: "Status",  width: 150},
                    {field: "supplier_name", title: "Supplier Name",  width: 150},
                    {field: "total_amount", title: "Amount",  width: 150},
                    {field: "actions", title: "Action",  width: 150}
                ]
        });
        a = t.getDataSourceQuery();
        $("#manage-page-search").on("submit", function (a) {
            a.preventDefault();
            var searchParams = $('#manage-page-search').serializeObject();
            t.setDataSourceQuery(searchParams),
                t.load()
        });
        $("#page-reset").on("click", function (a) {
            a.preventDefault();
            var dataTable = t.getDataSourceQuery();
            dataTable.order_number = '';
            dataTable.status = '';
            dataTable.min = '';
            dataTable.max = '';
            dataTable.createdAt = '';
            dataTable.updatedAt = '';
            dataTable.deletedAt = ''
            dataTable.trashedPages=null;
            $(this).closest('form').find("input[type=text]").val("");
            $('#status').prop('selectedIndex',0);
            t.setDataSourceQuery(dataTable);
            t.load()
        });

        $(".manage-pages").on("m-datatable--on-check", function (e, a) {
            var l = t.setSelectedRecords().getSelectedRecords().length;
            var checkStatus = $('#show-trashed-pages').is(':checked');
            if(checkStatus == true){
                $("#m_datatable_selected_page_restore").html(l), l > 0 && $("#m_datatable_group_action_form_page_restore").collapse("show")
            }else{
                $("#m_datatable_selected_page").html(l), l > 0 && $("#m_datatable_group_action_form_page").collapse("show")
            }
        }).on("m-datatable--on-uncheck m-datatable--on-layout-updated", function (e, a) {
            var l = t.setSelectedRecords().getSelectedRecords().length;
            var checkStatus = $('#show-trashed-pages').is(':checked');
            if(checkStatus == true) {
                $("#m_datatable_selected_page_restore").html(l), 0 === l && $("#m_datatable_group_action_form_page_restore").collapse("hide")
            }else{
                $("#m_datatable_selected_page").html(l), 0 === l && $("#m_datatable_group_action_form_page").collapse("hide")
            }
        });
        $('#show-trashed-pages').on('change', function(){
            $('#manage-page-search').submit();
            if ($(this).is(":checked")){
                $('#page-deleted-at').show(50,function(){
                    $('#page-created-at').hide('slow');
                    $('#page-updated-at').hide('slow');
                });
            }else{
                $('#page-deleted-at').hide(50,function(){
                    $('#page-created-at').show('slow');
                    $('#page-updated-at').show('slow');
                });
            }
        });
        $('#m_datatable_check_all_pages').on('click', function(){
            var chkArray = [];

            /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
            $(".m-checkbox--solid input:checked").each(function() {
                chkArray.push($(this).val());
            });

            /* we join the array separated by the comma */
            var selected;
            selected = chkArray.join(',') ;

            /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
            if(selected.length > 0){

                swal({
                        title: "Are You Sure?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#1C4670",
                        confirmButtonText: "Delete",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                type: 'GET',
                                url: window.Laravel.baseUrl+"bulk-delete/pages/"+selected,
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                                }
                            })
                                .done(function(res){ swal.close(); toastr.success("Record deleted successfully!"); t.reload(); })
                                .fail(function(res){ toastr.error("Something went wrong, please refresh."); });
                        } else {
                            swal("Cancelled", "No action taken.", "info");
                        }
                    });
            }else{
                alert("Please at least one of the checkbox");
            }
        });



        $('#m_datatable_check_all_pages_restore').on('click', function(){
            var chkArray = [];

            /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
            $(".m-checkbox--solid input:checked").each(function() {
                chkArray.push($(this).val());
            });

            /* we join the array separated by the comma */
            var selected;
            selected = chkArray.join(',');

            /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
            if(selected.length > 0){

                swal({
                        title: "Are You Sure?",
                        text: "If you restore, it will be undeleted instantly.",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#4C8370",
                        confirmButtonText: "Restore",
                        cancelButtonText: "No",
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm){
                        if (isConfirm) {
                            $.ajax({
                                type: 'GET',
                                url: window.Laravel.baseUrl+"bulk-restore/pages/"+selected,
                                dataType: 'json',
                                headers: {
                                    'X-CSRF-TOKEN': window.Laravel.csrfToken
                                }
                            })
                                .done(function(res){ swal.close(); toastr.success("Record restored successfully!"); t.reload(); })
                                .fail(function(res){ toastr.error("Something went wrong, please refresh");  });
                        } else {
                            swal("Cancelled", "No action taken.", "info");
                        }
                    });
            }else{
                alert("Please at least one of the checkbox");
            }
        });
        t.on('m-datatable--on-layout-updated', function(params){
            bindDeleteAction(t);
            bindRestoreAction(t);
            bindToggleAction(t);
                $('.activate-record-button').on('click', function(e) {
                    var url = $(this).data('url');
            
                    swal({
                            title: "Are you sure you want to active this service?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#1C4670",
                            confirmButtonText: "yes",
                            cancelButtonText: "cancel",
                            closeOnConfirm: false,
                            closeOnCancel: false,
                            showLoaderOnConfirm: true
                        },
                        function(isConfirm) {
            
                            if (isConfirm) {
                                $.ajax({
                                        type: 'get',
                                        url: url,
                                        dataType: 'json',
                                        headers: {
                                            'X-CSRF-TOKEN': window.Laravel.csrfToken
                                        }
                                    })
                                    .done(function(res) {
            
                                        swal.close();
                                        toastr.success(res.msg);
                                        t.reload();
                                    })
                                    .fail(function(res) {
            
                                        toastr.error("Something went wrong, please refresh.");
                                    });
                            } else {
                                swal.close();
                            }
                        });
                });
            
 
     
                $('.deactivate-record-button').on('click', function(e) {
                    var url = $(this).data('url');
            
                    swal({
                            title: "Are you sure you want to cancel this Quotation?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#1C4670",
                            confirmButtonText: "Yes",
                            cancelButtonText: "Cancel",
                            closeOnConfirm: false,
                            closeOnCancel: false,
                            showLoaderOnConfirm: true
                        },
                        function(isConfirm) {
            
                            if (isConfirm) {
                                $.ajax({
                                        type: 'get',
                                        url: url,
                                        dataType: 'json',
                                        headers: {
                                            'X-CSRF-TOKEN': window.Laravel.csrfToken
                                        }
                                    })
                                    .done(function(res) {
            
                                        swal.close();
                                        toastr.success(res.msg);
                                        t.reload();
                                    })
                                    .fail(function(res) {
            
                                        toastr.error("Something went wrong, please refresh.");
                                    });
                            } else {
                                swal.close();
                            }
                        });
                });
            
         

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
