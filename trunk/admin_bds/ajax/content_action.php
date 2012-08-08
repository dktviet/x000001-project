<?php
	require_once('../config.php');
	require_once('../lib/func.lib.php');
        $fnc = $_POST['fnc'] ? $_POST['fnc'] : $_GET['fnc'];
	$tbl = $_POST['tbl'] ? $_POST['tbl'] : $_GET['tbl'];
	$parent_id = $_POST['parent_id'] ? $_POST['parent_id'] : $_GET['parent_id'];
	$id = $_POST['id'];
	$chk = $_POST['chk'];
	$val = $_POST['val'];
	$val1 = $_POST['val1'];
	$val2 = $_POST['val2'];
	
	switch ($fnc){
		case 'del' 			: del($tbl,$id);                        break;
		case 'del_multi' 		: del_multi($tbl,$chk); 		break;
		case 'show_hide' 		: show_hide($tbl,$id, $val); 		break;
		case 'sort_row' 		: sort_row($tbl,$id, $val); 		break;
		case 'show_home' 		: show_home($tbl,$id, $val); 		break;
		case 'show_hot' 		: show_hot($tbl,$id, $val); 		break;
		case 'update_views'             : update_views($tbl,$id, $val); 	break;
		case 'edit_name' 		: edit_name($tbl,$id, $val1, $val2);    break;
		case 'view_edit_parent'         : view_edit_parent($parent_id, $id);    break;
		case 'update_parent'            : update_parent($tbl, $id, $val);	break;
                case 'view_add_new_content'     : view_add_new_content($tbl, $parent_id); break;
		case 'add_new' 			: add_new_content($tbl, $parent_id);    break;
		case 'view_edit_detail_short' 	: view_edit_detail_short($tbl, $id);	break;
		case 'update_detail_short' 	: update_detail_short($tbl, $id);	break;
		case 'view_edit_detail'         : view_edit_detail($tbl, $id);		break;
		case 'update_detail'            : update_detail($tbl, $id);		break;
		case 'view_edit_image'          : view_edit_image($tbl, $id);		break;
		case 'update_image'             : update_image($tbl, $id);		break;
		case 'check_contact'            : check_contact($id, $val); 		break;
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
                    <div id="short_en_call" style="float:left;padding:10px 20px;">
                            <input type="button" value="Thêm/Sửa Tiếng Anh" />
                    </div>
                    <div id="short_en_show" style="float:left;padding:20px;">Nội dung tiếng Anh:
                            <textarea name="txtshort_en" cols="100" rows="10" id="txtshort_en'.$random_id.'" class="to_get_id_short_en">'.$detail_short['detail_short_en'].'</textarea>
                    </div>
		</form>';
                $form_data .= script_for_edit_content();
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
                    <div id="long_en_call" style="float:left;padding:10px 20px;">
                            <input type="button" value="Thêm/Sửa Tiếng Anh" />
                    </div>
                    <div id="long_en_show" style="float:left;padding:20px;">Nội dung tiếng Anh:
                            <textarea name="txtlong_en" cols="100" rows="10" id="txtlong_en'.$random_id.'" class="to_get_id_en">'.$detail['detail_en'].'</textarea>
                    </div>
		</form>';
                $form_data .= script_for_edit_content();
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
                $folder_img = date('d-m-Y');
		$path = '../../images/'.$code;
                if(!is_dir($path)) mkdir($path,0777);
                $path .= '/'.$folder_img;
                if(!is_dir($path)) mkdir($path,0777);
                $pathdb = 'images/'.$code.'/'.$folder_img;

                $path_thumb = $path.'/thumbs';
                if(!is_dir($path_thumb)) mkdir($path_thumb,0777);
                $pathdb_thumb = $pathdb.'/thumbs';
		
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
        function view_add_new_content($tbl, $parent_id){
            require_once ('../ckeditor/ckeditor.php') ;
            require_once ('../ckfinder/ckfinder.php') ;
            $url = $_POST['url'];
            $random_id = rand(1,9999);
            $arraySourceCombo    = getArrayCombo(tbl_config::tbl_category,'id','name_vn','parent = ' . $parent_id);
            $get_parent_code = getRecord(tbl_config::tbl_category, 'id = ' . $parent_id);
            $code = $get_parent_code['code'];
            $html = '<form id="add_new_form" name="add_new_form" enctype="multipart/form-data" method="post" action="ajax/content_action.php">
                <input type="hidden" name="fnc" value="add_new" />
                <input type="hidden" name="url" value="'.$url.'" />
                <input type="hidden" name="tbl" value="'.$tbl.'" />
                <input type="hidden" name="code" value="'.$code.'" />
                <table border="0" cellpadding="2" bordercolor="#111111" width="100%" cellspacing="0">
                    <tr>
                            <td width="15%" class="smallfont" align="right">Tên</td>
                            <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                            <td width="83%" class="smallfont">
                                    <input value="" type="text" name="txtName_vn" class="textbox" size="34">
                            </td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right">Name</td>
                            <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                            <td width="83%" class="smallfont">
                                    <input value="" type="text" name="txtName_en" class="textbox" size="34">
                            </td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right">Hình ảnh</td>
                            <td width="1%" class="smallfont" align="center"></td>
                            <td width="83%" class="smallfont">
                                    <input type="file" name="txtImage" class="textbox" size="34" />
                                    (Kích thước&lt;2MB)(jpg,gif,bmp)
                            </td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right">Nội dung ngắn</td>
                            <td width="1%" class="smallfont" align="center"></td>
                            <td width="83%" class="smallfont">
                                    <textarea name="txtshort_vn" cols="80" rows="10" id="txtshort_vn'.$random_id.'"></textarea>
                            </td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right"></td>
                            <td width="1%" class="smallfont" align="center"></td>
                            <td width="83%" class="smallfont" id="short_en_call">
                                    <input type="button" value="Thêm/Sửa Tiếng Anh" />
                            </td>
                    </tr>
                    <tr id="short_en_show">
                            <td width="15%" class="smallfont" align="right">Short content</td>
                            <td width="1%" class="smallfont" align="center"></td>
                            <td width="83%" class="smallfont">
                                    <textarea name="txtshort_en" cols="80" rows="10" id="txtshort_en'.$random_id.'"></textarea>
                            </td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right">Nội dung chi tiết</td>
                            <td width="1%" class="smallfont" align="center"></td>
                            <td width="83%" class="smallfont">
                                    <textarea name="txtlong_vn" cols="80" rows="10" id="txtlong_vn'.$random_id.'"></textarea>
                            </td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right"></td>
                            <td width="1%" class="smallfont" align="center"></td>
                            <td width="83%" class="smallfont" id="long_en_call">
                                    <input type="button" value="Thêm/Sửa Tiếng Anh">
                            </td>
                    </tr>
                    <tr id="long_en_show">
                            <td width="15%" class="smallfont" align="right">Detail content</td>
                            <td width="1%" class="smallfont" align="center"></td>
                            <td width="83%" class="smallfont">
                                    <textarea name="txtlong_en" cols="80" rows="10" id="txtlong_en'.$random_id.'"></textarea>
                            </td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right">Thuộc danh mục</td>
                            <td width="1%" class="smallfont" align="center"></td>
                            <td width="83%" class="smallfont">'.comboCategory('ddCat',$arraySourceCombo,'smallfont',$parent,0).'</td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right">Lượt xem</td>
                            <td width="1%" class="smallfont" align="right"></td>
                            <td width="83%" class="smallfont">
                                    <input value="" type="text" name="txtViews" class="textbox" size="10">
                            </td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right">Thứ tự sắp xếp</td>
                            <td width="1%" class="smallfont" align="right"></td>
                            <td width="83%" class="smallfont">
                                    <input value="" type="text" name="txtSort" class="textbox" size="10">
                            </td>
                    </tr>
                    <tr>
                            <td width="15%" class="smallfont" align="right">Không hiển thị</td>
                            <td width="1%" class="smallfont" align="center"></td>
                            <td width="83%" class="smallfont">
                                    <input type="checkbox" name="chkStatus" />
                            </td>
                    </tr>
                </table>
            </form>';
            $html .= script_for_edit_content();
            $ckeditor = new CKEditor( ) ;
            $ckeditor->basePath    = 'ckeditor/' ;
            CKFinder::SetupCKEditor( $ckeditor, 'ckfinder/' ) ;
            $ckeditor->replace('txtshort_vn'.$random_id);
            $ckeditor->replace('txtshort_en'.$random_id);
            $ckeditor->replace('txtlong_vn'.$random_id);
            $ckeditor->replace('txtlong_en'.$random_id);
            echo $html;
        }
	function add_new_content($tbl, $parent_id){
                $url = $_POST['url'];
		$name_vn = $_POST['txtName_vn'] ? trim($_POST['txtName_vn']) : '';
		$name_en = $_POST['txtName_en'] ? trim($_POST['txtName_en']) : '';
                $txtshort_vn = $_POST['txtshort_vn'] ? trim($_POST['txtshort_vn']) : '';
		$txtshort_en = $_POST['txtshort_en'] ? trim($_POST['txtshort_en']) : '';
                $txtlong_vn = $_POST['txtlong_vn'] ? trim($_POST['txtlong_vn']) : '';
		$txtlong_en = $_POST['txtlong_en'] ? trim($_POST['txtlong_en']) : '';
                $parent_id = $_POST['ddCat'];
		$views = $_POST['txtViews'] ? $_POST['txtViews'] : 0;
                $sort = $_POST['txtSort'] ? $_POST['txtSort'] : 0;
		$status = $_POST['chkStatus'] ? 1 : 0;
                $code = $_POST['code'];
                $folder_img = date('d-m-Y');
		$errMsg = '';
		$time = time();
		$fields_arr = array(
			"name_vn"       => "'$name_vn'",
			"name_en"      	=> "'$name_en'",
			"parent"      	=> $parent_id,
                        "detail_short_vn" => "'$txtshort_vn'",
                        "detail_short_en" => "'$txtshort_en'",
                        "detail_vn"     => "'$txtlong_vn'",
                        "detail_en"     => "'$txtlong_en'",
                        "views"         => $views,
                        "sort"          => $sort,
			"status"	=> $status,
			"date_added"    => $time,
			"last_modified" => $time
		);
                $insert_content = insert($tbl,$fields_arr);
                if($insert_content || $insert_content != ''){
                    $id = $insert_content;
                    $errMsg .= checkUpload($_FILES["txtImage"],".jpg;.gif;.bmp",2048*1024,0);
                    $path = '../../images/'.$code;
                    if(!is_dir($path)) mkdir($path,0777);
                    $path .= '/'.$folder_img;
                    if(!is_dir($path)) mkdir($path,0777);
                    $pathdb = 'images/'.$code.'/'.$folder_img;

                    $path_thumb = $path.'/thumbs';
                    if(!is_dir($path_thumb)) mkdir($path_thumb,0777);
                    $pathdb_thumb = $pathdb.'/thumbs';

                    $r = getRecord($tbl,"id=".$id);
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
                                                                    "last_modified" => $time);
                    }
                    if($fields_arr!='')	{
			$result = update($tbl,$fields_arr,"id=".$id);
                        if($result) {
                                $err = 'SUCCESS';
                                $errMsg = "Thêm nội dung mới thành công";
                        }else{
                                $err = 'ERROR';
                                $errMsg = "Không thể thêm nội dung mới!";
                        }
                    }
                }
                if($err == 'SUCCESS'){
                        echo "<script>alert('".$errMsg."'); window.location='".$url."';</script>";
                }  else {
                        echo "<script>alert('".$errMsg."');</script>";
                }
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
        function script_for_edit_content(){
            return $script = '<script>
                $(\'#short_en_show\').hide();
                $(\'#long_en_show\').hide();
                $(\'#short_en_call input\').click(function() {
                        $(\'#short_en_show\').slideToggle(\'slow\');
                });
                $(\'#long_en_call input\').click(function() {
                        $(\'#long_en_show\').slideToggle(\'slow\');
                });
            </script>';
        }
	
?>







