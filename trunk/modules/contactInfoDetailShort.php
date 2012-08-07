<?
if($_lang=="vn"){
	$code 	= "vn_contact";
}else if($_lang=="en"){
	$code = "en_contact";
}else{
	$code = "cn_contact";
}
$parentWhere = "parent = (select id from bnk_content_category where code='$code')";
$introRecord = getRecord("bnk_content",$parentWhere);
echo $introRecord['detail_short'];
?>
