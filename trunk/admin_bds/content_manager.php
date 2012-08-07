<?
	require_once('../config.php');
	require_once('../lib/func.lib.php');
	$parent_id = $_POST['id'];
	$cat_id = $_POST['cat'];
	$cat_title = $_POST['title'];
	$page = $_POST['page'];

	$cat_parent = 'parent = ' . $parent_id;
	$count_child_cat = countRecord(tbl_config::tbl_category,$cat_parent);
	$arraySourceCombo   = getArrayCombo(tbl_config::tbl_category,'id','name_vn',$cat_parent);
	//$codeSelect.= 		" and id in (select cat_id from ".tbl_config::tbl_controller_per." where user_id=$adminId and cat_code='".$act."')";
	$firstWhere = 'parent in (select id from ' . tbl_config::tbl_category . ' where ' . $cat_parent . ')';
	$where = $cat_id || $cat_id!='' ? ' parent = ' . $cat_id : $firstWhere;
	if($count_child_cat == 0){
		$where = $cat_parent;
	}
	$p = $page || $page!='' ? $page : 0;
	
	$getCode = getRecord(tbl_config::tbl_category,'id = ' . $parent_id);
	$code = $getCode['code'];
	$field = 'id, name_vn, name_en, parent, detail_short_vn, detail_short_en, detail_vn, detail_en, image_thumbs, image, sort, status, show_home, show_hot, date_added, last_modified, views';
	switch($code){
		case 'alexa_rank' 	: $tbl = tbl_config::tbl_site_rank; $field = 'id, rank, compare, date_added'; break;
		case 'news' 		: $tbl = tbl_config::tbl_news; $field = 'id, name_vn, name_en, parent, source, detail_short_vn, detail_short_en, detail_vn, detail_en, image_thumbs, image, sort, status, show_home, show_hot, date_added, last_modified, views'; break;
		default 			: $tbl = tbl_config::tbl_content; 	break; 
	} 
	$pageindex = createPage(countRecord($tbl,$where),$parent_id,system_config::maxpage,$page);
?>
<script type="text/javascript" src="js/content_manager.js"></script>
<h3 parent_id="<?=$parent_id?>" tbl_data="<?=$tbl?>"><?=$cat_title?></h3>
<form method="POST" action="./" name="frmForm" enctype="multipart/form-data">
<div class="clear"></div>
<?php if($code != 'alexa_rank'){?>
<div id="toolbar" class="toolbar">
	<table class="toolbar">
    	<tr>
        	<td id="toolbar-new" class="button">
	            <a class="toolbar" onclick="add_new(<?=$parent_id?>);">
                	<span class="icon-32-new" title="Thêm mới"> </span>Thêm mới
                </a>
            </td>
        </tr>
    </table>
</div>
<?php }?>
<table cellspacing="0" cellpadding="0" width="100%" bgcolor="#FFFFFF">
	<tr>
		<td height="30" class="smallfont pagination">&nbsp;&nbsp;Trang : <?=$pageindex?></td>
		<td align="right" class="smallfont">
		<?php if($count_child_cat > 0){?>
			Xem theo danh mục: <?=comboCategory('ddCat',$arraySourceCombo,'smallfont',$cat_id,1,$parent_id)?>
		<?php }?>
		</td>
	</tr>
</table>

<table width="97%" class="adminlist">
	<thead>
		<tr>
		<?php
			switch($code){
				case 'news' 		: require('template/news_thead_ajax.php'); 			break;
				case 'advup' 		: require('template/advup_thead_ajax.php'); 		break;
				case 'banner' 		: require('template/banner_thead_ajax.php'); 		break;
				case 'albums' 		: require('template/albums_thead_ajax.php'); 		break;
				case 'contact_info' : require('template/contact_info_thead_ajax.php'); 	break;
				case 'contact' 		: require('template/contact_thead_ajax.php'); 		break;
				case 'entertainment': require('template/entertainment_thead_ajax.php'); break;
				case 'site_index'	: require('template/site_index_thead_ajax.php'); 	break;
				case 'alexa_rank'	: require('template/alexa_rank_thead_ajax.php'); 	break;
				case 'link'			: require('template/site_link_thead_ajax.php'); 	break;
				case 'partners'		: require('template/partner_thead_ajax.php'); 		break;
				default 			: require('template/content_thead_ajax.php'); 		break; 
			} 
		?>
		</tr>
    </thead>
<?
	$sortby="order by date_added";
	$sortby = $_REQUEST['sortby']!='' ? "order by ".(int)$_REQUEST['sortby'] : "order by id";
	$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?" desc":" ");
	$contents = getMultiRecord($tbl, $field, $where, $sortby . $direction, 'LIMIT ' . ($p * system_config::maxpage) . ',' . system_config::maxpage);
	$i=0;
	foreach($contents as $content){
		$id = $content['id'];
		if($code == 'alexa_rank'){
			$rank = $content['rank'];
			$compare = $content['compare'];
			$date_added = $content['date_added'];
		}else{
			$name_vn = $content['name_vn'];
			$name_en = $content['name_en'];
			$parent = $content['parent'];
			$short_vn = $content['detail_short_vn'];
			$short_en = $content['detail_short_en'];
			$detail_vn = $content['detail_vn'];
			$detail_en = $content['detail_en'];
			$image_thumbs = $content['image_thumbs'];
			$image = $content['image'];
			$sort = $content['sort'];
			$status = $content['status'];
			$show_home = $content['show_home'];
			$show_hot = $content['show_hot'];
			$date_added = $content['date_added'];
			$last_modified = $content['last_modified'];
			$views = $content['views'];
			$getParent = getRecord(tbl_config::tbl_category,'id = ' . $parent);
		}
		$mau = $i++%2 ? 'class="row0"' : 'class="row1"';
	?>
  
	<tr <?=$mau?> id="content_id_<?=$id?>">
		<?php
			switch($code){
				case 'advup' 		: require('template/advup_rows_ajax.php'); 			break;
				case 'banner' 		: require('template/banner_rows_ajax.php'); 		break;
				case 'albums' 		: require('template/albums_rows_ajax.php'); 		break;
				case 'contact_info' : require('template/contact_info_rows_ajax.php'); 	break;
				case 'contact' 		: require('template/contact_rows_ajax.php'); 		break;
				case 'news' 		: require('template/news_rows_ajax.php') ; 			break;
				case 'entertainment': require('template/entertainment_rows_ajax.php'); 	break;
				case 'site_index'	: require('template/site_index_rows_ajax.php'); 	break;
				case 'alexa_rank'	: require('template/alexa_rank_rows_ajax.php'); 	break;
				case 'link'			: require('template/site_link_rows_ajax.php'); 		break;
				case 'partners'		: require('template/partner_rows_ajax.php'); 		break;
				default 			: require('template/content_rows_ajax.php'); 		break; 
			} 
		?>
	</tr>
<? }?>
	<tfoot>
    	<td colspan="16"><div class="pagination smallfont">Trang: <?=$pageindex?></div></td>
    </tfoot>
</table>
<table width="100%">
	<tr>
		<?php if($code != 'alexa_rank'){?>
		<td width="7%">
			<input type="button" value="Nhập mới" name="addNew" onClick="add_new(<?=$parent_id?>);" class="button">
		</td>
		<?php }?>
		<td width="7%">
			<input type="button" value="Xóa chọn" name="btnDel" onClick="del_multi_row();" class="button">
		</td>
        <td width="86%" align="right">&nbsp;</td>
	</tr>
</table>
</form>