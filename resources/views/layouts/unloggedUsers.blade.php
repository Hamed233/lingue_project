<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lingua franca</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="public/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="public/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="public/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="public/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="public/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="public/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="public/plugins/summernote/summernote-bs4.min.css">
    <!-- jQuery -->
    <script src="public/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="public/plugins/jquery-ui/jquery-ui.min.js"></script>
    @yield('head')
    <style>
        .main-footer{
            background: rgb(47,69,106);
            background-image: radial-gradient(circle at 51% 111%,rgba(91, 121, 162, 1),rgba(46, 68, 105, 1) 86%);
        }
        .footer-col-title{
            margin-top: 70px;
            height: 50px;
            font-size: 20px;
            font-weight: bold;
        }
        .footer-logo-container{
            height: 120px;
            position: relative;
            text-align: center;
        }
        .footer-logo{
            background-image: url('public/dist/img/linguafranca.png');
            width: 100%;
            background-size:contain;
            background-repeat: no-repeat;
            height: 50px;
            position: absolute;
            bottom: 10px;
        }
        .footer-social a, .footer-links ul a{
            color: whitesmoke;
            margin: 0 3px;
        }
        .footer-social a:hover {
            color: black;
            
        }
        .footer-links ul a:hover{
            color: rgb(209, 208, 208);
        }
        .footer-links ul{
            padding: 0;
        }
        .footer-links li{
            list-style: none;
            font-weight: bold;
        }
    </style>
    
</head>

<body class="hold-transition layout-fixed sidebar-collapse @yield('body-classes') ">
    <div class="wrapper">
        
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            @yield('content')
            <!-- /.content -->
        </div>
        
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-6 aa">
                        <div class="footer-logo-container">
                            <div class="footer-logo"></div>
                        </div>
                        <div>
                            <p>
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.
                            </p>
                            <div class="footer-social">
                                <a href="#">
                                    <i class="fab fa-facebook-square fa-2x"></i>
                                </a>
                                <a href="#">
                                    <i class="fab fa-twitter-square fa-2x"></i>
                                </a>
                                <a href="#">
                                    <i class="fab fa-youtube-square fa-2x"></i>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-12 col-md-3 footer-links">
                        <div class="footer-col-title">Learn</div>
                        <ul>
                            <li><a href="javascript:void(0)">Courses</a></li>
                            <li><a href="javascript:void(0)">Teachers</a></li>
                            <li><a href="javascript:void(0)">Your Dicationary</a></li>
                            <li><a href="javascript:void(0)">Review Words</a></li>
                        </ul>
                    </div>
                    <div class="col-12 col-md-3 footer-links">
                        <div class="footer-col-title">Important links</div>
                        <ul>
                            <li><a href="javascript:void(0)">Forum</a></li>
                            <li><a href="javascript:void(0)">FAQ</a></li>
                            <li><a href="javascript:void(0)">Terms</a></li>
                            <li><a href="javascript:void(0)">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

    </div>
    <!-- ./wrapper -->

    
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)

    </script>
    <!-- Bootstrap 4 -->
    <script src="public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="public/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="public/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="public/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="public/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="public/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="public/plugins/moment/moment.min.js"></script>
    <script src="public/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="public/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="public/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="public/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="public/dist/js/adminlte.js"></script>
    @yield('js-codes')
</body>

</html>
