<?php
	require_once('../config.php');
	require_once('../lib/func.lib.php');
        $fnc = $_POST['fnc'] ? $_POST['fnc'] : $_GET['fnc'];
	$id = $_POST['id'];
	$val = $_POST['val'];
	
	switch ($fnc){
		case 'show_hide' 		: show_hide($id, $val); 		break;
		case 'sort_row' 		: sort_row($id, $val); 		break;
		case 'update_views'             : update_views($id, $val); 	break;
		case 'edit_name' 		: edit_name($id, $val);    break;
		case 'view_edit_detail_short' 	: view_edit_detail_short($id);	break;
		case 'update_detail_short' 	: update_detail_short($id);	break;
		case 'view_edit_detail'         : view_edit_detail($id);		break;
		case 'update_detail'            : update_detail($id);		break;
		case 'view_edit_image'          : view_edit_image($id);		break;
		case 'update_image'             : update_image($id);		break;
	}
	
	function show_hide($id, $val){
		$fields_arr = array("status" => "'$val'","last_modified" => time());
		$result = update(tbl_config::tbl_static,$fields_arr,"id=".$id);
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
	function sort_row($id, $val){
		$fields_arr = array("sort" => $val,"last_modified" => time());
		$sort = selectOne(tbl_config::tbl_static, "id=".$id);
		$result = update(tbl_config::tbl_static,$fields_arr,"id=".$id);
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
	function update_views($id, $val){
		$fields_arr = array("views" => $val,"last_modified" => time());
		$result = update(tbl_config::tbl_static,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Đã Cập nhật lượt view thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function edit_name($id, $val){
		$fields_arr = array("name" => "'$val'", "last_modified" => time());
		$result = update(tbl_config::tbl_static,$fields_arr,"id=".$id);
		if ($result){
			$err = 'SUCCESS';
			$errMsg = "Cập nhật tên thành công.";
		}else{
			$err = 'ERROR';
			$errMsg = "Không thể cập nhật!";
		}
		echo json_encode(array('error' => $err, 'msg' => $errMsg));
	}
	function view_edit_detail_short($id){
		require_once ('../ckeditor/ckeditor.php') ;
		require_once ('../ckfinder/ckfinder.php') ;
		$random_id = rand(1,9999);
		$detail_short = selectOne(tbl_config::tbl_static,'id = '.$id);
		$url = $_POST['url'];
		$form_data = '<form id="short_detail_form" name="short_detail_form" method="post" enctype="multipart/form-data" action="ajax/static_action.php">
                    <input type="hidden" name="fnc" value="update_detail_short" />
                    <input type="hidden" name="url" value="'.$url.'" />
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
	function update_detail_short($id){
		$val = $_POST['txtshort'];
		$url = $_POST['url'];
		$fields_arr = array("detail_short" => "'$val'", "last_modified" => time());
		$result = update(tbl_config::tbl_static,$fields_arr,"id=".$id);
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
	function view_edit_detail($id){
		require_once ('../ckeditor/ckeditor.php') ;
		require_once ('../ckfinder/ckfinder.php') ;
		$random_id = rand(1,9999);
		$detail = selectOne(tbl_config::tbl_static,'id = '.$id);
		$url = $_POST['url'];
		$form_data = '<form id="detail_form" name="detail_form" method="post" enctype="multipart/form-data" action="ajax/static_action.php">
                    <input type="hidden" name="fnc" value="update_detail" />
                    <input type="hidden" name="url" value="'.$url.'" />
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
	function update_detail($id){
		$val = $_POST['txtlong'];
		$url = $_POST['url'];
		$fields_arr = array("detail" => "'$val'", "last_modified" => time());
		$result = update(tbl_config::tbl_static,$fields_arr,"id=".$id);
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
	function view_edit_image($id){
		$url = $_POST['url'];
		$code = $_POST['code'];
		$img_form = '<form id="img_form" name="img_form" method="post" enctype="multipart/form-data" action="ajax/static_action.php">
			<input type="hidden" name="fnc" value="update_image" />
			<input type="hidden" name="url" value="'.$url.'" />
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
	function update_image($id){
		$url = $_POST['url'];
		$code = $_POST['code'];
		$img_check_clear = $_POST['chkClearImg'];
		$errMsg = '';
		$errMsg .= checkUpload($_FILES["txtImage"],".jpg",2048*1024,0);
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
		
		$r = selectOne(tbl_config::tbl_static,"id=".$id);
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
				$fields_arr = array("image_large" => "'".$pathdb."/".$code."_l".$id.$extImg."'",
									"image_thumbs" => "'".$pathdb_thumb."/".$code."_t".$id.$extImg."'",
									"last_modified" => time());
				$return_img = '../'.$pathdb_thumb."/".$code."_t".$code.$extImg;
				
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
			$result = update(tbl_config::tbl_static,$fields_arr,"id=".$id);
			if ($result){
				
				$errMsg = "Cập nhật hình ảnh thành công!";
			}else{
				$errMsg = "Không thể cập nhật!";
			}
		}
		echo "<script>alert('".$errMsg."'); window.location='".$url."';</script>";
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







