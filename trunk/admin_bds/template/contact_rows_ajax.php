<td align="center" class="smallfont"><?=$i?></td>
<td align="center" class="smallfont">
	<input class="chk" type="checkbox" name="chk[]" value="<?=$id?>">
</td>
<td class="smallfont" align="center"><?=$id?></td>
<td width="26" align="center" class="smallfont">
	<span onClick="delrow('<?=$id?>');">Xóa</span>
</td>
<td class="smallfont" align="center">
	<span><?=$name_vn?></span>
</td>
<td class="smallfont" align="center">
	<span><?=$short_vn?></span>			
</td>
<td class="smallfont" align="center">
	<span><?=$detail_vn?></span>			
</td>
<td class="smallfont" align="center"><img id="status_icon_<?=$id?>" src="<?=$status>0?'images/uncheck.png':'images/check.png'?>" onclick="show_hide('<?=$id?>','<?=$status>0?'0':'1'?>');" style="cursor:pointer;" /></td>
<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$date_added)?></td>
