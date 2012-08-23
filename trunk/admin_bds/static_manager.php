<?
	require_once('config.php');
	require_once('lib/func.lib.php');
?>
<script type="text/javascript" src="js/static_manager.js"></script>
<h3>Nội dung mặc định</h3>
<form method="POST" action="./" name="frmForm" enctype="multipart/form-data">
<div class="clear"></div>
<table width="97%" class="adminlist">
	<thead>
		<tr>
                    <th width="24" class="title"><a class="title" href="<?=getLinkSort(1)?>">ID</a></th>
                    <th width="54" class="title"><a class="title" href="<?=getLinkSort(2)?>">Mã nội dung</a></th>
                    <th width="152" class="title"><a class="title" href="<?=getLinkSort(3)?>">Tiêu đề</a></th>
                    <th width="63" class="title"><a class="title" href="<?=getLinkSort(5)?>">Nội dung</a></th>
                    <th width="100" class="title"><a class="title" href="<?=getLinkSort(6)?>">Hình ảnh</a></th>
                    <th width="59" class="title"><a class="title" href="<?=getLinkSort(7)?>">Lượt xem</a></th>
                    <th width="109" class="title"><a class="title" href="<?=getLinkSort(8)?>">Thứ tự sắp xếp</a></th>
                    <th width="54" class="title"><a class="title" href="<?=getLinkSort(11)?>">Hiển thị</a></th>
                    <th width="58" class="title"><a class="title" href="<?=getLinkSort(12)?>">Ngày tạo lập</a></th>
                    <th width="62" class="title"><a class="title" href="<?=getLinkSort(13)?>">Lần hiệu chỉnh trước</a></th>
		</tr>
    </thead>
<?
        $field = 'id, code, name, detail, image_thumbs, sort, status, date_added, last_modified, views';
        $where = 'code IN ("intro","info") AND parent_id = 0';
	$sortby="order by date_added";
	$sortby = $_REQUEST['sortby']!='' ? "order by ".(int)$_REQUEST['sortby'] : "order by id";
	$direction=($_REQUEST['direction']==''||$_REQUEST['direction']=='0'?" desc":" ");
	$contents = selectMulti(tbl_config::tbl_static, $field, $where, $sortby . $direction);
	$i=0;
	foreach($contents as $content){
		$id = $content['id'];
                $code = $content['code'];
                $name = $content['name'];
                $detail = $content['detail'];
                $image_thumbs = $content['image_thumbs'];
                $sort = $content['sort'];
                $status = $content['status'];
                $date_added = $content['date_added'];
                $last_modified = $content['last_modified'];
                $views = $content['views'];
		
		$mau = $i++%2 ? 'class="row0"' : 'class="row1"';
	?>
	<tr <?=$mau?> id="content_id_<?=$id?>">
            <td class="smallfont" align="center"><?=$id?></td>
            <td class="smallfont" align="center"><?=$code?></td>
            <td class="smallfont" align="center">
                    <span id="name_<?=$id?>" onclick="edit_name('<?=killInjection($name)?>','<?=$id?>');"><?=killInjection($name)?></span>
            </td>
            <td class="smallfont" align="center">
                    <span id="detail_<?=$id?>" onclick="edit_detail('<?=$id?>');"><?=$detail!=''?'<img src="images/icons/pencil.png" alt="" />':'<img src="images/empty.png" alt="" />'?></span>
            </td>
            <td class="smallfont" align="center">
                <img id="image_<?=$id?>" onclick="edit_image(<?=$id?>,'<?=$code?>');" src="<?=$image_thumbs!=''?'../'.$image_thumbs:'images/no_image.gif'?>" width="100" alt="" />
                <img onclick="edit_image(<?=$id?>,'<?=$code?>');" src="images/icons/pencil.png" alt="" />
            </td>
            <td class="smallfont" align="center">
                    <span id="views_num_<?=$id?>" onclick="show_views_input(<?=$id?>);"><?=$views?></span>
                    <input type="text" id="views_input_<?=$id?>" name="views_input" onblur="update_views('<?=$id?>',this.value);" value="<?=$views?>" size="2" style="display:none;" />
            </td>
            <td class="smallfont sort-num" align="center">
                    <img src="images/up.png" alt="" onclick="up_down_sort('<?=$id?>','1');" />
                    <div id="sort_num_<?=$id?>" align="center"><?=$sort?></div>
                    <img src="images/down.png" alt="" onclick="up_down_sort('<?=$id?>','0');" />
            </td>
            <td class="smallfont" align="center"><img id="status_icon_<?=$id?>" src="<?=$status==0?'images/uncheck.png':'images/check.png'?>" onclick="show_hide('<?=$id?>','<?=$status>0?'0':'1'?>');" style="cursor:pointer;" /></td>
            <td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$date_added)?></td>
            <td class="smallfont" align="center"><?=date('d/m/Y h:i:s A',$last_modified)?></td>
	</tr>
<? }?>
</table>
</form>