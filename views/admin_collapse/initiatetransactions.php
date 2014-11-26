<?php
//welcome.php

require_once '../../includes/global.inc.php';

//check to see if they're logged in
if(!isset($_SESSION['logged_in'])) {
    header("Location: banklogin.php");
}

try {
    NoCSRF::check( 'csrf_token', $_GET, true, 60*10, false );

    //get the user object from the session
    $user = unserialize(Validation::xss_clean($_SESSION['user']));

    $emailId = Validation::xss_clean(DB::makeSafe($_SESSION["emailId"]));

    if (filter_var($emailId, FILTER_VALIDATE_EMAIL) != true) {
        header ("Location: error.php?message=Email Validation Failed");
    }

    $row = mysql_fetch_object(mysql_query("SELECT * FROM USERS WHERE emailId = '$emailId' AND isActive = 1"));
}
catch (Exception $e) {
    header ("Location: error.php");
}

$token = NoCSRF::generate( 'csrf_token' );


?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 sidebar sidebar-collapse"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 sidebar sidebar-collapse"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 sidebar sidebar-collapse"> <![endif]-->
<!--[if gt IE 8]> <html class="ie sidebar sidebar-collapse"> <![endif]-->
<!--[if !IE]><!-->
<html class="sidebar sidebar-collapse">
<!-- <![endif]-->
<head>
    <title>Initiate Transactions</title>
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
	<link rel="stylesheet" href="../assets/components/common/forms/file_manager/dropzone/assets/lib/css/dropzone.css"
    />
	<link rel="stylesheet" href="../assets/components/common/forms/file_manager/plupload/assets/lib/jquery.plupload.queue/css/jquery.plupload.queue.css"
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
    <script src="../assets/components/modules/admin/charts/flot/assets/lib/excanvas.js?v=v1.0.3-rc2"></script>
    <script src="../assets/components/plugins/browser/ie/ie.prototype.polyfill.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
	<script src="../assets/components/common/forms/wizards/assets/lib/jquery.bootstrap.wizard.js"></script>
	<script src="../assets/components/common/forms/wizards/assets/custom/js/form-wizards.init.js"></script>
	<script src="../assets/components/common/forms/file_manager/dropzone/assets/lib/js/dropzone.min.js"></script>
	<script src="../assets/components/common/forms/file_manager/dropzone/assets/custom/dropzone.init.js"></script>
	<script src="../assets/components/common/forms/file_manager/plupload/assets/custom/plupload.init.js"></script>
	<script src="../assets/components/common/forms/file_manager/plupload/assets/lib/jquery.plupload.queue/jquery.plupload.queue.js"></script>
	<script src="../assets/components/common/forms/file_manager/plupload/assets/lib/plupload.browserplus.js"></script>
	<script src="../assets/components/common/forms/file_manager/plupload/assets/lib/plupload.flash.js"></script>
	<script src="../assets/components/common/forms/file_manager/plupload/assets/lib/plupload.full.js"></script>
	<script src="../assets/components/common/forms/file_manager/plupload/assets/lib/plupload.gears.js"></script>
	<script src="../assets/components/common/forms/file_manager/plupload/assets/lib/plupload.html5.js"></script>
	
    <script src="../assets/components/library/rollups/sha512.js"></script>
	<!--<script src="../assets/components/library/js/transactioninitiation.validation.js"></script>-->
    <script type="text/javascript">
    if ( /*@cc_on!@*/ false && document.documentMode === 10)
    {
        document.documentElement.className += ' ie ie10';
    }
    </script>
