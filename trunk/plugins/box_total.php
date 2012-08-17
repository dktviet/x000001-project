<?
if(!isset($_SESSION['online'])){ 
    mysql_query("insert into xteam_visitor (session_id, activity, ip_address, url, user_agent) values ('".session_id()."', now(), '{$_SERVER['REMOTE_ADDR']}', '{$_SERVER['HTTP_REFERER']}', '{$_SERVER['HTTP_USER_AGENT']}')",$conn); 
    $_SESSION['online']=true;
	
	mysql_query("update xteam_config set detail=detail+1 where code='total_visits'",$conn); 
} else { 
    if(isset($_SESSION['member']))
        mysql_query("update xteam_visitor set activity=now(), member='y' where session_id='".session_id()."'",$conn); 
    else
		mysql_query("update xteam_visitor set activity=now(), member='n' where session_id='".session_id()."'",$conn); 
}

$maxtime = $visitorTimeout; // 5 Minute time out. 60 * 5 = 300 
mysql_query("delete from xteam_visitor where UNIX_TIMESTAMP(activity) < UNIX_TIMESTAMP(now())-$maxtime",$conn); 

$guest  = countRecord("xteam_visitor","member='n'");
$members = countRecord("xteam_visitor","member='y'");

$rConfig = getRecord('xteam_config',"code = 'total_visits'");
$total_visits = $rConfig['detail'];
?>
<div class="child-content-left" style="text-align:center;">
    <div class="child-count">
        <p class="note-box">
		<?php
			if($_lang=="vn") echo "Số người Online : "; 
			else if($_lang=="en") echo "User online : "; 
			else echo "用戶在線 : ";
		?>
        <strong><?=$members+$guest?></strong>
        <br />
        <?php
			if($_lang=="vn") echo "Lượt truy cập : "; 
			else if($_lang=="en") echo "Total access : "; 
			else echo "總訪問 : ";
		?>
        <?=$total_visits; ?>
        </p>
    </div>
</div>