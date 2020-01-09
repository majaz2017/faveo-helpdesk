<!DOCTYPE html>
<html>

  <head>
    <meta charset="UTF-8">
    <?php
    $title = App\Model\helpdesk\Settings\System::where('id', '=', '1')->first();
    if (isset($title->name)) {
        $title_name = $title->name;
    } else {
        $title_name = "SUPPORT CENTER";
    }
    ?>
    <title> @yield('title') {!! strip_tags($title_name) !!} </title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css" rel="stylesheet"
      type="text/css" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet"
      type="text/css" />
    <!-- Theme style -->
    <link href="{{asset("dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="{{asset("plugins/iCheck/square/blue.css")}}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <?php $rtl = Finder::getRtl(); ?>
  @if ($rtl->option_value)

  <body class="login-page" dir="rtl">
    @else

    <body class="login-page">
      @endif
      <div class="login-box">
        <div class="login-logo">
          <a href="../../index2.html"> HELP DESK</a>
        </div><!-- /.login-logo -->

        @yield('body')

      </div><!-- /.login-box -->

      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
      <!-- iCheck -->
      <script src="{{asset("plugins/iCheck/icheck.min.js")}}" type="text/javascript"></script>
      <script>
        $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
      </script>
    </body>

</html>