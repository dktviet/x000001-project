<td align="center" class="smallfont"><?=$i?></td>
<td align="center" class="smallfont">
	<input class="chk" type="checkbox" name="chk[]" value="<?=$id?>">
</td>
<td class="smallfont" align="center"><?=$id?></td>
<td width="26" align="center" class="smallfont">
	<span onClick="delrow('<?=$id?>');">Xóa</span>
</td>
<td class="smallfont" align="center">
	<span id="name_vn_<?=$id?>" onclick="edit_name('<?=killInjection($name_vn)?>','<?=killInjection($name_en)?>','<?=$id?>');" title="Name: <?=$name_en!=''?killInjection($name_en):'Rỗng'?>"><?=killInjection($name_vn)?></span>
</td>
<td class="smallfont" align="center"><img id="image_<?=$id?>" onclick="edit_image('<?=$id?>','<?=$code?>');" src="<?=$image_thumbs!=''?'../'.$image_thumbs:'images/no_image.gif'?>" width="100" alt="" /></td>
<td class="smallfont sort-num" align="center">
   	<img src="images/up.png" alt="" onclick="up_down_sort('<?=$id?>','1');" />
	<div id="sort_num_<?=$id?>" align="center"><?=$sort?></div>
	<img src="images/down.png" alt="" onclick="up_down_sort('<?=$id?>','0');" />
</td>
<td class="smallfont" align="center"><img id="status_icon_<?=$id?>" src="<?=$status>0?'images/uncheck.png':'images/check.png'?>" onclick="show_hide('<?=$id?>','<?=$status>0?'0':'1'?>');" style="cursor:pointer;" /></td>
<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$date_added)?></td>
<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$last_modified)?></td>
