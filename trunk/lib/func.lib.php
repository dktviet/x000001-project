<?
//*********************************************************************************************************
//***************************************** Check PHP Version *********************************************
//echo 'Current PHP version: ' . phpversion();
if (phpversion()< "4.1.0") {
	$_GET = $HTTP_GET_VARS;
	$_POST = $HTTP_POST_VARS;
	$_SERVER = $HTTP_SERVER_VARS;
}
//*********************************************************************************************************
//************************************** Get email config *************************************************
$emailConfigRecord = getRecord("bnk_config","code='adminEmail'");
$adminEmail = $emailConfigRecord['detail'];
//*********************************************************************************************************
//*********************************** Get currency unit config ********************************************
$currencyUnitConfigRecord = getRecord("bnk_config","code='currencyUnit'");
$currencyUnit = $currencyUnitConfigRecord['detail'];
//*********************************************************************************************************
//************************************* Get hot line config ***********************************************
$hotlineConfigRecord = getRecord("bnk_config","code='hotline'");
$hotline = $hotlineConfigRecord['detail'];
//*********************************************************************************************************
//************************************** Public Key Interface *********************************************
$mytitle = getRecord("bnk_config","code='title'");
$mydescription = getRecord("bnk_config","code='description'");
$mykeywords = getRecord("bnk_config","code='keywords'");
$myphone = getRecord("bnk_config","code='PhoneNumber'");


