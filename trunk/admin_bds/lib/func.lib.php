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
$emailConfigRecord = selectOne(tbl_config::tbl_config,"code='adminEmail'");
$adminEmail = $emailConfigRecord['detail'];
//*********************************************************************************************************
//*********************************** Get currency unit config ********************************************
$currencyUnitConfigRecord = selectOne(tbl_config::tbl_config,"code='currencyUnit'");
$currencyUnit = $currencyUnitConfigRecord['detail'];
//*********************************************************************************************************
//************************************* Get hot line config ***********************************************
$hotlineConfigRecord = selectOne(tbl_config::tbl_config,"code='hotline'");
$hotline = $hotlineConfigRecord['detail'];
//*********************************************************************************************************
//************************************** Public Key Interface *********************************************
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
	$bad = array("\\","=",":","'","-","\"");
	$good = str_replace($bad,"", $str);
	return $good;
}
//************************************************************************************************************
//************************************************* PAGING ***************************************************
function countPages($total, $n){
	if($total%$n==0) return (int)($total/$n);
	return (int)($total/$n)+1;
}
function createPageLoad($total,$parent_id,$parent_name,$cat_id,$cat_name,$nitem,$itemcurrent,$step=5){
	$system_config = new system_config();
	$curHost = $system_config->curHost();
	if($total<1){return false;}
	global $conn;
	$ret="";
	$param="";
	$pages = countPages($total,$nitem);
	if ($itemcurrent>0) $ret.='<a href="'.$curHost.'td_'.$parent_id.'_'.$cat_id.'_p0/'.$parent_name.'/'.$cat_name.'.html" title="Đầu tiên" class="lslink">&lt;&lt;</a> ';
	if ($itemcurrent>1) $ret.='<a href="'.$curHost.'td_'.$parent_id.'_'.$cat_id.'_p'.($itemcurrent-1).'/'.$parent_name.'/'.$cat_name.'.html" title="Về trước" class="lslink">&lt;</a> ';
	$from=($itemcurrent-$step>0?$itemcurrent-$step:0);
	$to=($itemcurrent+$step<$pages?$itemcurrent+$step:$pages);
	for ($i=$from;$i<$to;$i++){
		if ($i!=$itemcurrent) $ret.='<a href="'.$curHost.'td_'.$parent_id.'_'.$cat_id.'_p'.($i).'/'.$parent_name.'/'.$cat_name.'.html" class="lslink">'.($i+1).'</a> ';
		else $ret.='<b>'.($i+1).'</b> ';
	}
	if (($itemcurrent<$pages-2) && ($pages>1)) $ret.='<a href="'.$curHost.'td_'.$parent_id.'_'.$cat_id.'_p'.($itemcurrent+1).'/'.$parent_name.'/'.$cat_name.'.html" title="Tiếp theo">&gt;</a> ';
	if ($itemcurrent<$pages-1) $ret.='<a href="'.$curHost.'td_'.$parent_id.'_'.$cat_id.'_p'.($pages-1).'/'.$parent_name.'/'.$cat_name.'.html" title="Cuối cùng">&gt;&gt;</a>'; 
	return $ret;
}
function createPage($total,$cat_id,$nitem,$itemcurrent,$step=5){
	if($total<1){return false;}
	global $conn;
	$ret="";
	$param="";
	$pages = countPages($total,$nitem);
	if ($itemcurrent>0) $ret.='<a href="#'.$cat_id.'#p_1" title="Đầu tiên" onclick="change_page(0);" class="lslink">[&lt;&lt;]</a> ';
	if ($itemcurrent>1) $ret.='<a href="#'.$cat_id.'#p_'.($itemcurrent).'" title="Về trước" onclick="change_page('.($itemcurrent-1).');" class="lslink">[&lt;]</a> ';
	$from=($itemcurrent-$step>0?$itemcurrent-$step:0);
	$to=($itemcurrent+$step<$pages?$itemcurrent+$step:$pages);
	for ($i=$from;$i<$to;$i++){
		if ($i!=$itemcurrent) $ret.='<a href="#'.$cat_id.'#p_'.($i+1).'" onclick="change_page('.$i.');" class="lslink">'.($i+1).'</a> ';
		else $ret.='<b>'.($i+1).'</b> ';
	}
	if (($itemcurrent<$pages-2) && ($pages>1)) $ret.='<a href="#'.$cat_id.'#p_'.($itemcurrent+2).'" title="Tiếp theo" onclick="change_page('.($itemcurrent+1).');">[&gt;]</a> ';
	if ($itemcurrent<$pages-1) $ret.='<a href="#'.$cat_id.'#p_'.($pages).'" title="Cuối cùng" onclick="change_page('.($pages-1).');">[&gt;&gt;]</a>'; 
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
		if ($req!=0) return "Bạn chưa chọn file !";
		return "";
	}else{
		if ($ext!="") if (strpos($ext, $fext)===false) 
			return "Tập tin không đúng định dạng : $fname";
		if ($maxsize>0) if ($fsize > $maxsize) 
			return "Kích thước phải nhỏ hơn ".$maxsize." byte";
	}
	return "";
}
function makeUpload($f,$newfile){
  if (move_uploaded_file($f["tmp_name"], $newfile))	return $newfile;
  return false;
}
//************************************************************************************************************
//************************************************************************************************************
function query($sql){
    global $conn;
    if ($sql == '') return false;
    $result_array = array();
	$result = mysql_query($sql,$conn);
	if($result){
		while($row=mysql_fetch_assoc($result)){
			$result_array[] = $row;
		}
	}
	return $result_array;
}

