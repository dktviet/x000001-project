<?
$l_name       = $_lang == 'vn' ? 'Họ và tên' : 'Full name';
$l_position   = $_lang == 'vn' ? 'Chức vụ' : 'Position';
$l_company    = $_lang == 'vn' ? 'Công ty' : 'Company name';
$l_address    = $_lang == 'vn' ? 'Địa chỉ' : 'Address';
$l_city       = $_lang == 'vn' ? 'Thành phố' : 'City';
$l_country    = $_lang == 'vn' ? 'Quốc gia' : 'Country';
$l_email      = $_lang == 'vn' ? 'Hộp thư' : 'Email';
$l_website    = $_lang == 'vn' ? 'Trang web' : 'Website';
$l_tel        = $_lang == 'vn' ? 'Điện thoại' : 'Telephone';
$l_fax        = $_lang == 'vn' ? 'Fax' : 'Fax';
$l_mobile     = $_lang == 'vn' ? 'ĐTDĐ' : 'Mobil';

$l_image    = $_lang == 'vn' ? 'Hình' : 'Image';
$l_product    = $_lang == 'vn' ? 'Sản phẩm' : 'Product';
$l_quantity   = $_lang == 'vn' ? 'Số lượng' : 'Quantity';
$l_price      = $_lang == 'vn' ? 'Đơn giá' : 'Unit price';
$l_money      = $_lang == 'vn' ? 'Thành tiền' : 'Cost';
$l_total      = $_lang == 'vn' ? 'Tổng cộng' : 'Total';
$l_btnSend    = $_lang == 'vn' ? 'Gửi thông tin' : 'Send order';

$l_sendSuccess = $_lang == 'vn' ? 'Thông tin đặt hàng của bạn đã được gởi đến chúng tôi.' : 'Your infomational cart sent successfully.';
$l_btnBackHome = $_lang == 'vn' ? 'Nhấn đây để trở về trang chủ' : 'Click here to go back home page.';

if (!isset($_SESSION['member']) || $_SESSION['member']==''){
	unset($_SESSION['member']);
	echo "<script>window.location='dang_nhap.html'</script>";
}
if (count($_SESSION['cart'])<=0){
	echo "<script>window.location='gio_hang.html'</script>";
}

function send_mail_order(){
	global $conn;
	global $adminEmail;
	$sql = "select * from xteam_member where uid='".$_SESSION['member']."'";
	$result = mysql_query($sql,$conn);
	$cust = mysql_fetch_assoc($result);
	
	$name    = $cust['name'];
	$address = $cust['address'];
	$tel     = $cust['tel'];
	$email   = $cust['email'];

	$dathang = "";
	$cart = $_SESSION['cart'];

	$tongcong=0;
	$cnt=0;
	foreach ($cart as $product){
		$sql = "select * from xteam_product where id='".$product[0]."'";
		$result = mysql_query($sql,$conn);
		$pro = mysql_fetch_assoc($result);
		
		$dathang .= "Ma san pham : ".$pro['code']."<br>"; 
		$dathang .= "Ten san pham : ".$pro['name']."<br>"; 
		$dathang .= "So luong : ".$product[1]."<br>"; 
		$dathang .= "Don gia : ".$pro['price']."<br>";
		$dathang .= "Thanh tien : ".$pro['price']*$product[1]."<br><br>";
		
		$tongcong = $tongcong+$pro['price']*$product[1];
		$cnt=$cnt+1;
	} 
	$dathang.="<hr>Tong cong : ".$tongcong."<br>";

	$m2 = send_mail($email,$adminEmail, "Thong tin dat hang cua : ".$name, "Ho ten : ".$name."<br>Dia chi : ".$address."<br>Dien thoai : ".$tel."<br>Email : ".$email."<br><hr><b>Don hang :</b><br>".$dathang);
	if(m2){
		return "";
	}else{
		return "Không thể gởi thông tin !";
	}
}

if (!isset($_SESSION['member'])) echo "<script>window.location='dang_ky.html'</script>";
if (count($_SESSION['cart'])<=0) echo "<script>window.location='gio_hang.html'</script>";
$cart = $_SESSION['cart'];

$sql = "select * from xteam_member where uid='".$_SESSION['member']."'";
$result = mysql_query($sql,$conn);
$cust = mysql_fetch_assoc($result);

if (isset($_POST['btnSend'])){
	$tongcong=0;
	$cnt=0;
	$sqlorder="insert into xteam_order (code,customer_id,date_added) values (".$cust['id'].",now())";		
	mysql_query($sqlorder,$conn);
	$newid=mysql_insert_id();
	foreach ($cart as $product){
		print_r($product);echo 'p:'.$pro['price'];
		$sql = "select * from xteam_product where id='".$product[0]."'";
		$result = mysql_query($sql,$conn);
		$pro=mysql_fetch_assoc($result);
		$price = $pro['price']!=0?$pro['price']:0;
		$sqlorderdetail="insert into xteam_order_detail (product_id,quantity,price,order_id) values (".$product[0].",".$product[1].",".$price.",".$newid.")";
		//$sqlorderdetail="insert into xteam_order_detail (order_id,date_added,pas_quantity,price) values (".$newid.",now(),".$product[1].")";
		//.$product[0].",".$product[1].",".$price.",".$newid.")";
		mysql_query($sqlorderdetail,$conn);
		$tongcong=$tongcong+$pro['price']*$product[1];
		$cnt=$cnt+1;
	}
	if (send_mail_order()==""){
		echo "<script>window.location='thanh_toan_ok.html'</script>";
	}else{
		echo "<p align='center' class='err'><font color=red>Không thể gởi thông tin</font></p>";
	}
}
?>


