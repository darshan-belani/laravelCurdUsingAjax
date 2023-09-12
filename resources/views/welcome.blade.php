@extends('master')
@section('content')
@section('title') | User Listing @endsection

<div class="row">
    <div class="col-xl-9 col-lg-9 col-md-9 col-12">
        <h3 class="text-center"> Laravel 9 Ajax CRUD </h3>
    </div>

    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-end">
        <a href="javascript:void(0)" id="create-user-btn" class="btn btn-primary"> Create User </a>
    </div>
</div>

<div class="card my-3">
    <table class="table table-bordered data-table" id="usersTable">
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

<!-- modal -->
<div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content ">
            <form method="user" id="userForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"> AJAX CRUD Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" value="" >
                    </div>
                    <div class="mb-3">
                        <label for="email" class="col-sm-2 control-label">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" value="">
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="col-sm-2 control-label">Phone</label>
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit"  class="btn btn-primary" id="savedata">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