function selectMulti($table, $colume, $where='1=1', $orderby='', $limit=''){
    global $conn;
    if ($table == '') return false;
    $result_array = array();
	$result = mysql_query("select $colume from $table where $where $orderby $limit",$conn);
	if($result){
		while($row=mysql_fetch_assoc($result)){
			$result_array[] = $row;
		}
	}
	return $result_array;
}

function selectOne($table, $where='1=1', $orderby='date_added desc'){
    global $conn;
    if ($table == '') return false;
	$result = mysql_query("select * from $table where $where order by $orderby limit 1",$conn);
	if($result){
		return @mysql_fetch_assoc($result);
	}else{
		return '';
	}
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
	$arrVN = array("Chủ nhật","Thứ Hai","Thứ Ba","Thứ tư","Thứ năm","Thứ sáu","Thứ bảy");
	$arrEN = array("Sunday","Monday","Tueday","Wednesday","Thuday","Friday","Satuday");
	$date = strtotime($dateField);
	
	$arr = $lang=='vn'?$arrVN:$arrEN;
	
	return $arr[date('w',$date)].', '.date('d/m/Y, H:i (O)',$date);
}

function getArrayCategory($table, $catid="", $split="="){
    global $conn;
    $hide = "status=1";
    if (isset($_SESSION['log'])) $hide="1=1";
    $ret = array();
    if ($catid=="") $catid=0;
	$result = mysql_query("select * from $table where $hide and parent=$catid",$conn);
	while($row=mysql_fetch_assoc($result)){
		$ret[] = array($row['id'],($catid==0?"":$split).$row['name']);
		$getsub = getArrayCategory($table, $row['id'], $split.'===');
		foreach ($getsub as $sub)
			$ret[]=array($sub[0],$sub[1]);
	}
	return $ret;
}

function getArrayCombo($table, $valueField, $textField, $where=""){
	global $conn;
	$ret = array();
	$hide = "status=1";
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
	$system_config = new system_config();
	$arrLanguage = $system_config->arrLanguage();
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
	return $arrLanguage[0][1];
	//return $arrLanguage[0][1][2];
}

