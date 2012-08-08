<?
class system_db{
	const hostname     	= "localhost";
	const username     	= "root";
	const password     	= "root";
	const databasename 	= "haytuyet_v2";
}
$conn = @mysql_connect(system_db::hostname, system_db::username, system_db::password) or 
	die("Không thể kết nối dữ liệu!");
mysql_select_db(system_db::databasename);
mysql_query("SET NAMES 'utf8'");
?>