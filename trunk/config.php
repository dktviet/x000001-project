<?
$hostname     = "localhost";
$username     = "root";
$password     = "";
$databasename = "ckvic_iphone";
$tblIp='xteam_guest_ip';
$visitorTimeout = 3600; //=15 * 60
$inLocal  = $_SERVER['HTTP_HOST']=='localhost'?'/bds/':'/';
$curHost  = 'http://'.$_SERVER['HTTP_HOST'].$inLocal;
$lightbox = 0;
$MAXPAGE = 10;
$multiLanguage = 1;//0 : single  ;  1 : multi
$arrLanguage = array(
	array('vn','Việt Nam'),/*tieng viet*/
	array('en','English'),/*tieng anh*/
	array('cn','China')/*tieng Trung quoc*/
);
$dbb=mysql_connect($hostname,$username,$password) or die("Die connect: ".mysql_error());
require("#connect/confix.php");
?>