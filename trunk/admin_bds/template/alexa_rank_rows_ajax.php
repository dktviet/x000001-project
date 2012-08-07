<td align="center" class="smallfont"><?=$i?></td>
<td align="center" class="smallfont"><input class="chk" type="checkbox" name="chk[]" value="<?=$id?>" /></td>
<td class="smallfont" align="center"><?=$id?></td>
<td width="26" align="center" class="smallfont"><span onClick="delrow('<?=$id?>');">Xóa</span></td>
<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$date_added)?></td>
<td class="smallfont" align="center"><?=number_format($rank)?></td>
<td class="smallfont" align="center"><?=$compare?></td>