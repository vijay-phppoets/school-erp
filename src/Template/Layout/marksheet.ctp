<!DOCTYPE html>
<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.1
Version: 3.3.0
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
	<!--<![endif]-->
	<!-- BEGIN HEAD -->
	<head>
		<?= $this->Html->charset() ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>
			<?php echo @$title; ?>
		</title>
		<!-- BEGIN GLOBAL MANDATORY STYLES -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
		<?php echo $this->Html->css('/assets/global/plugins/font-awesome/css/font-awesome.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/simple-line-icons/simple-line-icons.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap/css/bootstrap.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/uniform/css/uniform.default.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css'); ?>
		<?php echo $this->Html->css('/assets/global/plugins/bootstrap-toastr/toastr.min.css'); ?>
		<!-- END GLOBAL MANDATORY STYLES -->
		<?= $this->fetch('PAGE_LEVEL_CSS')?>
		<!-- BEGIN THEME STYLES -->
		<?php echo $this->Html->css('/assets/global/css/components.css'); ?>
		<?php echo $this->Html->css('/assets/global/css/plugins.css'); ?>
		<?php echo $this->Html->css('/assets/admin/layout/css/layout.css'); ?>
		<?php echo $this->Html->css('/assets/admin/layout/css/themes/darkblue.css'); ?>
		<?php echo $this->Html->css('/assets/admin/layout/css/custom.css'); ?>
		<!-- END THEME STYLES -->
		<style>
		span.required{
			color:red;
		}
		.rightAligntextClass{
			text-align:right !important;
		}
		.PointBox{
		    width: 65px;
			color: #060694;
			text-align: right;
			font-weight: bold;
		}
		
		#loading{
			background-color: rgba(0, 0, 0, 0.21);
			height: 100%;
			width: 100%;
			position: fixed;
			z-index: 999999;
			margin-top: 0px;
			top: 0px;
			display:none;
		}
		#loading-center{
			width: 100%;
			height: 100%;
			position: relative;
		}
		#loading-center-absolute {
			position: absolute;
			left: 50%;
			top: 50%;
			height: 150px;
			width: 150px;
			margin-top: -75px;
			margin-left: -75px;
		}
		.object{
			width: 20px;
			height: 20px;
			background-color: #F15340;
			float: left;
			margin-right: 20px;
			margin-top: 65px;
			-moz-border-radius: 50% 50% 50% 50% !important;
			-webkit-border-radius: 50% 50% 50% 50% !important;
			border-radius: 50% 50% 50% 50% !important;
		}

		#object_one {	
			-webkit-animation: object_one 1.5s infinite;
			animation: object_one 1.5s infinite;
			}
		#object_two {
			-webkit-animation: object_two 1.5s infinite;
			animation: object_two 1.5s infinite;
			-webkit-animation-delay: 0.25s; 
		    animation-delay: 0.25s;
			}
		#object_three {
		    -webkit-animation: object_three 1.5s infinite;
			animation: object_three 1.5s infinite;
			-webkit-animation-delay: 0.5s;
		    animation-delay: 0.5s;
			
			}
		@-webkit-keyframes object_one {
		75% { -webkit-transform: scale(0); }
		}

		@keyframes object_one {

		  75% { 
		    transform: scale(0);
		    -webkit-transform: scale(0);
		  }

		}
		@-webkit-keyframes object_two {
		  75% { -webkit-transform: scale(0); }
		}

		@keyframes object_two {
		  75% { 
		    transform: scale(0);
		    -webkit-transform:  scale(0);
		  }

		}

		@-webkit-keyframes object_three {
		  75% { -webkit-transform: scale(0); }
		}

		@keyframes object_three {

		  75% { 
		    transform: scale(0);
		    -webkit-transform: scale(0);
		  }
		  
		}
		.page-content-wrapper .page-content {
			    margin-left: 0px !important;
		}
		</style>
		<link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
	</head>
	<!-- END HEAD -->
	<!-- BEGIN BODY -->
	<!-- DOC: Apply "page-header-fixed-mobile" and "page-footer-fixed-mobile" class to body element to force fixed header or footer in mobile devices -->
	<!-- DOC: Apply "page-sidebar-closed" class to the body and "page-sidebar-menu-closed" class to the sidebar menu element to hide the sidebar by default -->
	<!-- DOC: Apply "page-sidebar-hide" class to the body to make the sidebar completely hidden on toggle -->
	<!-- DOC: Apply "page-sidebar-closed-hide-logo" class to the body element to make the logo hidden on sidebar toggle -->
	<!-- DOC: Apply "page-sidebar-hide" class to body element to completely hide the sidebar on sidebar toggle -->
	<!-- DOC: Apply "page-sidebar-fixed" class to have fixed sidebar -->
	<!-- DOC: Apply "page-footer-fixed" class to the body element to have fixed footer -->
	<!-- DOC: Apply "page-sidebar-reversed" class to put the sidebar on the right side -->
	<!-- DOC: Apply "page-full-width" class to the body element to have full width page without the sidebar menu -->
	<body class="page-header-fixed page-quick-sidebar-over-content page-container-bg-solid" style="font-family: 'Nunito Sans', sans-serif;">
		<!-- BEGIN HEADER -->
		<div id="loading">
			<div id="loading-center">
				<div id="loading-center-absolute">
					<div class="object" id="object_one"></div>
					<div class="object" id="object_two"></div>
					<div class="object" id="object_three"></div>
				</div>
			</div>
		</div>
		<div class="page-header navbar navbar-fixed-top" style=" background: -webkit-linear-gradient(#f37a65, #ef586d); "> 
			<!-- BEGIN HEADER INNER -->
			<div class="page-header-inner">
				<!-- BEGIN LOGO -->
				<div class="page-logo">
					<!--<a href="#" style="margin-top: 10px;" role="button" style="text-decoration: none !important;">-->
					<a href="#" style="margin-top: 0px;" role="button" style="text-decoration: none !important;">
						<span style="font-size:20px;color:#FFF;"><b>SCHOOL ERP</b></span>
						<?php //echo $this->Html->image('mds.png', array('alt' => 'CakePHP','width'=>90)); ?>
					</a>
					<div class="menu-toggler sidebar-toggler hide">
						<!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
					</div>
				</div>
				<!-- END LOGO -->
				<!-- BEGIN RESPONSIVE MENU TOGGLER -->
				<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
				</a>
				<!-- END RESPONSIVE MENU TOGGLER -->
				<!-- BEGIN TOP NAVIGATION MENU -->
				<div class="top-menu">
					<ul class="nav navbar-nav pull-right">
						<!-- BEGIN USER LOGIN DROPDOWN -->
						<!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
						
						<!-- END USER LOGIN DROPDOWN -->
					</ul>
				</div>
				<!-- END TOP NAVIGATION MENU -->
			</div>
			<!-- END HEADER INNER -->
		</div>
		<!-- END HEADER -->
		<div class="clearfix">
		</div>
		<!-- BEGIN CONTAINER -->
		<div class="page-container" style="margin-left: 0px !important;">
			<div class="page-content-wrapper">
				<div class="page-content" >
					<!-- BEGIN PAGE CONTENT-->
					<div class="row">
						<div class="col-md-12">
							<div id="toast-container" class="toast-top-right" aria-live="polite" role="alert">
								<?= $this->Flash->render() ?>
							</div>
							<?= $this->fetch('content') ?>
						</div>
					</div>
					<!-- END PAGE CONTENT-->
				</div>
			</div>
			<!-- END CONTENT -->
		</div>
		<!-- END CONTAINER -->
		<!-- BEGIN FOOTER -->
		<div class="page-footer">
			<div class="page-footer-inner">
				 2018 &copy; PHP Poets IT Solutions Pvt. Ltd.
			</div>
			<div class="scroll-to-top">
				<i class="icon-arrow-up"></i>
			</div>
		</div>
		<!-- END FOOTER -->
		<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) -->
		<!-- BEGIN CORE PLUGINS -->
		<!--[if lt IE 9]>
		<script src="../../assets/global/plugins/respond.min.js"></script>
		<script src="../../assets/global/plugins/excanvas.min.js"></script> 
		<![endif]-->
		<?php echo $this->Html->script('/assets/global/plugins/jquery.min.js'); ?>
		<?php echo $this->Html->script('/assets/global/plugins/jquery-migrate.min.js'); ?>
		<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip -->
		<?php echo $this->Html->script('/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js'); ?>
		<?php echo $this->Html->script('/assets/global/plugins/bootstrap/js/bootstrap.min.js'); ?>
		<?php echo $this->Html->script('/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js'); ?>
		<?php echo $this->Html->script('/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js'); ?>
		<?php echo $this->Html->script('/assets/global/plugins/jquery.blockui.min.js'); ?>
		<?php echo $this->Html->script('/assets/global/plugins/jquery.cokie.min.js'); ?>
		<?php echo $this->Html->script('/assets/global/plugins/uniform/jquery.uniform.min.js'); ?>
		<?php echo $this->Html->script('/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js'); ?>
		<?php echo $this->Html->script('/assets/global/plugins/bootstrap-toastr/toastr.min.js'); ?>
		<!-- END CORE PLUGINS -->
		<?= $this->fetch('PAGE_LEVEL_PLUGINS_JS')?>

		<?php echo $this->Html->script('/assets/global/scripts/metronic.js'); ?>
		<?php echo $this->Html->script('/assets/admin/layout/scripts/layout.js'); ?>

		<!-- BEGIN PAGE LEVEL SCRIPTS -->
		<?= $this->fetch('PAGE_LEVEL_SCRIPTS_JS')?>
		<!-- END PAGE LEVEL SCRIPTS -->
		<script>
		jQuery(document).ready(function() {  
			Metronic.init(); // init metronic core components
			Layout.init(); // init current layout
		});
		$(document).ready(function() {
			$('a[role=button]').live('click',function(e) {
				e.preventDefault();
			});
			
			$('.PointBox').live('click',function(e) {
				$(this).select();
			});
		});
		
		
		function round(value, exp) {
		  if (typeof exp === 'undefined' || +exp === 0)
			return Math.round(value);

		  value = +value;
		  exp = +exp;

		  if (isNaN(value) || !(typeof exp === 'number' && exp % 1 === 0))
			return NaN;

		  // Shift
		  value = value.toString().split('e');
		  value = Math.round(+(value[0] + 'e' + (value[1] ? (+value[1] + exp) : exp)));

		  // Shift back
		  value = value.toString().split('e');
		  return +(value[0] + 'e' + (value[1] ? (+value[1] - exp) : -exp));
		}
		
		</script>
		<?= $this->fetch('scriptBottom')?>
		<!-- END JAVASCRIPTS -->
	</body>
	<!-- END BODY -->
</html>