@extends('cp.layouts.adminMaster')
@section('head')
    <style>
        #roles{
            padding: 10px;
        }
        .role {
            background-color: #eee;
            margin: 10px 0px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        .role_placeholder{
            padding: 10px;
            background-color: rgb(207, 207, 198);
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
                    <h1 class="m-0">Edit roles authority</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/admincp')}}/">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/admincp/roles')}}/">Roles</a></li>
                        <li class="breadcrumb-item active">authority</li>
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
                            <h3 class="card-title">Roles authority order</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row" id="roles">
                                @foreach ($roles as $role)
                                    <div id="{{$role['id']}}" class="col-12 role">
                                        {{$role['name']}}
                                    </div>
                                @endforeach
                            </div>
                            <div class="row">
                                <div class="col-12" style="margin-top: 5px; ">
                                    <span id="state" style="text-align: center;"></span>
                                </div>
                            </div>
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
        $( "#roles" ).sortable( {
            placeholder: "role_placeholder",
            forcePlaceholderSize: true,
            stop: function ( event, ui ) {
                $("#state").html('<span class="spinner-border spinner-border-lg"></span><span class="sr-only">Loading...</span>');
                $.ajax({
                    url:"{{route('update.roles.authority')}}",
                    type: "post",
                    data: {
                        '_token':'{{csrf_token()}}',
                        'authority_order':JSON.stringify($("#roles").sortable("toArray"))
                    },
                    success: function(response){
                        $("#state").html('');
                        toastr.success(response);
                    },
                    error: function(response){
                        console.log(response);
                        toastr.error("Failed to update.");
                        $("#state").html('');
                    }
                });
            }
        } );
        $( "#roles" ).disableSelection();
        ////////////////////////////////////////////////////////////////////////

    })


    

    
</script>
@endsection
