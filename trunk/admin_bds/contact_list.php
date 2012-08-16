<?
	require_once('config.php');
	require_once('lib/func.lib.php');
	$type = $_POST['cat'];
	$cat_title = $_POST['title'];
	$page = $_POST['page'];
	if($type){
		$where = 'type = ' . $type;
	}else{
		$where = '1 = 1';
	}
	$p = $page || $page!='' ? $page : 0;
	
	$pageindex = createPage(countRecord(tbl_config::tbl_contact,$where),0,system_config::maxpage,$page);
	$arraySourceCombo = array(
		array(1,'Quản trị viên'),
		array(2,'Dịch vụ thiết kế web'),
		array(3,'Bộ phận đối tác'),
		array(4,'Bộ phận liên kết site'),
		array(5,'Quản lý quảng cáo')
	);
?>
<script type="text/javascript" src="js/content_manager.js"></script>
<h3 tbl_data="<?=tbl_config::tbl_contact?>">Liên hệ</h3>
<form method="POST" action="./" name="frmForm" enctype="multipart/form-data">
<div class="clear"></div>
<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
	<tr>
		<td height="30" class="smallfont pagination">&nbsp;&nbsp;Trang : <?=$pageindex?></td>
		<td align="right" class="smallfont">
			Xem theo danh mục: <?=comboCategory('ddCat',$arraySourceCombo,'smallfont',$type,1,1)?>
		</td>
	</tr>
</table>

<table width="97%" class="adminlist">
	<thead>
		<tr>
			<th class="title" width="20">TT</th>
			<th width="20" class="title"><input type="checkbox" name="chkall" onClick="chkallClick(this);"></th>
			<th width="24" class="title"><a class="title" href="<?=getLinkSort(1)?>">ID</a></th>
			<th width="26" class="title">&nbsp;</th>		
			<th width="152" class="title"><a class="title" href="<?=getLinkSort(2)?>">Tên người gửi</a></th>
			<th width="100" class="title"><a class="title" href="<?=getLinkSort(3)?>">Số đt</a></th>
			<th width="100" class="title"><a class="title" href="<?=getLinkSort(4)?>">Email</a></th>
			<th width="152" class="title"><a class="title" href="<?=getLinkSort(5)?>">Địa chỉ</a></th>
			<th width="100" class="title"><a class="title" href="<?=getLinkSort(6)?>">Nội dung</a></th>
			<th width="152" class="title"><a class="title" href="<?=getLinkSort(7)?>">Gửi đến</a></th>
			<th width="100" class="title"><a class="title" href="<?=getLinkSort(8)?>">Trạng thái</a></th>
			<th width="100" class="title"><a class="title" href="<?=getLinkSort(9)?>">Ngày gửi</a></th>
			<th width="100" class="title"><a class="title" href="<?=getLinkSort(10)?>">Hiệu chỉnh</a></th>
		</tr>
    </thead>
	<?php
		$field = 'id, name, phone, email, addr, type, content, date_added, last_modified, status';
		$sortby = $_REQUEST['sortby']!='' ? "order by ".(int)$_REQUEST['sortby'] : "order by date_added";
		$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?" desc":" ");
		$contacts = selectMulti(tbl_config::tbl_contact, $field, $where, $sortby . $direction, 'LIMIT ' . ($p * system_config::maxpage) . ',' . system_config::maxpage);
		//echo var_dump($contacts);
		$i=0;
		foreach($contacts as $contact){
			$id = $contact['id'];
			$name = $contact['name'];
			$phone = $contact['phone'];
			$email = $contact['email'];
			$addr = $contact['addr'];
			$type = $contact['type'];
			switch($type){
				case 0: $contact_to = 'Quản trị viên';			break;
				case 1: $contact_to = 'Dịch vụ thiết kế web';	break;
				case 2: $contact_to = 'Bộ phận đối tác';		break;
				case 3: $contact_to = 'Bộ phận liên kết site';	break;
				case 4: $contact_to = 'Quản lý quảng cáo';		break;
			}
			$content = $contact['content'];
			$date_added = $contact['date_added'];
			$last_modified = $contact['last_modified'];
			$status = $contact['status'];
			$mau = $i++%2 ? 'class="row0"' : 'class="row1"';
	?>
  
	<tr <?=$mau?> id="content_id_<?=$id?>">
		<td align="center" class="smallfont"><?=$i?></td>
		<td align="center" class="smallfont">
			<input class="chk" type="checkbox" name="chk[]" value="<?=$id?>">
		</td>
		<td class="smallfont" align="center"><?=$id?></td>
		<td width="26" align="center" class="smallfont">
			<span onClick="delrow('<?=$id?>');">Xóa</span>
		</td>
		<td class="smallfont" align="center"><?=$name?></td>
		<td class="smallfont" align="center"><?=$phone?></td>
		<td class="smallfont" align="center"><?=$email?></td>
		<td class="smallfont" align="center"><?=$addr?></td>
		<td class="smallfont" align="center"><a href="javascript:view_detail('<?=$content?>');">Xem chi tiết</a></td>
		<td class="smallfont" align="center"><?=$contact_to?></td>
		<td class="smallfont" align="center"><img id="status_icon_<?=$id?>" src="<?=$status>0?'images/uncheck.png':'images/check.png'?>" onclick="check_contact('<?=$id?>','<?=$status>0?'0':'1'?>');" style="cursor:pointer;" /></td>
		<td class="smallfont" align="center"><?=date('d/m/Y H:m',$date_added)?></td>
		<td class="smallfont" align="center"><?=date('d/m/Y H:m',$last_modified)?></td>
	</tr>
<? }?>
	<tfoot>
    	<td colspan="13"><div class="pagination smallfont">Trang: <?=$pageindex?></div></td>
    </tfoot>
</table>
<table width="100%">
	<tr>
		<td width="7%">
			<input type="button" value="Xóa chọn" name="btnDel" onClick="del_multi_row();" class="button">
		</td>
        <td width="86%" align="right">&nbsp;</td>
	</tr>
</table>
</form>