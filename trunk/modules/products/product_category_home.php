<?
$cat_pro_home =  getArray('xteam_category','status=0 AND system=0 AND parent>1');
$num_c = count($cat_pro_home);
foreach($cat_pro_home as $Item_c){
	$where .= 'parent='.$Item_c['id'].$Or=++$dem<$num_c?" OR ":"";
}
$top_pro = getArray('xteam_product',$where);
foreach($cat_pro_home as $Item_c){?>
	<div class="fancy-header">
    <h3><a href="<?=$curHost.$Item_c['id'].'-'.str_replace(' ','-',$Item_c['subject']).'/7-'.str_replace(' ','-',$Item_c['name']).'.html'?>"><?=$Item_c['name'];?></a></h3>
    </div>
    <div class="from-gallery-imgs">
	<?
	for($i=1;$i<=3;$i++){
		if($top_pro[$i]['parent']==$Item_c['id']){?>
			<div class="gallery-img-wrap <?=++$num %3==0 ? ' last-img':''?>">
                <h2><a href="<?=$curHost.$top_pro[$i]['id'].'-'.str_replace(' ','-',$top_pro[$i]['subject']).'/1-'.str_replace(' ','-',$top_pro[$i]['name']).'.html'?>"><?=$top_pro[$i]['name'] ?></a></h2>
                <a href="<?=$lightbox==1 ? $curHost.$top_pro[$i]['image_large'] : $curHost.$top_pro[$i]['id'].str_replace(' ','-',$top_pro[$i]['subject']).'/1-'.str_replace(' ','-',$top_pro[$i]['name']).'.html'?>"  <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
                <img width="180" height="150" class="image_frame"  src="<?=$curHost.$top_pro[$i]['image']?>" alt="<?=$top_pro[$i]["subject"]." - ".$top_pro[$i]["name"]?>" />
                <span class="zoom-wrap" style="display: none;"></span>
                <span class="img-load-wrap" style="display: none;"></span>
                </a>
                <p>
                    <?=$top_pro[$i]['price']==0? 'Call '.$myphone['detail']:number_format($top_pro[$i]['price'],0,',','.').' '.$currencyUnit?>
                </p>
                <p class="hidden-text"><?=strip_tags($top_pro[$i]['detail_short'])?></p>
                <div class='clear'></div>
            </div>
		<?
		if($num%3==0)echo"<div class='clear'></div>";
        }
		
	}?>
    </div>
<? }?>