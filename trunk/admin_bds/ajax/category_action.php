<?php
	require_once('../config.php');
	require_once('../lib/func.lib.php');
	
	$id = $_POST['id'];
	$chk = $_POST['chk'];
	$val = $_POST['val'];
	$val1 = $_POST['val1'];
	$val2 = $_POST['val2'];
	
	switch ($_POST['fnc']){	
		case 'del' 			: del($id); 					break;
		case 'del_multi' 	: del_multi($chk); 				break;
		case 'show_hide' 	: show_hide($id, $val); 		break;
		case 'sort_row' 	: sort_row($id, $val); 			break;
		case 'top_menu' 	: top_menu($id, $val); 			break;
		case 'bottom_menu' 	: bottom_menu($id, $val); 		break;
		case 'admin_menu' 	: admin_menu($id, $val); 		break;
		case 'edit_name' 	: edit_name($id, $val1, $val2); break;
		case 'add_new' 		: insert_new_category(); 		break;
	}
	
	function del($id){
		$r = getRecord(tbl_config::tbl_category,"id=".$id);
		$fields_arr = array("id" => $id);
		$result = delete_rows(tbl_config::tbl_category,$fields_arr);
		if ($result){
			if(file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
			if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
			$err = 'SUCCESS';
			$errMsg = "Đã xóa thành công!";
		}else{
			$err = 'ERROR';
			$errMsg = 'Không thể xóa dữ liệu!';
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function del_multi($chk){
		$cntDel=0;
		$cntNotDel=0;
		if($chk!=''){
			foreach ($chk as $id){
				$r = getRecord(tbl_config::tbl_category,"id=".$id);
				$fields_arr = array("id" => $id);
				$result = delete_rows(tbl_config::tbl_category,$fields_arr);
				if ($result){
					if(file_exists('../'.$r['image'])) @unlink('../'.$r['image']);
					if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
					$cntDel++;
				}else $cntNotDel++;
			}
			$err = 'SUCCESS';
			$errMsg = 'Đã xóa '.$cntDel.' phần tử.';
			$errMsg .= $cntNotDel>0 ? 'Không thể xóa '.$cntNotDel.' phần tử.' : '';
		}else{
			$err = 'ERROR';
			$errMsg = 'Hãy chọn trước khi xóa!';
		}	
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function show_hide($id, $val){
		$fields_arr = array("status" => "'$val'","last_modified" => time());
		$result = update(tbl_config::tbl_category,$fields_arr,"id=".$id);
		if ($result && $val=='1'){
			$err = 'SUCCESS';
			$errMsg = "Đã cập nhật trạng thái Ẩn.";
		}else if ($result && $val=='0'){
			$err = 'SUCCESS';
			$errMsg = "Đã cập nhật trạng thái Hiện.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}	
	function sort_row($id, $val){
		$fields_arr = array("sort" => $val,"last_modified" => time());
		$sort = getRecord(tbl_config::tbl_category, "id=".$id);
		$result = update(tbl_config::tbl_category,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			if($val > $sort['sort'])
				$errMsg = "Đã tăng vị trí sắp xếp lên 1";
			else
				$errMsg = "Đã giảm vị trí sắp xếp xuống 1";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function top_menu($id, $val){
		$fields_arr = array("top_menu" => $val,"last_modified" => time());
		$result = update(tbl_config::tbl_category,$fields_arr,"id=".$id);
		if ($result && $val=='1'){
			$err = 'SUCCESS';
			$errMsg = "Đã Cập nhật trạng thái Hiển thị top menu.";
		}else if ($result && $val=='0'){
			$err = 'SUCCESS';
			$errMsg = "Đã Huỷ trạng thái Hiển thị top menu.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function bottom_menu($id, $val){
		$fields_arr = array("bottom_menu" => $val,"last_modified" => time());
		$result = update(tbl_config::tbl_category,$fields_arr,"id=".$id);
		if ($result && $val=='1'){
			$err = 'SUCCESS';
			$errMsg = "Đã Cập nhật trạng thái bottom menu.";
		}else if ($result && $val=='0'){
			$err = 'SUCCESS';
			$errMsg = "Đã Huỷ trạng thái bottom menu.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function admin_menu($id, $val){
		$fields_arr = array("admin_menu" => $val,"last_modified" => time());
		$result = update(tbl_config::tbl_category,$fields_arr,"id=".$id);
		if ($result && $val=='1'){
			$err = 'SUCCESS';
			$errMsg = "Đã Cập nhật trạng thái admin menu.";
		}else if ($result && $val=='0'){
			$err = 'SUCCESS';
			$errMsg = "Đã Huỷ trạng thái admin menu.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function edit_name($id, $val1, $val2){
		$fields_arr = array("name_vn" => "'$val1'", "name_en" => "'$val2'","last_modified" => time());
		$result = update(tbl_config::tbl_category,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật tên thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function insert_new_category(){
		$code = $_POST['code'];
		$parent_id = $_POST['parent_id'];
		$name_vn = $_POST['name_vn'];
		$name_en = $_POST['name_en'];
		$time = time();
		$fields_arr = array(
			"code"          => "'$code'",
			"name_vn"       => "'$name_vn'",
			"name_en"      	=> "'$name_en'",
			"parent"      	=> "'$parent_id'",
			"status"		=> "0",
			"date_added"    => "$time",
			"last_modified" => "$time"
		);
		$result = insert(tbl_config::tbl_category,$fields_arr);
		if($result) {
			$err = 'SUCCESS';
			$errMsg = "Thêm danh mục mới thành công";
			$id = mysql_insert_id();	
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể thêm danh mục mới!";
			$id = '';
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg, 'id' => $id, 'time' => date('d/m/Y h:i:s A',$time)));
	}
?>







