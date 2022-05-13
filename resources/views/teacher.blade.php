<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(used by all pages)-->
    <link href="{{asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<body>
    
<div class="container" style="
display: inline-flex;
justify-content: center;
flex-direction: column;
align-items: center;">
    <!--begin::Table-->
    <a href="#" class="btn btn-light-primary btn-add">Add</a>
<table class="table .table-striped align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table" style="width:50%">
    <!--begin::Table head-->
    <thead>
        <!--begin::Table row-->
        <tr class="text-start text-gray-400 fw-bolder fs-7 text-uppercase gs-0">
            <th class="min-w-125px">Teacher Name</th>
            <th class="min-w-125px">Email</th>
            <th class="text-end min-w-70px">Actions</th>
        </tr>
        <!--end::Table row-->
    </thead>
    <!--end::Table head-->
    <!--begin::Table body-->
    <tbody id="body_table" class="fw-bold text-gray-600">
    </tbody>
    <!--end::Table body-->
</table>
<!--end::Table-->
</div>
<!-- Modal -->
<div id="modal_add" class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add teacher</h5>
        </div>
        <div class="modal-body">
            <form id="modal_form">
                <input type="hidden" name="id" value="">
                <div class="form-group">
                  <label>Name</label>
                  <input type="text" name="name" class="form-control" placeholder="Enter name">
                </div>
                <div class="form-group">
                  <label>Email address</label>
                  <input type="email" name="email" class="form-control"placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input type="password" name="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary btn-closehaha">Close</button>
        </div>
      </div>
    </div>
  </div>

<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{asset('assets/plugins/global/plugins.bundle.js')}}"></script>
<script src="{{asset('assets/js/scripts.bundle.js')}}"></script>
<!--end::Global Javascript Bundle-->
<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{asset('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
<!--end::Page Vendors Javascript-->

<script>
//table
 var Table = $('#kt_customers_table').DataTable( {
        serverSide: true,
        select: {
            style: 'os',
            selector: 'td:first-child',
            className: 'row-selected'
        },
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('teacher.show','get-table')}}",
            type: 'GET',
        },
        columns: [
            { 
                data: 'name',
                render:function ( data, type, row, meta ) {
                    return data;
                }
             },
            { 
                data: 'email',
                render:function ( data, type, row, meta ) {
                    return data;
                }
            },
            { 
                data: null,
                render:function ( data, type, row, meta ) {
                    let delete_button = '';
                    @can('delete', App\Models\User::class)
                    delete_button = '<div class="menu-item px-3"> \n' +
                                    '<a href="#" data-id="'+row.id+'" class="menu-link px-3 btn-delete" data-kt-customer-table-filter="delete_row">Delete</a> \n' +
                                '</div> \n';
                    @endcan
                    return '<a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions \n' +
                            '<span class="svg-icon svg-icon-5 m-0"> \n' +
                                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"> \n' +
                                    '<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="black" /> \n' +
                                '</svg> \n' +
                            '</span> \n' +
                            '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true"> \n' +
                                '<div class="menu-item px-3"> \n' +
                                    '<a href="" data-data=\'' + JSON.stringify(row) + '\' class="menu-link px-3 btn-edit">Edit</a> \n' +
                                '</div> \n' +
                                delete_button +
                            '</div>';
                }
            }
        ],
    });

    Table.on('draw', function () {
        KTMenu.createInstances();
    });

// xu ly
    $('.btn-add').on('click', function () {
        $('#modal_add').modal('show'); 
    });

    $('.btn-closehaha').on('click', function () {
        $('#modal_add').modal('hide'); 
    });

    $(document).on('click', '.btn-edit', function (e) {
        e.preventDefault();
        let data = $(this).data('data');
        let modal = $('#modal_add');
        modal.find('.modal-title').text('Edit info');
        modal.find('input[name=id]').val(data.id);
        modal.find('input[name=name]').val(data.name);
        modal.find('input[name=email]').val(data.email);
        $('#modal_add').modal('show'); 
    });
    
    $('#modal_form').on('submit', function (e) {
        e.preventDefault();
        let data = $(this).serialize(),
            type = 'POST',
            url = "{{route('teacher.store')}}",
            id = $('form#modal_form input[name=id]').val();
        if (parseInt(id)) {
            console.log('edit');
            type = 'PUT';
            url = url + '/' + id;
            }
        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: type,
            data: data,
            success: function(data) {
                if (data.type == 'success') {
                    alert(data.title);
                    Table.ajax.reload(null, false);
                    $('#modal_add').modal('hide');
                }
            },
            error: function(data) {
                console.log('error');
            }
        });
    });

    $(document).on('click', '.btn-delete', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
        $.ajax({
            url: "{{route('teacher.destroy','')}}" + '/' + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'DELETE',
            success: function(data) {
                if (data.type == 'success') {
                    alert(data.title);
                    Table.ajax.reload(null, false);
                }
            },
            error: function(data) {
                console.log('error');
            }
        });
    });
</script>
</body>
</html>