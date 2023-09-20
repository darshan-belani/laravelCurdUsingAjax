<!DOCTYPE html>
<html>
<head>
    <title>Laravel 10 AJAX CRUD Operation Example</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <link  href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">


</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-xl-8 col-md-8 col-sm-12 m-auto">
            <form method="post" id="upload-form" enctype="multipart/form-data">
                @csrf
                <div class="card shadow">
                    {{-- Display alert message --}}
                    <div id="response-container"></div>
                    <div class="card-header">
                        <h4 class="card-title fw-bold"> Laravel 10 Ajax Image Upload</h4>
                    </div>

                    <div class="card-body">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" >
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="">
                        </div>
                        <div class="form-group">
                            <label> Image <span class="text-danger">*</span> </label>
                            <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                            @error('image')
                            <div class="invalid-feedback">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary"> Upload </button>
                    </div>
                </div>
            </form>
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

<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#upload-form").validate({
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
                image: {
                    required: true,
                },
            },
            messages: {
                name: 'Please enter the name',
                email: 'Please enter the email',
                phone: 'Please enter the phone',
            },
            submitHandler: function(form, event) {
                event.preventDefault();
                const formData = new FormData(form);

                $.ajax({
                    url: "{{ route('storeAData') }}",
                    type: 'POST',
                    data: formData,
                    processData: false,
                    cache: false,
                    contentType: false,
                    success: function(response) {
                        form.reset();
                        if (response && response.status === 'success') {
                            $("#response-container").append(`<div class="alert alert-success alert-dismissible d-flex align-items-center" role="alert">
                                <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:"> <use xlink:href="#check-circle-fill" /> </svg>
                                ${response.message}<div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div></div>`);

                            setTimeout(() => {
                                $(".alert").remove();
                            }, 5000);
                        }

                        else if(response.status === 'failed') {
                            $("#response-container").append(`<div class="alert alert-danger d-flex alert-dismissible align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill" /></svg>
                                <div> ${response.message} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div></div>`);

                            setTimeout(() => {
                                $(".alert").remove();
                            }, 5000);
                        }

                        else if(response.status === 'error') {
                            $("#response-container").append(`<div class="alert alert-danger d-flex alert-dismissible align-items-center" role="alert">
                                    <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill" /></svg>
                                <div> ${response.message.image} <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div></div>`);

                            setTimeout(() => {
                                $(".alert").remove();
                            }, 5000);
                        }
                    }
                });
            }
        });
    });

</script>
</html>