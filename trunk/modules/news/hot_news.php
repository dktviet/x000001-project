<ul class="popular-posts-list">
<?
$i=0;
for($i=1;$i<=10;++$i){?>
	<li>
    <a href="<?=$curHost.$top_news[$i]['id'].'-'.str_replace(' ','-',$top_news[$i]['subject'])?>/3-<?=str_replace(' ','-',$top_news[$i]['name'])?>.html" style="line-height:150%;" title="<?=$top_news[$i]['name']?>">
		<? if($top_news[$i]['image_large']!=''){?>
        <img src="<?=$curHost.$top_news[$i]['image']?>" alt="<?=$top_news[$i]['subject']." - ".$top_news[$i]['name']?>" width="65" height="65" style="float:left; margin-right:10px; margin-top:7px;" />
        <? }?>
	</a>
    
    <p>
    <a href="<?=$curHost.$top_news[$i]['id'].'-'.str_replace(' ','-',$top_news[$i]['subject'])?>/3-<?=str_replace(' ','-',$top_news[$i]['name'])?>.html" style="line-height:150%;" title="<?=$top_news[$i]['name']?>"><?=catchu($top_news[$i]['name'],40)?></a>
	<span class="popular-post-date"><?=catchu(strip_tags($top_news[$i]['detail_short']),150)?></span>
	</p>
    </li>
	
<? }?>
</ul>