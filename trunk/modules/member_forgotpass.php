<script type="text/javascript" language="javascript">
function btnSend_onclick(){
	/*if(test_empty(document.frmForgotpass.txtUid.value)){
		alert(mustInput_Uid);document.frmForgotpass.txtUid.focus();return false;
	}*/
	if(test_empty(document.frmForgotpass.txtEmail.value)){
		alert(mustInput_Email);document.frmForgotpass.txtEmail.focus();return false;
	}
	if(!checkEmail(document.frmForgotpass.txtEmail.value)){
		alert(invalid_Email);document.frmForgotpass.txtEmail.focus();return false;
	}
	return true;
}
</script>
<? $errMsg =''?>
<?
$l_Uid          = $_lang == 'vn' ? 'Tên đăng nhập' : 'Username';
$l_Email        = $_lang == 'vn' ? 'Hộp thư' : 'Email';
$l_btnSend      = $_lang == 'vn' ? 'Gửi thông tin' : 'Send';

$l_SendSuccess  = $_lang == 'vn' ? 'Đã gởi thông tin thành công.' : 'Sent infomation Successfully.';

$flagForgotpass = false;
if (isset($_POST['btnSend'])){
	//$uid   = isset($_POST['txtUid']) ? trim($_POST['txtUid']) : "";
	$email = isset($_POST['txtEmail']) ? trim($_POST['txtEmail']) : "";
	
	$result = mysql_query("select * from xteam_member where email='".$email."'",$conn);
	$rows = mysql_num_rows($result);
	if($rows<1){
		$errMsg = $_lang == 'vn'?'Sai "Hộp thư" !':'Email wrong !';
	}else{
		$row = mysql_fetch_array($result);
		if($email != $row['email']){
			$errMsg = $_lang == 'vn'?'Sai "Hộp thư" !':'Email wrong !';
		}else{
			$flagForgotpass = true;
		}
	}
	
	if($flagForgotpass){
		if (send_mail($adminEmail,$email,"Thong tin dang nhap","Username : ".$row['uid']."<br>Password : ".$row['pwd'])){	
			echo "<script>window.location='./?frame=forgotpass&code=1'</script>";
		}else{
			$errMsg = $_lang == 'vn'? 'Không thể gởi thông tin !' : 'Can not send !';
		}
	}
}

if ($_REQUEST['code']=='1'){
?>

<table align="center" style="border: hidden;" width="98%" cellpadding="0" cellspacing="0">
	<tr>
		<td>

<table align="center" style="border: hidden;" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td align="center">
			<br><br><br>
			<font color="#0000FF" size="2" face="Verdana, Arial, Helvetica, sans-serif">
			<b><?=$l_SendSuccess?></b>
			</font>
			<br><br><br>
		</td>
	</tr>
</table>

		</td>
	</tr>
</table>

<?
}else{
?>

<table align="center" style="border: hidden;" width="98%" cellpadding="0" cellspacing="0">
	<tr>
		<td>

<table align="center" style="border: hidden;" width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<table align="center" style="border: hidden;" width="98%" cellpadding="0" cellspacing="0">
				<tr>
					<td valign="top">
						<form method="POST" name="frmForgotpass" action="./">
						<input type="hidden" name="frame" value="forgotpass">
						<table>
							<tr>
								<td colspan="2" style="padding:5px;">
								<p align="justify">
								<?
								echo $_lang == 'vn' ? 'Hãy điều đầy đủ thông tin và gởi về cho chúng tôi, bạn sẽ nhận lại mật khẩu theo địa chỉ hộp thư.' : 'Please send your infomation, we\'ll send your password to your e-mail address !'?>
								</p>
								</td>
							</tr>
							<!--<tr>
								<td align="right" width="40%"><=$l_Uid?>&nbsp;</td>
								<td width="5"><font color="#FF0000">*</font></td>
								<td>&nbsp;<input name="txtUid" value="<=$uid?>"></td>
							</tr>-->
							<tr>
								<td align="right" style="padding:5px;"><?=$l_Email?>&nbsp;<font color="#FF0000">*</font></td>
								<td>&nbsp;<input name="txtEmail" value="<?=$email?>" size="30"></td>
							</tr>
							<tr>
							  <td colspan="2" style="padding:5px;">
                              	<center>
								<input type="submit" class="buttonorange" onmouseover="this.className='buttonblue'" style="WIDTH: 89px; HEIGHT: 22px" onmouseout="this.className='buttonorange'" name="btnSend" value="<?=$l_btnSend?>" onclick="return btnSend_onclick()">
                        		</center>
							</td>
							</tr>
						</table>
						</form>
					</td>
				</tr>
			</table>
	
		</td>
	</tr>
</table>

		</td>
	</tr>
</table>

<? }?>
<? if($errMsg!=''){echo '<p align=center class="err">'.$errMsg.'<br></p>';}?> 

