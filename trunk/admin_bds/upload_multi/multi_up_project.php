<link href="css/style-upload.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="js/jquery.swfupload.js"></script>
<script type="text/javascript">

$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "upload_multi/upload-file.php",
		file_post_name: 'uploadfile',
		file_size_limit : "10000000",
		file_types : "*.jpg;*.png;*.gif",
		file_types_description : "Image files",
		file_upload_limit : 99999,
		flash_url : "js/swfupload/swfupload.swf",
		button_image_url : 'js/swfupload/wdp_buttons_upload_114x29.png',
		button_width : 114,
		button_height : 29,
		button_placeholder : $('#button')[0],
		debug: false
	})
		.bind('fileQueued', function(event, file){
			var listitem='<li id="'+file.id+'" >'+
				'File: <em><?=$randNum.'-'?>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
				'<div class="progressbar" ><div class="progress" ></div></div>'+
				'<p class="status" >Pending</p>'+
				'<span class="cancel" >&nbsp;</span>'+
				'</li>';
			$('#log').append(listitem);
			$('li#'+file.id+' .cancel').bind('click', function(){
				var swfu = $.swfupload.getInstance('#swfupload-control');
				swfu.cancelUpload(file.id);
				$('li#'+file.id).slideUp('fast');
			});
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			alert('Size of the file '+<?=$randNum.'-'?>+file.name+' is greater than limit');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			$('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
		})
		.bind('uploadStart', function(event, file){
			$('#log li#'+file.id).find('p.status').text('Uploading...');
			$('#log li#'+file.id).find('span.progressvalue').text('0%');
			$('#log li#'+file.id).find('span.cancel').hide();
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//Show Progress
			var percentage=Math.round((bytesLoaded/file.size)*100);
			$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			var item=$('#log li#'+file.id);
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			var pathtofile='<input id="fileimg[]" name="fileimg[]" value="<?=$randNum.'-'?>'+file.name + '" type="hidden">';
			item.addClass('success').find('p.status').html('Ok!!! | '+pathtofile);
		})
		.bind('uploadComplete', function(event, file){
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
		})
	
});	

</script>

<?
$request = substr($_REQUEST['act'],0,-2);
$tblContentCat = TBL_PREFIX.substr($request,0,-8);
$tblContent         = TBL_PREFIX.$request;
$actConfig           = $request;
$parentWhere = "parent>1";
$arraySourceCombo    = getArrayCombo($tblContentCat,'id','name_vn',$parentWhere);

if(!isset($_POST['fileimg'])){
?>
	<script type="text/javascript" language="javascript">
    function btnSave_onclick(){
        if(test_empty(document.frmForm.txtName_vn.value)){
            alert('Hãy nhập "tên" !');
            document.frmForm.txtName_vn.focus();
            return false;
        }
        if(test_integer(document.frmForm.txtSort.value)){
            alert('"Thứ tự sắp xếp" phải là số !');
            document.frmForm.txtSort.focus();
            return false;
        }
        
        return true;
    }
    </script>
    <div id="swfupload-control">
    <form name="frmForm" action="" method="post">
    <div class="clear"></div>
    <table border="1" cellpadding="0" cellspacing="0" bordercolor="#0069A8" width="100%">
        <tr>
            <td width="45%">
                <table border="0" cellpadding="2" bordercolor="#111111" width="100%" cellspacing="0">
                    <tr>
                        <td width="15%" class="smallfont" align="right">Mã</td>
                        <td width="1%" class="smallfont" align="center"></td>
                        <td width="83%" class="smallfont">
                            <input value="<?=$code?>" type="text" name="txtCode" class="textbox" size="34">
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="15%" class="smallfont" align="right">Tên</td>
                        <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                        <td width="83%" class="smallfont">
                            <input value='<?=fix_input($name_vn)?>' type="text" name="txtName_vn" class="textbox" size="34">
                        </td>
                    </tr>
                    <tr>
                        <td width="15%" class="smallfont" align="right">Name</td>
                        <td width="1%" class="smallfont" align="center"><font color="#FF0000">*</font></td>
                        <td width="83%" class="smallfont">
                            <input value='<?=fix_input($name_en)?>' type="text" name="txtName_en" class="textbox" size="34">
                        </td>
                    </tr>			
    
                    <tr>
                        <td width="15%" class="smallfont" align="right">Hình ảnh</td>
                        <td width="1%" class="smallfont" align="center"></td>
                        <td width="83%" class="smallfont">
                            <input type="button" id="button" />
                            <p id="queuestatus" ></p>
                            <ol id="log"></ol>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="15%" class="smallfont" align="right">Thuộc danh mục</td>
                        <td width="1%" class="smallfont" align="center"></td>
                        <td width="83%" class="smallfont">
                            <?=comboCategory('ddCat',$arraySourceCombo,'smallfont',$parent,0)?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="15%" class="smallfont" align="right">Thứ tự sắp xếp</td>
                        <td width="1%" class="smallfont" align="right"></td>
                        <td width="83%" class="smallfont">
                            <input value="<?=$sort?>" type="text" name="txtSort" class="textbox" size="34">
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="15%" class="smallfont" align="right">Không hiển thị</td>
                        <td width="1%" class="smallfont" align="center"></td>
                        <td width="83%" class="smallfont">
                            <input type="checkbox" name="chkStatus" value="on" <? if ($status>0) echo 'checked' ?>>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="15%" class="smallfont"></td>
                        <td width="1%" class="smallfont" align="center"></td>
                        <td width="83%" class="smallfont">
                            <input type="submit" class=button id="submit" VALUE="Up file" onclick="return btnSave_onclick()">
                            <input type="reset" class=button value="Nhập lại">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </form>
    </div>
<? }else{
	$a = count($_POST['fileimg']);
	$code          		= isset($_POST['txtCode']) ? trim($_POST['txtCode']) : '';
	$name_vn          	= isset($_POST['txtName_vn']) ? trim($_POST['txtName_vn']) : '';
	$name_en          	= isset($_POST['txtName_en']) ? trim($_POST['txtName_en']) : '';
	$parent        		= $_POST['ddCat'];
	$sort          		= isset($_POST['txtSort']) ? trim($_POST['txtSort']) : 0;
	$status        		= $_POST['chkStatus']!='' ? 1 : 0;
	for($i=0; $i< $a; $i++){
		
		$path = "../images/project";
		if(!is_dir($path)){ mkdir($path,0777);}
		$pathdb = "images/project";

		$path_thumb = "../images/project/thumbs";
		if(!is_dir($path_thumb)){ mkdir($path_thumb,0777);}
		$pathdb_thumb = "images/project/thumbs";

		@chmod("$path_thumb/".$_POST['fileimg'][$i], 0777);
		change_img_size("$path/".$_POST['fileimg'][$i],"$path_thumb/".$_POST['fileimg'][$i],170,135);
		
		$img_db = "$pathdb/".$_POST['fileimg'][$i];
		$img_thumb_db = "$pathdb_thumb/".$_POST['fileimg'][$i];
		

		$sql = "insert into ".$tblContent." (code, name_vn, name_en, parent, image, image_large, sort, status, date_added, last_modified) values ('".$code."','".$name_vn.'-'.$i."','".$name_en.'-'.$i."','".$parent."','".$img_thumb_db."','".$img_db."','".$sort."','".$status."',now(),now())";
		mysql_query($sql,$conn);
	}
	echo '<script>window.location="./?act='.$actConfig.'&code=1"</script>';
}
?>
