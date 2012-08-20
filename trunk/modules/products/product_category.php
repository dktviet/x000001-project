<div class="block-news">
<?
$parent_id = getRecord('xteam_category', 'code="product"');
$parents = getArray('xteam_category','parent_id='.$parent_id['id']);
$parname = array();
$parid = array();
foreach ($parents as $parent){
    $parname[$parent['id']] = $parent['name'];
    $parid[$parent['id']] = $parent['id'];
}
$per_page = 18;
$page_no = $p;
$first = ($page_no) * $per_page;
$limit = $first . ',' . $per_page;
$products = getArray('xteam_product','parent_id='.$cat,$limit);
$total = count($products);
foreach ($products as $product){
    if($i>=$per_page) break;
    if($parid[$product['parent_id']]%2==0){$class_sp="rental";}else{$class_sp="salse";}
    $class = ++$j%2!==0? 'block-left' : 'block-right';?>
    <div class="<?=$class?>">
        <h2 class="title-news">
            <a href="<?=$curHost.$product['id'].'-'.str_replace(' ','-',$product['subject'])?>/1-<?=str_replace(' ','-',$product['name'])?>.html">
				<span class="<?=$class_sp?>"><?=$parname[$top_pro[$i]['parent_id']]?> | </span><?=catchu($product['name'],40)?>
            </a>
        </h2>
        <a href="<?=$lightbox==1 ? $curHost.$product['image_large'] : $curHost.$product['id'].'-'.str_replace(' ','-',$product['subject']).'/1-'.str_replace(' ','-',$product['name']).'.html'?>"  <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
            <img src="<?=$curHost.$product['image']?>" alt="<?=$product['subject']." - ".$product["name"]?>"  class="img-news" style="display: inline;" />
        </a>
        <div class="short-news">
            <?=catchu(strip_tags($product['detail_short']),200)?>
        </div>
    </div>
<?  if($j%2==0 && $j<$per_page){
        echo '<div class="clear"></div></div><div class="block-news">';
    }
}?>
    <div class="clear"></div>
</div>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		var contentdiv = $('.block-news').text(function(){
			if ($.trim($(this).text())==''){
				$(this).hide();
			}
			});
	})
</script>
<?
$rowPage = $_lang=="vn" ? "Sản phẩm" : "Products";
$pagePage = $_lang=="vn" ? "Trang" : "Page";
if($_lang=="vn"){
	$$rowPage       = "Sản phẩm";
	$pagePage       = "Trang";
	$titleFirst 	= "&laquo;";
	$titlePrevious 	= "&lsaquo;";
	$titleNext 	= "&rsaquo;";
	$titleLast 	= "&raquo;";
}else if($_lang=="en"){
	$rowPage = "Products";
	$pagePage 	= "Page";
	$titleFirst 	= "First";
	$titlePrevious 	= "Previous";
	$titleNext 	= "Next";
	$titleLast 	= "Last";
}else{
	$rowPage = "新聞";
	$pagePage 	= "頁";
	$titleFirst 	= "首先";
	$titlePrevious 	= "上一頁";
	$titleNext 	= "下一頁";
	$titleLast 	= "最後";
}
$pages_no = countPages($total,$per_page);?>
<div class="pagging">
    <ul class="page-numbers">
        <? if($p!='' && $p>1){?>
            <? //if(){?>
            <li><a title="<?=$titleFirst?>" id="first" href="<?=$curHost.str_replace(' ','-',$_GET['cat'])?>/<?=str_replace(' ','-',$_REQUEST['ali'])?>/page-1.html"><?=$titleFirst?></a></li>
            <li><a title="<?=$titlePrevious?>" id="previous" href="<?=$curHost.str_replace(' ','-',$_GET['cat'])?>/<?=str_replace(' ','-',$_REQUEST['ali'])?>/page-<? if($p-1<0){echo $p=1;}else{echo $p-1;}?>.html"><?=$titlePrevious?></a></li>
            <? //}?>
        <? }?>
        <? $from=($p-10>0?$p-10:0); $to=($p+10<$pages_no?$p+10:$pages_no); 
        for ($i=$from;$i<$to;$i++){
            if ($i+1!=$p && $i+1>0) {?>
                <li><a href="<?=$curHost.str_replace(' ','-',$_GET['cat'])?>/<?=str_replace(' ','-',$_REQUEST['ali'])?>/page-<?=$i+1?>.html"><?=$i+1?></a></li>
        <? }else{?>
                <li><a class="active"><?=($i+1)?></a></li>
        <? }
        }?>
        <? if($pages_no>0 && $p<$pages_no){?>
            <li><a title="<?=$titleNext?>" id="next" href="<?=$curHost.str_replace(' ','-',$_GET['cat'])?>/<?=str_replace(' ','-',$_REQUEST['ali'])?>/page-<? if($p+1>$pages_no){echo $p=$pages_no;}else{if($p==''){echo $p+2;}else{echo $p+1;}}?>.html"><?=$titleNext?></a></li>
            <li><a title="<?=$titleLast?>" id="last" href="<?=$curHost.str_replace(' ','-',$_GET['cat'])?>/<?=str_replace(' ','-',$_REQUEST['ali'])?>/page-<? if($p+1>$pages_no){echo $p=$pages_no;}else{echo $pages_no;}?>.html"><?=$titleLast?></a></li>
        <? }?>
    </ul>
</div>