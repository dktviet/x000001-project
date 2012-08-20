<?
$top_menu = getArray('xteam_category','status=1 AND top_menu=1',NULL,'sort');
?>
<ul id="menu-bar">
    <li>
        <a href="<?=$curHost?>trang-chu.html" class="first <? if($pages=='home' || $pages==''){?>active<? }?>">
        	<span class="l"></span><span class="r"></span><span class="t"><?=_HOME?></span>
        </a>
    </li>	
    <li>
    	<a rel="nofollow" href="<?=$curHost?>gioi-thieu.html" <? if($pages=='intro'){?>class="active"<? }?>>
			<span class="l"></span><span class="r"></span><span class="t"><?=_INTRO?></span>
        </a>
    </li>
    <? echo Draw_Menu($top_menu,"product");?>
    <li>
        <a href="<?=$curHost.$getnews['id']?>-<?=$getnews['seo_key']?>/6-<?=$getnews['name']?>.html"><?=$getnews['name']?></a>
        <ul>
            <? echo Draw_Menu($cat_news,"news");?>
        </ul>
    </li>
    <li>
    	<a rel="nofollow" href="<?=$curHost?>lien-he.html" class="last <? if($pages=='contact'){?>active<? }?>">
        	<span class="l"></span><span class="r"></span><span class="t"><?=_CONTACT?></span>
        </a>
    </li>
        
</ul>
