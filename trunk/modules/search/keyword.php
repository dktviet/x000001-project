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
$keyword=killInjection(str_replace('-',' ',$_REQUEST['keyword']));
$per_page = 30;
$p=1;
if ($_REQUEST['p']!='') $p=killInjection($_REQUEST['p']);
	if ($_REQUEST['p']!='') $p=$_REQUEST['p'];
	
	$result = mysql_query("SELECT count(*) FROM xteam_news WHERE detail_short like '%".$keyword."%' OR  detail like '%".$keyword."%'",$conn);
	$total = mysql_fetch_row($result);

	$sql="SELECT * FROM  xteam_news WHERE detail_short like '%".$keyword."%' OR  detail like '%".$keyword."%' limit ".$per_page*($p-1).",".$per_page;
	$result = mysql_query($sql,$conn);
	?>
	<div class="art-blockcontent">
		<div class="art-blockcontent-body">
			<div class="containeritem">
				<div>(Tìm được <font color='red'><?=$spcount=$total[0]?></font> bài viết theo từ khóa <font color='red'><?=$keyword?></font> trên website)</div>
				<?
                $num=0;
                while($row=mysql_fetch_assoc($result)){
                    $num++;
                    ?>
                    
                        <div class="bodyitemsearch">
                            <a href="<?=$curHost?>3/<?=$row['id']?>/<?=utf8_to_ascii($row['name'])?>.html">
                            <? if($row["image"]==''){}
                            else {?>
                            <img src="<?=$curHost?><?=$row['image']?>" title="<?=$row['name']?>" alt="<?=$row['name']?>"  width="100" height="100" />
                            <? }?>
                            </a>
                            <h1><a href="<?=$curHost?>3/<?=$row['id']?>/<?=utf8_to_ascii($row['name'])?>.html" title="<?=$row['name']?>" >
                                <?=catchu($row['name'],40)?>
                            </a></h1>
                            <span style="color:red"><?=$row['price']==0? 'Call '.$myphone['detail']:number_format($row['price'],0,',','.').' '.$currencyUnit?></span><br />
                            <span><?=catchu(strip_tags($row['detail_short']),200)?></span><br />
                            <div style="text-align:right">
                            </div>
                          </div>
                        
                    <? if($num%2==0){echo '</div><div class="containeritem">'; }?>
                    
                
                <? }?>
			</div>
		</div>
	</div>
	<div class="cleared"></div>
	<?
	
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
$pages = countPages($total,$per_page);
?>
<div class="numpage">
	<? if($pages>1){?>
    <a title="<?=$titleFirst?>" id="first"
    href="<?=$curHost?>tim-key/<?=$_REQUEST['keyword']?>/1.html"><span></span>
    </a>
    <a title="<?=$titlePrevious?>" id="previous"
        href="<?=$curHost?>tim-key/<?=$_REQUEST['keyword']?>/<? if($p-1<0){echo $p=1;}else{echo $p-1;}?>.html"><span></span>
    </a>
    <?
    $from=($p-10>0?$p-10:0);
    $to=($p+10<$pages?$p+10:$pages);
    for ($i=$from;$i<$to;$i++){
        if ($i+1!=$p) {?> <span><a href="<?=$curHost?>tim-key/<?=$_REQUEST['keyword']?>/<?=$i+1?>.html"><?=$i+1?></a></span>
    <? }
        else echo '<span class="active">'.($i+1).'</span> ';
    }
    ?>
	<? /*
    $from=($p-10>0?$p-10:0);
    $to=($p+10<$pages?$p+10:$pages);
    for ($i=$from;$i<$to;$i++){
        if ($i!=$p){ ?>
        <span><a href="<?=$curHost?>tim-key/<?=$_REQUEST['keyword']?>/<?=$i?>.html"><?=$i+1?></a></span>
        <? }else{ ?>
        <span class="active"><?=($i+1)?></span>
        <? }
    }*/?>
    <a title="<?=$titleNext?>" id="next"
        href="<?=$curHost?>tim-key/<?=$_REQUEST['keyword']?>/<? if($p+1>$pages){echo $p=$pages;}else{echo $p+1;}?>.html"><span></span></a>
    <a title="<?=$titleNext?>" id="last"
        href="<?=$curHost?>tim-key/<?=$_REQUEST['keyword']?>/<?=$p=$pages?>.html"><span></span></a>
    <? }?>
</div>
