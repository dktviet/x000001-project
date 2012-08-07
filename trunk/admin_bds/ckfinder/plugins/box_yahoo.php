<?
$code = "yahoo";
$sql = "select * from ".TBL_CONTENT." where status=0 and parent in (select id from ".TBL_CONTENT_CAT." where code='".$code."') order by sort, date_added";
$result = mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($result)){
?>
<p><a href="ymsgr:sendim?<?=$row['code']?>" title="<?=$row['code']?>"><?=lang_change($row['name_vn'],$row['name_en'])?></a></p>
<? }?>
