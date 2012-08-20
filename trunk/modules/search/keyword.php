<?
//xác định danh mục cha
$parent_id = getRecord('xteam_category', 'code="product"');
$parents = getArray('xteam_category','parent_id='.$parent_id['id']);
$parname = array();
$parid = array();
foreach ($parents as $parent){
    $parname[$parent['id']] = $parent['name'];
    $parid[$parent['id']] = $parent['id'];
}
//phân trang
$per_page =20;
$page_no = $p;
$first = ($page_no) * $per_page;
$limit = $first . ',' . $per_page;
$result = mysql_query("SELECT prod.*
    FROM xteam_product prod
    INNER JOIN xteam_product_extend ext
    ON prod.id = ext.product_id
    WHERE properties_id=".$cat." LIMIT ".$limit);
	$num=0;
    while($row=mysql_fetch_assoc($result)){
        $num++;
        $class = $num%2==0? "block-left":"block-right";
        if($parid[$top_pro[$i]['parent_id']]%2==0){$class_sp="rental";}else{$class_sp="salse";}?>
           <div class="block-news">
            <div class="<?=$class?>">
                <h3 class="title-news">
                    <a href="<?=$curHost.$row['id'].'-'.str_replace(' ','-',$row['subject'])?>/1-<?=str_replace(' ','-',$row['name'])?>.html" title="<?=$row['name']?>" >
                        <span class="<?=$class_sp?>"><?=$parname[$row['parent_id']]?> | </span><?=catchu($row['name'],40)?>
                    </a>
                </h3>
                <a href="<?=$curHost.$row['id'].'-'.str_replace(' ','-',$row['subject'])?>/1-<?=str_replace(' ','-',$row['name'])?>.html" title="<?=$row['name']?>" >
                    <img class="img-news" src="<?=$curHost?><?=$row['image']?>" title="<?=$row['name']?>" alt="<?=$row['name']?>" />
                </a>
                <div class="short-news">
                    <?=catchu(strip_tags($row['detail_short']),200)?>
                </div>
            </div>
    <? if($num%2==0){echo '<div class="clear"></div></div><div class="block-news">'; }?>
    <? }?>
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
$total=count($result);
$pages = countPages($total,$per_page);
?>
<div class="numpage">
	<? if($pages>1){?>
    <a title="<?=$titleFirst?>" id="first"
    href="<?=$curHost.$list_propertie['id']?>-category/<?=$list_propertie['name']?>/1.html"><span></span>
    </a>
    <a title="<?=$titlePrevious?>" id="previous"
        href="<?=$curHost.$list_propertie['id']?>-category/<?=$list_propertie['name']?>/<? if($p-1<0){echo $p=1;}else{echo $p-1;}?>.html"><span></span>
    </a>
    <?
    $from=($p-10>0?$p-10:0);
    $to=($p+10<$pages?$p+10:$pages);
    for ($i=$from;$i<$to;$i++){
        if ($i+1!=$p) {?> <span><a href="<?=$curHost.$list_propertie['id']?>-category/<?=$list_propertie['name']?>/<?=$i+1?>.html"><?=$i+1?></a></span>
    <? }
        else echo '<span class="active">'.($i+1).'</span> ';
    }
    ?>
    <a title="<?=$titleNext?>" id="next"
        href="<?=$curHost.$list_propertie['id']?>-category/<?=$list_propertie['name']?>/<? if($p+1>$pages){echo $p=$pages;}else{echo $p+1;}?>.html"><span></span></a>
    <a title="<?=$titleNext?>" id="last"
        href="<?=$curHost.$list_propertie['id']?>-category/<?=$list_propertie['name']?>/<?=$p=$pages?>.html"><span></span></a>
    <? }?>
</div>
