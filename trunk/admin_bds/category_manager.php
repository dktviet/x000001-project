<?php 
	require_once('config.php');
	require_once('lib/func.lib.php');
	$cat_id = $_GET['id'];
        $get_info = selectOne(tbl_config::tbl_category, 'id = ' . $cat_id);
        $parent_code = $get_info['code'];
	$cat_title = $get_info['name'];
?>
<script type="text/javascript" language="javascript" src="js/category_manager.js"></script>
<h3 cat_id="<?=$cat_id?>">Danh mục <?=$cat_title?></h3>
<div class="clear"></div>
<form method="POST" action="./" name="frmForm" enctype="multipart/form-data">
	<div class="clear"></div>
	<? //if($adminInfo['id']==8388){?>
	<div id="toolbar" class="toolbar">
		<table class="toolbar">
	    	<tr>
	        	<td id="toolbar-new" class="button">
	            	<a class="toolbar" onclick="add_new(<?=$cat_id?>);">
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
                        <?php
                            if($parent_code == 'news' || $parent_code == 'product'){
                        ?>
                        <th width="163" class="title">
                            <a class="title" href="<?=getLinkSort(2)?>">Tên danh mục</a>
                            <br>
                            <a class="title" href="<?=getLinkSort(2)?>">Mô tả</a>
                        </th>
                        <th width="100" class="title">
                            <a class="title" href="<?=getLinkSort(2)?>">SEO KEY</a>
                            <br>
                            <a class="title" href="<?=getLinkSort(2)?>">Tiêu đề SEO</a>
                        </th>
                        <?php
                            }else{
                        ?>
			<th width="163" class="title"><a class="title" href="<?=getLinkSort(2)?>">Tên danh mục</a></th>
                        <?php }?>
			<th width="111" class="title"><a class="title" href="<?=getLinkSort(3)?>">Thứ tự sắp xếp</a></th>
			<th width="102" class="title"><a class="title" href="<?=getLinkSort(4)?>">Hiển thị</a></th>
			<th width="102" class="title"><a class="title" href="<?=getLinkSort(5)?>">Top menu</a></th>
			<th width="97" class="title"><a class="title" href="<?=getLinkSort(6)?>">Ngày tạo lập</a></th>
			<th width="103" class="title"><a class="title" href="<?=getLinkSort(7)?>">Lần hiệu chỉnh trước</a></th>
		</tr>
	  	</thead>
	<?php
	$where="parent_id=".$cat_id;
	//$where.= " and id in (select cat_id from ".tbl_config::tbl_controller_per." where user_id=$adminId and cat_code='".substr($act,0,-9)."')";
	$sortby="order by date_added";
	$sortby = $_REQUEST['sortby']!='' ? "order by ".(int)$_REQUEST['sortby'] : "order by id";
	$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?" asc":" ");
	$field = 'id, name, description, sort, status, date_added, last_modified, top_menu, seo_key, title';
	$nav_cats = selectMulti(tbl_config::tbl_category, $field, $where, $sortby . $direction);
	$i=0;
	foreach($nav_cats as $nav_cat){
		$nav_id = $nav_cat['id'];
		$nav_name = $nav_cat['name'];
                $desc = $nav_cat['description'];
		$sort = $nav_cat['sort'];
		$status = $nav_cat['status'];
		$top_menu = $nav_cat['top_menu'];
		$seo_key = $nav_cat['seo_key'];
                $title = $nav_cat['title'];
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
                        <?php
                            if($parent_code == 'news' || $parent_code == 'product'){
                        ?>
			<td class="smallfont" align="center">
				<span id="name_<?=$nav_id?>" onclick="edit_name('<?=$nav_name?>',<?=$nav_id?>);"><?=$nav_name?></span>
                                <br><hr>
                                <span id="desc_<?=$nav_id?>" onclick="edit_desc('<?=$desc?>',<?=$nav_id?>);"><?=$desc!=''?'<img src="images/icons/pencil.png" alt="" />':'<img src="images/empty.png" alt="" />'?></span>
			</td>
			<td class="smallfont" align="center">
				<span id="seo_key_<?=$nav_id?>" onclick="edit_seo_key('<?=$seo_key?>',<?=$nav_id?>);"><?=$seo_key!=''?$seo_key:'<img src="images/empty.png" alt="" />'?></span>
                                <br><hr>
                                <span id="title_<?=$nav_id?>" onclick="edit_title('<?=$title?>',<?=$nav_id?>);"><?=$title!=''?$title:'<img src="images/empty.png" alt="" />'?></span>
			</td>
                        <?php
                            }else{
                        ?>
			<td class="smallfont" align="center">
				<span id="name_<?=$nav_id?>" onclick="edit_name('<?=$nav_name?>',<?=$nav_id?>);"><?=$nav_name?></span>
			</td>
                        <?php }?>
			<td class="smallfont sort-num" align="center">
                                <img src="images/up.png" alt="" onclick="up_down_sort(<?=$nav_id?>,1);" />
				<div id="sort_num_<?=$nav_id?>" align="center"><?=$sort?></div>
				<img src="images/down.png" alt="" onclick="up_down_sort(<?=$nav_id?>,0);" />
	        </td>
			<td class="smallfont" align="center"><img id="status_icon_<?=$nav_id?>" src="<?=$status==0?'images/uncheck.png':'images/check.png'?>" onclick="show_hide('<?=$nav_id?>','<?=$status>0?'0':'1'?>');" style="cursor:pointer;" /></td>
			<td class="smallfont" align="center"><img id="top_menu_icon_<?=$nav_id?>" src="<?=$top_menu==0?'images/uncheck.png':'images/check.png'?>" onclick="top_menu('<?=$nav_id?>','<?=$top_menu>0?'0':'1'?>');" style="cursor:pointer;" /></td>
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