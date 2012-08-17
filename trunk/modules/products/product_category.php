<? $title_cat = getRecord('xteam_category','id='.$cat);?>
<div class="block-news">
<? $total = count($products);
$per_page = 18;
$start = $p!='' ? $per_page*($p-1) : 0;
$j=0;
for($i=$start; $per_page * ($p <= 0 ? 1 : $p) > $i; $i++){
    $class = ++$j%2!==0? 'block-left' : 'block-right';?>
    <div class="<?=$class?>">
        <h2 class="title-news">
            <a href="<?=$curHost.$products[$i]['id'].'-'.str_replace(' ','-',$products[$i]['subject'])?>/1-<?=str_replace(' ','-',$products[$i]['name'])?>.html">
				<?=catchu($products[$i]['name'],40)?>
            </a>
        </h2>
        <a href="<?=$lightbox==1 ? $curHost.$products[$i]['image_large'] : $curHost.$products[$i]['id'].'-'.str_replace(' ','-',$products[$i]['subject']).'/1-'.str_replace(' ','-',$products[$i]['name']).'.html'?>"  <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
            <img src="<?=$curHost.$products[$i]['image']?>" alt="<?=$products[$i]['subject']." - ".$products[$i]["name"]?>"  class="img-news" style="display: inline;" />
        </a>
        <div class="short-news">
            <?=catchu(strip_tags($products[$i]['detail_short']),200)?>
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