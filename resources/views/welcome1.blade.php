<!DOCTYPE html>
<html>
<head>
    <title>Laravel 10 AJAX CRUD Operation Example</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">


</head>
<body>

<div class="card-body">
    <h1>Laravel 10 AJAX CRUD Operation Example </h1>
    <div align="right" style="margin-bottom: 10px">
        <a class="btn btn-info" href="javascript:void(0)" id="createNewUser" style="text-align: right"> Add New User</a>
    </div>

    <table class="table table-bordered" id="ajax-crud-datatable">
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th width="280px">Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div class="modal fade" id="ajaxModelUser" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="userForm" name="userForm" class="form-horizontal add_user_form">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone" class="col-sm-2 control-label">Phone</label>
                        <div class="col-sm-12">
                            <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="">
                        </div>
                    </div>
                    <div class="col-sm-offset-2 col-sm-10">
                        <input type="submit" class="btn btn-primary" id="savedata" value="create">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</body>

{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.14.0/jquery.validate.min.js"></script>--}}
{{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>--}}

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="http://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="http://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="http://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#createNewUser').click(function () {
            $('#savedata').val("create-user");
            $('#id').val('');
            $('#userForm').trigger("reset");
            $('#modelHeading').html("Create New User");
            $('#ajaxModelUser').modal('show');
        });

        $('#userForm').validate({
            rules: {
                name: {
                    required: true,
                },
                action: "required"
            },
            messages: {
                name: {
                    required: "{{__('Please enter name')}}",
                },
            },
            // errorElement: 'span',
            errorPlacement: function (error, element) {
                console.log("element", element);
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });

    // $(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('users.index') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });



        $('body').on('click', '.editPost', function () {
            var id = $(this).data('id');
            $.get("{{ route('users.index') }}" +'/' + id +'/edit', function (data) {
                $('#modelHeading').html("Edit User");
                $('#savedata').val("edit-user");
                $('#ajaxModelUser').modal('show');
                $('#id').val(data.id);
                $('#name').val(data.name);
                $('#email').val(data.email);
                $('#phone').val(data.phone);
            })
        });

        $('#savedata').click(function (e) {
            e.preventDefault();
            $(this).html('Sending..');

            $.ajax({
                data: $('#userForm').serialize(),
                url: "{{ route('users.store') }}",
                type: "POST",
                dataType: 'json',
                success: function (data) {
                    $('#userForm').trigger("reset");
                    $('#ajaxModelUser').modal('hide');
                    table.draw();
                },
                error: function (data) {
                    console.log('Error:', data);
                    $('#savedata').html('Save Changes');
                }
            });
        });

        $('body').on('click', '.deletePost', function () {

            var id = $(this).data("id");
            confirm("Are You sure want to delete this Post!");

            $.ajax({
                type: "DELETE",
                url: "{{ route('users.store') }}"+'/'+id,
                success: function (data) {
                    table.draw();
                },
                error: function (data) {
                    // console.log('Error:', data);
                }
            });
        });

    // });
</script>
</html>