</head>
<body class="">
    <!-- Main Container Fluid -->
    <div class="container-fluid menu-hidden">
        <!-- Sidebar Menu -->
        <div id="menu" class="hidden-print hidden-xs  sidebar-white">
            <div id="sidebar-collapse-wrapper">
                <div id="brandWrapper">
                    <a href="accountoverview.php?lang=en" class="display-block-inline pull-left logo">
                        <img src="../assets/images/logo/logo.jpg" alt="">
                    </a>
                    <a href="accountoverview.php?lang=en">
                        <span class="text">Bank of M&uuml;nchen</span>
                    </a>
                </div>
                
                <ul class="menu list-unstyled hide" id="navigation_components">
                </ul>
                <ul class="menu list-unstyled hide" id="navigation_modules">
                </ul>
                <ul class="menu list-unstyled hide" id="navigation_modules_front">
                </ul>
                <ul class="menu list-unstyled" id="navigation_current_page">
                    <li><a href="accountoverview.php?lang=en&csrf_token=<?php echo $token; ?>" class="glyphicons home"><i></i><span>Account Overview</span></a>
                    </li>
					<li class="hasSubmenu active">
                        <a href="#sidebar-collapse-overview" data-toggle="collapse" class="glyphicons money ">
                            <span class="badge pull-right badge-primary hidden-md">2</span><i></i>
                            <span>Transactions</span>
                        </a>
                        <ul id="sidebar-collapse-overview" class="collapse in ">
                            <li><a href="detailedstatement.php?lang=en&csrf_token=<?php echo $token; ?>"><i class="fa fa-list-alt"></i> Detailed Statement</a>
                            </li>
                            <li class="active"><a href="#"><i class="fa fa-euro"></i> Initiate Transactions</a>
                            </li>
                            <!-- <li><a href="medical_overview.html?lang=en"><i class="fa fa-medkit"></i> Medical</a></li> -->
                            <!-- <li><a href="finances.html?lang=en"><i class="fa fa-credit-card"></i>Financial</a></li> -->
                            <!-- <li><a href="courses_2.html?lang=en"><i class="fa fa-book"></i>Learning</a></li> -->
                        </ul>
                    </li>
                    <?php if ($row->isAdmin == 1) { ?>
                    <li><a href="admin.php?lang=en&csrf_token=<?php echo $token; ?>" class="glyphicons cogwheels"><i></i><span>Administration</span></a>
                         <?php } ?>
                    </li>
					<?php if ($row->isAdmin == 1) { ?>
					<li><a href="users.php?lang=en&csrf_token=<?php echo $token; ?>" class="glyphicons parents"><i></i><span>Registered Users</span></a>
                        <?php } ?>
                    </li>
                    <li><a href="batchlogs.php?csrf_token=<?php echo $token; ?>" class="glyphicons notes_2"><i></i><span>Batch Logs</span></a>
                    </li>
                    <?php if ($row->isAdmin == 1) { ?>
					<li><a href="usersPrivChange.php?lang=en&csrf_token=<?php echo $token; ?>" class="glyphicons parents"><i></i><span>Privilege Change</span></a>
                        <?php } ?>
                    </li>
                </ul>
            </div>
        </div>
        <!-- // Sidebar Menu END -->
        <!-- Content -->
        <div id="content">
            <nav class="navbar hidden-print main " role="navigation">
                <div class="navbar-header pull-left">
                    <div class="user-action user-action-btn-navbar pull-left border-right">
                        <button class="btn btn-sm btn-navbar btn-inverse btn-stroke"><i class="fa fa-bars fa-2x"></i>
                        </button>
                    </div>
                </div>
                <ul class="main pull-right ">
                    
                    <li class="dropdown username">
                        <a href="" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="../assets/images/people/35/2.jpg" class="img-circle"
                            width="30" /><?=Validation::xss_clean($_SESSION["emailId"])?>
                            <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="changepassword.php?csrf_token=<?php echo $token; ?>" class="glyphicons edit no-ajaxify"><i></i>Change Password</a>
                            </li>
                            <li><a href="banklogout.php?lang=en&csrf_token=<?php echo $token; ?>" class="glyphicons lock no-ajaxify"><i></i>Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="navbar-collapse collapse">
                    
                </div>
            </nav>
            <!-- // END navbar -->
            <div class="innerLR">
                
                
                <!-- Form Wizard / Widget Tabs / Double Style -->
                <div class="wizard">
                    <div class="widget widget-tabs widget-tabs-double widget-tabs-responsive">
                        <!-- Widget heading -->
                        <div class="widget-head">
                            <ul>
                                <li class="active"><a href="#tab1-2" class="glyphicons user" data-toggle="tab"><i></i><span class="strong">Step 1</span><span>IBAN Number</span></a>
                                </li>
                                <li><a href="#tab2-2" class="glyphicons calculator"
                                    data-toggle="tab"><i></i><span class="strong">Step 2</span><span>BIC code</span></a>
                                </li>
                                <li><a href="#tab3-2" class="glyphicons credit_card"
                                    data-toggle="tab"><i></i><span class="strong">Step 3</span><span>Amount</span></a>
                                </li>
								<li><a href="#tab4-2" class="glyphicons notes"
                                    data-toggle="tab"><i></i><span class="strong">Step 4</span><span>TAN</span></a>
                                </li>
                                <li><a href="#tab5-2" class="glyphicons circle_ok"
                                    data-toggle="tab"><i></i><span class="strong">Step 5</span><span>Confirmation</span></a>
                                </li>
                            </ul>
                        </div>
                        <!-- // Widget heading END -->
                        <div class="widget-body">
                            <div class="tab-content">
                                <!-- Step 1 -->
                                <div class="tab-pane active" id="tab1-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Payee IBAN Number</strong>
                                            <p class="muted">Please enter the IBAN number of the payee.</p>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="inputTitle">IBAN</label>
                                            <input type="text" id="inputTitle" class="col-md-6 form-control" value="" placeholder="Enter IBAN number ..."
                                            />
                                            <div class="separator"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- // Step 1 END -->
                                <!-- Step 2 -->
                                <div class="tab-pane" id="tab2-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>BIC code</strong>
                                            <p class="muted">Please enter the BIC Code</p>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="inputTitle">BIC Code</label>
                                            <input type="text" id="inputBic" class="col-md-6 form-control" value="" placeholder="Enter BIC Code ..."
                                            />
                                            <div class="separator"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- // Step 2 END -->
                                <!-- Step 3 -->
                                <div class="tab-pane" id="tab3-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Enter the Amount</strong>
                                            <p class="muted">Please enter the Amount</p>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="inputTitle">Amount</label>
                                            <input type="text" id="amount" class="col-md-6 form-control" value="" placeholder="Enter Amount ..."
                                            />
                                            <div class="separator"></div>
                                        </div>
                                    </div>
									<div class="row">
										<div class="col-md-3">
                                            
                                        </div >
										<div class="col-md-9">
											<label for="inputTitle">Description</label>
                                            <input type="text" id="description" class="col-md-6 form-control" value="" placeholder="Enter transaction description"
                                            />
                                            <div class="separator"></div>
										</div>
									</div>
                                </div>
                                <!-- // Step 3 END -->
								<!-- Step 4 -->
                                <div class="tab-pane" id="tab4-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Enter the TAN</strong>
                                            <p class="muted">Please enter the TAN</p>
                                        </div>
                                        <div class="col-md-9">
                                            <label for="inputTitle">TAN</label>
                                            <input type="password" id="tan" class="col-md-6 form-control" value="" placeholder="Enter TAN ..."
                                            />
                                            <div class="separator"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- // Step 4 END -->
                                <!-- Step 5 -->
                                <div class="tab-pane" id="tab5-2">
                                    <h4>Transaction Summary</h4>
                                    <table class="table">
										<tbody>
											<tr>
												<td>IBAN number:<td>
												<td ><label id="confirmiban" class="label label-default"></label><td>
											</tr>
											<tr>
												<td>BIC code:<td>
												<td ><label id="confirmbic" class="label label-default"></label><td>
											</tr>
											<tr>
												<td>Amount:<td>
												<td><label id ="confirmamount" class="label label-default"></label><td>
											</tr>
											
										</tbody>
									</table>
									<input type="hidden" id="email" value="<?=$emailId?>">
                                </div>
                                <!-- // Step 5 END -->
                            </div>
                            <!-- Wizard pagination controls -->
                            <ul class="pagination margin-bottom-none">
                               <!-- <li class="primary previous first"><a href="#" class="no-ajaxify">First</a>
                                </li> -->
                                <li class="primary previous"><a href="#" class="no-ajaxify">Previous</a>
                                </li>
                               <!-- <li class="last primary"><a href="#" class="no-ajaxify">Last</a>
                                </li> -->
                                <li class="next primary"><a href="#" class="no-ajaxify">Next</a>
                                </li>
                                <li class="next finish primary" style="display:none;"><a href="#" class="no-ajaxify">Finish</a>
                                </li>
                            </ul>
                            <!-- // Wizard pagination controls END -->
                        </div>
                    </div>
                </div>
                <!-- // Form Wizard / Widget Tabs / Double Style END -->
                
				 <!-- Widget -->
                <div class="widget widget-heading-simple widget-body-gray">
                    <!-- Widget heading -->
                    <div class="widget-head">
                        <h4 class="heading glyphicons file_import"><i></i>Transaction Batch File Upload</h4>
                    </div>
                    <!-- // Widget heading END -->
                    <div class="widget-body">
                        <!-- Plupload -->
                        <form id="pluploadForm">
                            <div id="pluploadUploader">
                                <p>You browser doesn't have Flash, Silverlight, Gears,
                                    BrowserPlus or HTML5 support.</p>
                            </div>
                        </form>
                        <!-- // Plupload END -->
                    </div>
                </div>
                <!-- // Widget END -->
            </div>
			<!--Modal Body Begin-->
			<div class="widget-body">
				<!-- Form Modal 1 -->
				<a href="#modal-login" data-toggle="modal" class="btn btn-primary" id="modalbutton" style="display:none;"><i class="fa fa-fw fa-user"></i>Button</a>
				<!-- Modal -->
				<div class="modal fade" id="modal-login">
					<div class="modal-dialog">
						<div class="modal-content">
							<!-- Modal heading -->
							<div class="modal-header">
								<button style="display:none;" type="button" class="close" data-dismiss="modal" aria-hidden="true" id="closepasswordmodal">&times;</button>
								<h3 class="modal-title">Re-Enter Password for Transaction Initiation</h3>
							</div>
							<!-- // Modal heading END -->
							<!-- Modal body -->
							<div class="modal-body">
								<div class="innerAll">
									<div class="innerLR">
										<form class="form-horizontal" role="" id="modalForm">
											
											
											<div class="form-group">
												<label for="inputPassword3" class="col-sm-2 control-label">Password</label>
												<div class="col-sm-10">
													<input type="password" class="form-control" id="tranPasswordtext" placeholder="Password">
												</div>
											</div>
											
											<div class="form-group">
												<div class="col-sm-offset-2 col-sm-10">
													<button id="tranpassword" class="btn btn-primary">Submit</button>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
							<!-- // Modal body END -->
						</div>
					</div>
				</div>
				<!-- // Modal END -->
	</div>
	<!-- Modal Body End-->
        </div>
        <!-- // Content END -->
        <div class="clearfix"></div>
        <!-- // Sidebar menu & content wrapper END -->
        <div id="footer" class="hidden-print">
            <!--  Copyright Line -->
            <div class="copy">&copy; 2014 - Bank of München
            </div>
            <!--  End Copyright Line -->
        </div>
        <!-- // Footer END -->
    </div>
    <!-- // Main Container Fluid END -->
	
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
    <script src="../assets/components/modules/admin/invoice/assets/js/invoice.init.js?v=v1.0.3-rc2&sv=v0.0.1.1"></script>
    <script src="../assets/components/core/js/sidebar.main.init.js?v=v1.0.3-rc2"></script>
    <script src="../assets/components/core/js/sidebar.collapse.init.js?v=v1.0.3-rc2"></script>
    <script src="../assets/components/common/forms/elements/bootstrap-select/assets/lib/js/bootstrap-select.js?v=v1.0.3-rc2"></script>
    <script src="../assets/components/common/forms/elements/bootstrap-select/assets/custom/js/bootstrap-select.init.js?v=v1.0.3-rc2"></script>
    <script src="../assets/components/core/js/core.init.js?v=v1.0.3-rc2"></script>
</body>
</html>
