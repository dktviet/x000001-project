
<script type="text/javascript" language="javascript">
function btnLogin_onclick(){
	if(test_empty(document.frmLogin.txtUid.value)){
		alert("Hãy nhập tên truy cập");document.frmLogin.txtUid.focus();return false;
	}
	if(test_empty(document.frmLogin.txtPwd.value)){
		alert("Hãy nhập mật khẩu");document.frmLogin.txtPwd.focus();return false;
	}
	return true;
}
</script>
<? if($_SESSION['member'] == ''){?>
<form name="frmLogin" method="post" action="./">
    <input type="hidden" name="frame" value="login">
    <input type="hidden" name="btnLogin" value="Đăng nhập">   
    <span style="text-align:center;color:#9e6d32;margin-left:25px; *font-size:1.3em;">Tài khoản</span><br/>
    <input type="text" name="txtUid" onBlur="if (this.value=='') this.value='Username..';" onFocus="if (this.value=='Username..') this.value='';" style="float:left;text-align:left;margin-left:25px;border:1px solid #7d7d7d;" value="Username.." />
    <br/><br/>
    <span style="text-align:center;color:#9e6d32;margin-left:25px; *font-size:1.3em;">Mật khẩu</span><br/>
    <input type="password" name="txtPwd" onBlur="if (this.value=='') this.value='password';" onFocus="if (this.value=='password') this.value='';"  style="float:left;text-align:left;margin-left:25px;border:1px solid #7d7d7d;" value="password"   size="20" />
    <br/><br/>
    
    <input type="submit" src="images/login.gif" width="81" height="20" border="0" onclick="return btnLogin_onclick()" value="Đăng nhập" style="border:1px solid #7d7d7d;color:#9e6d32;margin-left:25px;cursor:pointer;" />
</form>
<?                   
} else {
	echo "<center> <a href='./?frame=logout' style='margin-left: -10px;'>"; ?>
	<?=$_lang=="vn" ? "Đăng xuất" : "Logout"?>
<? echo "</a> </center>";}?>

