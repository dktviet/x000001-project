<?php 
	require_once('../config.php');
	require_once('../lib/func.lib.php');
	$get_id = $_POST['id'] ? $_POST['id'] : 0;
	$cat_title = $_POST['title'];
?>
<script type="text/javascript" language="javascript" src="js/category_manager.js"></script>
<h3><?=$cat_title?></h3>
<div class="clear"></div>
<form method="POST" action="./" name="frmForm" enctype="multipart/form-data">
	<div class="clear"></div>
	<? //if($adminInfo['id']==8388){?>
	<div id="toolbar" class="toolbar">
		<table class="toolbar">
	    	<tr>
	        	<td id="toolbar-new" class="button">
	            	<a class="toolbar" onclick="add_new(<?=$get_id?>);">
	                	<span class="icon-32-new" title="Thêm mới"> </span>Thêm mới
	                </a>
	            </td>
	        </tr>
	    </table>
	</div>
	<? //}?>
	<table class="adminlist">
		<thead>
		<tr>
			<th width="20" class="title"><input type="checkbox" name="chkall" onClick="chkallClick(this);"></th>
			<th width="34" class="title"><a class="title" href="<?=getLinkSort(1)?>">ID</a></th>
			<th width="20" class="title">&nbsp;</th>
			<th width="100" class="title"><a class="title" href="<?=getLinkSort(2)?>">Mã danh mục</a></th>	
			<th width="163" class="title"><a class="title" href="<?=getLinkSort(2)?>">Tên danh mục</a></th>
			<th width="111" class="title"><a class="title" href="<?=getLinkSort(3)?>">Thứ tự sắp xếp</a></th>
			<th width="102" class="title"><a class="title" href="<?=getLinkSort(4)?>">Hiển thị</a></th>
			<th width="102" class="title"><a class="title" href="<?=getLinkSort(5)?>">Top menu</a></th>
			<th width="102" class="title"><a class="title" href="<?=getLinkSort(6)?>">Bottom menu</a></th>
			<th width="102" class="title"><a class="title" href="<?=getLinkSort(7)?>">Admin menu</a></th>
			<th width="97" class="title"><a class="title" href="<?=getLinkSort(8)?>">Ngày tạo lập</a></th>
			<th width="103" class="title"><a class="title" href="<?=getLinkSort(9)?>">Lần hiệu chỉnh trước</a></th>
		</tr>
	  	</thead>
	<?php
	$where="parent=".$get_id;
	//$where.= " and id in (select cat_id from ".tbl_config::tbl_controller_per." where user_id=$adminId and cat_code='".substr($act,0,-9)."')";
	$sortby="order by date_added";
	$sortby = $_REQUEST['sortby']!='' ? "order by ".(int)$_REQUEST['sortby'] : "order by id";
	$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?" asc":" ");
	$field = 'id, code, name_vn, name_en, sort, status, top_menu, bottom_menu, admin_menu, date_added, last_modified';
	$nav_cats = getMultiRecord(tbl_config::tbl_category, $field, $where, $sortby . $direction);
	$i=0;
	foreach($nav_cats as $nav_cat){
		$nav_id = $nav_cat['id'];
		$code = $nav_cat['code'];
		$nav_name_vn = $nav_cat['name_vn'];
		$nav_name_en = $nav_cat['name_en'];
		$sort = $nav_cat['sort'];
		$status = $nav_cat['status'];
		$top_menu = $nav_cat['top_menu'];
		$bottom_menu = $nav_cat['bottom_menu'];
		$admin_menu = $nav_cat['admin_menu'];
		$date_added = $nav_cat['date_added'];
		$last_modified = $nav_cat['last_modified'];
		$mau = $i++%2 ? 'class="row0"' : 'class="row1"';
	?>
		<tr <?=$mau?> id="cat_id_<?=$nav_id?>">
			<td align="center" class="smallfont">
			<input class="chk" type="checkbox" name="chk[]" value="<?=$nav_id?>"></td>
			<td class="smallfont" align="center"><?=$nav_id?></td>
			<td align="center" class="smallfont">
				<span onClick="delrow('<?=$nav_id?>');">Xóa</span>
	        </td>
	        <td class="smallfont" align="center">
				<span id="code_<?=$nav_id?>" onclick="edit_code('<?=$code?>','<?=$nav_id?>');"><?=$code?></span>
			</td>
			<td class="smallfont" align="center">
				<span id="name_vn_<?=$nav_id?>" onclick="edit_name('<?=$nav_name_vn?>','<?=$nav_name_en?>','<?=$nav_id?>');" title="Name: <?=$nav_name_en!=''?$nav_name_en:'Rỗng'?>"><?=$nav_name_vn?></span>
			</td>
			<td class="smallfont sort-num" align="center">
	            <img src="images/up.png" alt="" onclick="up_down_sort('<?=$nav_id?>','1');" />
				<div id="sort_num_<?=$nav_id?>" align="center"><?=$sort?></div>
				<img src="images/down.png" alt="" onclick="up_down_sort('<?=$nav_id?>','0');" />
	        </td>
			<td class="smallfont" align="center"><img id="status_icon_<?=$nav_id?>" src="<?=$status>0?'images/uncheck.png':'images/check.png'?>" onclick="show_hide('<?=$nav_id?>','<?=$status>0?'0':'1'?>');" style="cursor:pointer;" /></td>
			<td class="smallfont" align="center"><img id="top_menu_icon_<?=$nav_id?>" src="<?=$top_menu==0?'images/uncheck.png':'images/check.png'?>" onclick="top_menu('<?=$nav_id?>','<?=$top_menu>0?'0':'1'?>');" style="cursor:pointer;" /></td>
			<td class="smallfont" align="center"><img id="bottom_menu_icon_<?=$nav_id?>" src="<?=$bottom_menu==0?'images/uncheck.png':'images/check.png'?>" onclick="bottom_menu('<?=$nav_id?>','<?=$bottom_menu>0?'0':'1'?>');" style="cursor:pointer;" /></td>
			<td class="smallfont" align="center"><img id="admin_menu_icon_<?=$nav_id?>" src="<?=$admin_menu==0?'images/uncheck.png':'images/check.png'?>" onclick="admin_menu('<?=$nav_id?>','<?=$admin_menu>0?'0':'1'?>');" style="cursor:pointer;" /></td>
			<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$date_added)?></td>
			<td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$last_modified)?></td>
		</tr>	
	<?php }?>
	</table>
	<table width="100%">
		<tr>
			<td width="7%">
				<input type="button" class="button" value="Xóa chọn" name="btnDel" onClick="del_multi_row();" />
			</td>
	        <td width="86%" align="right">&nbsp;</td>
		</tr>
	</table>
</form>