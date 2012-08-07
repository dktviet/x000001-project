<?
if($_lang=="vn"){
	$code 	= 'vn_intro';
}else if($_lang=="en"){
	$code = 'en_intro';
}else{
	$code = 'cn_intro';
}
$parentWhere = "parent = (select id from bnk_content_category where code='$code')";
$row = getRecord("bnk_content",$parentWhere);
?>
<h2><?=$row['name']?></h2>

<?=$row['detail']?>
