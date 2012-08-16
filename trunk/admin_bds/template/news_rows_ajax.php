<td align="center" class="smallfont"><?=$i?></td>
<td align="center" class="smallfont">
	<input class="chk" type="checkbox" name="chk[]" value="<?=$id?>">
</td>
<td class="smallfont" align="center"><?=$id?></td>
<td width="26" align="center" class="smallfont">
	<span onClick="delrow('<?=$id?>');">Xóa</span>
</td>
<td class="smallfont" align="center">
	<span id="name_<?=$id?>" onclick="edit_name('<?=killInjection($name)?>','<?=$id?>');"><?=killInjection($name)?></span>
</td>
<td class="smallfont" align="center">
	<span id="parent_name_<?=$id?>" onclick="edit_parent(<?=$id?>);"><?=$get_cat_info['name']?></span>
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
	<span id="views_num_<?=$id?>" onclick="show_views_input('<?=$id?>','<?=$views?>');"><?=$views?></span>
	<input type="text" id="views_input_<?=$id?>" name="views_input" onblur="update_views('<?=$id?>',this.value);" value="<?=$views?>" size="2" style="display:none;" />
</td>
<td class="smallfont sort-num" align="center">
   	<img src="images/up.png" alt="" onclick="up_down_sort('<?=$id?>','1');" />
	<div id="sort_num_<?=$id?>" align="center"><?=$sort?></div>
	<img src="images/down.png" alt="" onclick="up_down_sort('<?=$id?>','0');" />
</td>
<td class="smallfont" align="center"><img id="status_icon_<?=$id?>" src="<?=$status == 0?'images/uncheck.png':'images/check.png'?>" onclick="show_hide('<?=$id?>','<?=$status>0?'0':'1'?>');" style="cursor:pointer;" /></td>
<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$date_added)?></td>
<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$last_modified)?></td>