// $name            : name of combobox
// $arrSource  : function return array ; example : getListCategory(), getListNewsCategory()
// $index           : paramater selected
// $all             : $all==1 => show [Tat ca]
function comboCategory($name, $arrSource, $class, $index, $all){
	$name = $name != '' ? $name : 'cmbParent';
	if(!$arrSource){return false;}
	$out = '';
	$out .= '<select id="'.$name.'" name="'.$name.'" class="'.$class.'" onChange="choose_cat();" size="1">';
	$out .= $all==1 ? '<option value="">--Tất cả--</option>' : '';
	$cats = $arrSource;
	foreach ($cats as $cat){
		$selected = $cat[0] == $index ? 'selected' : '';
		$out .= '<option value="'.$cat[0].'" '.$selected.'>'.$cat[1].'</option>';
	}
	$out .= '</select>';
	return $out;
}
function comboProperties($name, $arrSource, $class, $index, $all, $allow_change=false, $ext_id=0, $prod_id=0){
	$name = $name != '' ? $name : 'cmbParent';
	if(!$arrSource){return false;}
        $onchange = $allow_change ? 'onChange="choose_properties(this.value, '.$ext_id.', '.$prod_id.');" ' : '';
	$out = '';
	$out .= '<select id="'.$name.'" name="'.$name.'" class="'.$class.'" '.$onchange.'size="1">';
	$out .= $all==1 ? '<option value="">--Chọn thuộc tính--</option>' : '';
	$cats = $arrSource;
	foreach ($cats as $cat){
		$selected = $cat[0] == $index ? 'selected' : '';
		$out .= '<option value="'.$cat[0].'" '.$selected.'>'.$cat[1].'</option>';
	}
	$out .= '</select>';
	return $out;
}

