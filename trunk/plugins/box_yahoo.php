<?
if($_lang=="vn") $code = 'vn_yahoo'; 
else if($_lang=="en") $code = 'en_yahoo'; 
else $code = 'cn_yahoo'; 
$sql = "select * from bnk_content where status=0 and  parent in (select id from bnk_content_category where code='".$code."') order by sort, date_added";
$result = mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($result)){
?>
<li><a href="ymsgr:sendim?<?=$row['code']?>"><img align="middle" src="http://opi.yahoo.com/online?u=<?=$row['code']?>&amp;m=g&amp;t=0&amp;1=us" alt="<?=$row['name']?>" style="border:none;" /></a>&nbsp;<?=$row['name']?>&nbsp;-&nbsp;ĐT:&nbsp;<?=$row['subject']?></li>

<? }?>
