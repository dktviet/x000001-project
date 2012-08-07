	<?
	if($_lang=="vn") $code = 'vn_link'; 
	else if($_lang=="en") $code = 'en_link'; 
	else $code = 'cn_link'; 
	$sql = "select * from bnk_content where status=0 and parent in (select id from bnk_content_category where code='".$code."') order by sort, date_added";
	$result = mysql_query($sql,$conn);
	while($row=mysql_fetch_assoc($result)){
	echo '<option>www.'.$row['code'].'</option> / ';
	}
	?>
