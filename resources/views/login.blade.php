<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in (v2)</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{url('/')}}/public/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{url('/')}}/public/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{url('/')}}/public/dist/css/adminlte.min.css">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{url('/')}}/public/plugins/toastr/toastr.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="javascript:void(0)" class="h1"><b>Lingua</b>Franca</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">{{__('login.header')}}</p>

      <form action="session" method="POST">
        @csrf

        
        <small class="form-text text-danger"></small>
        <div class="input-group mb-3">
          <input id="email" name="email" type="email" class="form-control" placeholder="{{__('login.emailPlaceholder')}}" autofocus>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        
        <div class="input-group mb-3">
          <input id="password" name="password" type="password" class="form-control" placeholder="{{__('login.passwordPlaceholder')}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="icheck-primary">
              <input name="remember" type="checkbox" id="remember">
              <label for="remember">
                {{__('login.rememberMe')}}
              </label>
            </div>
          </div>
          
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">{{__('login.signIn')}}</button>
          </div>
          <!-- /.col -->
        </div>
       
      </form>

    {{--   <div class="social-auth-links text-center mt-2 mb-3">
        <a href="#" class="btn btn-block btn-primary">
          <i class="fab fa-facebook mr-2"></i> Sign in using Facebook
        </a>
        <a href="#" class="btn btn-block btn-danger">
          <i class="fab fa-google-plus mr-2"></i> Sign in using Google+
        </a>
      </div>
      <!-- /.social-auth-links -->
 --}}
      {{-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> --}}
      <p class="mb-0">
        <a href="/register" class="text-center">{{__('login.register')}}</a>
      </p>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="/public/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/public/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/public/dist/js/adminlte.min.js"></script>
<!-- jquery-validation -->
<script src="/public/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="/public/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- Toastr -->
<script src="/public/plugins/toastr/toastr.min.js"></script>
<script>
  $('document').ready(function(){
    {{--Form Validation--}}
        $('form').validate({
            rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
                minlength: 8
            },
            },
            messages: {
            email: {
                required: "Please enter an email address.",
                email: "Please enter a vaild email address."
            },
            password: {
                required: "Please enter your password.",
            },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            }  ,
            submitHandler: function(){
                var email = $('#email').val();
                var password = $('#password').val();
                var _token = '{{csrf_token()}}';
                $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', true );
                        $( 'button[type=submit], input[type=submit]' ).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>' );
                $.ajax({
                        type:'post',
                        url:'/session',
                        data:{
                        'email'   : email,
                        'password': password,
                        '_token'  : _token
                        },
                        success:function(Messages){
                            Messages = JSON.parse(Messages)
                            for (var key in Messages) {
                                if (Messages[key]== "You logged in successfully."){
                                    toastr.success(Messages[key]);
                                    window.location.replace('/');
                                }else{
                                    toastr.error(Messages[key]);
                                }
                            }
                            $( 'button[type=submit], input[type=submit]' ).prop( 'disabled', false );
                            $( 'button[type=submit], input[type=submit]' ).html("Login" );
                        }
                });
            
            }  
        });
    {{--/Form Validation--}}
    
});



</script>
</body>
</html>
