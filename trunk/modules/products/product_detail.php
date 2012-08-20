<?
$tbl_content = "xteam_product";
$product = getRecord("xteam_product", "id=".$cat);
$properties = product_properties($cat);
$ali = $_GET['ali'];
$urlshare = $curHost.'1/'.$cat.'/'.$ali.'.html';?>
<div class="description">
    
    <div class="img" style="position:relative;">
        <a href="<?=$lightbox==1 ? $curHost.$product['image_large'] : $curHost.$product['id'].'-'.$product['subject'].'/1-'.$product['name'].'.html'?>"  <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
            <img alt="<?=$product["subject"]." - ".$product["name"]?>" src="<?=$curHost?><?=$product["image"]?>" class="imgsp" />
        </a>
    </div>
    
    <div style="height: 25px; line-height: 25px; color: #50ABD1; font-weight: bold;">Thông tin chung</div>
    <ul>
	<?
	if($properties){
    	foreach($properties as $prop){?>
        <li><label><?=$prop['cat']?>:</label><span><?=$prop['name']?></span></li>
	<?
    	}
	}else{?>
        <li><label>đang cập nhật</label></li>
    <? }?>
    </ul>
    <p class="label-price">Giá tham khảo:</p>
    <?=$product['price']>0?'<p class="price"><font color="#F2B600">'.number_format($product['price'],0,',','.').' '.$currencyUnit.'</font></p>':'<p class="price"><font color="orange">Thỏa thuận</font></p>'?><br />
</div>
<div class="content-detail">
    <p class="detail-title"><strong>Thông tin chi tiết:</strong></p>
    <?=$product["detail"]?>
    <div class="clear"></div>
</div>
<div class="art-blockheader">
    <h3 class="detail-title">Có thể bạn quan tâm</h3>
</div>
<div class="from-gallery-imgs">
    <div class="block-news">
	<?
    $product_type = getArray('xteam_product','status=1 AND id<>'.$product['id'].' AND parent_id='.$product['parent_id']);
    foreach ($product_type as $Item_type){
        $num++;
        $class = $num%2!==0? 'block-left' : 'block-right';
        ?>
        <div class="<?=$class?>">
            <h2 class="title-news"><a href="<?=$curHost.$Item_type['id'].'-'.str_replace(' ','-',$Item_type['subject'])?>/1-<?=str_replace(' ','-',$Item_type['name'])?>.html"><?=catchu($Item_type['name'],30)?></a></h2>
            <a href="<?=$lightbox==1 ? $curHost.$Item_type['image_large'] : $curHost.$Item_type['id'].'-'.str_replace(' ','-',$Item_type['subject']).'/1-'.str_replace(' ','-',$Item_type['name']).'.html'?>" title="<?=$Item_type['name']?>" <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
                <img src="<?=$curHost?><?=$Item_type['image']?>" alt="<?=$Item_type['subject']." - ".$Item_type["name"]?>" class="img-news" style="display: inline;" />
            </a>
            <div class="short-news"><?=catchu(strip_tags($Item_type['detail_short']),200)?></div>
        </div>
        <?
        
        if($num%2==0 || $num >=count($product_type)){
            echo '<div class="clear"></div></div><div class="block-news">';
        }
    }?>
    </div>
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