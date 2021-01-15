@extends('layouts.unloggedUsers')
@section('head')
    <style>
        body{
            background:#2f456a;
        }
        .wrapper{
            max-width: 1501px;
            box-shadow:#000 10px 10px 10px,#000 -10px -10px 10px; 
        }
        @media (min-width:1500px){
            .wrapper{
                padding: 10px;
                border: 1px solid #ccc;
                margin: 10px auto;
            }
        }
        header {
            background: rgb(91, 121, 162);
            min-height: 672px;
            mask-image: url('/public/dist/img/home-bg-mask.svg');
            -webkit-mask-image: url('/public/dist/img/home-bg-mask.svg');
            background-image: radial-gradient(circle at 51% 111%,rgba(91, 121, 162, 1),rgba(46, 68, 105, 1) 86%);
            mask-size: cover;
            -webkit-mask-size: cover;
            position: relative;
        }
        .content-container{
            position: relative;
        }
        .header-logo{
            width: 50%;
            height: 50px;
            pointer-events: none;
        }
        .header-nav{
            text-align: right;
        }
        .btn-link{
            text-decoration: none;
            display:inline-block;
            margin: 5px;
            text-align: center;
            padding: 5px;
            border:2px solid  rgba(91, 121, 162);
            color: white;
            border-radius: 20px;
            font-weight: bold;
        }
        .btn-link:hover{
            background-color: white;
            color: rgba(46, 68, 105, 1);
            
        }
        .header-nav a{
            height: 40px;
            width: 100px;
        }
        
        .home-banner{
            mix-blend-mode:luminosity;
            pointer-events: none;
            width: 616px;
            height: auto;
            position:absolute;
            top: 50px;
            left: -616px;
            opacity: 1;
        }
        
        .header-content{
            position:absolute;
            top: 200px;
            left: 10px;
            color: whitesmoke;
        }
        .header-content p{
            max-width: 553px;
        }
        @media (max-width:767px){
            .home-banner{
            width: 100%;
            left: 0;
            top: -50px;
            opacity: 0.1;
            }
            .header-logo{
                width: 80%;
            }
            .header-content{
            top: 75px;
            }
            header {
                min-height: 500px;
            }
        }
        .header-title-accent {
        background: linear-gradient(90deg,#637bff 20%,#21c8f6 40%,#637bff 60%,#21c8f6 80%,#637bff);
        background-size: 200% auto;
        padding-right: 5px;
        color: #000;
        caret-color: #637bff;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        -webkit-animation: glimmer 5s linear infinite;
        animation: glimmer 5s linear infinite;
        animation-duration: 5s;
        animation-timing-function: linear;
        animation-delay: 0s;
        animation-iteration-count: infinite;
        animation-direction: normal;
        animation-fill-mode: none;
        animation-play-state: running;
        animation-name: glimmer;
        font-size: 28px;
        }
        #header-title-accent:after {
            content: "";
            display: inline-block;
            background: #21c8f6;
            line-height: 13px;
            margin-left: 3px;
            -webkit-animation: blink .8s infinite;
            animation: blink .8s infinite;
            width: 7px;
            height: 30px;
            position: relative;
            top: 5px;
            left: 4px;
        }
        @-webkit-keyframes blink {
        0% {background: transparent}
        50% {background:#21c8f6}
        100% {background: transparent}
        }
        .no-padding{
            padding: 0;
        }
        .widget-language{
            border-radius: 10px;
            background-color: #ffffff;
            text-align: center;
        }
        .widget-language-header{
            border-radius: 10px;
            background: linear-gradient(180deg,#f44881,#ec454f); 
            height: 100%;
        }
        .widget-language-footer{
            min-height: 75px;
        }
        section{
            margin: 50px 0;
        }
        
    </style>
@endsection

@section('content')

        <header>
            <div class="container-fluid">
                <div class="row">
                        <div class="col-6">
                            <img class="header-logo" alt="Header logo" src="/public/dist/img/linguafranca.png"/>
                        </div>
                        <div class="col-6 header-nav">
                            <a class="btn-link" href="{{route('login')}}">SIGN IN</a>
                            <a class="btn-link" href="#">Get started</a>
                        </div>
                </div>
                <div class="row">
                    <div class="col-12 offset-md-6 col-md-6 content-container">
                        <img class="home-banner" alt="Header banner" src="/public/dist/img/logo.svg"/>
                        <div class="header-content">
                            <h1>Lingua franca</h1>
                            <span id="header-title-accent" class="header-title-accent has-cursor"></span> 
                            <p>Push your language skills to the next level, through expert teachers, comprehensive curricula, fun games and so much more.</p>
                            <a href="#" class="btn-link">Browse Courses</a>
                        </div>
                        
                    </div>
                    
                    
                </div>
            </div>
        </header>
        <main>
            <section id="languages">
                <div class="container-fuid">
                    <div class="row" style="margin: 0;">
                        <div class="col-12 offset-md-4 col-md-4 text-center">
                            <h2>
                                Explore the world
                            </h2>
                        </div>
                    </div>
                    <div class="row" style="margin: 0;">
                        {{-- <!-- language --> --}}
                        <div class="col-12 col-md-3">
                            <div class="container-fluid widget-language shadow-lg">
                                <div class="row" >
                                    <div class="col-6 col-md-12 no-padding text-white">
                                        <div class="widget-language-header">
                                            <a href="#">
                                                <img style="width: 120px;height:120px;" src="/public/dist/img/english.png" alt="English">
                                            </a>
                                            <h3>English</h3>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 widget-language-footer">
                                        <div class="row">
                                            <div class=" col-5">
                                                Teachers
                                            </div>
                                            <div class="col-5">
                                                Teachers
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>  
                            </div> 
                        </div>
                        {{--  <!-- End language --> --}}

                        {{-- <!-- language --> --}}
                        <div class="col-12 col-md-3">
                            <div class="container-fluid widget-language shadow-lg">
                                <div class="row" >
                                    <div class="col-6 col-md-12 no-padding text-white">
                                        <div class="widget-language-header">
                                            <a href="#">
                                                <img style="width: 120px;height:120px;" src="/public/dist/img/english.png" alt="English">
                                            </a>
                                            <h3>English</h3>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 widget-language-footer">
                                        <div class="row">
                                            <div class=" col-5">
                                                Teachers
                                            </div>
                                            <div class="col-5">
                                                Teachers
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>  
                            </div> 
                        </div>
                        {{--  <!-- End language --> --}}

                        {{-- <!-- language --> --}}
                        <div class="col-12 col-md-3">
                            <div class="container-fluid widget-language shadow-lg">
                                <div class="row" >
                                    <div class="col-6 col-md-12 no-padding text-white">
                                        <div class="widget-language-header">
                                            <a href="#">
                                                <img style="width: 120px;height:120px;" src="/public/dist/img/english.png" alt="English">
                                            </a>
                                            <h3>English</h3>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 widget-language-footer">
                                        <div class="row">
                                            <div class=" col-5">
                                                Teachers
                                            </div>
                                            <div class="col-5">
                                                Teachers
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>  
                            </div> 
                        </div>
                        {{--  <!-- End language --> --}}

                        {{-- <!-- language --> --}}
                        <div class="col-12 col-md-3">
                            <div class="container-fluid widget-language shadow-lg">
                                <div class="row" >
                                    <div class="col-6 col-md-12 no-padding text-white">
                                        <div class="widget-language-header">
                                            <a href="#">
                                                <img style="width: 120px;height:120px;" src="/public/dist/img/english.png" alt="English">
                                            </a>
                                            <h3>English</h3>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-12 widget-language-footer">
                                        <div class="row">
                                            <div class="col-6 border-right">
                                                <span>Teachers</span>
                                                <span>5</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="d-block">Hours of Learning</span>
                                                <span>300</span>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>  
                            </div> 
                        </div>
                        {{--  <!-- End language --> --}}

                    </div>
                </div>
                
            </section>
            <section id="team">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 offset-md-4 col-md-4 text-center">
                            <h2>
                                Meet the team.
                            </h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="card card-widget widget-user shadow-lg">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header text-white"
                                    style="background: url('/public/dist/img/Ahmed-Fathi-cover.jpg') center center;">
                                    <h3 class="widget-user-username text-right">Ahmed Fathi</h3>
                                    <h5 class="widget-user-desc text-right">Owner of Lingua franca</h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle" style="width: 100px;height:100px;" src="./public/dist/img/Ahmed-Fathi-Home.jpg" alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12">
                                            I just love doing what I do. There’s no other way to put it. Being able to express my passion and at the same time help others grow is one of the most unique feelings I’ve ever felt.
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="card card-widget widget-user shadow-lg">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header text-white"
                                    style="background: url('/public/dist/img/photo1.png') center center;">
                                    <h3 class="widget-user-username text-right">Ahmed Fathi</h3>
                                    <h5 class="widget-user-desc text-right">Owner of Lingua franca</h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle" style="width: 100px;height:100px;" src="./public/dist/img/Ahmed-Fathi-Home.jpg" alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12">
                                            I just love doing what I do. There’s no other way to put it. Being able to express my passion and at the same time help others grow is one of the most unique feelings I’ve ever felt.
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="card card-widget widget-user shadow-lg">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header text-white"
                                    style="background: url('/public/dist/img/photo1.png') center center;">
                                    <h3 class="widget-user-username text-right">Ahmed Fathi</h3>
                                    <h5 class="widget-user-desc text-right">Owner of Lingua franca</h5>
                                </div>
                                <div class="widget-user-image">
                                    <img class="img-circle" style="width: 100px;height:100px;" src="./public/dist/img/Ahmed-Fathi-Home.jpg" alt="User Avatar">
                                </div>
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12">
                                            I just love doing what I do. There’s no other way to put it. Being able to express my passion and at the same time help others grow is one of the most unique feelings I’ve ever felt.
                                        </div>
                                    </div>
                                    <!-- /.row -->
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                        
                    </div>
                        <!-- /.row -->
                </div>
            </section>
                

        </main>
@endsection

@section('js-codes')
    <script>
        /* header-title-accent */
        'use strict';
        var pause = 15;
        var speed = 5;
        var texts = ['New language, new life', "New language, new careers", "New language, new connectins"];
        (function() {
            var text = texts[0];
            var cur = 0,
                dir = 1,
                cur_text = 0;
            var s = 0;
            setInterval(function loop() {
                cur += dir;
                if (cur < 0) {
                cur = 0;
                dir = -dir;
                cur_text = (++cur_text) % 3;
                text = texts[cur_text];
                }
                if (cur > text.length) {
                cur = text.length;
                if (s++ > pause) {
                    s = 0
                    dir = -dir;
                }
                }
                document.querySelector('#header-title-accent').setAttribute('class', 'header-title-accent')
                document.querySelector('#header-title-accent').innerHTML = text.substring(0, cur);
            }, 500 / speed)

        })()
        /* / header-title-accent */

    </script>
@endsection


