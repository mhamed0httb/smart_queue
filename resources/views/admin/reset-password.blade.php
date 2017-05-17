<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ URL::asset('/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ URL::asset('/css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ URL::asset('/css/blue.css') }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">

@if(Sentinel::check() && Sentinel::getUser()->roles()->first()->slug == 'admin')
    <script>window.location = '{{url('/dashboard')}}';</script>
@elseif(Sentinel::check() && Sentinel::getUser()->roles()->first()->slug == 'manager')
    <script>window.location = '{{url('/manager')}}';</script>
@endif


<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Reset Password</b> </a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Enter new password</p>

        <form action="" method="post">
            {{csrf_field()}}
            @if(count($errors) > 0)
                <div class="callout callout-danger" id="ban_callout">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="form-group has-feedback" id="div_has_error_password">
                <input type="password" class="form-control" name="password" id="input_password" placeholder="Password" required>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback" id="div_has_error_password">
                <input type="password" class="form-control" name="password_confirmation" id="input_password_confirmation" placeholder="Password Confirmation" required>
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-6">

                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Update Password</button>
                </div>
                <!-- /.col -->
            </div>
        </form>


    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<div id="div_alert" style="position: fixed; top: 5%; right: 0%"></div>

<!-- jQuery 2.2.3 -->
<script src="{{ URL::asset('/js/jquery-2.2.3.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ URL::asset('/js/bootstrap.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ URL::asset('/js/icheck.min.js') }}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>


<script>
    function dismissAlertMessage(){
        setTimeout(function() {
            $('#div_alert').fadeOut();
        }, 6000);
    }
</script>



@if(Session::has('error_credentials'))
    <script>
        //$('#input_email').css('border','1px solid red');
        //$('#input_password').css('border','1px solid red');
        $('#div_has_error_email').addClass('has-error');
        $('#div_has_error_password').addClass('has-error');
        $('#label_error_email').removeClass('hide');
        $('#label_error_password').removeClass('hide');
        $('#div_alert').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-ban"></i> ERROR!</h4>{{ Session::get('error_credentials') }}</div>');
        dismissAlertMessage();
    </script>
@endif
@if(Session::has('banned'))
    <script>
        //$('#div_alert').html('<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-ban"></i> BANNED!</h4>{{ Session::get('banned') }}</div>');
        //dismissAlertMessage();
        $('#ban_content').html('{{ Session::get('banned') }}');
        $('#ban_callout').removeClass('hide');
    </script>
@endif

</body>
</html>
