@extends('cp.layouts.adminMaster')
@section('head')
<style>
    #image-preview{
        display: block;
        width: 100px;
        height: 100px;
    }
</style>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-4">
                    <h1 class="m-0">Edit a course</h1>
                </div><!-- /.col -->
                <div class="col-sm-8">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('/')}}/admincp">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{url('/')}}/admincp/courses">Courses</a></li>
                        <li class="breadcrumb-item active">{{$course['name']}}</li>
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
                            <h3 class="card-title">Course details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <form action="/admincp/courses/{{$course['id']}}" id="course" enctype="multipart/form-data" method="post">
                                @method('PATCH')
                                @csrf
                                <div class="form-group">
                                    <label>Name</label>
                                    <input name="name" value="{{$course['name']}}" id="name" type="text" class="form-control" placeholder="Enter the name of this course." required="required">
                                </div>
                                <div class="form-group" >
                                    <label>Description:</label>
                                    <textarea name="description" class="form-control" rows="3" placeholder="Enter a description that helps students understand what the content of this course about." required="required">{{$course['description']}}</textarea>
                                </div>
                                <div class="form-group">
                                    <img src="{{url('/')}}{{$course['image']}}" alt="Course image review" id="image-preview">
                                    <label>Image: <span style="font-size: smaller">it's preferred to be round-shaped.</span></label>
                                    <input name="image" class="form-control" type="file" accept="image/png, image/jpeg ">
                                </div>
                                <div class="form-group">
                                    <label>Difficulty</label>
                                    <select name="difficulty" id="difficulty" class="form-control" required="required">
                                        <option value="" disabled>Choose the course difficulty</option>
                                        @if ($course['difficulty'] == "easy")
                                            <option value="easy" selected>Easy</option>
                                        @else
                                            <option value="easy">Easy</option>
                                        @endif
                                        
                                        @if ($course['difficulty'] == "intermediate")
                                            <option value="intermediate" selected>Intermediate</option>
                                        @else
                                            <option value="intermediate">Intermediate</option>
                                        @endif
                                        
                                        @if ($course['difficulty'] == "difficult")
                                            <option value="intermediate" selected>Difficult</option>
                                        @else
                                            <option value="intermediate">Difficult</option>
                                        @endif
                                        
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>State</label>
                                    <select name="state" id="state" class="form-control" required="required">
                                        <option value="" disabled>Choose the course state</option>
                                        @if ($course['state'] == "In progress")
                                            <option value="In progress" selected>In progress</option>
                                        @else
                                            <option value="In progress">In progress</option>
                                        @endif

                                        @if ($course['state'] == "Completed")
                                            <option value="Completed" selected>Completed</option>
                                        @else
                                            <option value="Completed">Completed</option>
                                        @endif
                                    </select>
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
        $("#course").submit(function(event){
            event.preventDefault();
            $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', true );
			$( 'button[type=submit], input[type=submit]' ).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>' );
            $.ajax({
                url:'{{route("update.course", ["course"=> $course["id"]])}}',
                type:"post",
                data: new  FormData(this),
                contentType: false,
                processData:false,
                success:function(Messages){
                
                    for (var key in Messages) {
                        if (key== "success"){
                            toastr.success(Messages[key]);
                        }else if (key == "image"){
                            $("#image-preview").attr("src", '{{url("/")}}' + Messages[key]);
                        }else{
                            toastr.error(Messages[key]);
                        }
                    }
                    $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', false );
					$( 'button[type=submit], input[type=submit]' ).html("Submit" );
                } ,
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    toastr.error("Failed to create the course.");
                    $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', false );
					$( 'button[type=submit], input[type=submit]' ).html("Submit" );
                } 
            })
        }); 

    })
</script>
@endsection
