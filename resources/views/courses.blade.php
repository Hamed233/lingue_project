@extends('layouts.master')

@section('head')
    <style>
        .main-header {
            background: rgb(91, 121, 162);
            background: -moz-linear-gradient(90deg, rgba(91, 121, 162, 1) 0%, rgba(46, 68, 105, 1) 100%);
            background: -webkit-linear-gradient(90deg, rgba(91, 121, 162, 1) 0%, rgba(46, 68, 105, 1) 100%);
            background: linear-gradient(90deg, rgba(91, 121, 162, 1) 0%, rgba(46, 68, 105, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#5b79a2", endColorstr="#2e4469", GradientType=1);
        }

        .main-header .nav-item i {
            color: white;
        }

        .nav-active {
            background-color: #83a9df52;
        }

        .Section-header h1 {
            padding: 50px 50px 10px 50px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            margin: auto;
            font-family: Arial, Tahoma;
        }

        .Section-header p {
            font-family: Arial, Tahoma;
            font-size: 17.5px;
        }

        .course-box-container {
            box-sizing: border-box;
            padding: 30px 50px 0px 50px;
        }
        .body{
            background-color: #f4f6f9;
        }
        .course-box-light {
            border-radius: 20px;
            background-color: white;
            box-sizing: border-box;
            padding: 50px 50px 50px 50px;
            background-image: url('english.png');
            background-size: 450px 500px;
            background-position-x: -130px;
            background-position-y: -50px;
            background-repeat: no-repeat;
            max-width: 1070px;
            margin: auto;
            min-height: 363px;
        }
        .course-box-content {
                height: 320px;
            }
        @media (max-width: 767px) {
            .course-box-light {
                background-size: 500px 400px;
                background-position-x: center;
                background-position-y: -90px;
                background-repeat: no-repeat;
                
            }
            .course-box-icon {
            height: 300px;
            }

            .course-box-content {
                height: 290px;
            }
            .start-cours-link{
                margin: 0 auto;
            }
        }
        .course-state-label {
            padding: 5px;
            background-color: rgb(49, 202, 138);
            width: 120px;
            text-align: center;
            border-radius: 20px;
            margin-bottom: 15px;
            color: white;
            display: block;
        }
        .course-state-label:hover {
            color: white;
            text-decoration: none;
        }
        .course-link-name{
            color:#22292f;
        }
        .course-link-name:hover{
            color:#22292f;
            text-decoration: underline;
        }
        .course-description{
            min-height: 100px;
        }
        .course-description, .course-difficulty{
            color: #606f8b;
        }
        .course-difficulty{
            font-family: arial;
            font-weight: bold;
        }
        .start-course-link{
            padding: 8px 1px;
            width: 90%;
            border: 1px solid;
            border-radius: 25px;
            display: block;
            text-align: center;
            margin: 20px auto;
            color:#22292f;
            font-weight: bold;
            box-sizing: border-box;
        }
        .start-course-link:hover{
            color:#1086ee;
        }
        .start-course-link span{
            font-size: 20px;
        }

    </style>
@endsection
@section('courses-active', 'nav-active')
@section('content')
    
        <!-- Main content -->
        <section class="coursesSection">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center Section-header">
                        <h1>Recently Updated</h1>
                        <p>
                            Curious what's new at Lingua Franca? The following courses have been recently updated
                        </p>
                    </div>
                </div>
                <x-course-wide-card state="In progress" image="public/dist/img/english.png" title="This is a test course" link="#" description="bla bla bla bla bla bla" difficulty="Easy" levels="18" time="16" stateBtnColor="rgba(255, 187, 0)" difficultyNumber="20" />
                <x-course-wide-card state="In progress" image="public/dist/img/french.png" title="This is a test course" link="#" description="bla bla bla" difficulty="inter" levels="18" time="90" stateBtnColor="rgba(255, 187, 0)" difficultyNumber="50" />
                
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    
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
