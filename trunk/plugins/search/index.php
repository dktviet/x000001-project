<form name="search" method="post" action="<?=$curHost?>">
    <input type="hidden" name="frame" value="search" />
<? $cat_properties = getRecord('xteam_category','code="properties"');
    $list_properties = getArray('xteam_category', 'parent_id='.$cat_properties['id']);    
    $i=0;
    foreach ($list_properties as $list){?>
    <label for="<?=utf8_to_ascii($list['name'])?>" class="title-search"><?=$list['name']?></label>
    <div class="input">
        <select name="<?=utf8_to_ascii($list['name'])?>">
            <? $list_items = getArray('xteam_properties','parent_id='.$list['id']);
            foreach ($list_items as $item){?>
            <?if($i>0){?>
            <option value="0">--- Chọn <?=$list['name']?> ---</option>
            <? }?>
            <option value="<?=$item['id']?>"><?=$item['name']?></option>
            <? $i=0;}?>
        </select>
    </div>
    <? $i++;}?>
    <input type="submit" name="search" value="Tìm kiếm" class="bottom-search" />
</form>