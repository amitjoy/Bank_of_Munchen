<?php 
session_start();

require_once '../../includes/global.inc.php';
require_once '../../utils/Generators.util.php';
require_once '../../includes/mail.inc.php';
require_once '../../libs/securimage/securimage.php';

//initialize php variables used in the form
$firstName = "";
$middleName = "";
$lastName = "";
$emailId = "";
$mobileNo = "";
$password = "";
$password_confirm = "";
$errorIsRejected = "";
$errorEmailExists = "";

$securimage = new Securimage();


//Temprary arrays used to store variable for further operation
$userData = array();
$accountData = array();

if (isset($_SESSION['logged_in'])) {
    header("Location: accountoverview.php");
}


//check to see that the form has been submitted
if(isset($_POST['submit_form'])) {

    //CAPTCHA Validation
    if (!$securimage->check($_POST['captcha_code'])) {
        ?>
        <script>
          alert("Captcha Validation Failed");
        </script>
        <?php
        exit;
    }

    //retrieve the $_POST variables
    $firstName = Validation::xss_clean(DB::makeSafe($_POST["firstName"]));
    $middleName = Validation::xss_clean(DB::makeSafe($_POST["middleName"]));
    $lastName = Validation::xss_clean(DB::makeSafe($_POST["lastName"]));
    $emailId = Validation::xss_clean(DB::makeSafe($_POST["emailId"]));
    $mobileNo = Validation::xss_clean(DB::makeSafe($_POST["mobileNo"]));
    $password = Validation::xss_clean(DB::makeSafe($_POST["password"]));
    $password_confirm = Validation::xss_clean(DB::makeSafe($_POST['retypePassword']));

    //initialize variables for form validation
    $success = true;
    $userTools = new UserTools();
    
    //validate that the form was filled out correctly
    if (filter_var($emailId, FILTER_VALIDATE_EMAIL) != true) {
        $success = false;
        ?>
        <script>
          alert("Email Validation Failed");
        </script>
        <?php
    }

    if (!preg_match("/(\d{11})/", $mobileNo)) {
        $success = false;
        ?>
        <script>
          alert("Mobile No Validation Failed");
        </script>
        <?php
    }

    //check to see if user name already exists
    if ($userTools->checkEmailExists($emailId))
    {
        $errorEmailExists = "That Email is already registered. \n\r";
        $success = false;
    }

	if ($userTools->isRejected($emailId)) 
	{
		$errorIsRejected = "This email Id has been rejected previously and hence blacklisted. \n\r";
		$success = false;
	}

    if ($errorIsRejected != "") {
		?>
		<script>
		  alert("This email Id has been rejected previously and hence blacklisted");
		</script>
		<?php
    }
    
    else if ($errorEmailExists != "") {
		?>
		<script>
		  alert("That Email is already registered");
		</script>
		<?php
    }

    if($success)
    {
        //prep the data for saving in a new user object
        $userData['emailId'] = $emailId;
        $userData['mobileNo'] = $mobileNo;
        $userData["lastName"] = $lastName;
        $userData["firstName"] = $firstName;
        $userData["middleName"] = $middleName;
        $userData["isActive"] = 0; //For the first time the user is not approved by admins
        $userData["isAdmin"] = 0;
        $userData["createdDate"] = date("Y-m-d H:i:s");

        //prepare account related information to save in account object
        $accountData["userId"] = $emailId;
        $accountData["balance"] = INITIAL_BALANCE;
        $accountData["accountNo"] = Generators::generateUniqueAccountNo();
        $accountData['password'] = $password; 
    
        //create the new user object
        $newUser = new User($userData);

        //create the new account object for this user
        $newAccount = new Account($accountData);
    
        //save the new user to the database
        $newUser->save(true);

        //save the account details to the database
        $newAccount->save(true);

        //Generate TAN and for this user's future USE
        $TANNos = Generators::generateTANs (NO_OF_TAN_TO_GENERATE);

        foreach ($TANNos as $key => $value) {
            $tempArray = array();

            $tempArray["no"] = $value;
            $tempArray["userId"] = "'$emailId'";
            $tempArray["isActive"] = 1;

            $db->insert($tempArray, "TANS");

            unset($tempArray);
        }

        // send the mail to the email
        $message = Swift_Message::newInstance()

                      ->setSubject(MAIL_SUBJECT_SIGNUP)

                      ->setFrom(array(MAIL_FROM => MAIL_FROM_NAME))

                      ->setTo(array($emailId))

                      ->setBody(MAIL_BODY_SIGNUP)

                      ;

        $mailer->send($message);

        //redirect them to a welcome page
        header("Location: signupsuccess.php?success=1");
        
    }

}

