<?
$row = 8;
$col = 2;

$cat = 0;
if($_REQUEST['cat']!='') $cat=$_REQUEST['cat'];

$p=0;
if ($_REQUEST['p']!='') $p=$_REQUEST['p'];

$code = $_lang=='vn' ? "vn_advright" : "en_advright";
$sql = "select * from xteam_content where status=0 and parent in (select id from xteam_content_category where code='".$code."') order by sort, date_added";
$result = @mysql_query($sql,$conn);
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" id="boder11">
<?
for($i=0;$i<$row;$i++){
?>
	<tr>
		
		
<?
	for($j=0;$j<$col&&$products=mysql_fetch_assoc($result);$j++){
		$pro = getRecord("xteam_content","id=".$products['id'])?>				
	<td width="90" align="center" valign="middle"><a href="<?=$pro['code']?>" target="_blank"><img src="<?=$pro["image"]?>" width="90" height="55" align="left" border="0" /></a></td>
<?
}
while($j<$col){
	echo "";
	$j=$j+1;
}
?>
		
	</tr>
	
<? }?>

</table>
 

