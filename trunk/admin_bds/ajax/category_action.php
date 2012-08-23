<?php
	require_once('../config.php');
	require_once('../lib/func.lib.php');
	
	$id = $_POST['id'];
	$chk = $_POST['chk'];
	$val = $_POST['val'];
	$val1 = $_POST['val1'];
	$val2 = $_POST['val2'];
	
	switch ($_POST['fnc']){	
		case 'del' 		: del($id);                 break;
		case 'del_multi' 	: del_multi($chk);          break;
		case 'show_hide' 	: show_hide($id, $val);     break;
                case 'sort_row' 	: sort_row($id, $val);      break;
		case 'top_menu' 	: top_menu($id, $val);      break;
		case 'edit_name' 	: edit_name($id, $val);     break;
                case 'edit_seo_key' 	: edit_seo_key($id, $val);  break;
                case 'edit_title' 	: edit_title($id, $val);    break;
                case 'edit_desc'        : edit_desc($id, $val);     break;
                case 'view_add_new' 	: view_add_new($id);        break;
		case 'add_new' 		: insert_new_category($id); break;
	}
	
	function del($id){
                $check = true;
		$r = selectOne(tbl_config::tbl_category,'id = ' . $id);
                $parent = selectOne(tbl_config::tbl_category,'id = ' . $r['parent_id']);
                switch($parent['code']){
                    case 'product':     $tbl = tbl_config::tbl_product;     break;
                    case 'properties':  $tbl = tbl_config::tbl_properties;  break;
                    case 'news':        $tbl = tbl_config::tbl_content;     break;
                }
		$fields_arr = array('id' => $id);
		$del1 = delete_rows(tbl_config::tbl_category,array('id' => $id));
                if($del1){
                    if(file_exists('../'.$r['image_thumbs'])) @unlink('../'.$r['image_thumbs']);
                    if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
                    if($parent['code'] == 'properties'){
                        $columes = 'id';
                    }else{
                        $columes = 'id,image_thumbs,image_large';                        
                    }
                    $childs = selectMulti($tbl,$columes,'parent_id = ' . $id);
                    if($childs){
                        $del2 = delete_rows($tbl,array('parent_id' => $id));
                        if($del2){
                            foreach($childs as $child){
                                if($parent['code'] == 'properties'){
                                    delete_rows(tbl_config::tbl_product_extend,array('properties_id' => $child['id']));
                                }else{
                                    if(file_exists('../'.$child['image_thumbs'])) @unlink('../'.$child['image_thumbs']);
                                    if(file_exists('../'.$child['image_large'])) @unlink('../'.$child['image_large']);
                                }
                            }
                        }else{
                            $check = false;
                        }
                    }
                }else{
                    $check = false;
                }
		if ($check){
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
                            $check = true;
                            $r = selectOne(tbl_config::tbl_category,'id = ' . $id);
                            $parent = selectOne(tbl_config::tbl_category,'id = ' . $r['parent_id']);
                            switch($parent['code']){
                                case 'product':     $tbl = tbl_config::tbl_product;     break;
                                case 'properties':  $tbl = tbl_config::tbl_properties;  break;
                                case 'news':        $tbl = tbl_config::tbl_content;     break;
                            }
                            $fields_arr = array('id' => $id);
                            $del1 = delete_rows(tbl_config::tbl_category,array('id' => $id));
                            if($del1){
                                if(file_exists('../'.$r['image_thumbs'])) @unlink('../'.$r['image_thumbs']);
                                if(file_exists('../'.$r['image_large'])) @unlink('../'.$r['image_large']);
                                if($parent['code'] == 'properties'){
                                    $columes = 'id';
                                }else{
                                    $columes = 'id,image_thumbs,image_large';
                                }
                                $childs = selectMulti($tbl,$columes,'parent_id = ' . $id);
                                if($childs){
                                    $del2 = delete_rows($tbl,array('parent_id' => $id));
                                    if($del2){
                                        foreach($childs as $child){
                                            if($parent['code'] == 'properties'){
                                                delete_rows(tbl_config::tbl_product_extend,array('properties_id' => $child['id']));
                                            }else{
                                                if(file_exists('../'.$child['image_thumbs'])) @unlink('../'.$child['image_thumbs']);
                                                if(file_exists('../'.$child['image_large'])) @unlink('../'.$child['image_large']);
                                            }
                                        }
                                    }else{
                                        $check = false;
                                    }
                                }
                            }else{
                                $check = false;
                            }
                            if ($check)
                                    $cntDel++;
                            else
                                    $cntNotDel++;
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
		$sort = selectOne(tbl_config::tbl_category, "id=".$id);
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
	function edit_name($id, $val){
		$fields_arr = array("name" => "'$val'", "last_modified" => time());
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
	function edit_seo_key($id, $val){
		$fields_arr = array("seo_key" => "'$val'", "last_modified" => time());
		$result = update(tbl_config::tbl_category,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật SEO KEY thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function edit_title($id, $val){
                $fields_arr = array("title" => "'$val'", "last_modified" => time());
		$result = update(tbl_config::tbl_category,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật Tiêu đề cho SEO thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
        function edit_desc($id, $val){
		$fields_arr = array("description" => "'$val'", "last_modified" => time());
		$result = update(tbl_config::tbl_category,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật mô tả thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function view_add_new($id){
                $get_parent = selectOne(tbl_config::tbl_category, 'id = ' . $id);
                $code = $get_parent['code'];
		$html = '';
                if($code == 'product' || $code == 'news'){
                    $html = '<div style="float:left;padding: 20px;">
                                Tên danh mục:<input type="text" id="name_space" value="" size="40" onkeyup="document.getElementById(\'seo_key_space\').value = this.value;document.getElementById(\'title_space\').value = this.value;" /><br>
                                SEO KEY:<input type="text" id="seo_key_space" value="" size="40" /><br>
                                Tiêu đề SEO:<input type="text" id="title_space" value="" size="40" /><br>
                                Mô tả:<textarea id="desc_space" name="desc_space" cols="40" rows="10"></textarea>
                             </div>';
                }else{
                    $html = '<div style="float:left;padding: 20px;">
                                Tên danh mục:<input type="text" id="name_space" value="" size="40" />
                             </div>';
                }
		echo $html;
	}
	function insert_new_category($id){
		$name = $_POST['name'] ? $_POST['name'] : 'no_name';
                $desc = $_POST['desc'] ? $_POST['desc'] : '';
                $seo_key = $_POST['seo_key'] ? $_POST['seo_key'] : '';
                $title = $_POST['title'] ? $_POST['title'] : '';
		$time = time();
		$fields_arr = array(
			"name"          => "'$name'",
                        "description"   => "'$desc'",
			"parent_id"     => "'$id'",
			"status"        => "1",
			"date_added"    => "$time",
			"last_modified" => "$time",
                        "seo_key"       => "'$seo_key'",
                        "title"         => "'$title'"
		);
		$insert_id = insert(tbl_config::tbl_category,$fields_arr);
		if($insert_id && $insert_id > 0) {
			$err = 'SUCCESS';
			$errMsg = "Thêm danh mục mới thành công";
			$inserted_id = $insert_id;
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể thêm danh mục mới!";
			$inserted_id = '';
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg, 'id' => $inserted_id, 'time' => date('d/m/Y h:i:s A',$time)));
	}
?>