function mo ($g, $l) {
	return $g - ($l * floor ($g/$l));
}
function powmod ($base, $exp, $modulus){
	$accum = 1;
	$i = 0;
	$basepow2 = $base;
	while (($exp >> $i)>0) {
		if ((($exp >> $i) & 1) == 1) {
			$accum = mo(($accum * $basepow2) , $modulus);
		}
		$basepow2 = mo(($basepow2 * $basepow2) , $modulus);
		$i++;
	}
	return $accum;
}
function PKI_Encrypt ($m, $e, $n){
	$asci = array ();
	for ($i=0; $i<strlen($m); $i+=3) {
		$tmpasci="1";
		for ($h=0; $h<3; $h++) {
			if ($i+$h <strlen($m)) {
				$tmpstr = ord (substr ($m, $i+$h, 1)) - 30;
				if (strlen($tmpstr) < 2) {
					$tmpstr ="0".$tmpstr;
				}
			} else {
				break;
			}
			$tmpasci .=$tmpstr;
		}
		array_push($asci, $tmpasci."1");
	}
	$coded = '';
	for ($k=0; $k< count ($asci); $k++) {
		$resultmod = powmod($asci[$k], $e, $n);
		$coded .= $resultmod." ";
	}
	return trim($coded);
}
function PKI_Decrypt ($c, $d, $n) {
	$decryptarray = split(" ", $c);
	for ($u=0; $u<count ($decryptarray); $u++) {
		if ($decryptarray[$u] == "") {
			array_splice($decryptarray, $u, 1);
		}
	}
	for ($u=0; $u< count($decryptarray); $u++) {
		$resultmod = powmod($decryptarray[$u], $d, $n);
		$deencrypt.= substr ($resultmod,1,strlen($resultmod)-2);
	}
	for ($u=0; $u<strlen($deencrypt); $u+=2) {
		$resultd .= chr(substr ($deencrypt, $u, 2) + 30);
	}
	return $resultd;
}
//************************************************************************************************************
//************************************************************************************************************
function killInjection($str){//HAM NAY LOAI BO CAC LENH INJECTION
	$bad = array("\\","=",":","'","-");
	$good = str_replace($bad,"", $str);
	return $good;
}
//************************************************************************************************************
//************************************************* PAGING ***************************************************
function countPages($total, $n){
	if($total%$n==0) return (int)($total/$n);
	return (int)($total/$n)+1;
}
function createPage($total,$link,$nitem,$itemcurrent,$step=10){
	if($total<1){return false;}
	global $conn;
	$ret="";
	$param="";
	$pages = countPages($total,$nitem);
	$ret.='<a title="Đầu tiên" href="'.$link.'0" class="number">Bắt đầu</a> ';
	$ret.='<a title="Về trước" href="'.$link.($itemcurrent-1).'" class="number">Trước</a> ';
	$from=($itemcurrent-$step>0?$itemcurrent-$step:0);
	$to=($itemcurrent+$step<$pages?$itemcurrent+$step:$pages);
	for ($i=$from;$i<$to;$i++){
		if ($i!=$itemcurrent) $ret.='<a href="'.$link.$i.'" class="number">'.($i+1).'</a> ';
		else $ret.='<a class="number current">'.($i+1).'</a> ';
	}
	$ret.='<a title="Tiếp theo" href="'.$link.($itemcurrent+1).'" class="number">Tiếp</a> ';
	$ret.='<a title="Cuối cùng" href="'.$link.($pages-1).'" class="number">Cuối cùng</a>'; 
	return $ret;
}
//************************************************************************************************************
//********************************************** SORT ********************************************************
function getLinkSort($order){
	$direction="";
	if ($_REQUEST['direction']==''||$_REQUEST['direction']!='0')
		$direction="0";
	else
		$direction="1";

	return "./?act=".$_REQUEST['act']."&cat=".$_REQUEST['cat']."&page=".$_REQUEST['page']."&sortby=".$order."&direction=".$direction;
}
//************************************************************************************************************
//************************************** file : upload *******************************************************
function getFileExtention($filename){  
    return strrchr($filename, ".");
}
function checkUpload($f,$ext="",$maxsize=0,$req=0){
	$fname=strtolower(basename($f['name']));
	$ftemp=$f["tmp_name"];
	$fsize=$f["size"];
	$fext=getFileExtention($fname);
	if($fsize==0){
		if ($req!=0) return "B&#7841;n ch&#432;a ch&#7885;n file !";
		return "";
	}else{
		if ($ext!="") if (strpos($ext, $fext)===false) 
			return "T&#7853;p tin kh&ocirc;ng &#273;&uacute;ng &#273;&#7883;nh d&#7841;ng : $fname";
		if ($maxsize>0) if ($fsize > $maxsize) 
			return "K&iacute;ch th&#432;&#7899;c h&igrave;nh ph&#7843;i nh&#7887; h&#417;n ".$maxsize." byte";
	}
	return "";
}
function makeUpload($f,$newfile){
  if (move_uploaded_file($f["tmp_name"], $newfile))	return $newfile;
  return false;
}
//************************************************************************************************************
//************************************************************************************************************
function getArray($table, $where="", $limit="",$sort=""){
    global $conn;
	$ret = array();
	$where = $where!="" ? $where : "1=1";
	$limit = $limit!="" ? $limit : "1000";
	$sort = $sort!="" ? $sort : "date_added DESC";
    if ($table == '') return false;
	$result = mysql_query("SELECT * FROM $table WHERE $where ORDER BY $sort LIMIT $limit ",$conn);
	while($row=mysql_fetch_assoc($result)){
		$ret[] = array(id=>$row["id"],name=>$row["name"],parent=>$row["parent"],subject=>$row["subject"],system=>$row["system"],image_large=>$row["image_large"],image=>$row["image"],detail_short=>$row["detail_short"],detail=>$row["detail"]);
	}
	return $ret;
}
function countArray($Arr, $field, $key){
	$key = $key!="" ? $key : "";
	foreach($Arr as $ItemArr){
		if($ItemArr[$field] == $key) $ItemCount++;
	}
	return $ItemCount;
}
function getRecord($table, $where='1=1'){
    global $conn;
    if ($table == '') return false;
	$result = mysql_query("select * from $table where $where limit 1 ",$conn);
	return @mysql_fetch_assoc($result);
}
function countRecord($table,$where=""){
	global $conn;
    if ($table=="") return false;
    if ($where=="") $where="1=1";
	$result = mysql_query("select count(*) as cnt from $table where $where",$conn);
	$row = @mysql_fetch_assoc($result);
	return $row['cnt'];
}
function dateFormat($dateField, $lang='vn'){
	if($dateField==''){return false;}
	$arrVN = array("Ch&#7911; nh&#7853;t","Th&#7913; Hai","Th&#7913; Ba","Th&#7913; t&#432;","Th&#7913; n&#259;m","Th&#7913; s&aacute;u","Th&#7913; b&#7843;y");
	$arrEN = array("Sunday","Monday","Tueday","Wednesday","Thuday","Friday","Satuday");
	$date = strtotime($dateField);
	
	$arr = $lang=='vn'?$arrVN:$arrEN;
	
	return $arr[date('w',$date)].', '.date('d/m/Y, H:i (O)',$date);
}

