@extends('cp.layouts.adminMaster')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a>Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <x-dashboard.small-box bgColor="bg-info" statistics="{{$studentsCount}}" title="Users" icon="fas fa-users" link="#" detailsText="More info" />
                <x-dashboard.small-box bgColor="bg-success" statistics="{{$coursesCount}}" title="Teachers" icon="fas fa-chalkboard-teacher" link="#" detailsText="More info" />
                <x-dashboard.small-box bgColor="bg-warning" statistics="{{$coursesCount}}" title="Courses" icon="fas fa-layer-group nav-icon" link="#" detailsText="More info" />
                <x-dashboard.small-box bgColor="bg-danger" statistics="{{$lessonsCount}}" title="Lessons" icon="fas fa-book-open" link="#" detailsText="More info" />
            </div>
            <!-- /.row -->
            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <section class="col-lg-7 connectedSortable">
                    <x-dashboard.to-do /> 
                    {{-- <x-direct-chat /> --}}
                    
                </section>
                <!-- /.Left col -->
                <!-- right col (We are only adding the ID to make the widgets sortable)-->
                <section class="col-lg-5 connectedSortable">
                    <x-dashboard.calendar-card />
                </section>
                <!-- right col -->
            </div>
            <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

{{-- @section('body-classes', 
'dark-mode                  => this is to activate dark mode
 layout-navbar-fixed        => this is to make the upper navbar fixed
 sidebar-mini-xs            => this is to prevent the sidebar from hiding on small screens 
 ') --}}
{{--
 <!-- sidebar options -->
     @section('sidebar-classes','
        nav-child-indent => this puts indentation to a child <li> in the sidebar, however,
                            if collapse is enebled so this is useless as it gets reset every collapse.
        nav-flat         => These two classes make different background-colors to the children <li></li>    
        nav-legacy
    ')
 <!-- /.sidebar options -->
  --}}