<?
$l_Product       = $_lang == 'vn' ? 'Sản phẩm' : 'Product';
$l_Price         = $_lang == 'vn' ? 'Giá' : 'Price';
$l_Keyword       = $_lang == 'vn' ? 'Từ khóa' : 'Keyword';
$l_CheckboxLabel = $_lang == 'vn' ? 'Chỉ tìm trong phần mô tả sản phẩm' : 'Only search in product detail';
$l_BelongTo      = $_lang == 'vn' ? 'Trong danh mục' : 'Belong to';
$l_PriceFrom     = $_lang == 'vn' ? 'Giá từ' : 'Price from';
$l_PriceTo       = $_lang == 'vn' ? 'Giá đến': 'Price to';
$l_DateFrom      = $_lang == 'vn' ? 'Từ ngày': 'From date';
$l_DateTo        = $_lang == 'vn' ? 'Đến ngày' : 'To date';
$l_DateFormat    = $_lang == 'vn' ? 'Tháng / ngày / năm' : 'month / day / year';
$per_page = 30;
$p=1;
//if ($_REQUEST['p']!='') $p=killInjection($_REQUEST['p']);

if (isset($pages_no)){
	$where="1=1";
	$keyword = killInjection(str_replace('-',' ',$_REQUEST['keyword']));
	if ($keyword!=''){
		$where .= " and (detail_short like '%".$keyword."%' or detail like '%".$keyword."%'";
		if (!isset($_REQUEST['search_in_detail'])) 
			$where.=" or code like '%".$keyword."%' or name like '%".$keyword."%'"; 
		$where.=") ";
	}
	if ($_REQUEST['parent']!='') $where.=" and parent=".$_REQUEST['parent'];
	if ($_REQUEST['pfrom']!='' && is_numeric($_REQUEST['pfrom']))	$where.=" and price>=".$_REQUEST['pfrom'];
	if ($_REQUEST['pto']!='' && is_numeric($_REQUEST['pto'])) $where.=" and price<=".$_REQUEST['pto'];
	if ($_REQUEST['dfrom']!='')	$where.=" and date_added>=".$_REQUEST['dfrom'];
	if ($_REQUEST['dto']!='') $where.=" and date_added<=".$_REQUEST['dto'];
	if ($_REQUEST['p']!='') $p=$_REQUEST['p'];
	
	$result = mysql_query("select count(*) from xteam_product where $where",$conn);
	$total = mysql_fetch_row($result);

	$sql="select * from xteam_product where $where limit ".$per_page*($p-1).",".$per_page;
	$result = mysql_query($sql,$conn);
	?>
	<div class="art-blockcontent">
		<div class="art-blockcontent-body">
			<div class="containeritem">
				<div>(Tìm được <font color='red'><?=$spcount=$total[0]?></font> sản phẩm theo từ khóa <font color='red'><?=$_REQUEST['keyword']?></font> trên website)</div>
	<?
	
	$num=0;
	while($row=mysql_fetch_assoc($result)){
		$num++;
		?>
			<div class="bodyitemsearch">
                <a href="<?=$curHost.$row['id'].'-'.str_replace(' ','-',$row['subject'])?>/1-<?=str_replace(' ','-',$row['name'])?>.html">
                <? if($row["image"]==''){}
                else {?>
                <img src="<?=$curHost?><?=$row['image']?>" title="<?=$row['name']?>" alt="<?=$row['name']?>"  width="100" height="100" />
                <? }?>
                </a>
                <h1><a href="<?=$curHost.$row['id'].'-'.str_replace(' ','-',$row['subject'])?>/1-<?=str_replace(' ','-',$row['name'])?>.html" title="<?=$row['name']?>" >
                    <?=catchu($row['name'],40)?>
                </a></h1>
                <span>Hãng sản xuất: <a href="<?=$curHost.$row['id'].'-'.str_replace(' ','-',$row['subject'])?>/1-<?=str_replace(' ','-',$row['name'])?>.html" title="<?=$row['name']?>" ><?=$row['maker']?></a></span><br />
                <span style="color:red"><?=$row['price']==0? 'Call '.$myphone['detail']:number_format($row['price'],0,',','.').' '.$currencyUnit?></span><br />
                <span><?=catchu(strip_tags($row['detail_short']),200)?></span><br />
			  </div>
			
		<? if($num%2==0){echo '<div class="cleared"></div></div><div class="containeritem">'; }?>
	<? }?>
			</div>
		</div>
	</div>
	<div class="cleared"></div>
	<?
	settype($total[0],int);
	if($_lang=="vn"){
		$rowPage 	= "Sản phẩm";
		$pagePage 	= "Trang";
		$titleFirst 	= "Đầu Tiên";
		$titlePrevious 	= "Về trước";
		$titleNext 	= "Tiếp theo";
		$titleLast 	= "Cuối cùng";
	}else if($_lang=="en"){
		$rowPage = "Products";
		$pagePage 	= "Page";
		$titleFirst 	= "First";
		$titlePrevious 	= "Previous";
		$titleNext 	= "Next";
		$titleLast 	= "Last";
	}else{
		$rowPage = "產品";
		$pagePage 	= "頁";
		$titleFirst 	= "首先";
		$titlePrevious 	= "上一頁";
		$titleNext 	= "下一頁";
		$titleLast 	= "最後";
	}
$total=$total[0];
$pages_no = countPages($total,$per_page);
?>
<div class="numpage">
    <? if($pages_no>1){?>
    <a title="<?=$titleFirst?>" id="first"
    href="<?=$curHost?>tim-kiem/<?=$keyword?>/page-1.html"><span></span>
    </a>
    <a title="<?=$titlePrevious?>" id="previous"
        href="<?=$curHost?>tim-kiem/<?=$keyword?>/page-<? if($p-1<=0){echo $p=1;}else{echo $p-1;}?>.html"><span></span>
    </a>
    <?
    $from=($p-10>0?$p-10:0);
    $to=($p+10<$pages_no?$p+10:$pages_no);
    for ($i=$from;$i<$to;$i++){
        if ($i+1!=$p){ ?>
        <span><a href="<?=$curHost?>tim-kiem/<?=$keyword?>/page-<?=$i+1?>.html"><?=$i+1?></a></span>
        <? }else{ ?>
        <span class="active"><?=($i+1)?></span>
        <? }
    }?>
    <a title="<?=$titleNext?>" id="next"
        href="<?=$curHost?>tim-kiem/<?=$keyword?>/page-<? if($p+1>$pages_no){echo $p=$pages_no;}else{echo $p+1;}?>.html"><span></span></a>
    <a title="<?=$titleNext?>" id="last"
        href="<?=$curHost?>tim-kiem/<?=$keyword?>/page-<?=$p=$pages_no?>.html"><span></span></a>
	<? }?>
</div>
<?
}else{
?>

<table border="0" cellpadding="10" cellspacing="1" width="100%">
	<tr><td>
<form name="frmSearch" action="./" method="GET">
<input type="hidden" name="act" value="search">
<input type="hidden" name="frame" value="search">
<table border="0" width="100%" cellSpacing="0" cellPadding="2">
	<tr>
		<td width="100" class="smallfont" align="right"><?=$l_Keyword?></td>
		<td width="5" class="smallfont" align="center"></td>
		<td class="smallfont">
			<input type="text" name="keyword" style="width: 90%" class="textbox">		</td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"></td>
		<td class="smallfont" align="center"></td>
		<td class="smallfont">
			<input type="checkbox" value="1" name="search_in_detail" class="textbox"> <?=$l_CheckboxLabel?>		</td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"></td>
		<td class="smallfont" align="center"></td>
		<td class="smallfont"><input name="submit" type="submit" class="button" value="<?=_SEARCH?>" /></td>
	</tr>
	
	<tr><td colspan="3" height="20"></td></tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_BelongTo?></td>
		<td class="smallfont" align="center"></td>
		<td class="smallfont">
			<?
			$sourceCombo = getArrayCategory("xteam_category");
			echo comboCategory('parent',$sourceCombo,'smallfont',"",1);
			?>		</td>
	</tr>

	<tr>
		<td class="smallfont" align="right"><?=$l_PriceFrom?></td>
		<td class="smallfont" align="center"></td>
		<td class="smallfont"><input type="text" name="pfrom" class="textbox"></td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_PriceTo?></td>
		<td class="smallfont" align="center"></td>
		<td class="smallfont"><input type="text" name="pto" class="textbox"></td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_DateFrom?></td>
		<td class="smallfont" align="center"></td>
		<td class="smallfont"><input type="text" name="dfrom" class="textbox"> (<?=$l_DateFormat?>)</td>
	</tr>
	
	<tr>
		<td class="smallfont" align="right"><?=$l_DateTo?></td>
		<td class="smallfont" align="center"></td>
		<td class="smallfont"><input type="text" name="dto" class="textbox"> (<?=$l_DateFormat?>)</td>
	</tr>
</table>

</form>

	</td></tr>
</table>
<? }?>
<?
session_register('cats');
$_SESSION['cats'] = $keyword;?>
<style>
.img_conten{
	width:100px;
	float:left;
	margin-right:10px;
}
</style>