<div class="anchorRight shareDropDown">
    <span class="shareHead"><a class="linkIcon share">Share</a></span>
    <div class="shareContent"> 
        <ul class="shareLinks left"> 
            <li><a href="https://www.facebook.com/share.php?u=<?=$urlshare?>" title="Post to Facebook" class="linkIcon facebook" target="_blank">Facebook</a></li> 
            <li><a href="http://twitter.com/share?url=<?=$urlshare?>&counturl=<?=$urlshare?>&via=<?=$product['name']?>&text=<?=$product['name']?>" title="Tweet this page" class="linkIcon twitter" target="_blank">Twitter</a></li>
            <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?=$urlshare?>&title=<?=$product['name']?>&summary=<?=catchu(strip_tags($product['detail']),200)?>&source=<?=$curHost?>" title="Post to LinkedIn" class="linkIcon linkedin" target="_blank">LinkedIn</a></li>
            <li><a href="http://digg.com/submit?phase=2&url=<?=$urlshare?>&title=<?=$product['name']?>&bodytext=<?=catchu(strip_tags($product['detail']),200)?>&topic=" title="Digg this story" class="linkIcon digg" target="_blank">Digg</a></li>
        </ul>
        <ul class="shareLinks right"> 
            <li><a href="http://del.icio.us/post?url=<?=$urlshare?>&title=<?=$product['name']?>&notes=<?=catchu(strip_tags($product['detail']),200)?>" title="Add to your del.icio.us account" class="linkIcon delicious" target="_blank">Delicious</a></li> 
            <li><a href="http://reddit.com/submit?url=<?=$urlshare?>&title=<?=$product['name']?>" title="Add to Reddit" class="linkIcon reddit" target="_blank">Reddit</a></li> 
            <li><a href="http://link.apps.zing.vn/share?u=<?=$urlshare?>&title=<?=$product['name']?>" title="Post to Me ZING" class="linkIcon stumble" target="_blank">Me zing</a></li> 
            <li><a href="http://www.google.com/bookmarks/mark?op=add&bkmk=<?=$urlshare?>&title=<?=$product['name']?>" title="Post to Google Bookmarks" class="linkIcon google" target="_blank">Google Bookmarks</a></li>
        </ul>
    </div>
</div>

<style type="text/css">
#shareDropDown,.shareDropDown{position:relative;float:right;}
#shareDropDown shareHead,.shareDropDown shareHead{z-index:100;}
#shareDropDown .shareContent,.shareDropDown .shareContent{background:#fff;-webkit-border-radius:3px 0 3px 3px;-moz-border-radius:3px 0 3px 3px;border-radius:3px 0 3px 3px;-webkit-box-shadow:0 3px 3px rgba(0,0,0,0.4);-moz-box-shadow:0 3px 3px rgba(0,0,0,0.4);box-shadow:0 3px 3px rgba(0,0,0,0.4);clear:both!important;display:none;top:23px;position:absolute;right:0;width:281px;z-index:5500000;zoom:1;_display:inline-block;}
#shareDropDown .shareContent:after,.shareDropDown .shareContent:after{content:".";display:block;height:0;clear:both;visibility:hidden;}
#shareDropDown:hover .shareContent,.shareDropDown:hover .shareContent{display:block;}
#shareDropDown.anchorLeft .shareHead a,.shareDropDown.anchorLeft .shareHead a{float:left;}
#shareDropDown.anchorRight .shareHead a,.shareDropDown.anchorRight .shareHead a{float:right;}
#shareDropDown .shareHead a,.shareDropDown .shareHead a{-webkit-box-shadow:0 1px 0 0 rgba(255,255,255,0.4) inset;-moz-box-shadow:0 1px 0 0 rgba(255,255,255,0.4) inset;box-shadow:0 1px 0 0 rgba(255,255,255,0.4) inset;border-bottom:none;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;}
.shareContent ul{background:#fff;-webkit-border-radius:3px 0 0 3px;-moz-border-radius:3px 0 0 3px;border-radius:3px 0 0 3px;float:left;padding:10px 20px 5px 10px;}
.shareContent ul.right{-webkit-border-radius:0 3px 3px 0;-moz-border-radius:0 3px 3px 0;border-radius:0 3px 3px 0;}
.shareContent ul li{height:25px; display:block;}
.shareContent ul li a{display:block;height:16px;padding-left:25px;font-size:1.03em;line-height:1.2em;color:#2964BF;}
.shareContent ul li img{height:16px;width:16px;display:block;float:left;padding-left:1px;}
.shareContent .tumblr{display:block;overflow:hidden;height:20px;padding-left:9px;background:none;padding-top:1px;}
.shareLinks a{background:url("../../images/icon-sprite.png") no-repeat;}
.shareLinks .email{background-position:0 -2069px;}
.shareLinks .print{background-position:0 -2088px;}
.shareLinks .facebook{background-position:-1px -1842px;}
.shareLinks .delicious{background-position:0 -2171px;}
.shareLinks .twitter{background-position:-4px -1486px;}
.shareLinks .reddit{background-position:0 -2192px;}
.shareLinks .linkedin{background-position:0 -2129px;}
.shareLinks .stumble{background-position:0 -2108px;}
.shareLinks .digg{background-position:0 -2150px;}
.shareLinks .google{background-position:0 -2213px;}
.shareLinks .pin{background-position:0 -2255px;}
.shareLinks .tumblr{background-position:0 -2234px;}
a, a:link, a:hover{cursor: pointer;outline: medium none;text-decoration: none;}
a, a:hover{text-decoration:underline;}
a.share {background: url("../../images/icon-sprite.png") no-repeat scroll 1px -327px, -moz-linear-gradient(center top , #D7D8D9 0pt, #AAAAAB 100%) repeat scroll 0 0 transparent;border: 1px solid #A7A7A8;border-radius: 3px 3px 3px 3px;box-shadow: 0 1px 0 #8B8B90, 0 1px 0 0 rgba(255, 255, 255, 0.4) inset;color: #39434C;display: block;font-family: franklin-gothic-urw-cond,"Helvetica Condensed Bold",Helvetica,Arial,sans-serif;font-size: 0.8667em;font-weight: 500;height: 21px;line-height: 21px !important;padding: 0 5px 0 22px;position: relative;text-shadow: 0 1px 0 rgba(255, 255, 255, 0.65);z-index: 100;text-decoration:none;}
</style>