function getArrayCategory($table, $catid="", $split="|_"){
    global $conn;
    $hide = "status=0";
    if (isset($_SESSION['log'])) $hide="1=1";
    $ret = array();
    if ($catid=="") $catid=0;
	$result = mysql_query("select * from $table where $hide and parent=$catid ORDER BY sort",$conn);
	while($row=mysql_fetch_assoc($result)){
		$ret[] = array($row['id'],($catid==0?"":$split).$row['name']);
		$getsub = getArrayCategory($table, $row['id'], $split.'__');
		foreach ($getsub as $sub)
			$ret[]=array($sub[0],$sub[1]);
	}
	return $ret;
}

function getArrayCombo($table, $valueField, $textField, $where=""){
	global $conn;
	$ret = array();
	$hide = "status=0";
	$where = $where!="" ? $where : "1=1";
	$result = mysql_query("select $valueField,$textField from $table where $hide and $where",$conn);
	while($row=mysql_fetch_assoc($result)){
		$ret[] = array($row[$valueField],$row[$textField]);
	}
	return $ret;
}

function isHaveChild($table, $id){
	global $conn;
	$result = mysql_query("select * from $table where parent=$id",$conn);
	$numRow = mysql_num_rows($result);
	return $numRow > 0 ? true : false;
}
//************************************************************************************************************
//****************************************** combo out HTML **************************************************
function comboLanguage($name, $langSelected, $class){
	global $arrLanguage;
	$name = $name != '' ? $name : 'cmbLang';
	$out = '';
	$out .= '<select size="1" name="'.$name.'" class="'.$class.'">';
	foreach ($arrLanguage as $lang){
		if ($lang[0] == $langSelected)
			$out .= '<option value="'.$lang[0].'" selected>'.$lang[1].'</option>';
		else
			$out .= '<option value="'.$lang[0].'">'.$lang[1].'</option>';
	}
	$out .= '</select>';
// sua lang:	return $arrLanguage[0][1];
	return $arrLanguage[0][1][2];
// end sua lang
}

// $name            : name of combobox
// $arrSource  : function return array ; example : getListCategory(), getListNewsCategory()
// $index           : paramater selected
// $all             : $all==1 => show [Tat ca]
function comboCategory($name, $arrSource, $class, $index, $all){
	$name = $name != '' ? $name : 'cmbParent';
	if(!$arrSource){return false;}
	$out = '';
	$out .= '<select size="1" name="'.$name.'" class="'.$class.'" onchange="writekey();">';
	$out .= $all==1 ? '<option value="">[T&#7845;t c&#7843;]</option>' : '';
	$cats = $arrSource;
	foreach ($cats as $cat){
		$selected = $cat[0] == $index ? 'selected' : '';
		$out .= '<option rev="'.str_replace(array("|","_"), "", $cat[1]).'" value="'.$cat[0].'" '.$selected.'>'.$cat[1].'</option>';
	}
	$out .= '</select>';
	return $out;
}

function comboSex($index, $lang="vn", $name="cmbSex", $class="textbox"){
	$arrValue  = array('0','1');
	$arrTextVN = array('Nam','N&#7919;');
	$arrTextEN = array('Male','Female');
	$arrText = $lang=="vn"?$arrTextVN:$arrTextEN;
	$firstValue = $lang=="vn"?"[Ch&#7885;n ph&aacute;i]":"[Select sex]";
	$out = '';
	$out .= '<select name="'.$name.'" id="'.$name.'" class="'.$class.'">';
	$out .= '<option value="-1">'.$firstValue.'</option>';
	for($i=0; $i<count($arrValue); $i++){
		$selected = $arrValue[$i] == $index ? 'selected' : '';
		$out .= '<option value="'.$arrValue[$i].'" '.$selected.'>'.$arrText[$i].'</option>';
	}
	$out .= '</select>';
	return $out;
}

