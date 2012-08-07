	<?
    $tbl_content = "bnk_product";
    $product = getRecord("bnk_product", "id=".$cat);
	$ali = $_GET['ali'];
	$urlshare = $curHost.'1/'.$cat.'/'.$ali.'.html';
    if($product["image_large"]!=''){?>	
		<div class="img" style="position:relative;">
            <div class="titleimg">
                <?=$product["name"]?>
            </div>
			<a href="<?=$lightbox==1 ? $curHost.$product['image_large'] : $curHost.$product['id'].'-'.$product['subject'].'/1-'.$product['name'].'.html'?>"  <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
                <img alt="<?=$product["subject"]." - ".$product["name"]?>" src="<?=$curHost?><?=$product["image"]?>" class="imgsp" />
            </a>
        </div>
    <? }?>
    
    <div class="description">
		<h2><?=$product["name"]?></h2>
		<?=$product['code']!=''?'<span>Mã sản phẩm: <strong>'.$product['code'].'</strong></span><br />':''?>
		<?=$product['price']>0?'<span>Giá trọn gói: <font color="#F2B600">'.number_format($product['price'],0,',','.').' '.$currencyUnit.'</font></span>':'<span>Liên hệ: <font color="red">'.$myphone['detail'].'</font></span>'?><br />
	</div>
    <p><strong>Thông tin thêm:</strong></p>
	<?=$product["detail"]?>
<div class="art-blockheader">
    <div class="l"></div>
    <div class="r"></div>
    <h3 class="t">website cùng loại</h3>
    <div style="width:100%; border-top: 1px solid #333; border-bottom: 1px solid #000; margin: 0 0 20px"></div>
</div>
<div class="from-gallery-imgs">
	<?
    $parentWhere = "parent = ".$product['parent'];
    $sql = "SELECT * FROM $tbl_content WHERE status=0 AND id <>".$product['id']." AND ".$parentWhere."  ORDER BY rand()";
    $result = @mysql_query($sql,$conn);
    $num = 0;
    while($products=mysql_fetch_assoc($result)){
        $num++;
        ?>
        <div class="gallery-img-wrap">
            <h2><a href="<?=$curHost.$products['id'].'-'.str_replace(' ','-',$products['subject'])?>/1-<?=str_replace(' ','-',$products['name'])?>.html"><?=catchu($products['name'],30)?></a></h2>
                <a href="<?=$lightbox==1 ? $curHost.$products['image_large'] : $curHost.$products['id'].'-'.str_replace(' ','-',$products['subject']).'/1-'.str_replace(' ','-',$products['name']).'.html'?>" title="<?=$products['name']?>" <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
                	<img height="150" width="180" src="<?=$curHost?><?=$products['image']?>" alt="<?=$products['subject']." - ".$products["name"]?>" class="image_frame" style="display: inline;" />
                    <span style="display: none;" class="zoom-wrap"></span>
                	<span style="display: none;" class="img-load-wrap"></span>
                </a>
            <p>
                <?=$products['price']==0? 'Call '.$myphone['detail']:number_format($products['price'],0,',','.').' '.$currencyUnit?>
            </p>
            <p class="hidden-text"><?=strip_tags($products['detail_short'])?></p>
            <div class="clear"></div>
        </div>
        <?=$num%3==0? '<div class="clear"></div>':''?>
    <? }// end while?>
</div>