<?
if(!isset($_SESSION['online'])){ 
    mysql_query("insert into ".TBL_VISITOR." (session_id, activity, ip_address, url, user_agent) values ('".session_id()."', now(), '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_REFERER']}', '{$_SERVER['HTTP_USER_AGENT']}')",$conn); 
    $_SESSION['online']=true;
	
	mysql_query("update ".TBL_CONFIG." set detail=detail+1 where code='total_visits'",$conn); 
} else { 
    if(isset($_SESSION['member']))
        mysql_query("update ".TBL_VISITOR." set activity=now(), member='y' where session_id='".session_id()."'",$conn); 
    else
		mysql_query("update ".TBL_VISITOR." set activity=now(), member='n' where session_id='".session_id()."'",$conn); 
}

$maxtime = $visitorTimeout; // 5 Minute time out. 60 * 5 = 300 
mysql_query("delete from ".TBL_VISITOR." where UNIX_TIMESTAMP(activity) < UNIX_TIMESTAMP(now())-$maxtime",$conn); 


$guest  = countRecord(TBL_VISITOR,"member='n'");
$members = countRecord(TBL_VISITOR,"member='y'");

$rConfig = getRecord(TBL_CONFIG,"code = 'total_visits'");
$total_visits = $rConfig['detail'];
?>

<strong><?=_ONLINE?> : <?=$members?> <?=_MEMBER?> - <?=$guest?> <?=_GUEST?> --- <?=_ACCESS?> : <?=$total_visits; ?> ---</strong>