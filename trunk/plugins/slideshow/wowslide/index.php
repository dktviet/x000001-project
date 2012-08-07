<link rel="stylesheet" type="text/css" href="<?=$curHost?>plugins/slideshow/wowslide/style.css" />
<style type="text/css">a#vlb{display:none}</style>

<script type="text/javascript" src="<?=$curHost?>plugins/slideshow/wowslide/wowslider.js"></script>
<div id="wowslider-container1">
	<div class="ws_images">
		<?
        $code = 'vn_advdown';
        $parentWhere = "parent = (select id from bnk_content_category where code='$code')";
        $sql = "select * from bnk_content where status=0 and $parentWhere order by sort,date_added";
        $result = @mysql_query($sql,$conn);
        while($row=mysql_fetch_assoc($result)){
            $i++;
        ?>
        <span><img src="<?=$curHost.$row["image_large"]?>" alt="<?=$row["name"]?>" title="<?=$row["name"]?>" id="wows<?=$i?>" width="440" height="220" /></span>
    	<? }?>
	</div>
    <div class="ws_bullets">
    	<div>
			<? while($row=mysql_fetch_assoc($result)){
            $j++;?>
            <a href="#wows<?=$j?>" title="advdown_s14"><img src="<?=$curHost.$row["image"]?>" alt="<?=$row["name"]?>" title="<?=$row["name"]?>" id="wows<?=$i?>" /><?=$j?></a>
			<? }?>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?=$curHost?>plugins/slideshow/wowslide/script.js"></script>