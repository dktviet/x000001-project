<div class="content-new">
<?
$news_detail = getRecord('xteam_news','id='.$cat);
	?>
    <h2><?=$news_detail["name"]?></h2>
    <div style="text-align:justify;">
        <?=$news_detail["detail"]?>
        <? require_once "plugins/footer_contact.html";?>
    </div>
    <div class="cleared"></div>
    <div class="newscungloai">
        <span class="date-tag">
            <?php
                if($_lang=="vn") echo "Các tin khác"; 
                else if($_lang=="en") echo "Other news"; 
                else echo "其他新聞";
            ?>
        </span>
        <br />
        <blockquote>
        <ul>
		<? $news_same=getArray('xteam_news','parent='.$news_detail['parent'].' AND id<>'.$cat);
        foreach($news_same as $Item_same){?>
            <li><a href="<?=$curHost.$Item_same['id'].'-'.$Item_same['subject']?>/3-<?=str_replace(' ','-',$Item_same['name'])?>.html"><?=$Item_same['name']?></a></li>
        <?	if(++$rows>=$MAXPAGE)break;
        }?>
        </ul>
        </blockquote>
    </div>
</div>