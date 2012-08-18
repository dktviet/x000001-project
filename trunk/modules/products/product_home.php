<div class="block-news">
<?
$per_page=14;
for($i=0;$i<$per_page;$i++){
	$class = $i%2!==0? 'block-left' : 'block-right';?>
	<div class="<?=$class?>">
    	<h3 class="title-news">
        	<a href="<?=$curHost.$top_pro[$i]['id']."-".str_replace(' ','-',$top_pro[$i]['seo_key'])?>/1-<?=str_replace(' ','-',$top_pro[$i]['name'])?>.html">
            	<span class="rental">Rental | </span><?=$top_pro[$i]['name']?>
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