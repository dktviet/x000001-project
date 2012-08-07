<div style="padding:10px; text-align:justify; border:1px solid #d4d4d4; width:95%; margin:10px auto;">
<?
$l_image  = $_lang == 'vn' ? 'Hình ảnh' : 'Image';
$l_func   = $_lang == 'vn' ? 'Chức năng' : 'Function';
$l_product   = $_lang == 'vn' ? 'Sản phẩm' : 'Product';
$l_quantity  = $_lang == 'vn' ? 'Số lượng' : 'Quantity';
$l_price     = $_lang == 'vn' ? 'Đơn giá' : 'Unit price';
$l_money     = $_lang == 'vn' ? 'Thành tiền' : 'Cost';
$l_total     = $_lang == 'vn' ? 'Tổng cộng' : 'Total';
$l_code     = $_lang == 'vn' ? 'Mã sản phẩm' : 'Code Product';
$l_btnDel    = $_lang == 'vn' ? 'Xóa' : 'Delete';
$l_btnDelAll = $_lang == 'vn' ? 'Xóa hết' : 'Delete all';
$l_btnUpdate = $_lang == 'vn' ? 'Cập nhật' : 'Update';
$l_btnPay    = $_lang == 'vn' ? 'Thanh toán' : 'Payment';

$l_cartEmpty = $_lang == 'vn' ? 'Bạn chưa chọn bất kỳ sản phẩm nào.' : 'Your cart is empty.';

function checkexist(){
	$cart=$_SESSION['cart'];
	foreach ($cart as $product)
		if ($product[0]==$_REQUEST['p']) return true;
	return false;
}

if ($_REQUEST['act']=='del'){
	if (count($_SESSION['cart'])==1){
		unset($_SESSION['cart']);
		unset($_SESSION['tongcong']);
	}else{
		$cart=$_SESSION['cart'];
		unset($cart[$_REQUEST['pos']]);
		$_SESSION['cart']=$cart;
		echo "<script>window.location='gio_hang.html'</script>";
	}
}

if (isset($_POST['butUpdate'])||isset($_POST['btnCheckout'])){
	$cart=$_SESSION['cart'];
	$t=0;
	foreach ($_POST['txtQuantity'] as $quantity){
		if (is_numeric($quantity) && $quantity > 0 && strlen($quantity) < 5)
			$cart[$t][1] = (int)$quantity;
		if ($quantity <= 0){
			unset($cart[$t]);
			$t = $t-1;
		}
		$t = $t+1;
	}
	if (count($cart)<=0) unset($cart);
	$_SESSION['cart']=$cart;
	
	if (isset($_POST['btnCheckout'])) echo "<script>window.location='thanh_toan.html'</script>";
}
	
if (isset($_POST['btnDeleteAll'])){ 
	unset($_SESSION['cart']);
	unset($_SESSION['tongcong']);
}

if (isset(killInjection($_REQUEST['cat']))){
	if (!isset($_SESSION['cart'])){
		$pro=killInjection($_REQUEST['cat']);
		$cart=array();
		$cart[] = array($pro,1);
		$_SESSION['cart']=$cart;
	}else{
		$pro=killInjection($_REQUEST['cat']);
		$cart=$_SESSION['cart'];
		if (countRecord("bnk_product","id='".killInjection($_REQUEST['cat'])."'")>0 && checkexist()==false){
			$cart[]=array($pro,1);
			$_SESSION['cart']=$cart;
		}
	}
	echo "<script>window.location='gio_hang.html'</script>";
}else{
	$cart=$_SESSION['cart'];
}
?>


<? if (!isset($_SESSION['cart'])){?>
<table align="center" width="98%" cellpadding="0" cellspacing="0" style="border:hidden;">
	<tr>
		<td>
			<table align="center" width="100%" cellpadding="0" cellspacing="0" style="border:hidden;">
				<tr>
					<td align="center">
						<br>
						<font color="#FF0000" size="2" face="Verdana, Arial, Helvetica, sans-serif">
							<b><?=$l_cartEmpty?></b>
						</font>
						<br><br><br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<? }else{?>


<FORM action="./" method="POST" name="frmCart">
<input type="hidden" name="frame" value="cart"> 
<table width="100%" cellspacing="0" cellpadding="4" border="1">
	<tr >
		<th width="100" ><?=$l_image?></th>
        <th width="100"><?=$l_code?></th>
		<th ><?=$l_product?></th>
		<th   width="70"><?=$l_quantity?></th>
		<th   width="70"><?=$l_price?></th>
		<th   width="70"><?=$l_money?></th>
		<th   width="60"><?=$l_func?></th>
	</tr>
<?
$cnt=0;
$tongcong=0;
foreach ($cart as $product){
	$sql = "select * from bnk_product where id='".$product[0]."'";
	$result = mysql_query($sql,$conn);
	if (mysql_num_rows($result)>0){
	$pro = mysql_fetch_assoc($result)?>
	<tr>
		<td   align="center">
				<img id="" src="<?=$pro['image']?>" alt="<?=$pro['name']?>" border="0" width="100">
		</td>
        <td  ><?=$pro['code']?></td>
		<td  ><?=$pro['name']?></td>
		<td>
            <center><input type="text" style="art-button" name="txtQuantity[]" size="1" value="<?=$product[1]?>"></center>
		</td>
		<td   align="center"><?=number_format($pro['price'],0)?></td>
		<td   align="center"><?=number_format(($pro['price']*$product[1]),0)?></td>
		<td   align="center">
        
        	<input type="button" style="art-button" name="btnDelete" value="<?=$l_btnDel?>" onclick="window.location='huy-<?=$cnt?>-gio_hang.html';return false;">
	  </td>
	</tr>
<?
}
$tongcong=$tongcong+$pro['price']*$product[1];
$cnt=$cnt+1;
$_SESSION['tongcong']=$tongcong+$pro['price']*$product[1];
} 
?>
</table>

<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td class="smallfont" align="right" colspan="2">
			<b><?=$l_total?> : <font color="#CC0000"><?=number_format($tongcong)?></font> <?=$currencyUnit?></b>
		</td>
	</tr>
	<tr><td height="10" colspan="2"></td></tr>
	<tr>
		<td>
			<input type="submit" style="art-button" name="butUpdate" value="<?=$l_btnUpdate?>">
			<input type="submit" style="art-button" name="btnDeleteAll" value="<?=$l_btnDelAll?>">
		</td>
		<td align="center">
		<input type="button"  style="art-button" <? if($_REQUEST["back1"]==1) echo 'onclick="javascript:history.go(-2)"'; else  echo 'onclick="javascript:history.go(-1)"'; ?>value="Tiếp tục chọn" />
			<input type="submit" style="art-button" onmouseover="this.className='button'" onmouseout="this.className='buttonorange'" name="btnCheckout" value="<?=$l_btnPay?>">
		</td>
	</tr>
</table>

</FORM>
<?
}
?>

</div>