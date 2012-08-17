<script type="text/javascript" language="javascript">

function btnSend_oncpck(){

	function validateEmail(txtEmail){
	   var a = document.getElementById(txtEmail).value;
	   var filter = /^((\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*?)\s*;?\s*)+/;
		if(filter.test(a)){
			return true;
		}
		else{
			return false;
		}
	}
	
	if(test_empty(document.frmContact.txtName.value)){

		alert(mustInput_Name);document.frmContact.txtName.focus();return false;

	}

	if(test_empty(document.frmContact.txtEmail.value)){

		alert(mustInput_Email);document.frmContact.txtEmail.focus();return false;

	}

	if(!checkEmail(document.frmContact.txtEmail.value)){

		alert(invalid_Email);document.frmContact.txtEmail.focus();return false;

	}

	if(test_empty(document.frmContact.txtTel.value)){

		alert(mustInput_Tel);document.frmContact.txtTel.focus();return false;

	}

	if(test_empty(document.frmContact.txtDetail.value)){

		alert(mustInput_Detail);document.frmContact.txtDetail.focus();return false;

	}
	return true;
}

</script>
<? $errMsg =''?>

<?
if($_lang=="vn"){
	$l_sao 	= "Để chúng tôi có thể hỗ trợ quý khách một cách tốt nhất, xin vui lòng điền các thông tin vào form dưới đây :";
	$l_hoten 	= "Họ và tên";
	$l_diachi 	= "Địa chỉ";
	$l_email 	= "Hộp thư";
	$l_dt 	= "Điện thoại";
	$l_noidung 	= "Nội dung";
	$l_nutgoi 	= "Gửi tin";
	$l_nutxoa 	= "Nhập lại";
}else if($_lang=="en"){
	$l_sao 	= "Request info";
	$l_hoten 	= "Full name";
	$l_diachi 	= "Address";
	$l_email 	= "Email";
	$l_dt 	= "Tel";
	$l_noidung 	= "Detail";
	$l_nutgoi 	= "Send";
	$l_nutxoa 	= "Reset";
}else{
	$l_sao 	= "請求信息";
	$l_hoten 	= "全名";
	$l_diachi 	= "地址";
	$l_email 	= "電子郵件";
	$l_dt 	= "電話";
	$l_noidung 	= "詳細";
	$l_nutgoi 	= "發送";
	$l_nutxoa 	= "復位";
}

if (isset($_POST['btnSend'])){
	
	$name      = trim($_REQUEST['txtName']);
	$address   = trim($_REQUEST['txtAddress']);
	$email     = trim($_REQUEST['txtEmail']);
	$tel       = trim($_REQUEST['txtTel']);
	$detail    = trim($_REQUEST['txtDetail']);
	$date		= date("Y-m-d");
	$sql="insert into xteam_contact (co_name,co_addr,co_email,co_fone,co_content,co_date,co_status) values('$name','$address','$email','$tel','$detail','$date',0)";
	$run=mysql_query($sql);
	if ($run){
		$errMsg = $_lang == 'vn' ? "Thông tin của bạn đã được gửi cho chúng tôi." : "Sent to us successfully.";
		echo "<script>alert('".$errMsg."');</script>";
		echo "<script>window.location='trang-chu.html'</script>";
	}else{
		$errMsg = $_lang == 'vn' ? "Không thể gửi thông tin !<br>Hãy liên hệ với quản trị để được hướng dẫn." : "Can not send contact infomation !<br>Please contact to administrator to be guided.";
	}
}
if($_lang=="vn"){
	$code 	= "vn_contact";
}else if($_lang=="en"){
	$code = "en_contact";
}else{
	$code = "cn_contact";
}

$contact = getRecord("xteam_content","parent = (select id from xteam_content_category where code='".$code."')");?>
<div class="no-title-box-text">
    <h4><strong>CKVIC DESIGN</strong></h4>
    <? include "modules/contactInfoDetailShort.php";?>
</div>
<div id="contact_form">
    <form method="post" name="frmContact" action="<?=$curHost?>lien-he.html"  enctype="multipart/form-data">
        <span for="author"><?=$l_hoten?> (<font color="#FF0000">*</font>):</span> <input value="<?=$name?>" type="text" id="author" name="txtName" class="required input_field" />
        <span class="cleaner h10"></span>
        <span for="email"><?=$l_email?> (<font color="#FF0000">*</font>):</span> <input value="<?=$email?>" type="text" id="email" name="txtEmail" class="validate-email required input_field" />
        <span class="cleaner h10"></span>
        <input type="hidden" name="frame" value="contact" />
        <span for="subject"><?=$l_diachi?>:</span> <input  value="<?=$address?>"type="text" name="txtAddress" id="subject" class="input_field" />
        <span class="cleaner h10"></span>
        <span for="subject"><?=$l_dt?>:</span> <input  value="<?=$tel?>"type="text" name="txtTel" id="subject" class="input_field" />
        <span class="cleaner h10"></span>
        <span for="text"><?=$l_noidung?> (<font color="#FF0000">*</font>):</span> <textarea id="text" name="txtDetail" rows="0" cols="0" class="required"></textarea>
        <span class="cleaner h10"></span>
        <input type="submit" value="<?=$l_nutgoi?>" id="submit" name="btnSend" class="submit_btn float_l" onclick="return btnSend_oncpck()" />
        <input type="reset" value="<?=$l_nutxoa?>" id="reset" name="btnReset" class="submit_btn float_r" />
    </form>
<div class="cleared"></div>
<!--end -->
</div>