function comboCountry($index, $lang="vn", $name="cmbCountry", $class="textbox"){
	$arrValue = array(
		'AF','AL','DZ','AS','AD','AO','AI','AQ','AG','AR','AM','AW','AU','AT','AZ','BS','BH','BD','BB','BY',
		'BE','BZ','BJ','BM','BT','BO','BA','BW','BV','BR','IO','VG','BN','BG','BF','BI','KH','CM','CA','CV',
		'KY','CF','TD','CL','CN','CX','CC','CO','KM','CG','CK','CR','CI','HR','CU','CY','CZ','DK','DJ','DM',
		'DO','TP','EC','EG','SV','GQ','ER','EE','ET','FK','FO','FJ','FI','FR','FX','GF','PF','TF','GA','GM',
		'GE','DE','GH','GI','GR','GL','GD','GP','GU','GT','GN','GW','GY','HT','HM','HN','HK','HU','IS','IN',
		'ID','IQ','IE','IR','IL','IT','JM','JP','JO','KZ','KE','KI','KP','KR','KW','KG','LA','LV','LB','LS',
		'LR','LY','LI','LT','LU','MO','MK','MG','MW','MY','MV','ML','MT','MH','MQ','MR','MU','YT','MX','FM',
		'MD','MC','MN','MS','MA','MZ','MM','NA','NR','NP','NL','AN','NC','NZ','NI','NE','NG','NU','NF','MP',
		'NO','OM','PK','PW','PA','PG','PY','PE','PH','PN','PL','PT','PR','QA','RE','RO','RU','RW','LC','WS',
		'SM','ST','SA','SN','YU','SC','SL','SG','SK','SI','SB','SO','ZA','ES','LK','SH','KN','PM','VC','SD',
		'SR','SJ','SZ','SE','CH','SY','TW','TJ','TZ','TH','TG','TK','TO','TT','TN','TR','TM','TC','TV','UG',
		'UA','AE','GB','US','VI','UY','UZ','VU','VA','VE','VN','WF','EH','YE','ZR','ZM'
	);				
	$arrText = array(
		'Afghanistan','Albania','Algeria','American Samoa','Andorra','Angola','Anguilla','Antarctica','Antigua and Barbuda','Argentina','Armenia','Aruba','Australia','Austria','Azerbaijan','Bahamas','Bahrain','Bangladesh','Barbados','Belarus',
		'Belgium','Belize','Benin','Bermuda','Bhutan','Bolivia','Bosnia and Herzegowina','Botswana','Bouvet Island','Brazil','British Indian Ocean Territory','British Virgin Islands','Brunei Darussalam','Bulgaria','Burkina Faso','Burundi','Cambodia','Cameroon','Canada','Cape Verde',
		'Cayman Islands','Central African Republic','Chad','Chile','China','Christmas Island','Cocos (Keeling) Islands','Colombia','Comoros','Congo','Cook Islands','Costa Rica','Cote D\'ivoire','Croatia','Cuba','Cyprus','Czech Republic','Denmark','Djibouti','Dominica',
		'Dominican Republic','East Timor','Ecuador','Egypt','El Salvador','Equatorial Guinea','Eritrea','Estonia','Ethiopia','Falkland Islands (Malvinas)','Faroe Islands','Fiji','Finland','France','France, Metropolitan','French Guiana','French Polynesia','French Southern Territories','Gabon','Gambia',
		'Georgia','Germany','Ghana','Gibraltar','Greece','Greenland','Grenada','Guadeloupe','Guam','Guatemala','Guinea','Guinea-Bissau','Guyana','Haiti','Heard and McDonald Islands','Honduras','Hong Kong','Hungary','Iceland','India',
		'Indonesia','Iraq','Ireland','Islamic Republic of Iran','Israel','Italy','Jamaica','Japan','Jordan','Kazakhstan','Kenya','Kiribati','Korea','Korea, Republic of','Kuwait','Kyrgyzstan','Laos','Latvia','Lebanon','Lesotho',
		'Liberia','Libyan Arab Jamahiriya','Liechtenstein','Lithuania','Luxembourg','Macau','Macedonia','Madagascar','Malawi','Malaysia','Maldives','Mali','Malta','Marshall Islands','Martinique','Mauritania','Mauritius','Mayotte','Mexico','Micronesia',
		'Moldova, Republic of','Monaco','Mongolia','Montserrat','Morocco','Mozambique','Myanmar','Namibia','Nauru','Nepal','Netherlands','Netherlands Antilles','New Caledonia','New Zealand','Nicaragua','Niger','Nigeria','Niue','Norfolk Island','Northern Mariana Islands',
		'Norway','Oman','Pakistan','Palau','Panama','Papua New Guinea','Paraguay','Peru','Philippines','Pitcairn','Poland','Portugal','Puerto Rico','Qatar','Reunion','Romania','Russian Federation','Rwanda','Saint Lucia','Samoa',
		'San Marino','Sao Tome and Principe','Saudi Arabia','Senegal','Serbia and Montenegro','Seychelles','Sierra Leone','Singapore','Slovakia','Slovenia','Solomon Islands','Somalia','South Africa','Spain','Sri Lanka','St. Helena','St. Kitts and Nevis','St. Pierre and Miquelon','St. Vincent and the Grenadines','Sudan',
		'Suriname','Svalbard and Jan Mayen Islands','Swaziland','Sweden','Switzerland','Syrian Arab Republic','Taiwan','Tajikistan','Tanzania, United Republic of','Thailand','Togo','Tokelau','Tonga','Trinidad and Tobago','Tunisia','Turkey','Turkmenistan','Turks and Caicos Islands','Tuvalu','Uganda',
		'Ukraine','United Arab Emirates','United Kingdom (Great Britain)','United States','United States Virgin Islands','Uruguay','Uzbekistan','Vanuatu','Vatican City State','Venezuela','Vietnam','Wallis And Futuna Islands','Western Sahara','Yemen','Zaire','Zambia'
	);
	$firstValue = $lang=="vn"?"[Ch&#7885;n qu&#7889;c gia]":"[Select country]";
	$out = '';
	$out .= '<select name="'.$name.'" id="'.$name.'" class="'.$class.'">';
	$out .= '<option value="-1">'.$firstValue.'</option>';
	for($i=0; $i<count($arrValue); $i++){
		$selected = $arrValue[$i] == $index ? 'selected' : '';
		$out .= '<option value="'.$arrValue[$i].'" '.$selected.'>'.$arrText[$i].'</option>';
	}
	$out .= '</select>';
	return $out;
}

