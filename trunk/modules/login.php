<script type="text/javascript" language="javascript">
function btnLogin_onclick(){
	if(test_empty(document.frmLogin.txtUid.value)){
		alert(mustInput_Uid);document.frmLogin.txtUid.focus();return false;
	}
	if(test_empty(document.frmLogin.txtPwd.value)){
		alert(mustInput_Pwd);document.frmLogin.txtPwd.focus();return false;
	}
	return true;
}
</script>
<? $errMsg ='';
?>
<?
if (isset($_POST['btnLogin'])){
	$uid = isset($_POST['txtUid']) ? trim($_POST['txtUid']) : "";
	$pwd = isset($_POST['txtPwd']) ? trim($_POST['txtPwd']) : "";
	
	if(!isset($_SESSION['member']) || $_SESSION['member']==''){
		$result = mysql_query("select * from bnk_member where uid='".$uid."'",$conn);
		$rows = mysql_num_rows($result);
		if($rows<1){
			$errMsg = 'Username wrong !';
		}else{
			$row = mysql_fetch_array($result);
			if($pwd != $row['pwd']){
				$errMsg ='Password wrong !';
			}else{
				$flagLogin = true;
			}
		}
	}
}
if($flagLogin){
	$_SESSION['member'] = isset($_SESSION['member'])?$_SESSION['member']:$uid;
	}
?>
<form name="frmLogin" method="POST" action="./">
<input type="hidden" name="frame" value="login">
<input type="hidden" name="btnLogin">
<p>
<input name="txtUid" class="select" onfocus="this.value=''" value="<?=$_lang=="vn" ? "Tên truy cập" : "User name"?>" style="padding-left:5px;" />
</p>
<p>
<input name="txtPwd" type="password" class="select" style="padding-left:5px;" 
onfocus="this.value=''" value="<?=$_lang=="vn" ? "Mật khẩu" : "Password"?>" />
</p>
<p>
<input name="btnLogin" type="submit" class="button1" value="<?=$_lang=="vn" ? "Đăng nhập" : "Login"?>" onClick="return btnLogin_onclick()" />
<input name="btnRegistry" type="button" class="button2" value="<?=$_lang=="vn" ? "Đăng ký" : "Registry"?>" onClick="window.location='dang-ky.html'" />
</p>
<input type="checkbox" name="checkbox" value="checkbox" />
<a href="quen-mat-khau.html"class="style3"><?=$_lang=="vn" ? "Quên mật khẩu ?" : "Forgot pass ?"?></a>
</form>