function comboSex($lang="vn", $index="0", $name="cmbSex", $class="textbox"){
	$arrValue  = array('0','1');
	$arrTextVN = array('Nam','Nữ');
	$arrTextEN = array('Male','Female');
	$arrText = $lang=="vn"?$arrTextVN:$arrTextEN;
	$firstValue = $lang=="vn"?"--Chọn giới tính--":"--Select sex--";
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

function comboCountry($lang="vn", $index="VN", $name="cmbCountry", $class="textbox"){
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
	$firstValue = $lang=="vn"?"--Chọn quốc gia--":"--Select country--";
	$out = '';
	$out .= '<select name="'.$name.'" id="'.$name.'" class="'.$class.'">';
	$out .= '<option value="-1">'.$firstValue.'</option>';
	for($i=0; $i<count($arrValue); $i++){
		$selected = $arrValue[$i] == $index || $arrValue[$i] == 'VN'? 'selected' : '';
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
	$result = mysql_query($query, $conn);
        $last_id = $result ? mysql_insert_id() : 0;
        return $last_id;
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
	$result = mysql_query($query, $conn);
	if (!$result) {return false;}
	return true;
}

function delete_where($table,$where) {
	global $conn;
	$query = "DELETE FROM $table WHERE $where";      
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

class mailer_config {
	const mail_user_name = 'dungnt@haytuyet.net';
	const mail_password = 'Dungquynh172!&@';
	const mail_reply_mail = 'dungnt@haytuyet.net';
	const mail_reply_name = 'Dungnt Adnet';
}
/*function send multi mail*/
function SendMultiMail($to_arr_email_and_name,$subject,$content){
	$i = 0;
	foreach($to_arr_email_and_name as $to_email => $to_name){
		GmailSend($to_email,$to_name,$subject,$content);
		$i++;
		if($i == 999) break;
	}
	return 'Sent ' . $i . ' email!';
}
/*function send mail*/
function GmailSend($to_email,$to_name,$subject,$content,$from_email=false,$from_name=false,$add=true){
	require_once 'phpmailer/class.phpmailer.php';
	require_once 'phpmailer/class.smtp.php';
	$mail = new PHPMailer();
	$mail->IsSMTP(); // send via SMTP
	$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
	                                           // 1 = errors and messages
	                                           // 2 = messages only
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
	
	$mail->Username = mailer_config::mail_user_name; // SMTP username
	$mail->Password = mailer_config::mail_password; // SMTP password
	$mail->Port = 465;
	$mail->CharSet="utf-8";
	      
	if ($from_email){
		$mail->From     = $from_email;
		$mail->FromName = $from_name;
	}else{
		$mail->From     = mailer_config::mail_reply_mail;
		$mail->FromName = mailer_config::mail_reply_name;
	}
	$mail->IsHTML(true); // send as HTML
	$mail->Subject =  $subject;
	$mail->AltBody = $content;
	$mail->AddReplyTo($from_email,$from_name);
	$mail->AddAddress($to_email,$to_name); 
	$mail->Body = $content;
	return $mail->Send();  
}
// Convert utf8 to ascII ************************************************************************************************************
function utf8_to_ascii($str) {
	$chars = array(
		'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
		'e' =>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
		'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
		'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ','ô','ơ'),
		'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
		'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'd'	=>	array('đ'),
		'D'	=>	array('Đ'),
/*
		'd'	=>	array('D'),
		'b'	=>	array('B'),
		'c'	=>	array('C'),
		'f'	=>	array('F'),
		'g'	=>	array('G'),
		'h'	=>	array('H'),
		'j'	=>	array('J'),
		'k'	=>	array('K'),
		'l'	=>	array('L'),
		'm'	=>	array('M'),
		'n'	=>	array('N'),
		'p'	=>	array('P'),
		'q'	=>	array('Q'),
		'r'	=>	array('R'),
		's'	=>	array('S'),
		't'	=>	array('T'),
		'v'	=>	array('V'),
		'w'	=>	array('W'),
		'x'	=>	array('X'),
		'z'	=>	array('Z'),
*/
		'_' =>	array(' - ','-',' ','.','/',','),
		'' =>	array('~','`','!','@','#','$','%','^','&','*','(',')','+','=','|','[',']','{','}',':','"',"'",';','?','<','>','\\','\'','“','”')
	);
	foreach ($chars as $key => $arr) 
		foreach ($arr as $val)
			$str = str_replace($val,$key,$str);
	return $str;
}
// Convert title to url ************************************************************************************************************
function title_to_url($str) {
	$chars = array(
		'-' =>	array(' - ','... ','...',', ','. ',' ','.','/',',','_'),
		'' =>	array('~','`','!','@','#','$','%','^','&','*','(',')','+','=','|','[',']','{','}',':','"',"'",';','?','<','>','\\','\'','“','”')
	);
	foreach ($chars as $key => $arr)
		foreach ($arr as $val)
			$str = str_replace($val,$key,$str);
	return $str;
}
// Convert url for cache file ************************************************************************************************************
function no_sign_text($str) {
	$chars = array(
		'a'	=>	array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
		'e' =>	array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
		'i'	=>	array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
		'o'	=>	array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ','ô','ơ'),
		'u'	=>	array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
		'y'	=>	array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'd'	=>	array('đ'),
		'D'	=>	array('Đ')
	);
	foreach ($chars as $key => $arr)
		foreach ($arr as $val)
			$str = str_replace($val,$key,$str);
	return $str;
}

// Convert '' to "" (fix for input form) ************************************************************************************************************
function fix_input($str) {
	$chars = array(
		'"'	=>	array('\'')
	);
	foreach ($chars as $key => $arr) 
		foreach ($arr as $val)
			$str = str_replace($val,$key,$str);
	return $str;
}

// Change language ************************************************************************************************
function lang_change($str_01,$str_02){
//	global SITE_LANG;
	switch(SITE_LANG){
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

// Cut string ************************************************************************************************
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
            if($pos_end === false) $string = $pre_string."...";
            else $string = substr($pre_string, 0, $pos_end)."...";
        }
        else if ($match_compute > (strlen($string) - ($length - strlen($match_to))))
        {
            $pre_string = substr($string, (strlen($string) - ($length - strlen($match_to))));
            $pos_start = strpos($pre_string, " ");
            $string = "...".substr($pre_string, $pos_start);
            if($pos_start === false) $string = "...".$pre_string;
            else $string = "...".substr($pre_string, $pos_start);
        }
        else
        {
            $pre_string = substr($string, ($match_compute - round(($length / 3))), $length);
            $pos_start = strpos($pre_string, " "); $pos_end = strrpos($pre_string, " ");
            $string = "...".substr($pre_string, $pos_start, $pos_end)."...";
            if($pos_start === false && $pos_end === false) $string = "...".$pre_string."...";
            else $string = "...".substr($pre_string, $pos_start, $pos_end)."...";
        }
 
        $match_start = stristr($string, $match_to);
        $match_compute = strlen($string) - strlen($match_start);
    }
 
    return $string;
    }else{
        return $string ='';
    }
}

