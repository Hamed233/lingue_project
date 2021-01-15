@extends('cp.layouts.adminMaster')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Create a new role</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/admincp')}}/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admincp/roles')}}/">Roles</a></li>
                        <li class="breadcrumb-item active">Create</li>
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
                            <h3 class="card-title">Role details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <form action="/admincp/roles" id="role" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" id="name" type="text" class="form-control" placeholder="Enter the name of this role." required="required">
                                </div>
                                    <label>Permissions</label>
                                    <div class="row">
                                    @foreach ($permissions as $permission => $name)
                                            <div class="form-group col-3">
                                                <label class="checkbox-inline">
                                                    <input name="permissions[]" type="checkbox" value="{{$permission}}"> {{$name}}
                                                </label>
                                            </div>
                                    @endforeach
                                    </div>
                                <input type="submit" value="Submit" class="btn btn-primary btn-block" >
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
        $("#role").submit(function(event){
            event.preventDefault();
            $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', true );
			$( 'button[type=submit], input[type=submit]' ).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>' );
            $.ajax({
                url:'/admincp/roles',
                type:"post",
                data:  new FormData(this),
                contentType: false,
                processData:false,
                success:function(Messages){
                    for (var key in Messages) {
                        if (Messages[key]== "The role was created successfully."){
                            toastr.success(Messages[key]);
                            $("#role").trigger('reset');
                        }else{
                            toastr.error(Messages[key]);
                        }
                    }
                    $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', false );
					$( 'button[type=submit], input[type=submit]' ).html("Submit" );
                    
                } ,
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error("Failed to create the role.");
                    $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', false );
					$( 'button[type=submit], input[type=submit]' ).html("Submit" );
                } 
            })
        });

    })


    

    
</script>
@endsection
