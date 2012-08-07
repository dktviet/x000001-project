<table width="100%">
<?
$sql = "select * from yahoo_sky where active=0";
$result = mysql_query($sql,$conn);
if(!empty($result))
while($row=mysql_fetch_assoc($result)){
?>
	<tr><td height="20" align="center" colspan="2" class="text_xanh"><?=$row['fullname']?></td></tr>
	<tr>
		
		<td align="center" height="30">
			<a href="ymsgr:sendIM?<?=$row['username']?>">
			<img border="0" src="http://mail.opi.yahoo.com/online?u=<?=$row['username']?>&m=g&t=2" alt="<?=$row['name']?>"></a>
		</td>
	</tr>
	
<? }?>

</table>
