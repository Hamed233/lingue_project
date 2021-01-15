@extends('cp.layouts.adminMaster')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Edit a user</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/')}}/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/')}}/admincp/users/">Users</a></li>
                        <li class="breadcrumb-item active">{{$user['first_name']. " " . $user['surname']}}</li>
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
                            <h3 class="card-title">User details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <form action="/admincp/users" id="user" enctype="multipart/form-data" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="form-group">
                                    <label>First name</label>
                                    <input value="{{$user['first_name']}}" name="first_name" id="first_name" type="text" class="form-control" placeholder="Enter the first name." required="required">
                                </div> 
                                <div class="form-group">
                                    <label>Surname</label>
                                    <input value="{{$user['surname']}}" name="surname" id="surname" type="text" class="form-control" placeholder="Enter the surname." required="required">
                                </div> 
                                <div class="form-group">
                                    <label>Email address:</label>
                                    <input value="{{$user['email']}}" name="email" id="email" type="email" class="form-control" placeholder="Enter the email address." required="required">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input name="password" id="password" type="password" class="form-control" placeholder="Enter the password.">
                                </div> 
                                <div class="form-group">
                                    <label>Password</label>
                                    <input name="password_confirmation" id="password_confirmation" type="password" class="form-control" placeholder="Confirm the password.">
                                </div> 
                                
                                @if (hasAbility('assign_roles'))
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" id="role" class="form-control" data-live-search="true">
                                            @foreach ($roles as $role)
                                                @if($user['role'] == $role['id'])
                                                <option value="{{$role['id']}}" selected>{{$role['name']}}</option>
                                                @else
                                                <option value="{{$role['id']}}">{{$role['name']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div> 
                                @endif
                                
                                <input type="submit" value="Update" class="btn btn-primary btn-block" >
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('js-codes')
<script>
    $().ready(function(){
        $("#user").submit(function(event){
            event.preventDefault();
            $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', true );
			$( 'button[type=submit], input[type=submit]' ).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>' );
            $.ajax({
                url:'{{route("update.user",["user"=> $user["id"]])}}',
                type:"post",
                data:  new FormData(this),
                contentType: false,
                processData:false,
                success:function(Messages){
                    for (var key in Messages) {
                        if (key== "success"){
                            toastr.success(Messages[key]);
                        }else{
                            if(key == "password"){
                                for(var passwordMessage in Messages[key]){
                                    toastr.error(Messages[key][passwordMessage]);
                                }
                            }else{
                                
                                toastr.error(Messages[key]);
                            }
                            
                        }
                    }
                    $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', false );
					$( 'button[type=submit], input[type=submit]' ).html("Submit" );
                    
                } ,
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error("Failed to create the user.");
                    $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', false );
					$( 'button[type=submit], input[type=submit]' ).html("Submit" );
                } 
            })
        });

    })


    

    
</script>
@endsection
