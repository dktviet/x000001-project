<!-- slide home BEGIN -->
<link href="<?=CUR_HOST?>plugins/fade_slide_weather/fade_slideshow.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
	function slideSwitch() {
		var $active = $('#slideshow div.active');
	
		if ( $active.length == 0 ) $active = $('#slideshow div:last');
	
		// use this to pull the images in the order they appear in the markup
		var $next =  $active.next().length ? $active.next()
			: $('#slideshow div:first');
	
		// uncomment the 3 lines below to pull the images in random order
		
		 //var $sibs  = $active.siblings();
		 //var rndNum = Math.floor(Math.random() * $sibs.length );
		 //var $next  = $( $sibs[ rndNum ] );
	
	
		$active.addClass('last-active');
	
		$next.css({opacity: 0.0})
			.addClass('active')
			.animate({opacity: 1.0}, 1000, function() {
				$active.removeClass('active last-active');
			});
	}
	
	$(function() {
		setInterval( "slideSwitch()", 5000 );
	});
</script>
<!-- slide home END -->
<div id="slideshow">
    <div class="active"> 
    <p><embed title="Free Online Weather for WordPress, Blogspot, Blogger, Drupal, TypePad, MySpace, Facebook, Bebo, Piczo, Xanga, Freewebs, Netvibes, Pageflakes, iGoogle and other blogs and web pages" src="http://www.weatherlet.com/weather.swf?locid=VMXX0006&unit=m" quality="high" wmode="transparent" bgcolor="#CC00CC" width="148" height="83" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></p></div>
    <div>
    <p><embed title="Free Online Weather for WordPress, Blogspot, Blogger, Drupal, TypePad, MySpace, Facebook, Bebo, Piczo, Xanga, Freewebs, Netvibes, Pageflakes, iGoogle and other blogs and web pages" src="http://www.weatherlet.com/weather.swf?locid=VMXX0007&unit=m" quality="high" wmode="transparent" bgcolor="#CC00CC" width="148" height="76" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></p></div>
    <div>
    <p><embed title="Free Online Weather for WordPress, Blogspot, Blogger, Drupal, TypePad, MySpace, Facebook, Bebo, Piczo, Xanga, Freewebs, Netvibes, Pageflakes, iGoogle and other blogs and web pages" src="http://www.weatherlet.com/weather.swf?locid=VMXX0029&unit=m" quality="high" wmode="transparent" bgcolor="#CC00CC" width="148" height="76" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></p></div>
    <div>
    <p>
      <embed title="Free Online Weather for WordPress, Blogspot, Blogger, Drupal, TypePad, MySpace, Facebook, Bebo, Piczo, Xanga, Freewebs, Netvibes, Pageflakes, iGoogle and other blogs and web pages" src="http://www.weatherlet.com/weather.swf?locid=VMXX0004&unit=m" quality="high" wmode="transparent" bgcolor="#CC00CC" width="149" height="76" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></p></div> 
    <div>
    <p><embed title="Free Online Weather for WordPress, Blogspot, Blogger, Drupal, TypePad, MySpace, Facebook, Bebo, Piczo, Xanga, Freewebs, Netvibes, Pageflakes, iGoogle and other blogs and web pages" src="http://www.weatherlet.com/weather.swf?locid=VMXX0028&unit=m" quality="high" wmode="transparent" bgcolor="#CC00CC" width="149" height="76" align="middle" allowScriptAccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></p></div>
    <div>
         <p>
           <embed title="Free Online Weather for WordPress, Blogspot, Blogger, Drupal, TypePad, MySpace, Facebook, Bebo, Piczo, Xanga, Freewebs, Netvibes, Pageflakes, iGoogle and other blogs and web pages" src="http://www.weatherlet.com/weather.swf?locid=VMXX0020&unit=m" quality="high" wmode="transparent" bgcolor="#CC00CC" width="148" height="76" align="middle" allowscriptaccess="sameDomain" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />      
    </div>
</div>
