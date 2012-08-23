<?php
	require_once('../config.php');
	require_once('../lib/func.lib.php');
        $fnc = $_POST['fnc'] ? $_POST['fnc'] : $_GET['fnc'];
	$tbl = $_POST['tbl'] ? $_POST['tbl'] : $_GET['tbl'];
	$parent_cat_id = $_POST['parent_cat_id'] ? $_POST['parent_cat_id'] : $_GET['parent_cat_id'];
        $cat_id = $_POST['cat_id'] ? $_POST['cat_id'] : $_GET['cat_id'];
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
		case 'update_price'             : update_price($tbl,$id, $val); 	break;
		case 'edit_name' 		: edit_name($tbl, $id, $val);           break;
                case 'edit_seo_key' 		: edit_seo_key($tbl, $id, $val);        break;
                case 'edit_title' 		: edit_title($tbl, $id, $val);          break;
		case 'view_edit_parent'         : view_edit_parent($parent_cat_id, $cat_id);            break;
		case 'update_parent'            : update_parent($tbl, $id, $val);                       break;
                case 'view_add_new_content'     : view_add_new_content($tbl, $parent_cat_id, $cat_id);  break;
		case 'add_new' 			: add_new_content($tbl, $parent_cat_id, $cat_id);       break;
                case 'add_new_properties'       : add_new_properties($cat_id);          break;
                case 'add_new_support'          : add_new_support($cat_id);             break;
                case 'update_properties'        : update_properties();                  break;
		case 'view_edit_detail_short' 	: view_edit_detail_short($tbl, $id);	break;
		case 'update_detail_short' 	: update_detail_short($tbl, $id);	break;
                case 'edit_adv_desc'            : edit_adv_desc($tbl, $id, $val);       break;
                case 'edit_support_code'        : edit_support_code($tbl, $id, $val);   break;
		case 'view_edit_detail'         : view_edit_detail($tbl, $id);		break;
		case 'update_detail'            : update_detail($tbl, $id);		break;
                case 'edit_adv_link'            : edit_adv_link($tbl, $id, $val);       break;
		case 'view_edit_image'          : view_edit_image($tbl, $id);		break;
		case 'update_image'             : update_image($tbl, $id);		break;
		case 'check_contact'            : check_contact($id, $val); 		break;
	}
	
	function del($tbl, $id){
		$r = selectOne($tbl,"id=".$id);
		$fields_arr = array("id" => $id);
		$result = delete_rows($tbl,$fields_arr);
		if ($result){
			if(file_exists('../../'.$r['image_thumbs'])) @unlink('../../'.$r['image_thumbs']);
			if(file_exists('../../'.$r['image_large'])) @unlink('../../'.$r['image_large']);
                        if($tbl == tbl_config::tbl_product){
                                delete_rows(tbl_config::tbl_product_extend,array('product_id' => $id));
                        }
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
				$r = selectOne($tbl,"id=".$id);
				$fields_arr = array("id" => $id);
				$result = delete_rows($tbl,$fields_arr);
				if ($result){
					if(file_exists('../../'.$r['image_thumbs'])) @unlink('../../'.$r['image_thumbs']);
					if(file_exists('../../'.$r['image_large'])) @unlink('../../'.$r['image_large']);
                                        if($tbl == tbl_config::tbl_product){
                                                delete_rows(tbl_config::tbl_product_extend,array('product_id' => $id));
                                        }
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
		if ($result && $val=='0'){
			$err = 'SUCCESS';
			$errMsg = "Đã cập nhật trạng thái Ẩn.";
		}else if ($result && $val=='1'){
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
		$sort = selectOne($tbl, "id=".$id);
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
	function update_price($tbl, $id, $val){
		$fields_arr = array("price" => $val,"last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Đã Cập nhật giá thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function edit_name($tbl, $id, $val){
                if($tbl == tbl_config::tbl_properties)
                    $fields_arr = array("name" => "'$val'", "last_modified" => time());
                else
                    $fields_arr = array("name" => "'$val'", "title" => "'$val'", "last_modified" => time());
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
	function edit_seo_key($tbl, $id, $val){
		$fields_arr = array("seo_key" => "'$val'", "last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật SEO KEY thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function edit_title($tbl, $id, $val){
                $fields_arr = array("title" => "'$val'", "last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật Tiêu đề cho SEO thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function view_edit_parent($parent_cat_id, $cat_id){
		$arraySourceCombo    = getArrayCombo(tbl_config::tbl_category,'id','name','parent_id = ' . $parent_cat_id);
		if ($arraySourceCombo){
			$err = 'SUCCESS';
			$drop_list = comboCategory('ddCatParent',$arraySourceCombo,'smallfont',$cat_id,0);
		}else{
			$err = 'ERROR';
		}
		echo json_encode(array('error' => $err, 'drop_list' => $drop_list));
	}
	function update_parent($tbl, $id, $val){
                $get_cat = selectOne(tbl_config::tbl_category, 'id = ' . $val);
                $get_parent = selectOne(tbl_config::tbl_category, 'id = ' . $get_cat['parent_id']);
                $seo_key = $get_parent['name'] . ' - ' . $get_cat['name'];
		$fields_arr = array("parent_id" => $val, "last_modified" => time(), "seo_key" => "'$seo_key'");
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
		$detail_short = selectOne($tbl,'id = '.$id);
		$url = $_POST['url'];
		$form_data = '<form id="short_detail_form" name="short_detail_form" method="post" enctype="multipart/form-data" action="ajax/content_action.php">
                    <input type="hidden" name="fnc" value="update_detail_short" />
                    <input type="hidden" name="url" value="'.$url.'" />
                    <input type="hidden" name="tbl" value="'.$tbl.'" />
                    <input type="hidden" name="id" value="'.$id.'" />
                    <div style="float:left;padding: 20px;">Nội dung ngắn:
                            <textarea name="txtshort" cols="100" rows="10" id="txtshort'.$random_id.'" class="to_get_id_short">'.$detail_short['detail_short'].'</textarea>
                    </div>
		</form>';
                $form_data .= script_for_edit_content();
		$ckeditor = new CKEditor( ) ;
		$ckeditor->basePath    = 'ckeditor/' ;
		CKFinder::SetupCKEditor( $ckeditor, 'ckfinder/' ) ;
		$ckeditor->replace("txtshort".$random_id);
		echo $form_data;
	}
	function update_detail_short($tbl, $id){
		$val = html_entity($_POST['txtshort']);
		$url = $_POST['url'];
		$fields_arr = array("detail_short" => "'$val'", "last_modified" => time());
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
        function edit_adv_desc($tbl, $id, $val){
		$fields_arr = array("detail_short" => "'$val'", "last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật mô tả thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
        function edit_support_code($tbl, $id, $val){
		$fields_arr = array("detail_short" => "'$val'", "last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật hỗ trợ trực tuyến thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function view_edit_detail($tbl, $id){
		require_once ('../ckeditor/ckeditor.php') ;
		require_once ('../ckfinder/ckfinder.php') ;
		$random_id = rand(1,9999);
		$detail = selectOne($tbl,'id = '.$id);
		$url = $_POST['url'];
		$form_data = '<form id="detail_form" name="detail_form" method="post" enctype="multipart/form-data" action="ajax/content_action.php">
                    <input type="hidden" name="fnc" value="update_detail" />
                    <input type="hidden" name="url" value="'.$url.'" />
                    <input type="hidden" name="tbl" value="'.$tbl.'" />
                    <input type="hidden" name="id" value="'.$id.'" />
                    <div style="float:left;padding: 20px;">Nội dung tiếng Việt:
                            <textarea name="txtlong" cols="100" rows="10" id="txtlong'.$random_id.'" class="to_get_id">'.$detail['detail'].'</textarea>
                    </div>
		</form>';
                $form_data .= script_for_edit_content();
		$ckeditor = new CKEditor( ) ;
		$ckeditor->basePath    = 'ckeditor/' ;
		CKFinder::SetupCKEditor( $ckeditor, 'ckfinder/' ) ;
		$ckeditor->replace("txtlong".$random_id);
		echo $form_data;
	}
	function update_detail($tbl, $id){
		$val = html_entity($_POST['txtlong']);
		$url = $_POST['url'];
		$fields_arr = array("detail" => "'$val'", "last_modified" => time());
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
        function edit_adv_link($tbl, $id, $val){
		$fields_arr = array("detail" => "'$val'", "last_modified" => time());
		$result = update($tbl,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật đường dẫn site thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
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
		$errMsg .= checkUpload($_FILES["txtImage"],".jpg;",2048*1024,0);
                if($errMsg != '')
                        die("<script>alert('".$errMsg."'); window.location='".$url."';</script>");
                $folder_img = date('d-m-Y');
		$path = '../../images/'.$code;
                if(!is_dir($path)) mkdir($path,0777);
                $path .= '/'.$folder_img;
                if(!is_dir($path)) mkdir($path,0777);
                $pathdb = 'images/'.$code.'/'.$folder_img;

                $path_thumb = $path.'/thumbs';
                if(!is_dir($path_thumb)) mkdir($path_thumb,0777);
                $pathdb_thumb = $pathdb.'/thumbs';

                $get_name = selectOne($tbl, 'id = ' . $id);
                $add_img_name = catchu(utf8_to_ascii($get_name['name']),100);
		$r = selectOne($tbl,"id=".$id);
		$return_img = '';
		if (!$img_check_clear || $img_check_clear==''){
			$extImg=getFileExtention($_FILES['txtImage']['name']);
			if (makeUpload($_FILES['txtImage'],"$path/".$code."_".$add_img_name."_l".$id.$extImg)){
				@chmod("$path/".$code."_".$add_img_name."_l".$id.$extImg, 0777);
				change_img_size("$path/".$code."_".$add_img_name."_l".$id.$extImg,"$path/".$code."_".$add_img_name."_l".$id.$extImg,800,800);
				if($code == 'adv'){
					change_img_size("$path/".$code."_".$add_img_name."_l".$id.$extImg,"$path_thumb/".$code."_".$add_img_name."_t".$id.$extImg,210,600);
				}else{
					change_img_size("$path/".$code."_".$add_img_name."_l".$id.$extImg,"$path_thumb/".$code."_".$add_img_name."_t".$id.$extImg,170,110);
				}
				$fields_arr = array("image_large" => "'".$pathdb."/".$code."_".$add_img_name."_l".$id.$extImg."'",
									"image_thumbs" => "'".$pathdb_thumb."/".$code."_".$add_img_name."_t".$id.$extImg."'",
									"last_modified" => time());
				$return_img = '../'.$pathdb_thumb."/".$code."_".$add_img_name."_t".$code.$extImg;
				
			}	
		}else{
			if(file_exists('../../'.$r['image_large']) && file_exists('../../'.$r['image_thumbs'])){
				@unlink('../../'.$r['image_large']); @unlink('../../'.$r['image_thumbs']);
			}
			$fields_arr = array("image_large" => "''",
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
        function view_add_new_content($tbl, $parent_cat_id, $cat_id){
            $random_id = rand(1,9999);
            $arraySourceCombo    = getArrayCombo(tbl_config::tbl_category,'id','name','parent_id = ' . $parent_cat_id);
            $get_parent = selectOne(tbl_config::tbl_category, 'id = ' . $parent_cat_id);
            $code = $get_parent['code'];
            $get_cat = selectOne(tbl_config::tbl_category, 'id = ' . $cat_id);
            if($code == 'properties'){
                $html = '<table border="0" cellpadding="2" bordercolor="#111111" width="100%" cellspacing="0">
                        <tr>
                                <td width="30%" class="smallfont" align="right">Chi tiết thuộc tính</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="69%" class="smallfont">
                                        <input value="" type="text" id="txtName" name="txtName" class="textbox" size="34">
                                </td>
                        </tr>
                        <tr>
                                <td width="30%" class="smallfont" align="right">Thứ tự sắp xếp</td>
                                <td width="1%" class="smallfont" align="right"></td>
                                <td width="69%" class="smallfont">
                                        <input value="" type="text" id="txtSort" name="txtSort" class="textbox" size="10">
                                </td>
                        </tr>
                        </table>';
            }else if($code == 'adv'){
                $url = $_POST['url'];
                $html = '<form id="add_new_form" name="add_new_form" enctype="multipart/form-data" method="post" action="ajax/content_action.php">
                    <input type="hidden" name="fnc" value="add_new" />
                    <input type="hidden" name="url" value="'.$url.'" />
                    <input type="hidden" name="tbl" value="'.$tbl.'" />
                    <input type="hidden" name="parent_cat_id" value="'.$parent_cat_id.'" />
                    <input type="hidden" name="cat_id" value="'.$cat_id.'" />
                    <table border="0" cellpadding="2" bordercolor="#111111" width="100%" cellspacing="0">
                        <tr>
                                <td width="15%" class="smallfont" align="right">Tên qc</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="83%" class="smallfont">
                                        <input value="" type="text" name="txtName" class="textbox" size="34">
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
                                <td width="15%" class="smallfont" align="right">Mô tả</td>
                                <td width="1%" class="smallfont" align="center"></td>
                                <td width="83%" class="smallfont">
                                        <textarea name="txtshort" cols="80" rows="10" id="txtshort'.$random_id.'"></textarea>
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">Đường dẫn site</td>
                                <td width="1%" class="smallfont" align="center"></td>
                                <td width="83%" class="smallfont">
                                        <input value="" type="text" name="txtlong" class="textbox" size="34">
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">Thuộc danh mục</td>
                                <td width="1%" class="smallfont" align="center"></td>
                                <td width="83%" class="smallfont">'.comboCategory('ddCat',$arraySourceCombo,'smallfont',$cat_id,0).'</td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">Thứ tự sắp xếp</td>
                                <td width="1%" class="smallfont" align="right"></td>
                                <td width="83%" class="smallfont">
                                        <input value="" type="text" name="txtSort" class="textbox" size="10">
                                </td>
                        </tr>
                     </table>
                     </form>';
            }else if($code == 'support'){
                $html = '<form id="add_new_form" name="add_new_form" enctype="multipart/form-data" method="post" action="ajax/content_action.php">
                    <input type="hidden" name="fnc" value="add_new" />
                    <table border="0" cellpadding="2" bordercolor="#111111" width="100%" cellspacing="0">
                        <tr>
                                <td width="30%" class="smallfont" align="right">Tên hiển thị</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="69%" class="smallfont">
                                        <input value="" type="text" id="txtName" name="txtName" class="textbox" size="40" />
                                </td>
                        </tr>
                        <tr>
                                <td width="30%" class="smallfont" align="right">' . $get_cat['name'] . ' hỗ trợ</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="69%" class="smallfont">
                                        <input value="" type="text" id="txtshort" name="txtshort" class="textbox" size="40" />
                                </td>
                        </tr>
                        <tr>
                                <td width="30%" class="smallfont" align="right">Thứ tự sắp xếp</td>
                                <td width="1%" class="smallfont" align="right"></td>
                                <td width="69%" class="smallfont">
                                        <input value="" type="text" id="txtSort" name="txtSort" class="textbox" size="10" />
                                </td>
                        </tr>
                     </table>
                     </form>';
            }else if($code == 'product'){
                $url = $_POST['url'];
                require_once ('../ckeditor/ckeditor.php') ;
                require_once ('../ckfinder/ckfinder.php') ;
                $html = '<form id="add_new_form" name="add_new_form" enctype="multipart/form-data" method="post" action="ajax/content_action.php">
                    <input type="hidden" name="fnc" value="add_new" />
                    <input type="hidden" name="url" value="'.$url.'" />
                    <input type="hidden" name="tbl" value="'.$tbl.'" />
                    <input type="hidden" name="parent_cat_id" value="'.$parent_cat_id.'" />
                    <input type="hidden" name="cat_id" value="'.$cat_id.'" />
                    <table border="0" cellpadding="2" bordercolor="#111111" width="100%" cellspacing="0">
                        <tr>
                                <td width="15%" class="smallfont" align="right">Tiêu đề</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="83%" class="smallfont">
                                        <input value="" type="text" name="txtName" class="textbox" size="34" onkeyup="document.getElementById(\'txtTitle\').value = this.value;" />
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">SEO KEY</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="83%" class="smallfont">
                                        <input value="'.$get_parent['name'].' - '.$get_cat['name'].'" type="text" name="txtSeokey" class="textbox" size="34">
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">Tiêu đề SEO</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="83%" class="smallfont">
                                        <input value="" type="text" id="txtTitle" name="txtTitle" class="textbox" size="34">
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
                                <td width="15%" class="smallfont" align="right">Nội dung chi tiết</td>
                                <td width="1%" class="smallfont" align="center"></td>
                                <td width="83%" class="smallfont">
                                        <textarea name="txtlong" cols="80" rows="10" id="txtlong'.$random_id.'"></textarea>
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">Thuộc danh mục</td>
                                <td width="1%" class="smallfont" align="center"></td>
                                <td width="83%" class="smallfont">'.comboCategory('ddCat',$arraySourceCombo,'smallfont',$cat_id,0).'</td>
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
                                <td width="15%" class="smallfont" align="right">Giá sp</td>
                                <td width="1%" class="smallfont" align="right"></td>
                                <td width="83%" class="smallfont">
                                        <input value="" type="text" name="txtPrice" class="textbox" size="10">
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">-----------------</td>
                                <td width="1%" class="smallfont" align="right"></td>
                                <td width="83%" class="smallfont"><strong>Thuộc tính:</strong></td>
                        </tr>';
                    $get_parent_id = selectOne(tbl_config::tbl_category, 'status=1 AND parent_id=0 AND code = "properties"', 'sort, date_added ASC');
                    $parent_id = $get_parent_id['id'];
                    $prop_cats = selectMulti(tbl_config::tbl_category, 'id, name', 'status=1 AND parent_id = ' . $parent_id, 'ORDER BY sort, date_added ASC');
                    foreach($prop_cats as $prop_cat){
                    $html .= '<tr>
                                <td width="15%" class="smallfont" align="right">'.$prop_cat['name'].'</td>
                                <td width="1%" class="smallfont" align="right"></td>
                                <td width="83%" class="smallfont">
                                        '.comboProperties(utf8_to_ascii($prop_cat['name']),getArrayCombo(tbl_config::tbl_properties,'id','name','parent_id = ' . $prop_cat['id']),'smallfont',0,1,false).'
                                </td>
                        </tr>';
                    }
                $html .= '</table>
                </form>';
                $html .= script_for_edit_content();
                $ckeditor = new CKEditor( ) ;
                $ckeditor->basePath    = 'ckeditor/' ;
                CKFinder::SetupCKEditor( $ckeditor, 'ckfinder/' ) ;
                $ckeditor->replace('txtlong'.$random_id);
            }else{
                $url = $_POST['url'];
                require_once ('../ckeditor/ckeditor.php') ;
                require_once ('../ckfinder/ckfinder.php') ;
                $html = '<form id="add_new_form" name="add_new_form" enctype="multipart/form-data" method="post" action="ajax/content_action.php">
                    <input type="hidden" name="fnc" value="add_new" />
                    <input type="hidden" name="url" value="'.$url.'" />
                    <input type="hidden" name="tbl" value="'.$tbl.'" />
                    <input type="hidden" name="parent_cat_id" value="'.$parent_cat_id.'" />
                    <input type="hidden" name="cat_id" value="'.$cat_id.'" />
                    <table border="0" cellpadding="2" bordercolor="#111111" width="100%" cellspacing="0">
                        <tr>
                                <td width="15%" class="smallfont" align="right">Tiêu đề</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="83%" class="smallfont">
                                        <input value="" type="text" name="txtName" class="textbox" size="34" onkeyup="document.getElementById(\'txtTitle\').value = this.value;" />
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">SEO KEY</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="83%" class="smallfont">
                                        <input value="'.$get_parent['name'].' - '.$get_cat['name'].'" type="text" name="txtSeokey" class="textbox" size="34">
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">Tiêu đề SEO</td>
                                <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                                <td width="83%" class="smallfont">
                                        <input value="" type="text" id="txtTitle" name="txtTitle" class="textbox" size="34">
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
                                        <textarea name="txtshort" cols="80" rows="10" id="txtshort"></textarea>
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">Nội dung chi tiết</td>
                                <td width="1%" class="smallfont" align="center"></td>
                                <td width="83%" class="smallfont">
                                        <textarea name="txtlong" cols="80" rows="10" id="txtlong'.$random_id.'"></textarea>
                                </td>
                        </tr>
                        <tr>
                                <td width="15%" class="smallfont" align="right">Thuộc danh mục</td>
                                <td width="1%" class="smallfont" align="center"></td>
                                <td width="83%" class="smallfont">'.comboCategory('ddCat',$arraySourceCombo,'smallfont',$cat_id,0).'</td>
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
                        </tr>';
                $html .= '</table>
                </form>';
                $html .= script_for_edit_content();
                $ckeditor = new CKEditor( ) ;
                $ckeditor->basePath    = 'ckeditor/' ;
                CKFinder::SetupCKEditor( $ckeditor, 'ckfinder/' ) ;
                $ckeditor->replace('txtlong'.$random_id);
            }
            echo $html;
        }
	function add_new_content($tbl, $parent_cat_id, $cat_id){
                $get_parent = selectOne(tbl_config::tbl_category, 'id = ' . $parent_cat_id);
                $code_folder = $get_parent['code'];
                $get_cat = selectOne(tbl_config::tbl_category, 'id = ' . $cat_id);
                $url = $_POST['url'];
		$name = $_POST['txtName'] ? trim($_POST['txtName']) : '';
                $txtlong = $_POST['txtlong'] ? trim(html_entity($_POST['txtlong'])) : '';
                if($code_folder == 'news')
                    $txtshort = $_POST['txtshort'] ? trim($_POST['txtshort']) : '';
                else
                    $txtshort = $_POST['txtlong'] ? catchu(strip_tags($_POST['txtlong']), 160) : '';
                $parent_id = $_POST['ddCat'];
		$views = $_POST['txtViews'] ? $_POST['txtViews'] : 0;
                $price = $_POST['txtPrice'] ? $_POST['txtPrice'] : 0;
                $sort = $_POST['txtSort'] ? $_POST['txtSort'] : 0;
                $seo_key = $_POST['txtSeokey'] ? $_POST['txtSeokey'] : '';
                $title = $_POST['txtTitle'] ? $_POST['txtTitle'] : '';
                $folder_img = date('d-m-Y');
		$errMsg = '';
		$time = time();
                if($code_folder == 'product'){
                    $code = $_POST['code'] ? trim($_POST['code']) : '';
                    $fields_arr = array(
                            "code"          => "'$code'",
                            "name"          => "'$name'",
                            "parent_id"     => $parent_id,
                            "detail_short"  => "'$txtshort'",
                            "detail"        => "'$txtlong'",
                            "views"         => $views,
                            "price"         => $price,
                            "sort"          => $sort,
                            "status"        => 1,
                            "date_added"    => $time,
                            "last_modified" => $time,
                            "seo_key"       => "'$seo_key'",
                            "title"         => "'$title'"
                    );
                }else if($code_folder == 'adv'){
                    $fields_arr = array(
                            "name"          => "'$name'",
                            "parent_id"     => $parent_id,
                            "detail_short"  => "'$txtshort'",
                            "detail"        => "'$txtlong'",
                            "sort"          => $sort,
                            "status"        => 1,
                            "date_added"    => $time,
                            "last_modified" => $time
                    );
                }else{
                    $fields_arr = array(
                            "name"          => "'$name'",
                            "parent_id"     => $parent_id,
                            "detail_short"  => "'$txtshort'",
                            "detail"        => "'$txtlong'",
                            "views"         => $views,
                            "sort"          => $sort,
                            "status"        => 1,
                            "date_added"    => $time,
                            "last_modified" => $time,
                            "seo_key"       => "'$seo_key'",
                            "title"         => "'$title'"
                    );
                }
                $insert_content = insert($tbl,$fields_arr);
                if($insert_content || $insert_content != ''){
                    $id = $insert_content;
                    $errMsg .= checkUpload($_FILES["txtImage"],".jpg;",2048*1024,0);
                    if($errMsg != '')
                        die("<script>alert('".$errMsg."'); window.location='".$url."';</script>");
                    $path = '../../images/'.$code_folder;
                    if(!is_dir($path)) mkdir($path,0777);
                    $path .= '/'.$folder_img;
                    if(!is_dir($path)) mkdir($path,0777);
                    $pathdb = 'images/'.$code_folder.'/'.$folder_img;
                    
                    $path_thumb = $path.'/thumbs';
                    if(!is_dir($path_thumb)) mkdir($path_thumb,0777);
                    $pathdb_thumb = $pathdb.'/thumbs';

                    $add_img_name = catchu(utf8_to_ascii($name),100);
                    $r = selectOne($tbl,"id=".$id);
                    $extImg=getFileExtention($_FILES['txtImage']['name']);
                    if (makeUpload($_FILES['txtImage'],"$path/".$code_folder."_".$add_img_name."_l".$id.$extImg)){
                            @chmod("$path/".$code_folder."_".$add_img_name."_l".$id.$extImg, 0777);
                            change_img_size("$path/".$code_folder."_".$add_img_name."_l".$id.$extImg,"$path/".$code_folder."_".$add_img_name."_l".$id.$extImg,800,800);
                            if($code == 'adv'){
                                    change_img_size("$path/".$code_folder."_".$add_img_name."_l".$id.$extImg,"$path_thumb/".$code_folder."_".$add_img_name."_t".$id.$extImg,210,600);
                            }else{
                                    change_img_size("$path/".$code_folder."_".$add_img_name."_l".$id.$extImg,"$path_thumb/".$code_folder."_".$add_img_name."_t".$id.$extImg,170,110);
                            }
                            $fields_arr = array("image_large" => "'".$pathdb."/".$code_folder."_".$add_img_name."_l".$id.$extImg."'",
                                                                    "image_thumbs" => "'".$pathdb_thumb."/".$code_folder."_".$add_img_name."_t".$id.$extImg."'",
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
                    }else{
                        $err = 'SUCCESS';
                        $errMsg = "Thêm nội dung mới thành công";
                    }
                    if($code_folder == 'product'){
                        $prop_parent_id = selectOne(tbl_config::tbl_category, 'status=1 AND parent_id=0 AND code = "properties"', 'sort, date_added ASC');
                        $parent_id = $prop_parent_id['id'];
                        $prop_cats = selectMulti(tbl_config::tbl_category, 'id, name', 'status=1 AND parent_id = ' . $parent_id, 'ORDER BY sort, date_added ASC');
                        foreach($prop_cats as $prop_cat){
                            if($_POST[utf8_to_ascii($prop_cat['name'])]){
                                $props_arr = array(
                                        "product_id"        => $id,
                                        "properties_id"     => $_POST[utf8_to_ascii($prop_cat['name'])]
                                );
                                $insert_props = insert(tbl_config::tbl_product_extend,$props_arr);
                                if($insert_props || $insert_props != ''){
                                    $err = 'SUCCESS';
                                    $errMsg = "Thêm nội dung mới thành công";
                                }else{
                                    $err = 'ERROR';
                                    $errMsg = "Không thể thêm nội dung mới!";
                                }
                            }
                        }
                    }
                }
                echo "<script>alert('".$errMsg."'); window.location='".$url."';</script>";
	}
	function add_new_support($cat_id){
		$name = $_POST['name'] ? trim($_POST['name']) : '';
                $detail_short = $_POST['detail_short'] ? trim($_POST['detail_short']) : '';
                $sort = $_POST['sort'] ? $_POST['sort'] : 0;
		$time = time();
		$fields_arr = array(
			"name"          => "'$name'",
                        "detail_short"  => "'$detail_short'",
			"parent_id"    	=> $cat_id,
                        "sort"          => $sort,
			"status"	=> 1,
			"date_added"    => $time,
			"last_modified" => $time
		);
                $insert_support = insert(tbl_config::tbl_content,$fields_arr);
                if($insert_support || $insert_support != ''){
                        $err = 'SUCCESS';
                        $errMsg = "Thêm hỗ trợ mới thành công";
                }else{
                        $err = 'ERROR';
                        $errMsg = "Không thể thêm hỗ trợ mới!";
                }
                echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function add_new_properties($cat_id){
		$name = $_POST['name'] ? trim($_POST['name']) : '';
                $sort = $_POST['sort'] ? $_POST['sort'] : 0;
		$time = time();
		$fields_arr = array(
			"name"          => "'$name'",
			"parent_id"    	=> $cat_id,
                        "sort"          => $sort,
			"status"	=> 1,
			"date_added"    => $time,
			"last_modified" => $time
		);
                $insert_properties = insert(tbl_config::tbl_properties,$fields_arr);
                if($insert_properties || $insert_properties != ''){
                        $err = 'SUCCESS';
                        $errMsg = "Thêm thuộc tính mới thành công";
                }else{
                        $err = 'ERROR';
                        $errMsg = "Không thể thêm thuộc tính mới!";
                }
                echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
        function update_properties(){
                $ext_id = $_POST['ext_id'];
		$properties_id = $_POST['pr_id'];
                $prod_id = $_POST['prod_id'];
                $fields_arr = array(
			"product_id"    => $prod_id,
			"properties_id" => $properties_id
		);
                if($ext_id == 0){
                    $insert = insert(tbl_config::tbl_product_extend,$fields_arr);
                }else if($properties_id == 0){
                    $delete = delete_where(tbl_config::tbl_product_extend,'id='.$ext_id);
                }else{
                    $update = update(tbl_config::tbl_product_extend,$fields_arr,'id='.$ext_id);
                }
                if(($insert && $insert != '') || $update || $delete){
                        $err = 'SUCCESS';
                        $errMsg = "Cập nhật thành công";
                }else{
                        $err = 'ERROR';
                        $errMsg = "Không thể cập nhật!";
                }
                echo json_encode(array('error' => $err, 'msg' => $errMsg));
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







