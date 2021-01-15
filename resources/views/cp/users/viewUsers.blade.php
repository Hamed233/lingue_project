@extends('cp.layouts.adminMaster')
@section('head')
    <style>
        .actionsIcons{
            text-align: center;
            min-width:140px;
        }
        td{
            text-align: center;
           
        }
        ul{
            padding: 0;
            margin: 0;
        }
        li.permisions {
            background-color: #2f2f2f;
            color: white;
            border-radius: 10px;
            padding: 0px 3px;
            box-sizing: border-box;
            display: inline-block;
            margin: 1px;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}/admincp">Home</a></li>
                            <li class="breadcrumb-item active">users</li>
                        </ol>
                    </div><!-- /.col -->
                    
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
            
        </div>
        <!-- /.content-header -->
        
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">users table</h3>
                                @if (hasAbility('add_users'))
                                <a class="btn btn-primary float-right" href="{{ url('/') }}/admincp/users/create">
                                    Create a new user
                                </a>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table id="users" class="table table-bordered table-striped dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="searchable">Name</th>
                                            <th class="searchable">Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($users)
                                            @foreach ($users as $user)
                                                    <tr id="user_{{$user->id}}">
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ $user->first_name. " " .$user->surname }}</td>
                                                        <td>{{ $user->roles->name }}</td>
                                                        <td class="actionsIcons">
                                                            <a title="View profile" target="_blank" href="/user/{{ $user->id }}">
                                                                <i style="color: dodgerblue;" class="fas fa-eye fa-2x"></i>
                                                            </a>
                                                            @if (hasAbility('edit_users') and $user->roles->authority > $loggedUserAuthority)
                                                            <a title="Edit" href="/admincp/users/{{ $user->id }}/edit">
                                                                <i style="color: rgb(73, 192, 89); " class="fas fa-edit fa-2x"></i>
                                                            </a>
                                                            @endif
                                                            @if (hasAbility('suspend_users') and $user->roles->authority > $loggedUserAuthority)
                                                            <a title="Suspend" href="javascript:void(0)" data-toggle="modal" data-target="#deleteModal" data-userid="{{$user->id}}">
                                                                <i style="color: red;" class="fas fa-ban fa-2x"></i>
                                                            </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th class="searchable">Name</th>
                                            <th class="searchable">Role</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                @if($users)
                    @if (hasAbility('suspend_users'))
                        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to suspend the user?
                                    </div>
                                    <div class="modal-footer">
                                        <button id="close_modal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        
                                        <form method="POST" >
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" id="user_id" name="user_id">
                                            <button id="confirm_deletion" type="button" class="btn btn-danger" onclick="delete_user()">Suspend</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@section('js-codes')
    @if($users)
        @if (hasAbility('suspend_users'))
            <script>
                $('#deleteModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget) // Button that triggered the modal
                    var user_id = button.data('userid') // Extract info from data-* attributes
                    // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                    // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                    var modal = $(this)
                    modal.find('.modal-footer #user_id').val(user_id)
                    modal.find('form').attr('action', '/admincp/users/' + user_id)
                })
                function delete_user(){
                    $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', true );
                    $( 'button[type=submit], input[type=submit]' ).html('<span class="spinner-border spinner-border-sm" user="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>' );

                    $.ajax({
                        url:"/admincp/users/" + $("#user_id").val(),
                        type: 'post',
                        data: {
                            '_token':'{{csrf_token()}}',
                            '_method': 'DELETE'
                            },
                        success: function(response){
                            var rowID = $("#user_id").val()
                            
                            for (var key in response) {
                                if(key == "success"){
                                    $("#close_modal").click();
                                    $('#user_'+rowID).fadeOut('slow', function(){
                                        $(this).remove();
                                    });
                                    toastr.success(response[key]);
                                }else{
                                    toastr.error(response[key]);
                                }
                            }
                        },
                        error: function(){
                            toastr.error(response[key]);
                        }
                    });
                }
            </script>
        @endif
    @endif
@endsection
{{-- @section('body-classes',
'dark-mode => this is to activate dark mode
layout-navbar-fixed => this is to make the upper navbar fixed
sidebar-mini-xs => this is to prevent the sidebar from hiding on small screens
',) --}}
{{--
<!-- sidebar options -->
@section('sidebar-classes',
'
nav-child-indent => this puts indentation to a child <li> in the sidebar, however,
    if collapse is enebled so this is useless as it gets reset every collapse.
    nav-flat => These two classes make different background-colors to the children
<li></li>
nav-legacy
',)
<!-- /.sidebar options -->
--}}
