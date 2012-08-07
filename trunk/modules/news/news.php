<?
foreach($cat_news as $cat_title){
	if($cat_title['id']==$cat){?>
		<div class="fancy-header">
        	<h3><?=$cat_title['name']?></h3>
		</div>
	<? }
}

$total = countArray($news,'parent',$cat);
$per_page = 5;
$start = $p!='' ? $per_page*($p-1) : 0;
for($i=$start;count($news)>$i;$i++){
	if($news[$i]['parent']==$cat){?>
        <div class="featured-item">            
            <? if($news[$i]["image"]!=''){?>
			<div class="featured-img-wrap">
				<img  class="img_new" src="<?=$curHost.$news[$i]["image"]?>" align="left" border="0" alt="<?=$news[$i]['subject']." - ".$news[$i]['name']?>" /> 
			</div>
			<? }?>
			<div class="info"<?=$news[$i]["image"]!=''?' style="width:405px;margin-left:20px;"':''?>>
                <h2><a href="<?=$curHost.$news[$i]['id'].'-'.str_replace(' ','-',$news[$i]['subject'])?>/3-<?=str_replace(' ','-',$news[$i]['name'])?>.html"><?=$news[$i]['name']?></a></h2>
                <p><?=$news[$i]["detail_short"]?></p>
                <? if($news[$i]["detail"]!=''){?><a href="<?=$curHost.$news[$i]['id'].'-'.str_replace(' ','-',$news[$i]['subject'])?>/3-<?=str_replace(' ','-',$news[$i]['name'])?>.html" class="more float_r">Chi tiết</a><? }?>
            </div>
            <div class="cleaner h20"></div>
        </div>
        <br class="clear">
<?	}
	if(++$dem>=$per_page) break;
}

if($_lang=="vn"){
	$rowPage 	= "Tin";
	$pagePage 	= "Trang";
	$titleFirst 	= "&laquo;";
	$titlePrevious 	= "&lsaquo;";
	$titleNext 	= "&rsaquo;";
	$titleLast 	= "&raquo;";
}else if($_lang=="en"){
	$rowPage = "News";
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
<div style="padding:10px;">
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
            		<li><a class="page-numbers" href="<?=$curHost.str_replace(' ','-',$_GET['cat'])?>/<?=str_replace(' ','-',$_REQUEST['ali'])?>/page-<?=$i+1?>.html"><?=$i+1?></a></li>
        	<? }else{?>
        	<li><span class="page-numbers current"><?=($i+1)?></span></li>
            <? }
			}?>
            <? if($pages_no>0 && $p<$pages_no){?>
            	
                <li><a title="<?=$titleNext?>" id="next" href="<?=$curHost.str_replace(' ','-',$_GET['cat'])?>/<?=str_replace(' ','-',$_REQUEST['ali'])?>/page-<? if($p+1>$pages_no){echo $p=$pages_no;}else{if($p==''){echo $p+2;}else{echo $p+1;}}?>.html"><?=$titleNext?></a></li>
                <li><a title="<?=$titleLast?>" id="last" href="<?=$curHost.str_replace(' ','-',$_GET['cat'])?>/<?=str_replace(' ','-',$_REQUEST['ali'])?>/page-<? if($p+1>$pages_no){echo $p=$pages_no;}else{echo $pages_no;}?>.html"><?=$titleLast?></a></li>
            <? }?>
        </ul>
    </div>
    <div class="cleared"></div>
</div>