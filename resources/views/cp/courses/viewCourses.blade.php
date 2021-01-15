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
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Courses</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Courses</li>
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
                                <h3 class="card-title">Coruses table</h3>
                                @if (hasAbility('add_courses'))
                                <a class="btn btn-primary float-right" href="{{route('create.course')}}">
                                    Create a new course
                                </a>
                                @endif
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table id="courses" class="table table-bordered table-striped dataTable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th class="searchable">Name</th>
                                            <th class="searchable">Created by</th>
                                            <th class="searchable">State</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($courses as $course)
                                            <tr id="course_{{$course['id']}}">
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $course['name'] }}</td>
                                                <td>
                                                    <a class="{{ $course['creator']['suspended'] }}" href="{{route('show.user', ['user'=> $course['creator']['id']])}}">
                                                        {{ $course['creator']['name'] }}
                                                    </a>
                                                </td>
                                                <td>{{ $course['state'] }}</td>
                                                
                                                <td class="actionsIcons">
                                                    <a href="{{route('show.course', ['course'=> $course['id']])}}">
                                                        <i style="color: dodgerblue;" class="fas fa-eye fa-2x"></i>
                                                    </a>
                                                    @if (hasAbility('edit_courses'))
                                                        <a href="{{route('edit.course', ['course'=> $course['id']])}}">
                                                            <i style="color: rgb(73, 192, 89); " class="fas fa-edit fa-2x"></i>
                                                        </a>
                                                    @endif

                                                    @if (hasAbility('delete_courses'))
                                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#deleteModal" data-courseid="{{$course['id']}}">
                                                        <i style="color: red;" class="fas fa-trash-alt fa-2x"></i>
                                                    </a>
                                                    @endif
                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Created by</th>
                                            <th>State</th>
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
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to delete the course?
                            </div>
                            <div class="modal-footer">
                                <button id="close_modal" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <form method="POST" >
                                    @method('DELETE')
                                    @csrf
                                    <input type="hidden" id="course_id" name="course_id">
                                    <button id="confirm_deletion" type="button" class="btn btn-danger" onclick="delete_course()">Delete</button>
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
        $('#deleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var course_id = button.data('courseid') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this)
            modal.find('.modal-footer #course_id').val(course_id)
            modal.find('form').attr('action', '/admincp/courses/' + course_id)
        })
        function delete_course(){
            $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', true );
			$( 'button[type=submit], input[type=submit]' ).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>' );

            $.ajax({
                url:"/admincp/courses/" + $("#course_id").val(),
                type: 'post',
                data: {
                    '_token':'{{csrf_token()}}',
                    '_method': 'DELETE'
                    },
                success: function(response){
                    var rowID = $("#course_id").val()
                    $("#close_modal").click();
                    $('#course_'+rowID).fadeOut('slow', function(){
                        $(this).remove();
                    }); 
                }
            });
        }
    </script>
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