//************************************************************************************************************
function comboDate($name, $class, $value=0){
	$name = $name != '' ? $name : 'cmbDate';
	$out = '';
	$out .= '<select size="1" name="'.$name.'" class="'.$class.'">';
	$out .= $value==0 ? '<option value="">Ngày</option>' : '';
	for ($i=1; $i<=31; $i++){
		$selected = $i == $value ? 'selected' : '';
		$out .= '<option value="'.($i>9?$i:'0'.$i).'" '.$selected.'>'.($i>9?$i:'0'.$i).'</option>';
	}
	$out .= '</select>';
	return $out;
}

function comboMonth($name, $class, $value=0){
	$name = $name != '' ? $name : 'cmbMonth';
	$out = '';
	$out .= '<select size="1" name="'.$name.'" class="'.$class.'">';
	$out .= $value==0 ? '<option value="">Tháng</option>' : '';
	for ($i=1; $i<=12; $i++){
		$selected = $i == $value ? 'selected' : '';
		$out .= '<option value="'.($i>9?$i:'0'.$i).'" '.$selected.'>'.($i>9?$i:'0'.$i).'</option>';
	}
	$out .= '</select>';
	return $out;
}

function comboYear($name, $class, $value=0){
	$name = $name != '' ? $name : 'cmbYear';
	$out = '';
	$out .= '<select size="1" name="'.$name.'" class="'.$class.'">';
	$out .= $value==0 ? '<option value="">Năm</option>' : '';
	for ($i=date(Y); $i>=1940; $i--){
		$selected = $i == $value ? 'selected' : '';
		$out .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
	}
	$out .= '</select>';
	return $out;
}
//************************************************************************************************************
//***************************************** SQL Query function ***********************************************
function insert($table,$fields_arr){
	global $conn;
	if(!$conn){return false;}
	$strfields="";
	$strvalues="";
	list($key, $val) = each($fields_arr);
	if(is_string($key)){
		$strfields = " ($key";
		$strvalues= $val;
		while(list($key, $val) = each($fields_arr)){
			$strfields.= ", $key";
			$strvalues.= ",".$val;
		}
			$strfields.=")";
	}else{
		$strvalues=$fields_arr[0];
		for($i=1;$i<(count($fields_arr));$i++){
			$strvalues .= ", $fields_arr[$i]";
		}
	}
	
	$query = "INSERT INTO $table $strfields VALUES ($strvalues)";
	//echo $query;
	return mysql_query($query, $conn);
}

