<?
$code = $_lang=='vn' ? "vn_advleft" : "en_advleft";
$sql = "select * from xteam_content where status=0 and parent in (select id from xteam_content_category where code='".$code."') order by sort, date_added";
$result = mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($result)){
	if($row['image']!=''){
?>
 
           <a href="<?=$row['code']?>"><img src="<?=$row['image']?>" width="210" height="84" border="0" /></a>
        
<?
	}
}
?>
