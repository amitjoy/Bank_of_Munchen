<?php
require_once '../../includes/global.inc.php';
require_once '../../libs/securimage/securimage.php';

$error = "";
$username = "";
$password = "";

$securimage = new Securimage();

if(isset($_SESSION['logged_in'])) {
    header("Location: accountoverview.php");
}

$token = NoCSRF::generate( 'csrf_token' );

//check to see if they've submitted the login form
if(isset($_POST['submit_logon'])) { 

    //CAPTCHA Validation
    if (!$securimage->check($_POST['captcha_code'])) {
        ?>
        <script>
          alert("Captcha Validation Failed");
        </script>
        <?php
        exit;
    }

    $username = Validation::xss_clean(DB::makeSafe($_POST['email']));
    $password = Validation::xss_clean(DB::makeSafe($_POST['password']));

    if (filter_var($username, FILTER_VALIDATE_EMAIL) != true) {
        header ("Location: error.php?message=Email Validation Failed");
    }

    $userTools = new UserTools();

    if ($userTools->login($username, $password)){ 
        //successful login, redirect them to a page
        header("Location: accountoverview.php?csrf_token=$token");
    } else {
        $error = "Incorrect username or password. Please try again.";
    }
}

if($error != "")
{
?>
<script>
 alert("Incorrect username or password / Account not approved. Please try again.");
</script>

<?php
}

?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 "> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 "> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 "> <![endif]-->
<!--[if gt IE 8]> <html class="ie "> <![endif]-->
<!--[if !IE]><!-->
<html class="">
<!-- <![endif]-->
<head>
    <title>Login</title>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <!-- 
	**********************************************************
	In development, use the LESS files and the less.js compiler
	instead of the minified CSS loaded by default.
	**********************************************************
	<link rel="stylesheet/less" href="../assets/less/admin/module.admin.stylesheet-complete.sidebar_type.collapse.less" />
	-->
    <!--[if lt IE 9]><link rel="stylesheet" href="../assets/components/library/bootstrap/css/bootstrap.min.css" /><![endif]-->
    <link rel="stylesheet" href="../assets/css/admin/module.admin.stylesheet-complete.sidebar_type.collapse.min.css"
    />
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="../assets/components/library/jquery/jquery.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="../assets/components/library/jquery/jquery-migrate.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="../assets/components/library/modernizr/modernizr.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="../assets/components/plugins/less-js/less.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
	<script src="../assets/components/library/rollups/sha512.js"></script>
	<script src="../assets/components/library/js/login.validation.js"></script>
    <script src="../assets/components/modules/admin/charts/flot/assets/lib/excanvas.js?v=v1.0.3-rc2"></script>
    <script src="../assets/components/plugins/browser/ie/ie.prototype.polyfill.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script>
    if ( /*@cc_on!@*/ false && document.documentMode === 10)
    {
        document.documentElement.className += ' ie ie10';
    }
    </script>
</head>
<body class=" loginWrapper">
    <!-- Main Container Fluid -->
    <div class="container-fluid menu-hidden">
        <!-- Content -->
        <div id="content">
            <nav class="navbar hidden-print main " role="navigation">
                <!-- // END container -->
            </nav>
            <!-- // END navbar -->
            <div class="container">
                <!-- row-app -->
                <div class="row row-app">
                    <!-- col -->
                    <!-- col-separator.box -->
                    <div class="col-separator col-unscrollable box">
                        <!-- col-table -->
                        <div class="col-table">
                            <h4 class="innerAll margin-none border-bottom text-center"><i class="fa fa-lock"></i> Login to your Account</h4>
                            <!-- col-table-row -->
                            <div class="col-table-row">
                                <!-- col-app -->
                                <div class="col-app col-unscrollable">
                                    <!-- col-app -->
                                    <div class="col-app">
                                        <div class="login">
                                            <div class="placeholder text-center"><i class="fa fa-lock"></i>
                                            </div>
                                            <div class="panel panel-default col-md-4 col-sm-6 col-sm-offset-3 col-md-offset-4">
                                                <div class="panel-body">
                                                    <form role="form" action="banklogin.php" method="POST" id="loginForm" onsubmit="return validation()">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Email address</label>
                                                            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Password</label>
                                                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                                        </div>
                                                        <div class="form-group">
                                                            <img id="captcha" src="../../libs/securimage/securimage_show.php" alt="CAPTCHA Image" />
                                                            <object type="application/x-shockwave-flash" data="../../libs/securimage/securimage_play.swf?bgcol=%23ffffff&amp;icon_file=..%2F..%2Flibs%2Fsecurimage%2Fimages%2Faudio_icon.png&amp;audio_file=..%2F..%2Flibs%2Fsecurimage%2Fsecurimage_play.php" height="32" width="32"><param name="movie" value="/securimage/securimage_play.swf?bgcol=%23ffffff&amp;icon_file=%2Fsecurimage%2Fimages%2Faudio_icon.png&amp;audio_file=%2Fsecurimage%2Fsecurimage_play.php"></object>
                                                            <a href="#" onclick="document.getElementById('captcha').src = '../../libs/securimage/securimage_show.php?' + Math.random(); return false"><img height="32" width="32" src="../../libs/securimage/images/refresh.png" alt="Refresh Image" onclick="this.blur()" border="0"></a>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="captcha_code" id="captcha_code" size="10" maxlength="6" placeholder="Captcha Code"/>
                                                        </div>
                                                        <button type="submit" class="btn btn-primary btn-block" name="submit_logon">Login</button>
                                                        <!--div class="checkbox">
                                                            <label>
                                                                <input type="checkbox">Remember my details>
                                                            </label>
                                                        </div-->
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-sm-offset-4 text-center">
                                                <div class="innerAll">
                                                    <a href="banksignup.php?lang=en" class="btn btn-info">Create a new account? <i class="fa fa-pencil"></i> </a>
                                                    <div class="separator"></div>
                                                </div>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                    <!-- // END col-app -->
                                </div>
                                <!-- // END col-app.col-unscrollable -->
                            </div>
                            <!-- // END col-table-row -->
                        </div>
                        <!-- // END col-table -->
                    </div>
                    <!-- // END col-separator.box -->
                </div>
                <!-- // END row-app -->
                <!-- Global -->
                <script data-id="App.Config">
                var App = {};
                var basePath = '',
                    commonPath = '../assets/',
                    rootPath = '../',
                    DEV = false,
                    componentsPath = '../assets/components/';
                var primaryColor = '#3695d5',
                    dangerColor = '#b55151',
                    successColor = '#609450',
                    infoColor = '#4a8bc2',
                    warningColor = '#ab7a4b',
                    inverseColor = '#45484d';
                var themerPrimaryColor = primaryColor;
                </script>
                <script src="../assets/components/library/bootstrap/js/bootstrap.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
                <script src="../assets/components/plugins/nicescroll/jquery.nicescroll.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
                <script src="../assets/components/plugins/breakpoints/breakpoints.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
                <script src="../assets/components/plugins/preload/pace/pace.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
                <script src="../assets/components/plugins/preload/pace/preload.pace.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
                <script src="../assets/components/core/js/animations.init.js?v=v1.0.3-rc2"></script>
                <script src="../assets/components/core/js/core.init.js?v=v1.0.3-rc2"></script>
</body>
</html>