function update($table,$fields_arr,$where) {
	global $conn;
	if (!$conn) { return false; }
	list($key, $val) = each($fields_arr);
	$strset=" $key = $val";
	while(list($key, $val) = each($fields_arr)){
		$strset .= ", $key = $val";
	}
	$query = "UPDATE $table SET $strset WHERE $where"; 
	$result = mysql_query($query, $conn);
	return !$result?false:true;
}

function delete_rows($table,$fields_arr,$where_ext="") {
	global $conn;
	if (!$conn) { return false; }
	if(count($fields_arr)>0){
		list($key, $val) = each($fields_arr);
		$strwhere=" $key = $val";
		while(list($key, $val) = each($fields_arr)){
			$strwhere .= "OR $key = $val";
		}
	}
	
	$query = "DELETE FROM $table WHERE $strwhere $where_ext";      
	#echo $query;#exit;
	$result = mysql_query($query, $conn);
	if (!$result) {return false;}
	return true;
}
//************************************************************************************************************
//************************************************ MAIL ******************************************************
function check_mail($email){
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) return false;
	return true;
}

function send_mail($from,$to,$subject,$body){
	return mail_smtp($from,$to,$subject,$body,1);
}

function mail_smtp($from,$to,$subject,$body,$html=0){
	require_once("smtp.php");

	$smtp=new smtp_class;

	$smtp->host_name="localhost";       /* Change this variable to the address of the SMTP server to relay, like "smtp.myisp.com" */
	$smtp->localhost="localhost";       /* Your computer address */
	$smtp->direct_delivery=0;           /* Set to 1 to deliver directly to the recepient SMTP server */
	$smtp->timeout=10;                  /* Set to the number of seconds wait for a successful connection to the SMTP server */
	$smtp->data_timeout=0;              /* Set to the number seconds wait for sending or retrieving data from the SMTP server.
	                                       Set to 0 to use the same defined in the timeout variable */
	$smtp->debug=0;                     /* Set to 1 to output the communication with the SMTP server */
	$smtp->html_debug=1;                /* Set to 1 to format the debug output as HTML */
	$smtp->pop3_auth_host="tramhuonganphat.com";           /* Set to the POP3 authentication host if your SMTP server requires prior POP3 authentication */
	$smtp->user="client@tramhuonganphat.com";                     /* Set to the user name if the server requires authetication */
	$smtp->realm="";                    /* Set to the authetication realm, usually the authentication user e-mail domain */
	$smtp->password="degoimail";                 /* Set to the authetication password */
	$smtp->workstation="";              /* Workstation name for NTLM authentication */
	$smtp->authentication_mechanism=""; /* Specify a SASL authentication method like LOGIN, PLAIN, CRAM-MD5, NTLM, etc..
	                                       Leave it empty to make the class negotiate if necessary */

	if($smtp->direct_delivery){
		if(!function_exists("GetMXRR")){
			$_NAMESERVERS=array();
			include("getmxrr.php");
		}
	}

	$header="";
	if ($html==0)
		$header = array(
			"From: $from",
			"To: $to",
			"Subject: $subject",
			"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")
		);
	else
		$header = array(
			"MIME-Version: 1.0",
			"Content-type: text/html; charset=iso-8859-1",
			"From: $from",
			"To: $to",
			"Subject: $subject",
			"Date: ".strftime("%a, %d %b %Y %H:%M:%S %Z")
		);
	$ret = $smtp->SendMessage($from,array($to),$header,$body);
	return $ret;
}
//************************************************************************************************************
function utf8_to_ascii($str) {
	$chars = array(
		'a'	=>	array('A','ấ','ầ','ẩ','ẫ','ậ','A','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
		'b'	=>	array('B'),
		'c'	=>	array('C'),
		'd'	=>	array('D','đ','Đ'),
		'e' =>	array('E','ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
		'f'	=>	array('F'),
		'g'	=>	array('G'),
		'h'	=>	array('H'),
		'i'	=>	array('I','í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
		'j'	=>	array('J'),
		'k'	=>	array('K'),
		'l'	=>	array('L'),
		'm'	=>	array('M'),
		'n'	=>	array('N'),
		'o'	=>	array('O','ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
		'p'	=>	array('P'),
		'q'	=>	array('Q'),
		'r'	=>	array('R'),
		's'	=>	array('S'),
		't'	=>	array('T'),
		'u'	=>	array('U','ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
		'v'	=>	array('V'),
		'x'	=>	array('X'),
		'y'	=>	array('Y','ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'z'	=>	array('Z'),
		''	=>	array('(&nbsp;','&nbsp;)'),
		'-' =>	array(' ',',','&',' - '),
		'' =>	array('~','`','!','@','#','$','%','^','*','(',')','+','=','|','[',']','{','}',':','"',"'",';','/','?','.','<','\'','>','\\'),
	);
	foreach ($chars as $key => $arr) 
		foreach ($arr as $val)
			$str = str_replace($val,$key,$str);
	return $str;
}
function convert_key($str) {
	$chars = array(
		'a'	=>	array('A','ấ','ầ','ẩ','ẫ','ậ','A','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
		'b'	=>	array('B'),
		'c'	=>	array('C'),
		'd'	=>	array('D','đ','Đ'),
		'e' =>	array('E','ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
		'f'	=>	array('F'),
		'g'	=>	array('G'),
		'h'	=>	array('H'),
		'i'	=>	array('I','í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
		'j'	=>	array('J'),
		'k'	=>	array('K'),
		'l'	=>	array('L'),
		'm'	=>	array('M'),
		'n'	=>	array('N'),
		'o'	=>	array('O','ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
		'p'	=>	array('P'),
		'q'	=>	array('Q'),
		'r'	=>	array('R'),
		's'	=>	array('S'),
		't'	=>	array('T'),
		'u'	=>	array('U','ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
		'v'	=>	array('V'),
		'x'	=>	array('X'),
		'y'	=>	array('Y','ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'z'	=>	array('Z'),
	);
	foreach ($chars as $key => $arr) 
		foreach ($arr as $val)
			$str = str_replace($val,$key,$str);
	return $str;
}

//************************************************************************************************************
function fix_input($str) {
	$chars = array(
		'"' =>	array('\''),
	);
	foreach ($chars as $key => $arr) 
		foreach ($arr as $val)
			$str = str_replace($val,$key,$str);
	return $str;
}

//************************************************************************************************************

function catchu($value, $length)
{
    if($value!=''){
    if(is_array($value)) list($string, $match_to) = $value;
    else { $string = $value; $match_to = $value{0}; }
 
    $match_start = stristr($string, $match_to);
    $match_compute = strlen($string) - strlen($match_start);
 
    if (strlen($string) > $length)
    {
        if ($match_compute < ($length - strlen($match_to)))
        {
            $pre_string = substr($string, 0, $length);
            $pos_end = strrpos($pre_string, " ");
            if($pos_end === false) $string = $pre_string;
            else $string = substr($pre_string, 0, $pos_end);
        }
        else if ($match_compute > (strlen($string) - ($length - strlen($match_to))))
        {
            $pre_string = substr($string, (strlen($string) - ($length - strlen($match_to))));
            $pos_start = strpos($pre_string, " ");
            $string =substr($pre_string, $pos_start);
            if($pos_start === false) $string = $pre_string;
            else $string = substr($pre_string, $pos_start);
        }
        else
        {
            $pre_string = substr($string, ($match_compute - round(($length / 3))), $length);
            $pos_start = strpos($pre_string, " "); $pos_end = strrpos($pre_string, " ");
            $string = substr($pre_string, $pos_start, $pos_end);
            if($pos_start === false && $pos_end === false) $string = $pre_string;
            else $string =substr($pre_string, $pos_start, $pos_end);
        }
 
        $match_start = stristr($string, $match_to);
        $match_compute = strlen($string) - strlen($match_start);
    }
 
    return $string;
    }else{
        return $string ='';
    }
}
// Change language ************************************************************************************************
function lang_change($cur_lang,$str_01,$str_02){
	switch($cur_lang){
		case 'vn': $str_out = $str_01; break;
		case 'en': $str_out = $str_02; break;
	}
	return $str_out ;
}


// Change img size ************************************************************************************************
function change_img_size($source_pic,$destination_pic,$max_width,$max_height){
	$src = imagecreatefromjpeg($source_pic);
	list($width,$height)=getimagesize($source_pic);
	
	$x_ratio = $max_width / $width;
	$y_ratio = $max_height / $height;
	
	if( ($width <= $max_width) && ($height <= $max_height) ){
		$tn_width = $width;
		$tn_height = $height;
		}elseif (($x_ratio * $height) < $max_height){
			$tn_height = ceil($x_ratio * $height);
			$tn_width = $max_width;
		}else{
			$tn_width = ceil($y_ratio * $width);
			$tn_height = $max_height;
	}
	
	$tmp=imagecreatetruecolor($tn_width,$tn_height);
	imagecopyresampled($tmp,$src,0,0,0,0,$tn_width, $tn_height,$width,$height);
	
	imagejpeg($tmp,$destination_pic,100);
	imagedestroy($src);
	imagedestroy($tmp);
}
// Get URL ************************************************************************************************
function curPageURL() {
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	}
	return $pageURL;
}


// Get real IP ************************************************************************************************
function get_real_ip(){
	if ($_SERVER['X_FORWARDED_FOR'] !="")
	{
	$X_FORWARDED_FOR=explode(",", $_SERVER['X_FORWARDED_FOR']);
	$count = count($X_FORWARDED_FOR);
	if($count =0 ) {
	$REMOTE_ADDR=trim($X_FORWARDED_FOR); // Chỉ có một ip trong chain
	} else {
	$REMOTE_ADDR=trim($X_FORWARDED_FOR[0]); //Lấy ip đầu tiên trong chain
	}
	} else {
	$REMOTE_ADDR=$_SERVER['REMOTE_ADDR']; // Người dùng truy cập trực tiếp, không qua proxy
	}
	return $REMOTE_ADDR; // xuất ip thực của người dùng
// Cho server khác
/*	
	if ( !empty($_SERVER['HTTP_X_FORWARDED_FOR']) )
	{
	$X_FORWARDED_FOR=explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
	$REMOTE_ADDR=trim($X_FORWARDED_FOR[0]); //lấy giá trị đầu tiên
	} else {
	$REMOTE_ADDR=$_SERVER['REMOTE_ADDR'];
	}
	echo $REMOTE_ADDR;
*/
}
function update_ip($guest_ip,$position){
	global $conn;
	$table = "bnk_guest_ip";
	$where = "guest_ip='".$guest_ip."' and position=".$position;
	$countIp = countRecord($table,$where);
	if($countIp>0){
		$query = "UPDATE $table SET last_modified=now(),num_in=num_in+1 WHERE $where"; 
	}else{
		$query = "INSERT INTO $table (guest_ip,num_in,date_added,last_modified,position) VALUES ('".$guest_ip."',1,now(),now(),".$position.")"; 
	}
	mysql_query($query, $conn);
}
function Draw_Menu($arrItem, $type="", $parent_id = "",$class=""){
	global $curHost;
	global $seokey;
	$_return = '';
	$class = $class!="" ? $class : "";
	$parent_id = $parent_id != '' ? $parent_id : 1;
	if($parent_id>1) {$_return.="<ul>";}else{$_return.='';}
	
	for($i=0; $i<count($arrItem); $i++){
		if($arrItem[$i]['parent'] == $parent_id){
			//kiểm tra danh mục con
			if(countArray($arrItem,'parent',$arrItem[$i]['id'])){$dem=1;}
			//kiểm tra loại dữ liệu truyền vào
			if($type=='news'){
				if($dem>=1){$MenuPage = "6-";}else{$MenuPage = "2-";}
			}else{
				if($dem>=1){$MenuPage = "4-";}else{$MenuPage = "7-";}
			}
			$seo_arr=explode(',',$arrItem[$i]['subject']);
			//xét nội dung chuỗi SEO KEY
			if($arrItem[$i]['subject']!=''){
				//nếu chuỗi SEO KEY có nhiều từ thì nối các từ lại với nhau
				if(stripos(',',$arrItem[$i]['subject'])){
					$seo_keyword=substr_replace(',','-',str_replace(' ','-',$arrItem[$i]['subject']))."-";
				}else{
					$seo_keyword=str_replace(' ','-',trim($arrItem[$i]['subject']))."-";
				}
				
			}else{
				$seo_keyword='';
			}
			$link = $curHost.$arrItem[$i]['id']."-".$seo_keyword."/".$MenuPage.str_replace(' ','-',$arrItem[$i]['name']).".html";
			$_return.="<li><a href='".$link."'>".$arrItem[$i]['name']."</a>";
			$_return.=Draw_Menu($arrItem, $type, $arrItem[$i]['id']);
			$_return.="</li>";
			$dem=0;
		}else{$_return.="<li style='display:none;'></li>";}
	}
	if($parent_id>1) {$_return.="</ul>";}else{$_return.='';}
	return $_return;
}
?>