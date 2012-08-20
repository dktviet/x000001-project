<td align="center" class="smallfont"><?=$i?></td>
<td align="center" class="smallfont">
	<input class="chk" type="checkbox" name="chk[]" value="<?=$id?>">
</td>
<td class="smallfont" align="center"><?=$id?></td>
<td width="26" align="center" class="smallfont">
	<span onClick="delrow(<?=$id?>);">Xóa</span>
</td>
<td class="smallfont" align="center">
	<span id="name_<?=$id?>" onclick="edit_name('<?=killInjection($name)?>',<?=$id?>);"><?=killInjection($name)?></span>
        <br><hr>
	<span id="parent_name_<?=$id?>" onclick="edit_parent(<?=$id?>);"><?=$get_cat_info['name']?></span>
        <br><hr>
        <span id="seo_key_<?=$id?>" onclick="edit_seo_key('<?=$seo_key?>',<?=$id?>);"><?=$seo_key!=''?$seo_key:'<img src="images/icons/pencil.png" alt="" />'?></span>
</td>
<td class="smallfont" align="center">
	<span id="short_detail_<?=$id?>" onclick="edit_short_detail('<?=$id?>');"><?=$detail_short!=''?'...':'<img src="images/icons/pencil.png" alt="" />'?></span>
</td>
<td class="smallfont" align="center">
	<span id="detail_<?=$id?>" onclick="edit_detail('<?=$id?>');"><?=$detail!=''?'...':'<img src="images/icons/pencil.png" alt="" />'?></span>			
</td>
<td class="smallfont" align="center">
    <img id="image_<?=$id?>" onclick="edit_image('<?=$id?>','<?=$code?>');" src="../<?=$image_thumbs!=''?$image_thumbs:'images/no_image.gif'?>" width="100" alt="" />
    <img onclick="edit_image('<?=$id?>','<?=$code?>');" src="images/icons/pencil.png" alt="" />
</td>
<td class="smallfont" align="center">
<?php
    $get_parent_id = selectOne(tbl_config::tbl_category, 'status=1 AND parent_id=0 AND code = "properties"', 'sort, date_added ASC');
    $parent_id = $get_parent_id['id'];
    $prop_cats = selectMulti(tbl_config::tbl_category, 'id, name', 'status=1 AND parent_id = ' . $parent_id, 'ORDER BY sort, date_added ASC');
    foreach($prop_cats as $prop_cat){
        $sql = 'SELECT prop.id prop_id, ext.id ext_id
                        FROM ' . tbl_config::tbl_product_extend . ' ext
                        INNER JOIN ' . tbl_config::tbl_properties . ' prop
            ON ext.properties_id = prop.id
            WHERE ext.product_id = ' . $id . ' AND prop.parent_id = ' . $prop_cat['id'];
        $get_ext_prod = query($sql);
        if($get_ext_prod){
            foreach($get_ext_prod as $ext_prod){
                echo comboProperties(utf8_to_ascii($prop_cat['name']),getArrayCombo(tbl_config::tbl_properties,'id','name','parent_id = ' . $prop_cat['id']),'smallfont',$ext_prod['prop_id'],1,true,$ext_prod['ext_id'],$id) . '<br>';
            }
        }else{
            echo comboProperties(utf8_to_ascii($prop_cat['name']),getArrayCombo(tbl_config::tbl_properties,'id','name','parent_id = ' . $prop_cat['id']),'smallfont',0,1,true,0,$id) . '<br>';
        }
    }
?>
</td>
<td class="smallfont" align="center">
	<span id="price_num_<?=$id?>" onclick="show_price_input(<?=$id?>);"><?=$price?></span>
	<input type="text" id="price_input_<?=$id?>" name="price_input" onblur="update_price(<?=$id?>,this.value);" value="<?=$price?>" size="2" style="display:none;" />
</td>
<td class="smallfont" align="center">
	<span id="views_num_<?=$id?>" onclick="show_views_input(<?=$id?>);"><?=$views?></span>
	<input type="text" id="views_input_<?=$id?>" name="views_input" onblur="update_views(<?=$id?>,this.value);" value="<?=$views?>" size="2" style="display:none;" />
</td>
<td class="smallfont sort-num" align="center">
   	<img src="images/up.png" alt="" onclick="up_down_sort('<?=$id?>','1');" />
	<div id="sort_num_<?=$id?>" align="center"><?=$sort?></div>
	<img src="images/down.png" alt="" onclick="up_down_sort('<?=$id?>','0');" />
</td>
<td class="smallfont" align="center"><img id="status_icon_<?=$id?>" src="<?=$status==0?'images/uncheck.png':'images/check.png'?>" onclick="show_hide('<?=$id?>','<?=$status>0?'0':'1'?>');" style="cursor:pointer;" /></td>
<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$date_added)?></td>
<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$last_modified)?></td>
