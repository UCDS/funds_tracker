<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Funds Tracker</title>
    <script src="<?php echo base_url(); ?>css_js/js_frameworks/jquery-3.1.0.min.js"></script>
    <script src="<?php echo base_url(); ?>css_js/js_frameworks/angular.js"></script>
    <script src="<?php echo base_url(); ?>css_js/js_frameworks/lodash.min.js"></script>
    <script src="<?php echo base_url(); ?>css_js/js_frameworks/angular-route.min.js"></script>
    <script src="<?php echo base_url(); ?>css_js/js_custom/funds_tracker.js"></script>
    
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>css_js/css_frameworks/css/bootstrap.min.css" rel="stylesheet">  
    <link href="<?php echo base_url(); ?>css_js/css_frameworks/fa-4.7.0/css/font-awesome.min.css" rel="stylesheet">  
	
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>css_js/css_custom/dashboard.css" rel="stylesheet">
	<style>
		.PageLoadImg{
			position: fixed;
			background-color: black;
			opacity: 0.5;
			top:0;
			height: 100%;
			width: 100%;
			z-index: 9999;
		}
		.LoadingImg{
			width : 100%;
			top : 45%;
			position: fixed;
			opacity: 1;
			z-index: 9999;
		}
		.LoadingImg>div{
			margin:0 auto; width: 100px;
		}
		.BusyLoopHide{
			display: none;
		}
		.BusyLoopShow{
			display: initial;
		}
		table thead{
			font-size: 11px;
		}
	</style>
  </head>

  <body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?php echo base_url(); ?>">Funds Tracker</a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<!--<li><a href="#">Dashboard</a></li>
					<li><a href="#">Settings</a></li>
					<li><a href="#">Profile</a></li>-->
					<li><a href="#">Help</a></li>
					<?php
						if($this->session->logged_in == 'YES'){
					?>
						<li id="LefNaveLogOut" class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Profile
							<span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li id="LefNaveLogOut"><a href="<?php echo base_url(); ?>profile/changepassword">Change Password</a></li>
								<li><a href="<?php echo base_url(); ?>welcome/logout">Logout</a></li>
							</ul>
						</li>
					<?php
						}else{
					?>
					<li id="LefNaveLogIn"><a href="<?php echo base_url(); ?>">Login</a></li>
					<?php
						}
					?>
				</ul>
				<form class="navbar-form navbar-right">
					<!--<input type="text" class="form-control" placeholder="Search...">-->
				</form>
			</div>
		</div>
	</nav>
	<div class="BusyLoopMain PageLoadImg BusyLoopHide">

	</div>
	<div class="BusyLoopMain LoadingImg BusyLoopHide">
		<div>
		  <img width="100px" height="100px" src="<?php echo base_url(); ?>assets/img/loader.gif" />
		</div>
	</div>
	<div class="container-fluid">
		<div class="row">