<?
$tbl_content = "xteam_product";
$product = getRecord("xteam_product", "id=".$cat);
$ali = $_GET['ali'];
$urlshare = $curHost.'1/'.$cat.'/'.$ali.'.html';?>
<div class="description">
    <? if($product["image_large"]!=''){?>
        <div class="img" style="position:relative;">
            <a href="<?=$lightbox==1 ? $curHost.$product['image_large'] : $curHost.$product['id'].'-'.$product['subject'].'/1-'.$product['name'].'.html'?>"  <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
                <img alt="<?=$product["subject"]." - ".$product["name"]?>" src="<?=$curHost?><?=$product["image"]?>" class="imgsp" />
            </a>
        </div>
    <? }?>
    <div style="height: 25px; line-height: 25px; color: #50ABD1; font-weight: bold;">Thông tin chung</div>
    <ul>
        <li><label>Loại bất động sản:</label><span>Chung cư</span></li>
        <li><label>Vị trí:</label><span>Hà nội</span></li>
        <li><label>Hướng:</label><span>Nam</span></li>
        <li><label>diện tích:</label><span>100-150m2</span></li>
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
    $parentWhere = "parent_id = ".$product['parent_id'];
    $sql = "SELECT * FROM $tbl_content WHERE status=0 AND id <>".$product['id']." AND ".$parentWhere."  ORDER BY rand()";
    $result = @mysql_query($sql,$conn);
    $num = 0;
    while($products=mysql_fetch_assoc($result)){
        $num++;
        $class = $num%2!==0? 'block-left' : 'block-right';
        ?>
        <div class="<?=$class?>">
            <h2 class="title-news"><a href="<?=$curHost.$products['id'].'-'.str_replace(' ','-',$products['subject'])?>/1-<?=str_replace(' ','-',$products['name'])?>.html"><?=catchu($products['name'],30)?></a></h2>
            <a href="<?=$lightbox==1 ? $curHost.$products['image_large'] : $curHost.$products['id'].'-'.str_replace(' ','-',$products['subject']).'/1-'.str_replace(' ','-',$products['name']).'.html'?>" title="<?=$products['name']?>" <?=$lightbox==1 ? ' rel="prettyPhoto[gallery1]" class="zoom-img load-img"' : ''?>>
                <img src="<?=$curHost?><?=$products['image']?>" alt="<?=$products['subject']." - ".$products["name"]?>" class="img-news" style="display: inline;" />
            </a>
            <div class="short-news"><?=catchu(strip_tags($products['detail_short']),200)?></div>
        </div>
        <?
        if($num%2==0 || $num >=count($product)){
            echo '<div class="clear"></div></div><div class="block-news">';
        }?>
    <? }// end while?>
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