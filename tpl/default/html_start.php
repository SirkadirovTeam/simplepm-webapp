<?php
	DEFINED("SPM_GENUINE") OR DIE('403 ACCESS DENIED');
	
	global $_SPM_CONF;
?>
<html>
	<head>
		<title><?php print($_TPL_PAGESUBNAME . " - " . $_SPM_CONF["BASE"]["SITE_NAME"]); ?></title>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="<?php print(_S_TPL_); ?>bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<link rel="stylesheet" href="<?php print(_S_TPL_); ?>dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="<?php print(_S_TPL_); ?>dist/css/skins/skin-blue.min.css">
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		<style>
			 .layout-boxed{
				 background: url('<?php print(_S_TPL_); ?>dist/img/bg.jpg');
				 background-repeat: no-repeat;
				 background-attachment: fixed;
				 background-size: 100% 100%;
			 }
		</style>
		<script src="<?php print(_S_TPL_); ?>js/push.min.js"></script>
	</head>
	<body class="hold-transition skin-blue sidebar-mini layout-boxed">
		<div class="wrapper">