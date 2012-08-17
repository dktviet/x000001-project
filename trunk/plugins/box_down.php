<table border="0" style="border-collapse: collapse" width="100%" id="table45" cellpadding="0">
            <tr>
<?
$code ="vn_advdown";
$sql = "select * from xteam_content where status=0 and parent in (select id from xteam_content_category where code='".$code."') order by sort, date_added";
$result = mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($result)){
	if($row['image']!=''){
?>
 
           <td><img border="0" src="<?=$row['image']?>" width="94" height="70" /></td>
        
<?
	}
}
?>
 </tr>
</table>