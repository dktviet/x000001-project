<div class="block-news">
<?
$parent_id = getRecord('xteam_category', 'code="product"');
$parents = getArray('xteam_category','parent_id='.$parent_id['id']);
$parname = array();
$parid = array();
foreach ($parents as $parent){
    $parname[$parent['id']] = $parent['name'];
    $parid[$parent['id']] = $parent['id'];
}
$per_page=14;
for($i=0;$i<$per_page;$i++){
	$class = $i%2!==0? 'block-left' : 'block-right';
    if($parid[$top_pro[$i]['parent_id']]%2==0){$class_sp="rental";}else{$class_sp="salse";}
    ?>
	<div class="<?=$class?>">
    	<h3 class="title-news">
        	<a href="<?=$curHost.$top_pro[$i]['id']."-".str_replace(' ','-',$top_pro[$i]['seo_key'])?>/1-<?=str_replace(' ','-',$top_pro[$i]['name'])?>.html">
            	<span class="<?=$class_sp?>"><?=$parname[$top_pro[$i]['parent_id']]?> | </span><?=$top_pro[$i]['name']?>
			</a>
        </h3>
        <a href="<?=$curHost.$top_pro[$i]['id']."-".str_replace(' ','-',$top_pro[$i]['seo_key'])?>/1-<?=str_replace(' ','-',$top_pro[$i]['name'])?>.html">
        	<img src="<?=$curHost.$top_pro[$i]['image_thumbs']?>" alt="<?=$top_pro[$i]['seo_key'].'-'.$top_pro[$i]['name']?>" class="img-news">
        </a>
        <div class="short-news">
        	<?=catchu($top_pro[$i]['detail_short'],200)?>
        </div>
	</div>
	
<?
if($i%2!==0 && $i<$per_page)
	echo '<div class="clear"></div></div><div class="block-news">';
}
?>
</div>
<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		var contentdiv = $('.block-news').text(function(){
			if ($(this).text()==''){
				$(this).hide();
			}
        });
	})
</script>