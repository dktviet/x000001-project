<?php
/*
	$get_frame = $_GET['frame'];
	$get_cat = $_GET['cat'];
	$get_id = $_GET['id'];
	$get_page = $_GET['p'];
*/
$system_config = new system_config();
?>
<form name="tf_language" action="<? /*if($get_frame == '') echo 'home.html';
 else if($get_frame != '' && $get_cat != '' && $get_id != '') echo $get_frame.'-c'.$get_cat.'-i'.$get_id.'.html'; 
 else if($get_frame != '' && $get_cat != '' && $get_page != '') echo $get_frame.'-c'.$get_cat.'-p'.$get_page.'.html'; 
 else if($get_frame != '' && $get_cat != '') echo $get_frame.'-c'.$get_cat.'.html'; 
 else if($get_page !='' && $get_id !='') echo $get_frame.'-i'.$get_id.'-p'.$get_page.'.html'; 
 else echo $get_frame.'.html';*/?><?=$system_config->curHost().lang_change('Home.html','Trang_chu.html')?>" method="post">
	<input type="hidden" value="true" name="set_language" />
	<input type="hidden" value="" name="LANGUAGE" />
</form>
<script type="text/javascript" language="javascript">
	function doChangeLanguage(id){
		document.tf_language.LANGUAGE.value=id;
		document.tf_language.submit();
	}
</script>
