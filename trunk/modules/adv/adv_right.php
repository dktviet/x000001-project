<center>
<?
$code = $_lang == 'vn' ? 'vn_advright' : 'en_advright';
$parentWhere = "parent = (select id from bnk_content_category where code='$code')";
$sql = "select * from bnk_content where status=0 and $parentWhere order by sort,date_added limit 0,5";
$result = @mysql_query($sql,$conn);
while($row=mysql_fetch_assoc($result)){
if(getFileExtention($row["image"])=='.swf'){
?>
<object id="banner" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="152" height="auto" title="Flash intro">
        <param name="movie" value="<?=$curHost?><?=$row["image"]?>" />
        <param name="quality" value="high" />
        <param value="transparent" name="wmode">
        <embed src="<?=$curHost?><?=$row["image"]?>" wmode="opaque" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="170" height="auto"></embed>
    </object>                    
<? }else{?>
    <a href="http://<?=$row["code"]?>" target="_blank"><img src="<?=$curHost?><?=$row["image"]?>" width="226" alt="http://<?=$row["code"]?>" title="<?=$row["name"]?>" class="gal" /></a><br />
<? } }?>
</center>