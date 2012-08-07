<table width="100%">	
<?
$code = $_lang=='vn' ? "vn_skype" : "en_skype";
$sql = "select * from bnk_content where status=0 and parent in (select id from bnk_content_category where code='".$code."') order by sort, date_added";
$result = mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($result)){
?>	
	<tr>
		<td align="center" height="30"><a href="skype:<?=$row['code'];?>?chat"><img src="images/skype.png" style="border: none;" alt="<?=$row['name']?>"/></a></td>
	</tr>
	<tr><td height="20" align="center"><b><?=$row['name']?></b></td></tr>
<? }?>
	<tr><td height="5"></td></tr>
</table>
