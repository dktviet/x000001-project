<?
$conn = @mysql_connect($hostname, $taikhoan, $matkhau) or 
	die("Không thể kết nối cơ sở dữ liệu !");
mysql_select_db($databasename);
mysql_query("SET NAMES 'utf8'");
//----------------------------------------------------------------------------------------------
if(!session_id()) session_start();
//----------------------------------------------------------------------------------------------
if($_POST['set_language'] == 'true'){
	if(!isset($_SESSION['LANGUAGE']) || $_SESSION['LANGUAGE'] == NULL){
		session_register('LANGUAGE');
		$_SESSION['LANGUAGE'] = $_POST['LANGUAGE'];
	}else{
		$_SESSION['LANGUAGE'] = $_POST['LANGUAGE'];
	}
}else{
	if(!isset($_SESSION['LANGUAGE']) || $_SESSION['LANGUAGE'] == NULL){
		session_register('LANGUAGE');
		$_SESSION['LANGUAGE'] = 1;
	}
}
if($_SESSION['LANGUAGE']>0){
	include("lib/lang".$_SESSION['LANGUAGE'].".php");
}
if($_SESSION['LANGUAGE']==1) $_lang="vn";
// sua lang: else $_lang = "en";
else if($_SESSION['LANGUAGE']==2) $_lang="en";
else $_lang="cn";
?>