//If the form wasn't submitted, or didn't validate
//then we show the registration form again
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
    <title>SignUp</title>
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
    <link rel="stylesheet" href="../assets/css/admin/module.admin.stylesheet-complete.sidebar_type.collapse.min.css"/>
    <link rel="stylesheet" href="../assets/css/admin/signupvalidation.css"/>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <script src="../assets/components/library/jquery/jquery.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="../assets/components/library/js/registration.validation.js"></script>
    <script src="../assets/components/library/rollups/sha512.js"></script>
    <script src="../assets/components/library/jquery/jquery-migrate.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="../assets/components/library/modernizr/modernizr.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="../assets/components/plugins/less-js/less.min.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
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
                            <h4 class="innerAll margin-none border-bottom text-center bg-primary"><i class="fa fa-pencil"></i> Create a new Account</h4>
                            <!-- col-table-row -->
                            <div class="col-table-row">
                                <!-- col-app -->
                                <div class="col-app col-unscrollable">
                                    <!-- col-app -->
                                    <div class="col-app">
                                        <div class="login">
                                            <div class="placeholder text-center"><i class="fa fa-pencil"></i>
                                            </div>
                                            <div class="panel panel-default col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                                                <div class="panel-body">
                                                    <form role="form" method="POST" id="registraionForm" onsubmit="return validateFields()">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">First Name</label>
                                                            <input type="text" class="form-control" id="firstName" placeholder="Your first name" name="firstName">
                                                        </div>
														<div class="form-group">
                                                            <label for="exampleInputEmail1">Middle Name</label>
                                                            <input type="text" class="form-control" id="middleName" placeholder="Your middle name" name="middleName">
                                                        </div>
														<div class="form-group">
                                                            <label for="exampleInputEmail1">Last Name</label>
                                                            <input type="text" class="form-control" id="lastName" placeholder="Your last name" name="lastName">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Email address</label>
                                                            <input type="email" class="form-control" id="emailId" placeholder="Enter email" name="emailId">
                                                        </div>
														<div class="form-group">
                                                            <label for="exampleInputEmail1">Mobile Number</label>
                                                            <input type="text" class="form-control" id="mobileNo" placeholder="Enter mobile no" name="mobileNo">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Password</label>
                                                            <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Confirm Password</label>
                                                            <input type="password" class="form-control" id="retypePassword" placeholder="Retype Password" name="retypePassword">
                                                        </div>
                                                        <div class="form-group">
                                                            <img id="captcha" src="/securimage/securimage_show.php" alt="CAPTCHA Image" />
                                                            <object type="application/x-shockwave-flash" data="/securimage/securimage_play.swf?bgcol=%23ffffff&amp;icon_file=%2Fsecurimage%2Fimages%2Faudio_icon.png&amp;audio_file=%2Fsecurimage%2Fsecurimage_play.php" height="32" width="32"><param name="movie" value="/securimage/securimage_play.swf?bgcol=%23ffffff&amp;icon_file=%2Fsecurimage%2Fimages%2Faudio_icon.png&amp;audio_file=%2Fsecurimage%2Fsecurimage_play.php"></object>
                                                            <a href="#" onclick="document.getElementById('captcha').src = '/securimage/securimage_show.php?' + Math.random(); return false"><img height="32" width="32" src="/securimage/images/refresh.png" alt="Refresh Image" onclick="this.blur()" border="0"></a>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" name="captcha_code" id="captcha_code" size="10" maxlength="6" placeholder="Captcha Code"/>
                                                        </div>
                                                        <input type="submit" class="btn btn-primary btn-block" name="submit_form" value="Sign Up">
                                                        <button type="reset" class="btn btn-primary btn-block">Reset</button>                                                        
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-sm-offset-4 text-center">
                                                <div class="innerAll">
                                                    <a href="banklogin.php?lang=en" class="btn btn-info">Have an account? Log-In <i class="fa fa-pencil"></i> </a>
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
