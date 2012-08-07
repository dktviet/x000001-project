<?
$news_home = getArray('bnk_news','status=0 and home=0');
foreach($cat_news as $cat_n){
	$i=0;
	foreach($news_home as $news_h){
		if($news_h['parent']==$cat_n['id']){
			if(++$i<=1){?>
				<div class="fancy-header">
                    <h3><a href="<?=$curHost.$cat_n['id'].'-'.str_replace(' ','-',$cat_n['subject'])?>/2-<?=str_replace(' ','-',$cat_n['name'])?>.html"><?=$cat_n['name']?></a></h3>
                </div>
                <div class="latest-news-item">
                    <h2><a href="<?=$curHost.$news_h['id'].'-'.str_replace(' ','-',$cat_n['subject'])?>/3-<?=str_replace(' ','-',$news_h['name'])?>.html" title="<?=$news_h['name']?>">
                    <? if($news_h['image_large']!=''){?>
                    <img src="<?=$curHost.$news_h['image']?>" alt="<?=$news_h['subject']." - ".$news_h['name']?>" class="alignleft" />
                    <? }?>
                    <?=$news_h['name']?>
                    </a></h2>
                    <p><?=catchu(strip_tags($news_h['detail_short']),350)?></p>			
                    <a href="<?=$curHost.$news_h['id'].'-'.str_replace(' ','-',$cat_n['subject'])?>/3-<?=str_replace(' ','-',$news_h['name'])?>.html">Xem thêm</a>	
				</div>
			<? }else{?>
				<ul style="margin:0;padding-left:15px;"><li style="text-transform: lowercase;">
				<a href="<?=$curHost.$news_h['id'].'-'.str_replace(' ','-',$cat_n['subject'])?>/3-<?=str_replace(' ','-',$news_h['name'])?>.html" title="<?=$news_h['name']?>">
				<?=$news_h['name']?>
				</a></li></ul>
		<? }
		}
	}
}?>