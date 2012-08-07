<?php
	include('../../config.php');
	$uploaddir = '../../images/project/'; 
	if(!is_dir($uploaddir)) mkdir($uploaddir,0777);
	$file = $uploaddir.$randNum.'-'.basename($_FILES['uploadfile']['name']); 
	$size=$_FILES['uploadfile']['size'];
	if($size>1048576)
	{
		echo "Dung lượng ảnh phải dưới 1 MB";
		unlink($_FILES['uploadfile']['tmp_name']);
		exit;
	}
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) { 
	  echo "success"; 
	} else {
		echo "Lỗi ".$_FILES['uploadfile']['error']." --- ".$_FILES['uploadfile']['tmp_name']." %%% ".$file."($size)";
	}
?>