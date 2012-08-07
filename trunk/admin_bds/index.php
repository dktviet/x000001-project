<?
	require 'first_run.php';
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Control Panel</title>
<script type="text/javascript" language="javascript" src="../lib/javascript.lib-min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-1.7.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery-ui-1.8.18.min.js"></script>
<script type="text/javascript" language="javascript" src="../lib/md5.js"></script>
<script type="text/javascript" language="javascript" src="js/script.js"></script>
<script type="text/javascript" language="javascript" src="js/top_panel/top_panel.js"></script>
<link href="css/cssAdmin.css" rel="stylesheet" type="text/css">
<link href="css/smoothness/jquery-ui-1.8.18.custom.css" rel="stylesheet" type="text/css">
<link href="css/black.css" rel="stylesheet" type="text/css">
<link href="css/blue.css" rel="stylesheet" type="text/css">
<link href="css/orange.css" rel="stylesheet" type="text/css">
<link href="css/pink.css" rel="stylesheet" type="text/css">
<link href="css/purple.css" rel="stylesheet" type="text/css">
<link href="css/red.css" rel="stylesheet" type="text/css">
<link href="css/teal.css" rel="stylesheet" type="text/css">
<link href="css/white.css" rel="stylesheet" type="text/css">
<link href="css/yellow.css" rel="stylesheet" type="text/css">
<!--[if IE 7]>

<link href="templates/jbsimpla/css/ie7.css" rel="stylesheet" type="text/css" />

<![endif]-->
<!--[if lte IE 6]>

<script type="text/javascript" src="templates/jbsimpla/js/supersleight-min.js"></script>

<link href="templates/jbsimpla/css/ie6.css" rel="stylesheet" type="text/css" />

<![endif]-->
</head>
<body id="body_main">
<div id="header-box">
	
	<div id="logoText">HAYTUYET.NET</div>

	<div class="clear"></div>

	<div id="module-menu" class="autohide">

		<? include "panel_left.php";?>
	</div>

	<div class="clr"></div>

</div>

<div id="content-wrap">
	<!-- begin header-->
	<div id="module-status"></div>
	<div id="admin-theme" class="ad-bg"></div>
	<div id="border-top"></div>
	<!-- end header -->
    <!-- begin body -->
    <div id="content-box">

		<div id="toolbar-box">

			<div class="m">

				<h3><? include("processtitle.php")?></h3>

				<? include("processframe.php")?>

    		</div>
        </div>
		<? include("panel_bottom.php")?>
    </div>
</div>
    <!-- end body -->




<div state="mouseleave" style="position: absolute; top: 70px; left: 386px; visibility: hidden;" class="tool-tip"><div><div class="tool-text"><span>Copyright 2011 @ Powered by <b>Nguyễn Tuấn Dũng</b></span></div></div></div>
<!--end body-->



</body>
</html>
<? require("../common_end.php") ?>