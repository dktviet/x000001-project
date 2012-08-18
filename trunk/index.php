<?php
session_start();
require("config.php");
require("common_start.php");
require("lib/func.lib.php");
require("validate.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
<title><?=$title?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<? $key_arr =  explode(", ", $mykeywords['detail']);
	$Strkey='';
	foreach($key_arr as $key){
		$Strkey.=", ".convert_key($key);
}?>
<meta name="keywords" content="<?=$mykeywords['detail'].$Strkey?>" />
<meta name="description" content="<?=$description?>" />
<link rel="stylesheet" href="<?=$curHost?>css/styles.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=$curHost?>lib/cssIndex.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?=$curHost?>js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?=$curHost?>Scripts/swfobject_modified.js"></script>
<script type="text/javascript" language="javascript" src="<?=$curHost?>lib/javascript.lib.js"></script>
<script type="text/javascript" language="javascript" src="<?=$curHost?>lib/varAlert.<?=$_lang?>.unicode.js"></script>
<script type="text/javascript" language="javascript">
	$(document).ready(function(){
		$('#adv-left').css('position','absolute');
		$('#adv-left').css('top','465px');
		$('#adv-left').css('bottom','');
		$('#adv-right').css('position','absolute');
		$('#adv-right').css('bottom','');
		$('#adv-right').css('top','465px');
		$(window).scroll(function(){
			if($(this).scrollTop()<=250){
				$('#adv-left').css('position','absolute');
				$('#adv-left').css('top','465px');
				$('#adv-left').css('bottom','');
				$('#adv-right').css('position','absolute');
				$('#adv-right').css('top','465px');
				$('#adv-right').css('bottom','');
			}else{
				$('#adv-left').css('position','fixed');
				$('#adv-left').css('bottom','0');
				$('#adv-left').css('top','');
				$('#adv-right').css('position','fixed');
				$('#adv-right').css('bottom','0');
				$('#adv-right').css('top','');
			}
		});
	});
</script>
</head>
<body>
    <div id="slider">
        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="1440" height="465" id="FlashID" title="batdóngan6699.com">
            <param name="movie" value="<?=$curHost?>images/bg.swf" />
            <param name="quality" value="high" />
            <param name="wmode" value="opaque" />
            <param name="swfversion" value="9.0.45.0" />
            <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
            <param name="expressinstall" value="<?=$curHost?>Scripts/expressInstall.swf" />
            <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
            <!--[if !IE]>-->
            <object type="application/x-shockwave-flash" data="<?=$curHost?>images/bg.swf" width="1440" height="465">
            <!--<![endif]-->
            <param name="quality" value="high" />
            <param name="wmode" value="opaque" />
            <param name="swfversion" value="9.0.45.0" />
            <param name="expressinstall" value="<?=$curHost?>Scripts/expressInstall.swf" />
            <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
            <div>
                <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>
            </div>
            <!--[if !IE]>-->
            </object>
        <!--<![endif]-->
        </object>
    </div>
    <div id="main-body">
    	
        <div id="head">
        	<div class="contain-head">
                <h1 id="logo"><a href="#"><?=$mykeywords['detail'].$Strkey?></a></h1>
                <div id="main-menu">
                	<div class="nav-left"></div>
                    <ul id="menu-bar">
                        <li><a href="#" class="active first">Trang chủ</a></li>
                        <li><a href="#">Chung cư</a></li>
                        <li><a href="#">Văn phòng cho thuê</a></li>
                        <li><a href="#">Nhà - Biệt thự</a></li>
                        <li><a href="#">Tin tức</a></li>
                        <li><a href="#" nofllow class="last">Liên hệ</a></li>
                    </ul>
                    <div class="nav-right"></div>
                </div>
            </div>
            <!-- end contain-->
        </div>
        <div id="adv-left">
                <img src="<?=$curHost?>images/img01.jpg" alt="Quảng cáo trái" />
            </div>
            <!-- end adv-left-->
            <div id="adv-right">
                <img src="<?=$curHost?>images/img01.jpg" alt="Quảng cáo phải" />
            </div>
            <!-- end adv-right-->
        <!-- end head-->
        <div id="main-content">
        	
           	
        	<div id="flash-news">
                <div class="title-flash">Tin tức</div>
                <marquee   direction="left"   scrollamount="3" onmouseover="this.stop()" onmouseout="this.start()">
                <ul>
                    <li class="news-item"><a href="#">Hà nội có liên minh bất động sản đầu tiên</a></li>
                    <li class="news-item"><a href="#">Giá đất liên tục giảm mạnh, nhà đầu tư lao đao</a></li>
                    <li class="news-item"><a href="#">1000 căn hộ xây rồi bỏ hoang</a></li>
                    <li class="news-item"><a href="#">Khoản đầu tư 1000 tỷ để cứu thị trường địa ốc</a></li>
                    <li class="news-item"><a href="#">Bất động sản vẫn ngủ yên, nhà đầu tư mất trắng</a></li>
                </ul>
                </marquee>
            </div>
            <!-- end flash-news-->
        	<div class="right">
            	<div id="search">
                	<h3 class="head-module">Tìm kiếm</h3>
                    <div class="search-content">
                    	<form name="search" method="post">
                        	<div class="radio">
                            	<input type="radio" name="type" checked="checked" id="chothue" /><label for="chothue">Cho thuê</label><br />
                            </div>
                            <div class="radio">
                            	<input type="radio" name="type" value="Bán" id="ban" /><label for="ban">Bán</label>
                            </div>
                            <label for="area" class="title-search">Khu vực</label>
                            <div class="input">
                            	<select name="area" id="area">
                                	<option value="0">Chọn khu vực</option>
                                    <option value="0">Hà nội</option>
                                    <option value="0">Hồ chí minh</option>
                                </select>
                            </div>
                            <label for="price" class="title-search">Khoảng giá</label>
                            <div class="input">
                            	<select name="khuvuc" id="price">
                                	<option value="0">Chọn khoảng giá</option>
                                    <option value="1">100tr - 200tr</option>
                                    <option value="2">200tr - 300tr</option>
                                </select>
                            </div>
                            <label for="acreage" class="title-search">Diện tích</label>
                            <div class="input">
                            	<select name="acreage" id="acreage">
                                	<option value="0">Chọn khoảng giá</option>
                                    <option value="1">30m2</option>
                                    <option value="2">40m2</option>
                                    <option value="2">50m2</option>
                                    <option value="2">60m2</option>
                                    <option value="2">70m2</option>
                                    <option value="2">80m2</option>
                                    <option value="2">90m2</option>
                                    <option value="2">100m2</option>
                                </select>
                            </div>
                            <label for="direction" class="title-search">Hường nhà</label>
                            <div class="input">
                            	<select name="direction" id="direction">
                                	<option value="0">Chọn khoảng giá</option>
                                    <option value="1">100tr - 200tr</option>
                                    <option value="2">200tr - 300tr</option>
                                </select>
                            </div>
                            <input type="submit" name="search" value="Tìm kiếm" class="bottom-search" />
                        </form>
                    </div>
                </div>
                <!-- end search-->
                <div id="menu-right">
                	<h3 class="head-module">Chuyên mục chính</h3>
                    <div class="menu-right-top"></div>
                	<ul>
                    	<li><a href="#" class="active">Cần bán</a></li>
                        <li><a href="#">Cần mua</a></li>
                        <li><a href="#">Cho thuê</a></li>
                        <li><a href="#">Dự án</a></li>
                        <li><a href="#">Tin tức</a></li>
                    </ul>
                    <div class="menu-right-bottom"></div>
                </div>
                <!-- end menu-right-->
                <div id="support">
                	<h3 class="head-module">Hỗ trợ trực tuyến</h3>
                    <div class="menu-right-top"></div>
                    <ul>
                        <li style="display:block; background: none;">
                            <a href="ymsgr:sendim?nguyentuandung172"><img align="middle" style="border: medium none;" src="http://opi.yahoo.com/online?u=nguyentuandung172&amp;m=g&amp;t=1&amp;1=us" alt="Mr. Dũng"></a> Mr. Dũng - ĐT: 0974 036 579</li>
                        <li style="display:block; background: none;">
                            <a href="ymsgr:sendim?bnkhanhk2t1"><img align="middle" style="border: medium none;" src="http://opi.yahoo.com/online?u=bnkhanhk2t1&amp;m=g&amp;t=1&amp;1=us" alt="Mr. Khánh"></a> Mr. Khánh - ĐT: 0919 416 222</li>
                        <li style="display:block; background: none;">
                            <a href="ymsgr:sendim?hero_td_2004"><img align="middle" style="border: medium none;" src="http://opi.yahoo.com/online?u=hero_td_2004&amp;m=g&amp;t=1&amp;1=us" alt="Mr. Chinh"></a> Mr. Chinh - ĐT: 0979 601 731</li>
                    </ul>
                    <div class="menu-right-bottom"></div>
                </div>
                <!-- end support-->
                <div id="adv">
                	<a href="#"><img src="<?=$curHost?>images/quangcao.png" alt="quang cáo" /></a>
                </div>
                <div id="news-letter">
                	<a href="#"><img src="<?=$curHost?>images/newsletter.jpg" alt="quang cáo" /></a>
                </div>
                <div class="clear"></div>
                <!-- end adv-->
            </div>
            <!-- end right-->
            <div id="contain">
                <div id="content-news">
                	<h2 class="title-cat iconhome">
                        <? require_once "modules/processTitle.php";
                        echo $pages;
                        ?>
                        <? if($pages==='' || $pages==='home'){?>
                    	<a class="readmore" href="<?=$curHost?>/san-pham.html"><span>[+]</span>&nbsp;&nbsp;Xem tất</a>
                        <? }?>
                    </h2>
                    <? if($pages==='' || $pages==='home'){}else{?>
                    <div class="line-head"></div>
                    <? }?>
                    <? //require_once "modules/products/product_home.php";
					require_once "modules/processFrame.php";?>
                    <div class="clear"></div>
                </div>
                <!-- end content-news-->
            </div>
            <!-- end main-content-->
        </div>
        <!-- end contain-->
        <div id="footer">
        	<div class="contain">
            	<div id="copy-right">
                	Copyright &copy; <a href="mailto:ckvicvn@gmail.com">ckvicvn@gmail.com</a> - phone: 0919416222<br />
                    Create by <a href="http://ckvic.com">CKVICDESIGN</a> - Email: ckvicvn@gmail.com
                </div>
                <div class="right">
                	<ul id="menu-bottom">
                    	<li><a href="<?=$curHost?>">Trang chủ</a></li>
                        <li><a href="<?=$curHost?>gioi-thieu.html" rel="nofollow">Giới thiệu</a></li>
                        <li><a href="">Tin tức</a></li>
                        <li><a href="<?=$curHost?>lien-he.html" rel="nofollow">Liên hệ</a></li>
                        <li><a href="<?=$curHost?>site-map.html">Sitemap</a></li>
                    </ul>
                    <br />ckvic.com - Ckvicdesign.Ltd
                </div>
                <div class="clear"></div>
            </div>
            <!-- end contain-->
        </div>
        <!-- end footer-->
    </div>
    <!-- end main-->
<script type="text/javascript">
swfobject.registerObject("FlashID");
    </script>
</body>
</html>
