<?
$num_cat = countArray($cat_pro,'parent',$cat);
//loc chuyen muc con de tao dk loc sản phẩm
foreach($cat_pro as $Item_cat){
	if($Item_cat['parent']==$cat){
		$where .= 'parent='.$Item_cat['id'].$Or=++$dem<$num_cat?" OR ":"";
	}
}
//loc sản phẩm trong chuyen muc con
$ListPro = getArray('xteam_product',$where);
//in chuyen muc con co sản phẩm
foreach($cat_pro as $Item_c){
	if($Item_c['parent']==$cat){?>
        <div class="fancy-header">
        	<h3><a href="<?=$curHost.$Item_c['id'].'-'.str_replace(' ','-',$Item_c['subject'])?>/7-<?=str_replace(' ','-',$Item_c['name'])?>.html"><?=$Item_c['name']?></a></h3>
        </div>
        <div class="from-gallery-imgs">
        <? //in bai viet
        for($i=0;$i<=18;$i++){
			if($ListPro[$i]['parent']==$Item_c['id']){?>
            	<div class="gallery-img-wrap">
                    <h2><a href="<?=$curHost.$ListPro[$i]['id'].'-'.str_replace(' ','-',$ListPro[$i]['subject'])?>/1-<?=str_replace(' ','-',$ListPro[$i]['name'])?>.html"><?=catchu($ListPro[$i]['name'],40)?></a></h2>
                    <a href="<?=$lightbox==1 ? $curHost.$ListPro[$i]['image_large'] : $curHost.$ListPro[$i]['id'].'-'.str_replace(' ','-',$ListPro[$i]['subject']).'/1-'.str_replace(' ','-',$ListPro[$i]['name']).'.html'?>" <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
                        <img height="150" width="180" src="<?=$curHost.$ListPro[$i]['image']?>" alt="<?=$mykeywords['detail']." - ".$ListPro[$i]["name"]?>"  class="image_frame" style="display: inline;" />
                        <span style="display: none;" class="zoom-wrap"></span>
                        <span style="display: none;" class="img-load-wrap"></span>
                    </a>
                    <p><?=$ListPro[$i]['price']==0? 'Call '.$myphone['detail']:number_format($ListPro[$i]['price'],0,',','.').' '.$currencyUnit?></p>
                    <p class="hidden-text"><?=strip_tags($ListPro[$i]['detail_short'])?></p>
                </div>
		<? }
		}?>
        	<div class="clear"></div>
        </div>
        <?
	}
}?>