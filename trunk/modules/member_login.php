<div style="padding:10px; text-align:justify; border:1px solid #d4d4d4; width:95%; margin:10px auto;">
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
<? $errMsg =''?>
<?
$l_notmember ='Không là thành viên';
$l_member    ='Thành viên';

$l_Uid       ='Tên đăng nhập';
$l_Pwd       ='Mật khẩu';
$l_ForgotPwd ='Quên Mật khẩu';

$l_btnRegistry ='Đăng ký';
$l_btnLogin    ='Đăng nhập';
$l_btnLogout   ='Đăng xuất';

$l_Welcome      ='Welcome';
$l_LoginSuccess ='Đăng nhập thành công.';

if ($pages=='logout'){
	unset($_SESSION['member']);
	echo "<script>window.location='dang-nhap.html'</script>";
}
if(!isset($_SESSION['member']) || $_SESSION['member']==''){
	$flagLogin = false;
}else{
	$flagLogin = true;
}

if($_REQUEST['boxUid']!=''){
	$uid = $_REQUEST['boxUid'];
	$pwd = $_REQUEST['boxPwd'];
	
	if(!isset($_SESSION['member']) || $_SESSION['member']==''){
		$result = mysql_query("select * from bnk_member where uid='".$uid."'",$conn);
		$rows = mysql_num_rows($result);
		if($rows<1){
			$errMsg = $_lang == 'vn'?'Sai "tên đăng nhập" !':'Username wrong !';
		}else{
			$row = mysql_fetch_array($result);
			if($pwd != $row['pwd']){
				$errMsg = $_lang == 'vn'?'Sai "mật khẩu" !':'Password wrong !';
			}else{
				$flagLogin = true;
			}
		}
	}
}

if (isset($_POST['btnLogin'])){
	$uid = isset($_POST['txtUid']) ? trim($_POST['txtUid']) : "";
	$pwd = isset($_POST['txtPwd']) ? trim($_POST['txtPwd']) : "";
	
	if(!isset($_SESSION['member']) || $_SESSION['member']==''){
		$result = mysql_query("select * from bnk_member where uid='".$uid."'",$conn);
		$rows = mysql_num_rows($result);
		if($rows<1){
			$errMsg = '<?=$_lang=="vn" ? "Tên truy cập sai" : "Username wrong"?>';
		}else{
			$row = mysql_fetch_array($result);
			if($pwd != $row['pwd']){
			$errMsg = $_lang == 'vn'?'Sai "tên đăng nhập" !':'Username wrong !';
			}else{
				$flagLogin = true;
			}
		}
	}
}

if($flagLogin){
	$_SESSION['member'] = isset($_SESSION['member'])?$_SESSION['member']:$uid;
?>

<table align="center" border="0" width="100%" cellpadding="0" cellspacing="0" >
	<tr>
		<td>
			<table style="border:1px solid #d4d4d4; background:#F2F2F2;" align="center" width="100%" cellpadding="15" cellspacing="0">
				<tr>
					<td><center>
						<br><font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
						<?=$l_Welcome.' <b class="fontRed">'.$_SESSION['member'].'</b>'?></font>
						<br><br>
						<font color="#0000FF" size="2" face="Verdana, Arial, Helvetica, sans-serif">
							<b><?=$l_LoginSuccess?></b>
						</font>
						<br><br>
						[ <a class="aMagenta" href="dang-xuat.html"><?=$_lang=="vn" ? "Đăng xuất" : "Logout"?></a> ]&nbsp;[ <a href="gio-hang.html">Xem giỏ hàng</a> ]
						<br /><br /><br /></center>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="5"></td></tr>
</table>

<?
}else{
?>
<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td height="22">
			<span style="FONT-WEIGHT: 700; FONT-SIZE: 8.5pt">&nbsp;&nbsp;<?=$_lang=="vn" ? "Không là thành viên" : "Not member"?></span>
		</td>
	</tr>
	
	<tr>
		<td align="center">
			<table  style="border:1px solid #d4d4d4; background:#F2F2F2;" border="0" width="100%" cellpadding="15" cellspacing="0">
				<tr>
					<td>
				<p align="justify">
				<?=$_lang == 'vn' ? 'Nếu đây là lần đầu tiên bạn sử dụng website này, xin hãy đăng ký làm thành viên trước khi thực hiện các thao tác khác. Một khi là thành viên, bạn có thể truy cập đầy đủ chức năng và dịch vụ của website.' : 'If you ever hadn\'t visited our website yet. Please registry to become member of us. Then you\'ll have full control on this !'?>
				</p>
					</td>
				</tr>
				<tr>
					<td align="center">
                    	<center>
						<input class="buttonorange" onmouseover="this.className='buttonblue'"  onmouseout="this.className='buttonorange'" type="button" value="<?=$_lang=="vn" ? "Đăng ký" : "Registry"?>" name="btnRegistry" onclick="window.location='dang-ky.html'" />
                        </center>
					</td>
				</tr>
			</table>
		</td>
	</tr>
    <tr><td height="22">&nbsp;</td></tr>
	<tr>
		<td height="25" valign="middle">
			<span style="FONT-WEIGHT: 700; FONT-SIZE: 8.5pt">&nbsp;&nbsp;<?=$_lang=="vn" ? "Thành viên" : "Member"?></span>
		</td>
	</tr>
	<tr>
		<td>
			<table style="border:1px solid #d4d4d4; background:#F2F2F2;" width="100%" cellpadding="15" cellspacing="0" >
				<tr>
					<td valign="top">
					<form name="frmLogin" method="POST" action="dang-nhap.html">
						
						<table  width="100%" cellpadding="0" cellspacing="0">
							<tr><td colspan="3" height="10"></td></tr>
							<tr>
								<td align="right" width="40%"><?=$_lang=="vn" ? "Tên truy cập" : "User name"?></td>
								<td width="5"></td>
								<td><input type="text" name="txtUid" class="art-button" /></td>
							</tr>
                            <tr>
								<td align="right">&nbsp;</td>
								<td width="5"></td>
								<td></td>
							</tr>
							<tr>
								<td align="right"><?=$_lang=="vn" ? "Mật khẩu" : "Password"?></td>
								<td width="5"></td>
								<td><input type="password" name="txtPwd"  class="art-button" /></td>
							</tr>
							<tr><td colspan="3" height="10"></td></tr>
							<tr>
								<td align="right"><a href="quen-mat-khau.html" class="style13"><?=$_lang=="vn" ? "Quên mật khẩu ?" : "Forgot pass ?"?></a></td>
								<td width="5"></td>
								<td><input  onmouseover="this.className='buttonblue'"  onmouseout="this.className='buttonorange'" type="submit" value="<?=$_lang=="vn" ? "Đăng nhập" : "Login"?>" name="btnLogin" onclick="return btnLogin_onclick()" /></td>
							</tr>
							<tr>
							  <td align="right">&nbsp;</td>
							  <td></td>
							  <td>&nbsp;</td>
						  </tr>
						</table>
					</form>
					</td>
				</tr>
			</table>
	
		</td>
	</tr>
</table>
<? }?>

<? if($errMsg!=''){echo '<p align=center class="err">'.$errMsg.'<br></p>';}?>

  </div>