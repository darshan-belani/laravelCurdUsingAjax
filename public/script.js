$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    // create user
    $('#create-user-btn').click(function() {
        $('.error').remove();
        $('#id').remove();
        $('#userModal #modalTitle').text('Create User');
        $('#userForm')[0].reset();
        $('#userModal').modal('toggle');
    });

    // form validate and submit
    $('#userForm').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
            },
            phone: {
                required: true,
            },
        },
        messages: {
            name: 'Please enter the name',
            email: 'Please enter the email',
            phone: 'Please enter the phone',
        },

        submitHandler: function(form) {
            const id = $('input[name=id]').val();
            const formData = $(form).serializeArray();

            $.ajax({
                url: 'users',
                type: 'POST',
                data: formData,
                success: function(response) {
                    console.log("response",response.success);
                    if (response && response.success) {
                        $('#userForm').trigger("reset");
                        $('#userModal').modal('hide');
                        table.draw();
                    }
                }
            });
        }
    })
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
var table = $('.data-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "users",
    columns: [
        {data: 'DT_RowIndex', name: 'DT_RowIndex'},
        {data: 'name', name: 'name'},
        {data: 'email', name: 'email'},
        {data: 'phone', name: 'phone'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
});
// edit button click
$('body').on('click', '.edit', function () {
    const id = $(this).data('id');
    $('label.error').remove();
    $('input[name=name]').removeClass('error');
    $('input[name=name]').after('<input type="hidden" name="id" value="'+id+'" />')
    $('input[name=email]').removeClass('error');
    $('input[name=phone]').removeClass('error');
    $('input[name=name]').removeAttr('disabled');
    $('input[name=email]').removeAttr('disabled');
    $('input[name=phone]').removeAttr('disabled');
    $('#userModal button[type=submit]').removeClass('d-none');

    $.ajax({
        url: `users/${id}`,
        type: 'GET',
        success: function(response) {
            console.log("response", response)
            if (response && response.success) {
                const data = response.data;
                $('#userModal #modalTitle').text('Update User');

                $('#userModal input[name=name]').val(data.name);
                $('#userModal input[name=email]').val(data.email);
                $('#userModal input[name=phone]').val(data.phone);
                $('#userModal').modal('toggle');
            }
        }
    })
});

// delete button click
$('body').on('click', '.btn-delete', function () {
    const id = $(this).data('id');

    if (id) {
        const result = window.confirm('Do you want to delete?');
        if (result) {
            $.ajax({
                url: `users/${id}`,
                type: 'DELETE',
                success: function(response) {
                    if (response && response.success) {
                        table.draw();
                    }
                }
            });
        }
        else {
            console.log('error', 'Post not found');
        }
    }
});