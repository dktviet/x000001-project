<?
$code = $_lang == 'vn' ? 'vn_download' : 'en_download';
$parentWhere = "and parent = (select id from bnk_content_category where code='$code')";

$parentRecord = getRecord("bnk_content","1=1 ".$parentWhere);

$cat1 = killInjection($_REQUEST['cat']);
if ($cat1=='') $cat1 = $parentRecord['parent'];
$per_page = 10;
$p=0;
if ($_REQUEST['p']!='') $p=killInjection($_REQUEST['p']);
$total = countRecord("bnk_content","status=0 and parent=".$cat1);
if($total==0){
?>
<div class="content-content" style="color:#040404;font-size:1.2em;line-height:17px;text-align:left;">
    <br /><div style="width:10%;float:left;height:22px;border:1px solid #ccc;color:#FFF;background:red;line-height:22px;text-align:left;text-indent:10px;font-weight:bold;">STT</div>
    <div style="width:60%;float:left;height:22px;border:1px solid #ccc;color:#FFF;background:red;line-height:22px;text-align:left;text-indent:10px;font-weight:bold;">Danh mục</div>
    <div style="width:25%;float:left;height:22px;border:1px solid #ccc;color:#FFF;background:red;line-height:22px;text-align:left;text-indent:10px;font-weight:bold;">Download</div>
                
    <table align="center" cellSpacing="0" cellPadding="0" width="100%" border="0">
        
        <tr>
            <td align="center">
                <font color="#FF0000"><b><?=$_lang=="vn"?'Dữ liệu đang cập nhật !':'Data are being updated !'?></b></font>
            </td>
        </tr>
        <tr><td height="20"></td></tr>
    </table>
</div>
<?
}else{
$sql = "select * from bnk_content where status=0 $parentWhere order by sort,date_added desc limit ".$per_page*$p.",".$per_page;
$result = @mysql_query($sql,$conn);
$i=1;
while($row=mysql_fetch_assoc($result)){
?>
<div style="width:10%;float:left;height:22px;border:1px solid #ccc;color:#000;line-height:22px;text-align:left;text-indent:10px;font-weight:bold;"><?=$i++;?></div>
                <div style="width:60%;float:left;height:22px;border:1px solid #ccc;color:#9e6d32;line-height:22px;text-align:left;text-indent:10px;font-weight:bold;"><? if($row['image']){?>
			<?=$_lang=='vn'?'Tên tập tin : ':'File name : '?> 
			<a href="<?=$row['image']?>">
			<font color="#336699" size="-1"><?=$row['name']?></font>
			</a>
			<? }?></div>
                <div style="width:25%;float:left;height:22px;border:1px solid #ccc;color:#FFF;line-height:22px;text-align:left;text-indent:10px;font-weight:bold;">
                <a href="<?=$row['image']?>" style="width:22px;height:18px;float:left;text-decoration:none;margin-left:15px;">
				
			<img src="images/down.jpg" /></a></div>
			
			<br />
<? }?>
<table align="center" cellSpacing=0 cellPadding=0 width="100%" border=0>
<?
$newsPage       = $_lang=="vn" ? "Tài liệu" : "Document";
$pagePage       = $_lang=="vn" ? "Trang" : "Page";
$titleFirst     = $_lang=="vn" ? "Đầu Tiên" : "First";
$titlePrevious  = $_lang=="vn" ? "Về trước" : "Previous";
$titleNext      = $_lang=="vn" ? "Tiếp theo" : "Next";
$titleLast      = $_lang=="vn" ? "Cuối cùng" : "Last";

$total=countRecord("bnk_content","status=0 and parent=".$cat1);
$pages = countPages($total,$per_page);
echo '<tr><td colspan="2" align="center"></td></tr>';
echo '<tr><td class="smallfont" align="left"></td>';
echo '<td class="smallfont" align="right">'.$pagePage.' : ';
$param="";
if ($p>1) echo '<a class="aLink3" title="'.$titleFirst.'" href="./?frame='.$pages.'&cat='.killInjection($_REQUEST['cat']).'&'.$param.'&p=0"><img src="images/arrown2_2.png" alt="'.$titleFirst.'" /></a> ';
if ($p>0) echo '<a class="aLink3" title="'.$titlePrevious.'" href="./?frame='.$pages.'&cat='.killInjection($_REQUEST['cat']).'&'.$param.'&p='.($p-1).'"><img src="images/arrown1_2.png" alt="'.$titlePrevious.'" /></a> ';
$from=($p-10>0?$p-10:0);
$to=($p+10<$pages?$p+10:$pages);
for ($i=$from;$i<$to;$i++){
	if ($i!=$p) echo '<a class="aLink3" href="./?frame='.$pages.'&cat='.killInjection($_REQUEST['cat']).'&'.$param.'&p='.$i.'">'.($i+1).' </a>';
	else echo '<b>'.($i+1).'</b> ';
}
if ($p<$i-1) echo '<a class="aLink3" title="'.$titleNext.'" href="./?frame='.$pages.'&cat='.killInjection($_REQUEST['cat']).'&'.$param.'&p='.($p+1).'"><img src="images/arrown1.png" alt="'.$titleNext.'" /></a> ';
if ($p<$pages-1) echo '<a class="aLink3" title="'.$titleLast.'" href="./?frame='.$pages.'&cat='.killInjection($_REQUEST['cat']).'&'.$param.'&p='.($pages-1).'"><img src="images/arrown2.png" alt="'.$titleLast.'" /></a>'; 
echo '</td></tr>';
?>
</table><br />
<? }?>