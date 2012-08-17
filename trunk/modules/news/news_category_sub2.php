<?
$num_cat = countArray($cat_news,'parent',$cat);
//loc chuyen muc con de tao dk loc bai viet
foreach($cat_news as $Item_cat){
	if($Item_cat['parent']==$cat){
		$where .= 'parent='.$Item_cat['id'].$Or=++$dem<$num_cat?" OR ":"";
	}
}
//loc bai viet trong chuyen muc con
$ListNews = getArray('xteam_news',$where);
//in chuyen muc con co bai viet
foreach($cat_news as $Item_c){
	if($Item_c['parent']==$cat){?>
    	<div class="fancy-header">
            <h3><a href="<?=$curHost.$Item_c['id'].'-'.str_replace(' ','-',$Item_c['subject'])?>/2-<?=str_replace(' ','-',$Item_c['name'])?>.html"><?=$Item_c['name']?></a></h3>
        </div>
        <? //in bai viet
		for($i=0; $i<=2; $i++){
			if($ListNews[$i]['parent']==$Item_c['id']){?>
                <div class="featured-item">
					<? if($ListNews[$i]["image"]!=''){?>
                        <div class="featured-img-wrap">
                            <a href="<?=$curHost.$ListNews[$i]['id'].'-'.str_replace(' ','-',$ListNews[$i]['subject'])?>/3-<?=str_replace(' ','-',$ListNews[$i]['name'])?>.html" rel="prettyPhoto">
                                <img style="display: block;" class="alignleft" src="<?=$curHost?><?=$ListNews[$i]["image"]?>" align="left" border="0" alt="<?=$ListNews[$i]['subject']." - ".$ListNews[$i]['name']?>" />
                            </a>
                        </div>
                        <? }?>
                    <div class="info"<?=$ListNews[$i]["image"]!=''?' style="width:405px;margin-left:20px;"':''?>>
                        <h2><a href="<?=$curHost.$ListNews[$i]['id'].'-'.str_replace(' ','-',$ListNews[$i]['subject'])?>/3-<?=str_replace(' ','-',$ListNews[$i]['name'])?>.html"><?=$ListNews[$i]['name']?></a></h2>
                        <p><?=catchu(strip_tags($ListNews[$i]['detail_short']),350)?></p>
                        <a href="<?=$curHost.$ListNews[$i]['id'].'-'.str_replace(' ','-',$ListNews[$i]['subject'])?>/3-<?=str_replace(' ','-',$ListNews[$i]['name'])?>.html" class="viewall float_r">Chi tiết</a>
                    </div>
                </div>
    			<br class="clear">
    	<? }
		}
	}
}?>
