<th class="title" width="20">TT</th>
<th width="20" class="title"><input type="checkbox" name="chkall" onClick="chkallClick(this);"></th>
<th width="24" class="title"><a class="title" href="<?=getLinkSort(1)?>">ID</a></th>
<th width="26" class="title">&nbsp;</th>		
<th width="152" class="title">
    <a class="title" href="<?=getLinkSort(2)?>">Tên sản phẩm</a>
    <br>
    <a class="title" href="<?=getLinkSort(3)?>">Danh mục</a>
    <br>
    <a class="title" href="<?=getLinkSort(3)?>">SEO KEY</a>
</th>
<th width="71" class="title"><a class="title" href="<?=getLinkSort(4)?>">Mô tả ngắn</a></th>
<th width="63" class="title"><a class="title" href="<?=getLinkSort(5)?>">Chi tiết</a></th>
<th width="100" class="title"><a class="title" href="<?=getLinkSort(6)?>">Hình ảnh</a></th>
<th width="100" class="title"><a class="title" href="<?=getLinkSort(7)?>">
<?php
    $nav_cat = selectOne(tbl_config::tbl_category, 'status=1 AND parent_id=0 AND code = "properties"', 'sort, date_added ASC');
    $nav_id = $nav_cat['id'];
    $nav_child_cats = selectMulti(tbl_config::tbl_category, 'id, name', 'status=1 AND parent_id = ' . $nav_id, 'ORDER BY sort, date_added ASC');
    foreach($nav_child_cats as $nav_child_cat){
            echo $nav_child_cat['name'] . '<br>';
    }
?>
</a></th>
<th width="59" class="title"><a class="title" href="<?=getLinkSort(8)?>">Giá sp</a></th>
<th width="59" class="title"><a class="title" href="<?=getLinkSort(8)?>">Lượt xem</a></th>
<th width="109" class="title"><a class="title" href="<?=getLinkSort(9)?>">Sắp xếp</a></th>
<th width="54" class="title"><a class="title" href="<?=getLinkSort(11)?>">Hiển thị</a></th>
<th width="58" class="title"><a class="title" href="<?=getLinkSort(12)?>">Ngày tạo lập</a></th>
<th width="62" class="title"><a class="title" href="<?=getLinkSort(13)?>">Lần hiệu chỉnh trước</a></th>
