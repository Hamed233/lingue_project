@extends('cp.layouts.adminMaster')

@section('head')
<style>
    .course-header{
        position: relative;
    }
    .course-header #add-level{
        position: absolute;
        bottom: 10px;
        right: 10px;
    }
    #add-level{
        padding: 0px 15px;
        background-color: #2aa760;
        border: 1px solid #2f8f59;
        margin-top: 150px;
        font-size: 35px;
        color: white;
        text-decoration: none;
    }
    #add-level:hover{
        background-color: #1f8049;
    }
    .course-image{
        display: block;
        margin: 15px auto;
        width: 200px;
        height: 200px;
        pointer-events: none;
    }
    .lesson{
        margin: 5px 0;
    }
    .lesson-image img {
        height: 50px;
        width: 45px;
        display: block;
        margin: 0 auto;
    }
    .lesson-details {
        background-color: #eee;
        margin: 0;
        padding: 10px;
        border: 1px solid #ddd;
    }
    .lesson-title{
        padding: 3px 0;
        border-bottom: 1px solid #ddd;
    }
    .card-header{
        padding: 0;
    } 
    .card-header h4 a{
        padding: 12px 20px;
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
                    <h1 class="m-0">View a course</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('view.courses')}}">Courses</a></li>
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
                <div class="col-12 course-header">
                    @if (hasAbility('edit_courses'))
                        <a id="add-level" href="#" class="rounded-circle add-level" title="Add Level" data-toggle="modal" data-target="#levelAction">+</a>
                    @endif
                    <img class="img-thumbnail rounded-circle course-image" src="{{$course['image']}}" alt="">
                    
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                    <div id="accordion">
                        @foreach ($course['levels'] as $level)
                            <div class="card card-light">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-10">
                                            <h4 dir="{{textFormatter($level['name'])['dir']}}" class="card-title w-100">
                                                <a id="level{{$level['id']}}_name" class="d-block w-100" data-toggle="collapse" href="#level{{$level['id']}}" aria-expanded="true">{{$level['name']}}</a>
                                                <span class="d-none" id="level{{$level['id']}}_unlocked_by">{{$level['unlocked_by']}}</span>
                                                <span class="d-none" id="level{{$level['id']}}_exam">{{$level['exam']}}</span>
                                            </h4>
                                        </div>
                                        <div class="col-2">
                                            @if (hasAbility('edit_courses'))
                                                <a style="margin: 5px;" href="javascript:void(0)" data-toggle="modal" data-target="#levelAction" data-levelid="{{$level['id']}}" class="float-right edit-level">
                                                    <i style="color: rgb(73, 192, 89); " class="fas fa-edit fa-2x"></i>
                                                </a>
                                                <a style="margin: 5px;" href="javascript:void(0)" data-toggle="modal" data-target="#deleteModal" data-levelid="{{$level['id']}}" class="float-right">
                                                    <i style="color: red;" class="fas fa-trash-alt fa-2x"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div id="level{{$level['id']}}" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        @foreach ($level['lessons'] as $lesson)
                                            <div class="row lesson">
                                                <div class="d-none d-md-block col-md-1 lesson-image">
                                                    <img src="/public/dist/img/user5-128x128.jpg" alt="">
                                                </div>
                                                <div class="col-12 col-md-11 lesson-details">
                                                    <h6 dir="{{textFormatter($lesson['title'])['dir']}}" class="lesson-title ellipsis">{{$lesson['title']}}</h6>
                                                    <p  dir="{{textFormatter($lesson['description'])['dir']}}" class="lesson-description ellipsis">{{textFormatter($lesson['description'], 60)['text']}}</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        @if (hasAbility('edit_courses'))
            <!-- Modal -->
            <div class="modal fade" id="levelAction" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="levelActionLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="levelActionLabel">Add Level</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div> 
                        <form action="{{route('store.level',['course'=> $course['id']])}}" id="level" data-action="add" enctype="multipart/form-data" method="post">
                            <div class="modal-body">
                                        @csrf
                                        <input id="method" type="hidden" name="_method" value="post">
                                        <input type="hidden" name="course" value="{{$course['id']}}">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input name="name" id="name" type="text" class="form-control" placeholder="Enter the name of this course." required="required">
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
                                    <div class="form-group">
                                        <label>Exam</label>
                                        <select name="exam" id="exam" class="form-control">
                                            <option value="-1">Not set</option>
                                            @foreach ($quizzes as $quiz)
                                                <option value="{{$quiz['id']}}">{{$quiz['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>  
                            <div class="modal-footer">
                                <button id="submit" type="submit" class="btn btn-success">Add level</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
            </section>
            <!-- /.content -->
        </div>
@endsection

@section('js-codes')
    @if (hasAbility('edit_courses'))
        <script>
            $().ready(function(){
                $("#level").submit(function(event){
                    event.preventDefault();
                    $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', true );
                    $( 'button[type=submit], input[type=submit]' ).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>' );
                    $.ajax({
                        url: $(this).attr('action'),
                        type:"post",
                        data:  new FormData(this),
                        contentType: false,
                        processData:false,
                        success:function(Messages){
                            for (var key in Messages) {
                                if (key == "success"){
                                    toastr.success(Messages[key]);
                                    if($('#level').attr('data-action') == "add"){
                                        addLevelHtml(Messages['last_insert_id'], $('#lock_state').val(), $('#exam').val());
                                        $("#level").trigger('reset');
                                    }else if($('#level').attr('data-action') == "edit"){
                                        $('#level' + Messages['level_id'] + '_unlocked_by').html($('#lock_state').val())
                                        $('#level' + Messages['level_id'] + '_exam').html($('#exam').val())
                                        $('#level' + Messages['level_id'] + '_name').html($('#name').val())
                                    }
                                }else if(key == "error"){
                                    toastr.error(Messages[key]);
                                }
                            }
                            $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', false );
                            if($('#level').attr('data-action') == "add"){
                                $( 'button[type=submit], input[type=submit]' ).html("Add level" );
                            }else if($('#level').attr('data-action') == "edit"){
                                $( 'button[type=submit], input[type=submit]' ).html("Update" );
                            }
                            
                        } ,
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            toastr.error("Failed to create the course.");
                            $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', false );
                            if($('#level').attr('data-action') == "add"){
                                $( 'button[type=submit], input[type=submit]' ).html("Add level" );
                            }else if($('#level').attr('data-action') == "edit"){
                                $( 'button[type=submit], input[type=submit]' ).html("Update" );
                            }
                        } 
                    })
                });
                /* {{-- Change the modal to suit editing a level --}} */
                $(document).on('click', '.edit-level', function(){
                    var levelId = $(this).attr('data-levelid');
                    var form = $('#level');
                    form.attr('data-action', 'edit');
                    form.attr('action', "{{route('store.level',['course'=> $course['id']])}}/" + levelId);
                    $('#levelActionLabel').html('Edit level');
                    $("#name").val($('#level' + levelId + '_name').html());
                    $("#lock_state").val($('#level' + levelId + '_unlocked_by').html());
                    $("#exam").val($('#level' + levelId + '_exam').html());
                    $("#method").val('patch');
                    $('#submit').html('Update');
                });
                /* {{-- Change the modal to suit adding a level --}} */
                $(document).on('click', '.add-level', function(){
                    var levelId = $(this).attr('data-levelid');
                    var form = $('#level');
                    form.attr('data-action', 'add');
                    form.attr('action', "{{route('store.level',['course'=> $course['id']])}}");
                    $('#levelActionLabel').html('Add level');
                    $("#name").val('');
                    $("#lock_state").val('0');
                    $("#exam").val('-1');
                    $("#method").val('post');
                    $('#submit').html('Add level');
                });
            })

            function addLevelHtml(levelId, unlockedBy, exam){
                var levelName = $("#name").val();
                var html = '<div class="card card-primary"><div class="card-header"><div class="row"><div class="col-10"><h4 class="card-title w-100"><a id="level' + levelId + '_name" class="d-block w-100" data-toggle="collapse" href="#level' + levelId + '" aria-expanded="true">'+ levelName + '</a><span class="d-none" id="level' + levelId + '_unlocked_by">' + unlockedBy + '</span><span class="d-none" id="level' + levelId + '_exam">' + exam + '</span></h4></div><div class="col-2"><a style="margin: 5px;" href="javascript:void(0)" data-toggle="modal" data-target="#levelAction" data-levelid="' + levelId + '" class="float-right edit-level"><i style="color: rgb(73, 192, 89); " class="fas fa-edit fa-2x"></i></a><a style="margin: 5px;" href="javascript:void(0)" data-toggle="modal" data-target="#deleteModal" data-levelid="' + levelId + '" class="float-right"><i style="color: red;" class="fas fa-trash-alt fa-2x"></i></a></div></div></div><div id="level' + levelId + '" class="collapse" data-parent="#accordion"><div class="card-body"></div></div></div>';
                
                $("#accordion").append(html);
            }

            
            

            
        </script>
    @endif
@endsection

