<!-- slideshow-->

<script type="text/javascript"   src="<?=$curHost?>plugins/slideshow/nivo/jquery.cycle.min.js"></script>	
<link rel="stylesheet" type="text/css" href="<?=$curHost?>plugins/slideshow/nivo/slide.css" />
<script type="text/javascript" src="<?=$curHost?>plugins/slideshow/nivo/nivo.slider.packed.js"></script>
<!-- end slideshow-->
<div id="header_under_cycle" class="">
<div id="cycle_loader"></div>
<div id="cycle_wrapper">
<?
        $code = 'vn_advdown';
        $parentWhere = "parent = (select id from bnk_content_category where code='$code')";
        $sql = "select * from bnk_content where status=0 and $parentWhere order by sort,date_added";
        $result = @mysql_query($sql,$conn);
        while($row=mysql_fetch_assoc($result)){
        ?>
	
    <div class="c_slide">
                
        <div class="cycle_left">
            <!--<h2 class="cycle_header"><?=$row["name"]?></h2>-->
            <p><?=$row["detail_short"]?></p>
                    
            <div class="cleared"></div>
            
        </div><!-- /cycle_left -->	
        
        <div class="cycle_right">
            <span class="cycle_image_anchor"><img src="<?=$curHost.$row["image_large"]?>" alt="<?=$row["name"]?>" title="<?=$row["name"]?>" id="wows<?=$i?>" width="440" height="220" /></span>
        </div><!-- /cycle_right -->
        
        <div class="cleared"></div>
    </div>
<? }?>
</div>
<div id="cycle_positioner">
	
	<div id="cycle_nav"></div>
</div>
</div>
<script type="text/javascript">
		
	jQuery(window).load(function() {
		
		// Initialise Nivo Slider
		jQuery("#slider").nivoSlider({
			effect:"fade", 
			animSpeed:1000, 
			pauseOnHover:true, 
			pauseTime:5000, 
			directionNav:false
		});
		// Fade in Sliders once all images are loaded
		jQuery(".nivoSlider, #cycle_wrapper").fadeTo(1000, 1);
		// Initialise Nivo Slider
		jQuery("#cycle_wrapper").cycle({
			speed:  1000, 
			pause:true, 
			timeout:5000, 
			pager:  "#cycle_nav",
			before: stopVideo,
			after: stopVideo
		});
		function stopVideo() {
			jQuery.each(jQuery("iframe"), function() {
				jQuery(this).attr({
					scr: jQuery(this).attr("scr")
				});
			});
			return false;
		}
		//Pixastic Desaturate Controls
		jQuery(".pixastic_logo, .bw, .desaturate").pixastic("desaturate");

		//Load in the Porfolio Vignettes 
		jQuery(".portfolio_item_4_col span.vignette_portfolio  span").fadeIn(300);
		jQuery("#cycle_loader").fadeOut(300);
		
	});
</script>