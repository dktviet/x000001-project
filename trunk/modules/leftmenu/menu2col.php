<?
$Hangsx = getRecord("bnk_content_category","code='vn_maker'");
$resultMaker = mysql_query("select * from bnk_content where parent='".$Hangsx['id']."'",$conn);
while($rowMaker=mysql_fetch_assoc($resultMaker)){?>
	<div id="multicol<?=$i++%2==0 ? 'left' : 'right'?>">
    	<a href="<?=$curHost?>tim-key/<?=$rowMaker['name']?>.html"><?=$rowMaker['name']?></a>
    </div>
<? }?>
<style>
#multicolleft{
	float:left;
	width:48%;
	border-bottom:1px dashed #D4D4D4;
}
#multicolleft a{
	line-height:30px;
	font-size:13px;
}
#multicolright{
	float:right;
	width:48%;
	border-bottom:1px dashed #D4D4D4;
}
#multicolright a{
	line-height:30px;
	font-size:13px;
}
</style>