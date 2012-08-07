<?php
	require_once('../../config.php');
	require_once('../../lib/func.lib.php');
	$tbl = $_POST['tbl'];
	$parent_id = $_POST['parent_id'];
	$id = $_POST['id'];
	$chk = $_POST['chk'];
	$val = $_POST['val'];
	$val1 = $_POST['val1'];
	$val2 = $_POST['val2'];
	
	switch ($_POST['fnc']){	
		case 'del' 				: del($tbl,$id); 					break;
		case 'del_multi' 		: del_multi($tbl,$chk); 			break;
		case 'show_hide' 		: show_hide($tbl,$id, $val); 		break;
		case 'sort_row' 		: sort_row($tbl,$id, $val); 		break;
		case 'show_home' 		: show_home($tbl,$id, $val); 		break;
		case 'show_hot' 		: show_hot($tbl,$id, $val); 		break;
		case 'update_views' 	: update_views($tbl,$id, $val); 	break;
		case 'edit_name' 		: edit_name($tbl,$id, $val1, $val2);break;
		case 'view_edit_parent' : view_edit_parent($parent_id, $id);break;
		case 'update_parent' 	: update_parent($tbl, $id, $val);	break;
		case 'add_new' 			: insert_new_category($tbl); 		break;
		case 'view_edit_detail_short' 	: view_edit_detail_short($tbl, $id);	break;
		case 'update_detail_short' 		: update_detail_short($tbl, $id);		break;
		case 'view_edit_detail' : view_edit_detail($tbl, $id);		break;
		case 'update_detail' 	: update_detail($tbl, $id);			break;
		case 'view_edit_image' 	: view_edit_image($tbl, $id);		break;
		case 'update_image' 	: update_image($tbl, $id);			break;
		case 'check_contact' 	: check_contact($id, $val); 		break;
	}
	
	function del($tbl, $id){
		$r = getRecord($tbl,"id=".$id);
		$fields_arr = array("id" => $id);
		$result = delete_rows($tbl,$fields_arr);
		if ($result){
			if(file_exists('../../'.$r['image_thumbs'])) @unlink('../../'.$r['image_thumbs']);
			if(file_exists('../../'.$r['image'])) @unlink('../../'.$r['image']);
			$err = 'SUCCESS';
			$errMsg = "Đã xóa thành công!";
		}else{
			$err = 'ERROR';
			$errMsg = 'Không thể xóa dữ liệu!';
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function del_multi($tbl, $chk){
		$cntDel=0;
		$cntNotDel=0;
		if($chk!=''){
			foreach ($chk as $id){
				$r = getRecord($tbl,"id=".$id);
				$fields_arr = array("id" => $id);
				$result = delete_rows($tbl,$fields_arr);
				if ($result){
					if(file_exists('../../'.$r['image_thumbs'])) @unlink('../../'.$r['image_thumbs']);
					if(file_exists('../../'.$r['image'])) @unlink('../../'.$r['image']);
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
	function show_hide($tbl, $id, $val){
		$fields_arr = array("status" => "'$val'","last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
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
	function sort_row($tbl, $id, $val){
		$fields_arr = array("sort" => $val,"last_modified" => time());
		$sort = getRecord($tbl, "id=".$id);
		$result = update($tbl,$fields_arr,"id=".$id);
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
	function show_home($tbl, $id, $val){
		$fields_arr = array("show_home" => $val,"last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result && $val=='1'){
			$err = 'SUCCESS';
			$errMsg = "Đã Cập nhật trạng thái Hiển thị trang chủ.";
		}else if ($result && $val=='0'){
			$err = 'SUCCESS';
			$errMsg = "Đã Huỷ trạng thái Hiển thị trang chủ.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function show_hot($tbl, $id, $val){
		$fields_arr = array("show_hot" => $val,"last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result && $val=='1'){
			$err = 'SUCCESS';
			$errMsg = "Đã Cập nhật trạng thái bài tiêu điểm.";
		}else if ($result && $val=='0'){
			$err = 'SUCCESS';
			$errMsg = "Đã Huỷ trạng thái bài tiêu điểm.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function update_views($tbl, $id, $val){
		$fields_arr = array("views" => $val,"last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Đã Cập nhật lượt view thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function edit_name($tbl, $id, $val1, $val2){
		$fields_arr = array("name_vn" => "'$val1'", "name_en" => "'$val2'","last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật tên thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function view_edit_parent($parent_id, $id){
		$arraySourceCombo    = getArrayCombo(tbl_config::tbl_category,'id','name_vn','parent = ' . $parent_id);
		if ($arraySourceCombo){
			$err = 'SUCCESS';
			$drop_list = comboCategory('ddCatParent',$arraySourceCombo,'smallfont',$id,0);
		}else{
			$err = 'ERROR';
		}
		echo json_encode(array('error' => $err, 'drop_list' => $drop_list));
	}
	function update_parent($tbl, $id, $val){
		$fields_arr = array("parent" => $val,"last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Đã Cập nhật thành công danh mục.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function view_edit_detail_short($tbl, $id){
		require_once ('../ckeditor/ckeditor.php') ;
		require_once ('../ckfinder/ckfinder.php') ;
		$random_id = rand(1,9999);
		$detail_short = getRecord($tbl,'id = '.$id);
		$url = $_POST['url'];
		$form_data = '<form id="short_detail_form" name="short_detail_form" method="post" enctype="multipart/form-data" action="ajax/content_action.php">
		<input type="hidden" name="fnc" value="update_detail_short" />
		<input type="hidden" name="url" value="'.$url.'" />
		<input type="hidden" name="tbl" value="'.$tbl.'" />
		<input type="hidden" name="id" value="'.$id.'" />
		<div style="float:left;padding: 20px;">Nội dung tiếng Việt:
			<textarea name="txtshort_vn" cols="100" rows="10" id="txtshort_vn'.$random_id.'" class="to_get_id_short_vn">'.$detail_short['detail_short_vn'].'</textarea>
		</div>
		<div style="float:left;padding:20px;">Nội dung tiếng Anh:
			<textarea name="txtshort_en" cols="100" rows="10" id="txtshort_en'.$random_id.'" class="to_get_id_short_en">'.$detail_short['detail_short_en'].'</textarea>
		</div>
		</form>';
		$ckeditor = new CKEditor( ) ;
		$ckeditor->basePath    = 'ckeditor/' ;
		CKFinder::SetupCKEditor( $ckeditor, 'ckfinder/' ) ;
		$ckeditor->replace("txtshort_vn".$random_id);
		$ckeditor->replace("txtshort_en".$random_id);	
		echo $form_data;
	}
	function update_detail_short($tbl, $id){
		$val1 = $_POST['txtshort_vn'];
		$val2 = $_POST['txtshort_en'];
		$url = $_POST['url'];
		$fields_arr = array("detail_short_vn" => "'$val1'", "detail_short_en" => "'$val2'", "last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = 'Cập nhật Nội dung ngắn thành công!';
		}else{
			$err = 'ERROR';
			$errMsg = 'Không thể cập nhật!';
		}
		if($err == 'SUCCESS'){
			echo "<script>alert('".$errMsg."'); window.location='".$url."';</script>";
		}
	}
	function view_edit_detail($tbl, $id){
		require_once ('../ckeditor/ckeditor.php') ;
		require_once ('../ckfinder/ckfinder.php') ;
		$random_id = rand(1,9999);
		$detail = getRecord($tbl,'id = '.$id);
		$url = $_POST['url'];
		$form_data = '<form id="detail_form" name="detail_form" method="post" enctype="multipart/form-data" action="ajax/content_action.php">
		<input type="hidden" name="fnc" value="update_detail" />
		<input type="hidden" name="url" value="'.$url.'" />
		<input type="hidden" name="tbl" value="'.$tbl.'" />
		<input type="hidden" name="id" value="'.$id.'" />
		<div style="float:left;padding: 20px;">Nội dung tiếng Việt:
			<textarea name="txtlong_vn" cols="100" rows="10" id="txtlong_vn'.$random_id.'" class="to_get_id_vn">'.$detail['detail_vn'].'</textarea>
		</div>
		<div style="float:left;padding:20px;">Nội dung tiếng Anh:
			<textarea name="txtlong_en" cols="100" rows="10" id="txtlong_en'.$random_id.'" class="to_get_id_en">'.$detail['detail_en'].'</textarea>
		</div>
		</form>';
		$ckeditor = new CKEditor( ) ;
		$ckeditor->basePath    = 'ckeditor/' ;
		CKFinder::SetupCKEditor( $ckeditor, 'ckfinder/' ) ;
		$ckeditor->replace("txtlong_vn".$random_id);
		$ckeditor->replace("txtlong_en".$random_id);	
		echo $form_data;
	}
	function update_detail($tbl, $id){
		$val1 = $_POST['txtlong_vn'];
		$val2 = $_POST['txtlong_en'];
		$url = $_POST['url'];
		$fields_arr = array("detail_vn" => "'$val1'", "detail_en" => "'$val2'", "last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = 'Cập nhật Nội dung chi tiết thành công!';
		}else{
			$err = 'ERROR';
			$errMsg = 'Không thể cập nhật!';
		}
		if($err == 'SUCCESS'){
			echo "<script>alert('".$errMsg."'); window.location='".$url."';</script>";
		}
	}
	function view_edit_image($tbl, $id){
		$url = $_POST['url'];
		$code = $_POST['code'];
		$img_form = '<form id="img_form" name="img_form" method="post" enctype="multipart/form-data" action="ajax/content_action.php">
			<input type="hidden" name="fnc" value="update_image" />
			<input type="hidden" name="url" value="'.$url.'" />
			<input type="hidden" name="tbl" value="'.$tbl.'" />
			<input type="hidden" name="code" value="'.$code.'" />
			<input type="hidden" name="id" value="'.$id.'" />
			<div style="float:left;padding: 20px;">
				Chọn hình ảnh mới: <input type="file" id="txtImage" name="txtImage" class="textbox" size="34"><br>
				Kích thước: &lt;2MB<br>
				Định dạng: jpg,gif,bmp<br><br>
				Chọn xoá hình ảnh cũ: <input type="checkbox" id="chkClearImg" name="chkClearImg">
			</div>
			</form>';
		echo $img_form;
	}
	function update_image($tbl, $id){
		$url = $_POST['url'];
		$code = $_POST['code'];
		$img_check_clear = $_POST['chkClearImg'];
		$errMsg = '';
		$errMsg .= checkUpload($_FILES["txtImage"],".jpg;.gif;.bmp",2048*1024,0);
		$path = "../../images/".$code;
		if(!is_dir($path)) mkdir($path,0777);
		$pathdb = "images/".$code;
		
		$path_thumb = "../../images/".$code."/thumbs";
		if(!is_dir($path_thumb)) mkdir($path_thumb,0777);
		$pathdb_thumb = "images/".$code."/thumbs";
		
		$r = getRecord($tbl,"id=".$id);
		$return_img = '';
		if (!$img_check_clear || $img_check_clear==''){
			$extImg=getFileExtention($_FILES['txtImage']['name']);
			if (makeUpload($_FILES['txtImage'],"$path/".$code."_l".$id.$extImg)){
				@chmod("$path/".$code."_l".$id.$extImg, 0777);
				change_img_size("$path/".$code."_l".$id.$extImg,"$path/".$code."_l".$id.$extImg,800,1000);
				if($code == 'news'){
					change_img_size("$path/".$code."_l".$id.$extImg,"$path_thumb/".$code."_t".$id.$extImg,140,100);
				}else{
					change_img_size("$path/".$code."_l".$id.$extImg,"$path_thumb/".$code."_t".$id.$extImg,292,950);
				}
				$fields_arr = array("image" => "'".$pathdb."/".$code."_l".$id.$extImg."'",
									"image_thumbs" => "'".$pathdb_thumb."/".$code."_t".$id.$extImg."'",
									"last_modified" => time());
				$return_img = '../'.$pathdb_thumb."/".$code."_t".$code.$extImg;
				
			}	
		}else{
			if(file_exists('../../'.$r['image']) && file_exists('../../'.$r['image_thumbs'])){
				@unlink('../../'.$r['image']); @unlink('../../'.$r['image_thumbs']);
			}
			$fields_arr = array("image" => "''",
									"image_thumbs" => "''",
									"last_modified" => time());
		}		
		if($fields_arr!='')	{
			$result = update($tbl,$fields_arr,"id=".$id);
			if ($result){
				
				$errMsg = "Cập nhật hình ảnh thành công!";
			}else{
				$errMsg = "Không thể cập nhật!";
			}
		}
		echo "<script>alert('".$errMsg."'); window.location='".$url."';</script>";
	}
	function insert_new_category($tbl){
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
		$result = insert($tbl,$fields_arr);
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
	function check_contact($id, $val){
		$fields_arr = array("status" => "'$val'","last_modified" => time());
		$result = update(tbl_config::tbl_contact,$fields_arr,"id=".$id);
		if ($result && $val=='1'){
			$err = 'SUCCESS';
			$errMsg = "Đã xử lý thông tin liên hệ.";
		}else if ($result && $val=='0'){
			$err = 'SUCCESS';
			$errMsg = "Thông tin liên hệ cần xử lý.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	
?>







