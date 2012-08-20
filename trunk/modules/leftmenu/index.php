<? 
$tinbds = getRecord('xteam_category','id=38');
$list_properties = getArray('xteam_properties','parent_id ='.$tinbds['id']);?>
<ul>
    <?
    foreach ($list_properties as $list_propertie){?>
    <li><a href="<?=$curHost.$list_propertie['id']?>-category/<?=str_replace(' ', '-', $list_propertie['name'])?>.html"><?=$list_propertie['name']?></a></li>
    <? }?>
</ul>