// Get real IP ************************************************************************************************
function get_real_ip(){
	if ($_SERVER['X_FORWARDED_FOR'] !="")
	{
	$X_FORWARDED_FOR=explode(",", $_SERVER['X_FORWARDED_FOR']);
	$count = count($X_FORWARDED_FOR);
	if($count == 0 ) {
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
function update_ip($guest_ip,$uid,$position){
	global $conn;
	$where1 = "guest_ip='".$guest_ip."' and uid='".$uid."' and position=".$position;
	$where2 .= $where1.' and UNIX_TIMESTAMP(last_modified) < UNIX_TIMESTAMP(now())-'.system_config::visitorTimeout;
	$countIp1 = countRecord(tbl_config::tbl_guest_ip,$where1);
	$countIp2 = countRecord(tbl_config::tbl_guest_ip,$where2);
	if($countIp1>0 || $countIp2>0){
		$query = "UPDATE ".tbl_config::tbl_guest_ip." SET last_modified=now(),num_in=num_in+1 WHERE $where1"; 
	}else{
		$query = "INSERT INTO ".tbl_config::tbl_guest_ip." (guest_ip,num_in,date_added,last_modified,uid,position) VALUES ('".$guest_ip."',1,now(),now(),'".$uid."',".$position.")"; 
	}
	$runUpdate = mysql_query($query, $conn);
}

/* thuat toan tinh am lich. Dung ham convertSolar2Lunar() de doi tu ngay duong sang ngay am lich*/
function INT($d) {
    return floor($d);
}

function jdFromDate($dd, $mm, $yy) {
    $a = INT((14 - $mm) / 12);
    $y = $yy + 4800 - $a;
    $m = $mm + 12 * $a - 3;
    $jd = $dd + INT((153 * $m + 2) / 5) + 365 * $y + INT($y / 4) - INT($y / 100) + INT($y / 400) - 32045;
    if ($jd < 2299161) {
        $jd = $dd + INT((153* $m + 2)/5) + 365 * $y + INT($y / 4) - 32083;
    }
    return $jd;
}

function jdToDate($jd) {
    if ($jd > 2299160) { // After 5/10/1582, Gregorian calendar
        $a = $jd + 32044;
        $b = INT((4*$a+3)/146097);
        $c = $a - INT(($b*146097)/4);
    } else {
        $b = 0;
        $c = $jd + 32082;
    }
    $d = INT((4*$c+3)/1461);
    $e = $c - INT((1461*$d)/4);
    $m = INT((5*$e+2)/153);
    $day = $e - INT((153*$m+2)/5) + 1;
    $month = $m + 3 - 12*INT($m/10);
    $year = $b*100 + $d - 4800 + INT($m/10);
    //echo "day = $day, month = $month, year = $year\n";
    return array($day, $month, $year);
}

function getNewMoonDay($k, $timeZone) {
    $T = $k/1236.85; // Time in Julian centuries from 1900 January 0.5
    $T2 = $T * $T;
    $T3 = $T2 * $T;
    $dr = M_PI/180;
    $Jd1 = 2415020.75933 + 29.53058868*$k + 0.0001178*$T2 - 0.000000155*$T3;
    $Jd1 = $Jd1 + 0.00033*sin((166.56 + 132.87*$T - 0.009173*$T2)*$dr); // Mean new moon
    $M = 359.2242 + 29.10535608*$k - 0.0000333*$T2 - 0.00000347*$T3; // Sun's mean anomaly
    $Mpr = 306.0253 + 385.81691806*$k + 0.0107306*$T2 + 0.00001236*$T3; // Moon's mean anomaly
    $F = 21.2964 + 390.67050646*$k - 0.0016528*$T2 - 0.00000239*$T3; // Moon's argument of latitude
    $C1=(0.1734 - 0.000393*$T)*sin($M*$dr) + 0.0021*sin(2*$dr*$M);
    $C1 = $C1 - 0.4068*sin($Mpr*$dr) + 0.0161*sin($dr*2*$Mpr);
    $C1 = $C1 - 0.0004*sin($dr*3*$Mpr);
    $C1 = $C1 + 0.0104*sin($dr*2*$F) - 0.0051*sin($dr*($M+$Mpr));
    $C1 = $C1 - 0.0074*sin($dr*($M-$Mpr)) + 0.0004*sin($dr*(2*$F+$M));
    $C1 = $C1 - 0.0004*sin($dr*(2*$F-$M)) - 0.0006*sin($dr*(2*$F+$Mpr));
    $C1 = $C1 + 0.0010*sin($dr*(2*$F-$Mpr)) + 0.0005*sin($dr*(2*$Mpr+$M));
    if ($T < -11) {
        $deltat= 0.001 + 0.000839*$T + 0.0002261*$T2 - 0.00000845*$T3 - 0.000000081*$T*$T3;
    } else {
        $deltat= -0.000278 + 0.000265*$T + 0.000262*$T2;
    };
    $JdNew = $Jd1 + $C1 - $deltat;
    //echo "JdNew = $JdNew\n";
    return INT($JdNew + 0.5 + $timeZone/24);
}

function getSunLongitude($jdn, $timeZone) {
    $T = ($jdn - 2451545.5 - $timeZone/24) / 36525; // Time in Julian centuries from 2000-01-01 12:00:00 GMT
    $T2 = $T * $T;
    $dr = M_PI/180; // degree to radian
    $M = 357.52910 + 35999.05030*$T - 0.0001559*$T2 - 0.00000048*$T*$T2; // mean anomaly, degree
    $L0 = 280.46645 + 36000.76983*$T + 0.0003032*$T2; // mean longitude, degree
    $DL = (1.914600 - 0.004817*$T - 0.000014*$T2)*sin($dr*$M);
    $DL = $DL + (0.019993 - 0.000101*$T)*sin($dr*2*$M) + 0.000290*sin($dr*3*$M);
    $L = $L0 + $DL; // true longitude, degree
    //echo "\ndr = $dr, M = $M, T = $T, DL = $DL, L = $L, L0 = $L0\n";
    $L = $L*$dr;
    $L = $L - M_PI*2*(INT($L/(M_PI*2))); // Normalize to (0, 2*PI)
    return INT($L/M_PI*6);
}

function getLunarMonth11($yy, $timeZone) {
    $off = jdFromDate(31, 12, $yy) - 2415021;
    $k = INT($off / 29.530588853);
    $nm = getNewMoonDay($k, $timeZone);
    $sunLong = getSunLongitude($nm, $timeZone); // sun longitude at local midnight
    if ($sunLong >= 9) {
        $nm = getNewMoonDay($k-1, $timeZone);
    }
    return $nm;
}

function getLeapMonthOffset($a11, $timeZone) {
    $k = INT(($a11 - 2415021.076998695) / 29.530588853 + 0.5);
    $last = 0;
    $i = 1; // We start with the month following lunar month 11
    $arc = getSunLongitude(getNewMoonDay($k + $i, $timeZone), $timeZone);
    do {
        $last = $arc;
        $i = $i + 1;
        $arc = getSunLongitude(getNewMoonDay($k + $i, $timeZone), $timeZone);
    } while ($arc != $last && $i < 14);
    return $i - 1;
}


/* Comvert solar date dd/mm/yyyy to the corresponding lunar date */
function convertSolar2Lunar($dd, $mm, $yy, $timeZone) {
    $dayNumber = jdFromDate($dd, $mm, $yy);
    $k = INT(($dayNumber - 2415021.076998695) / 29.530588853);
    $monthStart = getNewMoonDay($k+1, $timeZone);
    if ($monthStart > $dayNumber) {
        $monthStart = getNewMoonDay($k, $timeZone);
    }
    $a11 = getLunarMonth11($yy, $timeZone);
    $b11 = $a11;
    if ($a11 >= $monthStart) {
        $lunarYear = $yy;
        $a11 = getLunarMonth11($yy-1, $timeZone);
    } else {
        $lunarYear = $yy+1;
        $b11 = getLunarMonth11($yy+1, $timeZone);
    }
    $lunarDay = $dayNumber - $monthStart + 1;
    $diff = INT(($monthStart - $a11)/29);
    $lunarLeap = 0;
    $lunarMonth = $diff + 11;
    if ($b11 - $a11 > 365) {
        $leapMonthDiff = getLeapMonthOffset($a11, $timeZone);
        if ($diff >= $leapMonthDiff) {
            $lunarMonth = $diff + 10;
            if ($diff == $leapMonthDiff) {
                $lunarLeap = 1;
            }
        }
    }
    if ($lunarMonth > 12) {
        $lunarMonth = $lunarMonth - 12;
    }
    if ($lunarMonth >= 11 && $diff < 4) {
        $lunarYear -= 1;
    }
    return array($lunarDay, $lunarMonth, $lunarYear, $lunarLeap);
}

/* Convert a lunar date to the corresponding solar date */
function convertLunar2Solar($lunarDay, $lunarMonth, $lunarYear, $lunarLeap, $timeZone) {
    if ($lunarMonth < 11) {
        $a11 = getLunarMonth11($lunarYear-1, $timeZone);
        $b11 = getLunarMonth11($lunarYear, $timeZone);
    } else {
        $a11 = getLunarMonth11($lunarYear, $timeZone);
        $b11 = getLunarMonth11($lunarYear+1, $timeZone);
    }
    $k = INT(0.5 + ($a11 - 2415021.076998695) / 29.530588853);
    $off = $lunarMonth - 11;
    if ($off < 0) {
        $off += 12;
    }
    if ($b11 - $a11 > 365) {
        $leapOff = getLeapMonthOffset($a11, $timeZone);
        $leapMonth = $leapOff - 2;
        if ($leapMonth < 0) {
            $leapMonth += 12;
        }
        if ($lunarLeap != 0 && $lunarMonth != $leapMonth) {
            return array(0, 0, 0);
        } else if ($lunarLeap != 0 || $off >= $leapOff) {
            $off += 1;
        }
    }
    $monthStart = getNewMoonDay($k + $off, $timeZone);
    return jdToDate($monthStart + $lunarDay - 1);
}

// Lam trong thu muc
function EmptyDir($dir) {
	$handle=opendir($dir);
	while (($file = readdir($handle))!==false) {
		//echo "$file <br>";
		@unlink($dir.'/'.$file);
	}
	closedir($handle);
}

// Get google page rank
function google_page_rank($url) { // URL or domain name
    if (strlen(trim($url))>0) {
        $_url = eregi("http://",$url)? $url:"http://".$url;
        $pagerank = trim(GooglePageRank($_url));
        if (empty($pagerank)) $pagerank = 0;
        return (int)($pagerank);
    }
    return 0;
}
 
function GooglePageRank($url) {
    $fp = fsockopen("toolbarqueries.google.com", 80, $errno, $errstr, 30);
    if (!$fp) {
        echo "$errstr ($errno)<br />\n";
        } else {
        $out = "GET /search?client=navclient-auto&ch=".CheckHash(HashURL($url))."&features=Rank&q=info:".$url."&num=100&filter=0 HTTP/1.1\r\n";
        $out .= "Host: toolbarqueries.google.com\r\n";
        $out .= "User-Agent: Mozilla/4.0 (compatible; GoogleToolbar 2.0.114-big; Windows XP 5.1)\r\n";
        $out .= "Connection: Close\r\n\r\n";
        fwrite($fp, $out);
 
        while (!feof($fp)) {
            $data = fgets($fp, 128);
            $pos = strpos($data, "Rank_");
        if($pos === false){} else{
                $pagerank = substr($data, $pos + 9);
            }
        }
        fclose($fp);
        return $pagerank;
    }
}
 
function StrToNum($Str, $Check, $Magic) {
    $Int32Unit = 4294967296; // 2^32
    $length = strlen($Str);
    for ($i = 0; $i < $length; $i++) {
        $Check *= $Magic;
        if ($Check >= $Int32Unit) {
            $Check = ($Check - $Int32Unit * (int) ($Check / $Int32Unit));
            $Check = ($Check < -2147483648)? ($Check + $Int32Unit) : $Check;
        }
        $Check += ord($Str{$i});
    }
    return $Check;
}
 
function HashURL($String) {
    $Check1 = StrToNum($String, 0x1505, 0x21);
    $Check2 = StrToNum($String, 0, 0x1003F);
    $Check1 >>= 2;
    $Check1 = (($Check1 >> 4) & 0x3FFFFC0 ) | ($Check1 & 0x3F);
    $Check1 = (($Check1 >> 4) & 0x3FFC00 ) | ($Check1 & 0x3FF);
    $Check1 = (($Check1 >> 4) & 0x3C000 ) | ($Check1 & 0x3FFF);
    $T1 = (((($Check1 & 0x3C0) << 4) | ($Check1 & 0x3C)) << 2 ) | ($Check2 & 0xF0F );
    $T2 = (((($Check1 & 0xFFFFC000) << 4) | ($Check1 & 0x3C00)) << 0xA) | ($Check2 & 0xF0F0000 );
    return ($T1 | $T2);
}
 
function CheckHash($Hashnum) {
    $CheckByte = 0;
    $Flag = 0;
    $HashStr = sprintf('%u', $Hashnum) ;
    $length = strlen($HashStr);
    for ($i = $length - 1; $i >= 0; $i --) {
        $Re = $HashStr{$i};
        if (1 === ($Flag % 2)) {
            $Re += $Re;
            $Re = (int)($Re / 10) + ($Re % 10);
        }
        $CheckByte += $Re;
        $Flag ++;
    }
    $CheckByte %= 10;
    if (0!== $CheckByte) {
        $CheckByte = 10 - $CheckByte;
        if (1 === ($Flag % 2) ) {
            if (1 === ($CheckByte % 2)) {
                $CheckByte += 9;
            }
            $CheckByte >>= 1;
        }
    }
    return '7'.$CheckByte.$HashStr;
}

// Get Alexa rank
function alexaRank($domain){
    $remote_url = 'http://data.alexa.com/data?cli=10&dat=snbamz&url='.trim($domain);
    $search_for = '<POPULARITY URL';
    if ($handle = @fopen($remote_url, "r")) {
        while (!feof($handle)) {
            $part .= fread($handle, 100);
            $pos = strpos($part, $search_for);
            if ($pos === false)
            continue;
            else
            break;
        }
        $part .= fread($handle, 100);
        fclose($handle);
    }
    $str = explode($search_for, $part);
    $str = array_shift(explode('"/>', $str[1]));
    $str = explode('TEXT="', $str);
 
    return $str[1];
}
/* auto download images from remote server */
function auto_save_image($inPath,$outPath){
    $in 	= fopen($inPath, "rb");
    $out 	= fopen($outPath, "wb");
    while ($chunk = fread($in,8192)){
        fwrite($out, $chunk, 8192);
    }
    fclose($in);
    fclose($out);
}
function FormatNumber($number) {
	$number = doubleval($number);
	if (!$number)
		$number = 0;
	return number_format($number, 0, '.', ',');
}

function html_entity($string, $encode = true){
        $string = $encode ? $string = htmlentities($string) : html_entity_decode($string);
        return $string;
}

function product_properties($product_id){
        $sql = 'SELECT (SELECT name FROM ' . tbl_config::tbl_category . ' WHERE id = prop.parent_id) cat, prop.name name
                FROM ' . tbl_config::tbl_properties . ' prop INNER JOIN ' . tbl_config::tbl_product_extend . ' ext
                ON ext.properties_id = prop.id WHERE ext.product_id = ' . $product_id;
        $properties = query($sql);
        if(!$properties)
                return false;
        else
                return $properties;
}
?>
