@extends('cp.layouts.adminMaster')
@section('head')


@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Create a new lesson</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{route('view.courses')}}">Courses</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">{{$course->name}}</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">{{$level->name}}</a></li>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Lessons</a></li>
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
                                <h3 class="card-title">Lesson details</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <form action="{{route('store.lesson', ['course'=>$course->id, 'level' => $level->id])}}" id="lesson" enctype="multipart/form-data"
                                    method="post">
                                    @csrf
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input name="title" id="title" type="text" class="form-control"
                                            placeholder="Enter the title of this lesson." required="required">
                                    </div>
                                    <div class="form-group">
                                        <label>Description:</label>
                                        <textarea name="description" class="form-control" rows="3"
                                            placeholder="Enter a description that helps students understand what the content of this lesson about."
                                            required="required"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Image:</label>
                                        <input name="image" class="form-control" type="file"
                                            accept="image/png, image/jpeg ">
                                    </div>
                                    <div class="form-group">
                                        <label>Lock state</label>
                                        <select name="lock_state" id="lock_state" class="form-control">
                                            <option value="0">Open</option>
                                            <option value="-1">Locked</option>
                                            @foreach ($quizzes as $quiz)
                                                <option value="{{$quiz['id']}}">{{$quiz['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="submit" value="Submit" class="btn btn-primary btn-block">
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
        $().ready(function() {
            $("#lesson").submit(function(event) {
                event.preventDefault();
                $('button[type=submit], input[type=submit]').prop('disabled', true);
                $('button[type=submit], input[type=submit]').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>'
                );
                $.ajax({
                    url: '',
                    type: "post",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    success: function(Messages) {
                        for (var key in Messages) {
                            if (key == "success") {
                                toastr.success(Messages[key]);
                                $("#course").trigger('reset');
                            } else {
                                toastr.error(Messages[key]);
                            }
                        }
                        $('button[type=submit], input[type=submit]').prop('disabled', false);
                        $('button[type=submit], input[type=submit]').html("Submit");
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        toastr.error("Failed to create the course.");
                        $('button[type=submit], input[type=submit]').prop('disabled', false);
                        $('button[type=submit], input[type=submit]').html("Submit");
                    }
                })
            });

        })

    </script>
@endsection
