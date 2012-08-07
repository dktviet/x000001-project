<?
$title_cat = getRecord('bnk_product_category','id='.$cat);?>
<div class="fancy-header">
	<h3><?=$title_cat['name']?></h3>
</div>
<div class="from-gallery-imgs">
<? 
$total = countArray($products,'parent',$cat);
$per_page = 18;
$start = $p!='' ? $per_page*($p-1) : 0;
for($i=$start;$per_page*($p<=0?1:$p)>$i;$i++){
	if($products[$i]['parent']==$cat){?>
        <div class="gallery-img-wrap ">
            <h2><a href="<?=$curHost.$products[$i]['id']."-".str_replace(' ','-',$products[$i]['subject'])?>/1-<?=str_replace(' ','-',$products[$i]['name'])?>.html"><?=catchu($products[$i]['name'],40)?></a></h2>
            <a href="<?=$lightbox==1 ? $curHost.$products[$i]['image_large'] : $curHost.$products[$i]['id'].'-'.str_replace(' ','-',$products[$i]['subject']).'/1-'.str_replace(' ','-',$products[$i]['name']).'.html'?>"  <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
                <img height="150" width="180" src="<?=$curHost.$products[$i]['image']?>" alt="<?=$products[$i]['subject']." - ".$products[$i]["name"]?>"  class="image_frame" style="display: inline;" />
                <span style="display: none;" class="zoom-wrap"></span>
                <span style="display: none;" class="img-load-wrap"></span>
                
            </a>
            <p><?=$products[$i]['price']==0? 'Call '.$myphone['detail']:number_format($products[$i]['price'],0,',','.').' '.$currencyUnit?></p>
            <p class="hidden-text"><?=strip_tags($products[$i]['detail_short'])?></p>
        	<div class="clear"></div>
        </div>	
<?	}
	if(++$num%3==0){?>
		<div class="clear"></div>
	<? }
//	if(++$dem>=$per_page) break;
}?>

</div>

<?
$rowPage       = $_lang=="vn" ? "Sản phẩm" : "Products";
$pagePage       = $_lang=="vn" ? "Trang" : "Page";
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
<div class="cleared"></div>