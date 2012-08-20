<? 
require('config.php');
require('common_start.php');
require('lib/func.lib.php');
$errMsg='';

if (isset($_POST['btnLogin'])){
	$uid = $_POST['txtUid'];
	$pwd = $_POST['txtPwd'];
	$get_controller = countRecord(tbl_config::tbl_controller,"uid='".$uid."' and pwd='".$pwd."'");
	if ($get_controller > 0) {
		$log = $uid;
		session_register("log");
			$_SESSION['log'] = $uid;
		echo "<script>window.location='./'</script>";
	}else{
		$errMsg="Tên đăng nhập / mật khẩu không đúng !";
	}
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="vi-vn" dir="ltr" lang="vi-vn">
<head>

  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <meta name="robots" content="index, follow" />
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="generator" content="" />
  <title>ĐĂNG NHẬP HỆ THỐNG</title>


<link href="css/cssAdmin.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]>

<link href="css/ie7.css" rel="stylesheet" type="text/css" />

<![endif]-->



<!--[if lte IE 6]>

<link href="css/ie6.css" rel="stylesheet" type="text/css" />

<![endif]-->
<script type="text/javascript" language="javascript" src="js/jquery-1.7.min.js"></script>
<script type="text/javascript" language="javascript" src="lib/md5.js"></script>
<script type="text/javascript" language="javascript" src="lib/javascript.lib.js"></script>
<script type="text/javascript" language="javascript" src="lib/varAlert.vn.unicode.js"></script>
<script type="text/javascript" language="javascript" src="js/login.js"></script>
</head>

<body onload="javascript:setFocus()" id="login" class="black">

		<div id="login-wrapper">

			<div id="login-top">

				<div id="logo">	

				</div>

					<h3>ĐĂNG NHẬP HỆ THỐNG</h3>

			</div>

			<div id="login-content">

	<form method="post" name="frmLogin" id="form-login" style="clear: both;">
        <p id="form-login-username">
            <label for="modlgn_username">Tên đăng nhập</label>
            <input name="txtUid" id="modlgn_username" class="inputbox" size="15" type="text" />
        </p>
    
        <p id="form-login-password">
            <label for="modlgn_passwd">Mật mã</label>
            <input name="txtPwd" id="modlgn_passwd" class="inputbox" size="15" type="password" />
        </p>
        
        
        <div class="clear"></div>
        <p>
            <input type="submit" name="btnLogin" id="btnLogin" value="&#272;&#259;ng nh&#7853;p" style="border: 0pt none; padding: 0pt; margin: 0pt; width: 100px;" />
        </p>
       
    </form>

					<div class="notification information"><div>Dùng một tên đăng nhập và Mật mã hợp lý để đăng nhập vào khu vực quản trị.</div></div>

					<p class="home-page">

						<a href="../">Trở về trang chủ</a>

					</p>

					<div class="clear"></div>

				</div>

			</div>

			<noscript>

				!Cảnh báo! Javascript phải được bật để chạy được các chức năng trong phần Quản trị
			</noscript>

			<div class="clr"></div>

<div style="position: absolute; top: 0pt; left: 0pt; visibility: hidden;" class="tool-tip"><div></div></div>


	
<? if($errMsg!=''){echo '<p align=center class="err">'.$errMsg.'<br>&nbsp;</p>';}?>
</body>
</html>
<? require("common_end.php") ?>