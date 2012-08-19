<?
	if(!session_id()) session_start();
	if(!isset($_SESSION["session_message"])){
		$_SESSION["session_message"] = "";
	}	
	
	if(isset($_GET['page']))
	$page = $_GET['page'];
	if (!session_is_registered('log')){
		header("Location: login.php");
	}
	require_once('config.php');
	require_once('common_start.php');
	require_once('lib/func.lib.php');

	$act_req = $_REQUEST['act'];
	$act = substr($act_req,-2,2)!='_m'?$act_req:substr($act_req,0,-2);

	$act_link = $_REQUEST['act'];
	$cat_link = $_REQUEST['cat']!=''?'&cat='.$_REQUEST['cat']:'';
	$page_link = $_REQUEST['page']!=''?'&page='.$_REQUEST['page']:'';
	
	$bg_td = $_REQUEST['bg_td'];
	$adminUid = $_SESSION['log'];
	$adminInfo 	= selectOne(tbl_config::tbl_controller,"uid='".$adminUid."'");
	$adminId	= $adminInfo['id'];
	$adminPw	= $adminInfo['pwd'];
	
	/* Set Admin IP: */
	if(!isset($_SESSION['ADMIN_IP']) || $_SESSION['ADMIN_IP'] == NULL){
		session_register('ADMIN_IP');
		$_SESSION['ADMIN_IP'] = get_real_ip();
		if($adminUid != ''){
			update_ip($_SESSION['ADMIN_IP'],$adminUid,1);
		}
	}
	
	$val = $_POST['val'];
	switch($val){
		case 'admin_log':
			echo 'Quản trị viên: ' . $adminUid;
			break;
		case 'logout': logout(); break;
		case 'admin_theme':
			echo $adminInfo['ad_bg'];
			break;
		case 'set_theme':
			echo set_theme($_POST['ad_theme'],$adminUid);
			break;
		case 'check_pw':
			echo check_pw($_POST['oldPw'],$adminPw);
			break;
		case 'change_pw':
			echo change_pw($_POST['new_pw'],$adminUid);
			break;
		case 'empty_cache':
			echo empty_cache($_POST['cache_val'],$_POST['cache_text']);
			break;
			
	}
        function logout(){
                if(session_unregister('log') && session_unregister('ADMIN_IP'))
                    $err = 'ok';
                else
                    $err = 'error';
                echo json_encode(array('error' => $err));
        }
	function set_theme($ad_theme,$adminUid){
		$errMessage = '';
		$fields_arr = array('ad_bg' => "'$ad_theme'");
		$result = update(tbl_config::tbl_controller,$fields_arr,"uid='".$adminUid."'");
		if($result)$errMessage = 'ok';
		return $errMessage;
	}
	function check_pw($old,$adminPw){
		$errMessage = '';
		if($old != $adminPw){
                    $err = 'err';
                    $errMessage = 'Sai mật khẩu!';
                }else{
                    $err = 'ok';
                    $errMessage = 'Đổi mật khẩu...';
                }
                echo json_encode(array('error' => $err, 'msg' => $errMessage));
	}
	function change_pw($newPw,$adminUid){
		$errMessage = '';
		$fields_arr = array('pwd' => "'$newPw'");
		$result = update(tbl_config::tbl_controller,$fields_arr,"uid='".$adminUid."'");
		if ($result){
                    $err = 'ok';
                    $errMessage = "Cập nhật thành công!";
                }else{
                    $err = 'err';
                    $errMessage = "Không thể cập nhật !";
                }
                echo json_encode(array('error' => $err, 'msg' => $errMessage));
	}
	function empty_cache($cache_val,$cache_text){
		$errMsg = '';
		if($cache_val != 'all'){
			if(is_dir('../cache/'.$cache_val)){
				EmptyDir('../cache/'.$cache_val);
				$err = 'SUCCESS';
				$errMsg = 'Xoá Cache '.$cache_text.' thành công!';
			}else{
				$err = 'ERROR';
				$errMsg = 'Không thể xoá Cache '.$cache_text.'!';
			}
		}else{
			EmptyDir('../cache');
			if(is_dir('../cache/home'))			EmptyDir('../cache/home');
			if(is_dir('../cache/content'))			EmptyDir('../cache/content');
			if(is_dir('../cache/contact'))			EmptyDir('../cache/contact');
                        if(is_dir('../cache/side_bar'))			EmptyDir('../cache/side_bar');
			$err = 'SUCCESS';
			$errMsg = 'Xoá toàn bộ Cache thành công!';
		}	
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	} 	
?>
