<?
	require_once('config.php');
	require_once('lib/func.lib.php');
        $cat_parent_id = $_GET['parent_id'];
        $get_parent_info = selectOne(tbl_config::tbl_category, 'id = ' . $cat_parent_id);
        $code = $get_parent_info['code'];
        $parent_title = $get_parent_info['name'];
        $cat_id = $_GET['id'];
        $get_cat_info = selectOne(tbl_config::tbl_category, 'id = ' . $cat_id);
	$cat_title = $get_cat_info['name'];
	$page = $_POST['page'];

	$where_parent = 'parent_id = ' . $cat_id;
	$p = $page || $page!='' ? $page : 0;

        $field = 'id, name, detail_short, detail, image_thumbs, image_large, sort, status, date_added, last_modified, views';
	switch($code){
		case 'properties' 	: $tbl = tbl_config::tbl_properties; $field = 'id, name, parent_id, sort, status, date_added, last_modified'; break;
//		case 'news' 		: $tbl = tbl_config::tbl_news; $field = 'id, name_vn, name_en, parent, source, detail_short_vn, detail_short_en, detail_vn, detail_en, image_thumbs, image, sort, status, show_home, show_hot, date_added, last_modified, views'; break;
		case 'product' 		: $tbl = tbl_config::tbl_product; $field = 'id, name, parent_id, detail_short, detail, image_thumbs, sort, status, date_added, last_modified, views'; break;
		default 		: $tbl = tbl_config::tbl_content; 	break; 
	}
        $where = $where_parent;
	$pageindex = createPage(countRecord($tbl,$where),$parent_id,system_config::maxpage,$page);
?>
<script type="text/javascript" src="js/content_manager.js"></script>
<h3 parent_id="<?=$cat_parent_id?>" cat_id="<?=$cat_id?>" tbl_data="<?=$tbl?>"><?=$parent_title?> / <?=$cat_title?></h3>
<form method="POST" action="./" name="frmForm" enctype="multipart/form-data">
<div class="clear"></div>
<?php if($code != 'alexa_rank'){?>
<div id="toolbar" class="toolbar">
	<table class="toolbar">
    	<tr>
            <td id="toolbar-new" class="button">
                <?php if($code == 'properties'){?>
                <a class="toolbar" onclick="add_new_properties('<?=$tbl?>', <?=$cat_parent_id?>, <?=$cat_id?>);">
                	<span class="icon-32-new" title="Thêm mới"> </span>Thêm mới
                </a>
                <?php }else{?>
                <a class="toolbar" onclick="add_new('<?=$tbl?>', <?=$cat_parent_id?>, <?=$cat_id?>);">
                	<span class="icon-32-new" title="Thêm mới"> </span>Thêm mới
                </a>
                <?php }?>
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
				case 'news' 		: require('template/news_thead_ajax.php'); 		break;
                                case 'product' 		: require('template/product_thead_ajax.php'); 		break;
                                case 'properties'	: require('template/properties_thead_ajax.php'); 	break;
				case 'advup' 		: require('template/advup_thead_ajax.php'); 		break;
				case 'banner' 		: require('template/banner_thead_ajax.php'); 		break;
				case 'albums' 		: require('template/albums_thead_ajax.php'); 		break;
				case 'contact_info'     : require('template/contact_info_thead_ajax.php'); 	break;
				case 'contact' 		: require('template/contact_thead_ajax.php'); 		break;
				case 'entertainment'    : require('template/entertainment_thead_ajax.php');     break;
				case 'site_index'	: require('template/site_index_thead_ajax.php'); 	break;
				case 'alexa_rank'	: require('template/alexa_rank_thead_ajax.php'); 	break;
				case 'link'		: require('template/site_link_thead_ajax.php'); 	break;
				case 'partners'		: require('template/partner_thead_ajax.php'); 		break;
				default 		: require('template/content_thead_ajax.php'); 		break; 
			} 
		?>
		</tr>
    </thead>
<?
	$sortby="order by date_added";
	$sortby = $_REQUEST['sortby']!='' ? "order by ".(int)$_REQUEST['sortby'] : "order by id";
	$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?" desc":" ");
	$contents = selectMulti($tbl, $field, $where, $sortby . $direction, 'LIMIT ' . ($p * system_config::maxpage) . ',' . system_config::maxpage);
	$i=0;
	foreach($contents as $content){
		$id = $content['id'];
                $name = $content['name'];
                $detail_short = $content['detail_short'];
                $detail = $content['detail'];
                $image_thumbs = $content['image_thumbs'];
                $image_large = $content['image_large'];
                $sort = $content['sort'];
                $status = $content['status'];
                $date_added = $content['date_added'];
                $last_modified = $content['last_modified'];
                $views = $content['views'];
		
		$mau = $i++%2 ? 'class="row0"' : 'class="row1"';
	?>
	<tr <?=$mau?> id="content_id_<?=$id?>">
		<?php
			switch($code){
				case 'news' 		: require('template/news_rows_ajax.php') ; 		break;
                                case 'product' 		: require('template/product_rows_ajax.php') ; 		break;
                                case 'properties'	: require('template/properties_rows_ajax.php') ; 	break;
				case 'advup' 		: require('template/advup_rows_ajax.php'); 		break;
				case 'banner' 		: require('template/banner_rows_ajax.php'); 		break;
				case 'albums' 		: require('template/albums_rows_ajax.php'); 		break;
				case 'contact_info' : require('template/contact_info_rows_ajax.php'); 	break;
				case 'contact' 		: require('template/contact_rows_ajax.php'); 		break;
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
                <?php if($code == 'properties'){?>
                <td width="7%">
			<input type="button" value="Nhập mới" name="addNew" onClick="add_new_properties('<?=$tbl?>', <?=$cat_parent_id?>, <?=$cat_id?>);" class="button">
		</td>
                <?php }else{?>
                <td width="7%">
			<input type="button" value="Nhập mới" name="addNew" onClick="add_new('<?=$tbl?>', <?=$cat_parent_id?>, <?=$cat_id?>);" class="button">
		</td>
                <?php }?>
		<td width="7%">
			<input type="button" value="Xóa chọn" name="btnDel" onClick="del_multi_row();" class="button">
		</td>
        <td width="86%" align="right">&nbsp;</td>
	</tr>
</table>
</form>