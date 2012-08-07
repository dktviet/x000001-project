<ul id="main-menu">
    <li>
        <a href="<?=$curHost?>trang-chu.html" <? if($pages=='home' || $pages==''){?>class="active"<? }?>>
        	<span class="l"></span><span class="r"></span><span class="t"><?=_HOME?></span>
        </a>
    </li>	
    <li>
    	<a rel="nofollow" href="<?=$curHost?>gioi-thieu.html" <? if($pages=='intro'){?>class="active"<? }?>>
			<span class="l"></span><span class="r"></span><span class="t"><?=_INTRO?></span>
        </a>
    </li>
    <? echo Draw_Menu($cat_pro,"product");?>
    <? echo Draw_Menu($cat_news,"news");?>
    <li>
    	<a rel="nofollow" href="<?=$curHost?>lien-he.html" <? if($pages=='contact'){?>class="active"<? }?>>
        	<span class="l"></span><span class="r"></span><span class="t"><?=_CONTACT?></span>
        </a>
    </li>
        
</ul>
