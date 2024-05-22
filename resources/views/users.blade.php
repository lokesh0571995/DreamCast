<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>DreamCast</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
 
 <style>
   .container{
    padding: 0.5%;
   } 
</style>
</head>
<body>
 
<div class="container">
    <h2 style="margin-top: 12px;" >DreamCast</h2><br>
    <div class="alert alert-success" style="display:none"></div>
    
    <!-- Validation Errors -->
    <div class="alert alert-danger" style="display:none">
        <ul></ul>
    </div>
    <div class="row">
        <div class="col-12">
          <a href="javascript:void(0)" class="btn btn-success mb-2" id="create-new-user">Add User</a> 
          
          <table class="table table-bordered" id="">
           <thead>
              <tr>
                 <th>Id</th>
                 <th>Name</th>
                 <th>Email</th>
                 <th>Phone</th>
                 <th>Role</th>
                 
                 <td colspan="2">Action</td>
              </tr>
           </thead>
           <tbody id="users-crud">
              @foreach($users as $user)
              <tr id="user_id_{{ $user->id }}">
                 <td>{{ $user->id  }}</td>
                 <td>{{ $user->name }}</td>
                 <td>{{ $user->email }}</td>
                 <td>{{ $user->phone }}</td>
                 <td>{{ $user->role->name ?? "-" }}</td>
                 
                 <td><a href="javascript:void(0)" id="edit-user" data-id="{{ $user->id }}" class="btn btn-info">Edit</a></td>
                 <td>
                  <a href="javascript:void(0)" id="delete-user" data-id="{{ $user->id }}" class="btn btn-danger delete-user">Delete</a></td>
              </tr>
              @endforeach
           </tbody>
          </table>
       
       </div> 
    </div>
</div>
 <!-- Success Message -->
 

<div class="modal fade" id="ajax-crud-modal" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="userCrudModal"></h4>
    </div>
    <div class="modal-body">
        <form id="userForm" name="userForm" class="form-horizontal" enctype="multipart/form-data">
            @csrf
           <input type="hidden" name="user_id" id="user_id">
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="name" name="name" value="" required="">
                    <div id="name-error-message" class="text-danger"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-12">
                    <input type="email" class="form-control" id="email" name="email" value="" required="">
                    <div id="email-error-message" class="text-danger"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Phone</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="phone" name="phone" value="" required="">
                    <div id="phone-error-message" class="text-danger"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-12">
                    <input type="text" class="form-control" id="description" name="description" value="" >
                    <div id="description-error-message" class="text-danger"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Role</label>
                <div class="col-sm-12">
                @if($roles)
                   
                    <select  class="form-control" id="role_id" name="role_id" value="" required="">
                    @foreach($roles as $role)
                        <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                    </select>
                  
                @endif
                <div id="role_id-error-message" class="text-danger"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Image</label>
                <div class="col-sm-12">
                    <input type="file" class="form-control" id="profile_image" name="profile_image" value="">
                </div>
            </div>
            <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" id="btn-save" value="create">Save
             </button>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        
    </div>
</div>
</div>
</div>
</body>
</html>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/additional-methods.min.js"></script>

<script type="text/javascript">
$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Load all users
    $.get('view', function (data) {
        var rows = '';
        $.each(data, function (key, user) {
            rows += '<tr id="user_id_' + user.id + '"><td>' + user.id + '</td><td>' + user.name + '</td><td>' + user.email + '</td><td>' + user.phone + '</td><td>' + user.role.id + '</td>';
            rows += '<td><a href="javascript:void(0)" id="edit-user" data-id="' + user.id + '" class="btn btn-info">Edit</a></td>';
            rows += '<td><a href="javascript:void(0)" id="delete-user" data-id="' + user.id + '" class="btn btn-danger delete-user">Delete</a></td></tr>';
        });
        $('#users-crud').html(rows);
    });

    // Open modal to create new user
    $('#create-new-user').click(function () {
        $('#btn-save').val("create-user");
        $('#userForm').trigger("reset");
        $('#userCrudModal').html("Add New User");
        $('#ajax-crud-modal').modal('show');
    });

    // Open modal to edit user
    $('body').on('click', '#edit-user', function () {
        var user_id = $(this).data('id');
        $.get('users/' + user_id, function (data) {
            $('#userCrudModal').html("Edit User");
            $('#btn-save').val("edit-user");
            $('#ajax-crud-modal').modal('show');
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#description').val(data.description);
            $('#role_id').val(data.role.id);
            $('#profile_image').val(data.profile_image);
        });
    });

    // Handle form submission
    $('body').on('submit', '#userForm', function (e) {
        e.preventDefault();
        var actionType = $('#btn-save').val();
        $('#btn-save').html('Sending..');

        $.ajax({
            type: (actionType === 'edit-user') ? 'PUT' : 'POST',
            url: (actionType === 'edit-user') ? 'users/' + $('#user_id').val() : 'users',
            data: $('#userForm').serialize(),
            success: function (data) {
                var user = '<tr id="user_id_' + data.id + '"><td>' + data.id + '</td><td>' + data.name + '</td>';
                user += '<td><a href="javascript:void(0)" id="edit-user" data-id="' + data.id + '" class="btn btn-info">Edit</a></td>';
                user += '<td><a href="javascript:void(0)" id="delete-user" data-id="' + data.id + '" class="btn btn-danger delete-user">Delete</a></td></tr>';

                if (actionType === 'create-user') {
                    $('#users-crud').prepend(user);
                    $('.alert-success').html('User created successfully').show();
                } else {
                    $("#user_id_" + data.id).replaceWith(user);
                    $('.alert-success').html('User updated successfully').show();
                }

                $('#userForm').trigger("reset");
                $('#ajax-crud-modal').modal('hide');
                $('#btn-save').html('Save changes');
            },
            error: function (data) {
                var errors = data.responseJSON.errors;
                var errorHtml = '<ul>';
                $.each(errors, function (key, value) {
                    errorHtml += '<li>' + value[0] + '</li>';
                });
                errorHtml += '</ul>';
                $('.alert-danger').html(errorHtml).show();
                $('#btn-save').html('Save changes');
            }
        });
    });

    // Delete user
    $('body').on('click', '.delete-user', function () {
        var user_id = $(this).data("id");
        var result = confirm("Are you sure you want to delete this user?");
        if (result) {
            $.ajax({
                type: "DELETE",
                url: 'users/' + user_id,
                success: function (data) {
                    $("#user_id_" + user_id).remove();
                    $('.alert-success').html('User deleted successfully').show();
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });
        }
    });
});
</script>