<? if ($frame=='checkoutok'){?>
<table align="center" border="0" width="98%" cellpadding="0" cellspacing="0">
	<tr><td height="5"></td></tr>
	<tr>
		<td>
			<table align="center" border="1" width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td align="center">
						<br><br><br>
						<font color="#0000FF" size="2" face="Verdana, Arial, Helvetica, sans-serif">
							<b><?=$l_sendSuccess?></b>
						</font>
						<br><br>
						<a href='trang_chu.html'><?=$l_btnBackHome?></a>
						<br><br><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr><td height="5"></td></tr>
</table>
<?
	unset($_SESSION['cart']);
}else{
?>

<table cellspacing="1" cellpadding="2" width="100%" style="border:none;">
	<tr><td colspan="3" height="10"></td></tr>
	<tr>
		<td class="smallfont" align="right" width="100"><?=$l_name?></td>
        <td width="5"></td>
		<td class="smallfont"><b><?=$cust['name']?></b></td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_company?></td>
        <td width="5"></td>
		<td class="smallfont"><b><?=$cust['company']?></b></td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_address?></td>
        <td width="5"></td>
		<td class="smallfont"><b><?=$cust['address']?></b></td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_city?></td>
        <td width="5"></td>
		<td class="smallfont"><b><?=$cust['city']?></b></td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_country?></td>
        <td width="5"></td>
		<td class="smallfont"><b><?=$cust['country']?></b></td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_tel?></td>
        <td width="5"></td>
		<td class="smallfont"><b><?=$cust['tel']?></b></td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_fax?></td>
        <td width="5"></td>
		<td class="smallfont"><b><?=$cust['fax']?></b></td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_email?></td>
        <td width="5"></td>
		<td class="smallfont"><b><?=$cust['email']?></b></td>
	</tr>

</table>


<form action="thanh_toan.html" method="POST" name="cartform">
<table border="0" width="100%" cellspacing="0" cellpadding="4" bordercolor="EBEBEB">
	<tr>
		<th width="100"  style="border:1px solid #a9bdd0;color:#9e6d32;"><?=$l_image?></th>
		<th class="smallfont"  style="border:1px solid #a9bdd0;color:#9e6d32;"><?=$l_product?></th>
		<th class="smallfont"  style="border:1px solid #a9bdd0;color:#9e6d32;" width="70"><?=$l_quantity?></th>
		<th class="smallfont" style="border:1px solid #a9bdd0;color:#9e6d32;" width="70"><?=$l_price?></th>
		<th class="smallfont" style="border:1px solid #a9bdd0;color:#9e6d32;" width="70"><?=$l_money?></th>
	</tr>
<?
$cart=$_SESSION['cart'];
$cnt=0;
$tongcong=0;
foreach ($cart as $product){
	$sql = "select * from xteam_product where id='".$product[0]."'";
	$result = mysql_query($sql,$conn);
	if(mysql_num_rows($result)>0){
		$pro=mysql_fetch_assoc($result)?>	
	<tr>
		<td  style="border:1px solid #a9bdd0;color:#9e6d32;" align="center">
				<img id="" src="<?=$pro['image']?>" alt="<?=$pro['name']?>" border="0" width="100">
		</td>
		<td  style="border:1px solid #a9bdd0;color:#9e6d32;" align="left"><?=$pro['name']?></td>
		<td  style="border:1px solid #a9bdd0;color:#9e6d32;" align="center"><?=$product[1]?></td>
		<td  style="border:1px solid #a9bdd0;color:#9e6d32;" align="center"><?=number_format($pro['price'],0)?></td>
		<td  style="border:1px solid #a9bdd0;color:#9e6d32;" align="center"><?=number_format(($pro['price']*$product[1]),0)?></td>
	</tr>
<?
	}
	$tongcong=$tongcong+$pro['price']*$product[1];
	$cnt=$cnt+1;
} 
?>
</table>


<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smallfont" align="right" colspan="2">
			<b><?=$l_total?> : <font color="#CC0000"><?=number_format($tongcong,0)?></font> <?=$currencyUnit?></b>
		</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td align="center">
<input type="submit" onmouseover="this.className='buttonblue'" onmouseout="this.className='buttonorange'" name="btnSend"   value="<?=$l_btnSend?>">
		</td>
	</tr>
</table>

</form>

<? }?>

