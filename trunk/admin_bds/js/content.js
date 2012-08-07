function delrow(id){
	var row_id = '#content_id_'+id;
	var tbl_name = $('#tbl_name').val();
	if(confirm('Bạn có chắc chắn muốn xóa ?')){
		$.post("ajax/content_action.php", {
			fnc:'del',
			tbl: tbl_name,
			id: id 
		}, function(data) {
			$(row_id).hide();
		});
	}
}
function del_multi_row(){
	var tbl_name = $('#tbl_name').val();
	var multi_id = [];
    $.each($('.chk:checked'), function() {
    	multi_id.push($(this).val()); 
    });
	if(confirm('Bạn có chắc chắn muốn xóa ?')){
		$.post("ajax/content_action.php", {
			fnc:'del_multi',
			tbl: tbl_name,
			id: multi_id 
		}, function(data) {
			alert(data);
		    $.each(multi_id, function(id, val) {
		    	$("#content_id_" + val).hide();
		    });
		});
	}
}
function show_hide(id, val){
	var status_icon = '#status_icon_'+id;
	var tbl_name = $('#tbl_name').val();
	$.post("ajax/content_action.php", {
		fnc:'show_hide',
		tbl: tbl_name,
		id: id,
		val: val
	}, function(data) {
		if(val==0){
			$(status_icon).attr('src','images/check.png');
			$(status_icon).attr("onclick","show_hide('"+id+"','1');");
		}else{
			$(status_icon).attr('src','images/uncheck.png');
			$(status_icon).attr("onclick","show_hide('"+id+"','0');");
		}
	});
}
function show_home(id, val){
	var show_home_icon = '#show_home_icon_'+id;
	var tbl_name = $('#tbl_name').val();
	$.post("ajax/content_action.php", {
		fnc:'show_home',
		tbl: tbl_name,
		id: id,
		val: val
	}, function(data) {
		if(val==0){
			$(show_home_icon).attr('src','images/uncheck.png');
			$(show_home_icon).attr("onclick","show_home('"+id+"','1');");
		}else{
			$(show_home_icon).attr('src','images/check.png');
			$(show_home_icon).attr("onclick","show_home('"+id+"','0');");
		}
	});
}
function show_hot(id, val){
	var show_hot_icon = '#show_hot_icon_'+id;
	var tbl_name = $('#tbl_name').val();
	$.post("ajax/content_action.php", {
		fnc:'show_hot',
		tbl: tbl_name,
		id: id,
		val: val
	}, function(data) {
		if(val==0){
			$(show_hot_icon).attr('src','images/uncheck.png');
			$(show_hot_icon).attr("onclick","show_hot('"+id+"','1');");
		}else{
			$(show_hot_icon).attr('src','images/check.png');
			$(show_hot_icon).attr("onclick","show_hot('"+id+"','0');");
		}
	});
}
function up_down_sort(id, sort_index){
	var sort_num_id = '#sort_num_'+id;
	var tbl_name = $('#tbl_name').val();
	var sort_num = $(sort_num_id).text();
	if(sort_index == '1'){
		sort_num = parseInt(sort_num) + 1;
	}else{
		if(sort_num>0){	sort_num = parseInt(sort_num) - 1; }else{ sort_num = 0; }
	}
	$.post("ajax/content_action.php", {
		fnc:'sort_row',
		tbl: tbl_name,
		id: id,
		val: sort_num
	}, function(data) {	$(sort_num_id).text(sort_num); });
}
function edit_name(name_vn, name_en, id){
	var tbl_name = $('#tbl_name').val();
	$('#dialog').dialog({
		title: 'Sửa tên',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var name_vn = $('#name_vn_space').val();
				var name_en = $('#name_en_space').val();
				$.post("ajax/content_action.php", {
					fnc:'edit_name',
					tbl: tbl_name,
					id: id,
					val1: name_vn,
					val2: name_en
				}, function(data) {
					alert(data);
					$('#name_vn_'+id).text(name_vn);
					$('#name_vn_'+id).attr('title',name_en);
				});
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;">Tên tiếng Việt:<input type="text" id="name_vn_space" value="" /></div><div style="float:left;padding:20px 0px 20px 20px;">Tên tiếng Anh:<input type="text" id="name_en_space" value="" /></div>');
	$('#name_vn_space').val(name_vn);
	$('#name_vn_space').focus(function(){$('#name_vn_space').val('');});
	$('#name_en_space').val(name_en);
	$('#name_en_space').focus(function(){$('#name_en_space').val('');});
}
function edit_parent_name(parent_id, row_id){
	var tbl_name = $('#tbl_name').val();
	var tbl_cat_name = $('#tbl_cat_name').val();
	$('#dialog').dialog({
		title: 'Sửa danh mục',
		autoOpen: true,
		modal: true,
		width: 350,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var new_parent_id = $('#parent_space select option:selected').val();
				var new_parent_name = $('#parent_space select option:selected').text();
				$.post("ajax/content_action.php", {
					fnc:'update_parent_name',
					tbl: tbl_name,
					id: row_id,
					val: new_parent_id
				}, function(data) {
					alert(data);
					$('#parent_name_'+row_id).text(new_parent_name);
				});
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;">Chọn danh mục:  <span id="parent_space"></span></div>');
	$.post("ajax/content_action.php", {
		fnc:'view_edit_parent_name',
		tblcat: tbl_cat_name,
		id: parent_id
		}, function(data) {
			$('#parent_space').html(data);
		});
}
function edit_short_detail(act,id,page){
	var tbl_name = $('#tbl_name').val();
	$('#detail_short_space').html('');
	$('#dialog').dialog({
		title: 'Sửa nội dung ngắn',
		autoOpen: true,
		modal: true,
		width: 800,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				if($('#short_detail_form').submit()){
					$(this).dialog('close');
				}
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div id="detail_short_space"></div>');
		$.post("ajax/content_action.php", {
			fnc:'view_edit_detail_short',
			act: act,
			tbl: tbl_name,
			id: id,
			p: page
		}, function(data) {
			$('#detail_short_space').html(data);
			$('#detail_short_id').val(id);
		});
}
function edit_detail(act,id,page){
	var tbl_name = $('#tbl_name').val();
	$('#detail_space').html('');
	$('#dialog').dialog({
		title: 'Sửa nội dung chính',
		autoOpen: true,
		modal: true,
		width: 800,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				if($('#detail_form').submit()){
					$(this).dialog('close');
				}
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div id="detail_space"></div>');
		$.post("ajax/content_action.php", {
			fnc:'view_edit_detail',
			act: act,
			tbl: tbl_name,
			id: id,
			p: page
		}, function(data) {
			$('#detail_space').html(data);
			$('#detail_id').val(id);
		});
}
function edit_image(act,id,page){
	var tbl_name = $('#tbl_name').val();
	$('#dialog').dialog({
		title: 'Tải hình ảnh',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				if($('#img_form').submit()){
					$(this).dialog('close');
				}
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div id="img_space"></div>');
		$.post("ajax/content_action.php", {
			fnc:'view_edit_image',
			act: act,
			tbl: tbl_name,
			id: id,
			p: page
		}, function(data) {
			$('#img_space').html(data);
			//$('#detail_id').val(id);
		});
}
function show_views_input(id,views){
	$('#views_num_'+id).hide();
	$('#views_input_'+id).show();
	$('#views_input_'+id).focus();
}
function update_views(id,views){
	var tbl_name = $('#tbl_name').val();
	$.post("ajax/content_action.php", {
		fnc:'update_views',
		tbl: tbl_name,
		id: id,
		val: views
	}, function(data) {
		//alert(data);
		$('#views_input_'+id).hide();
		$('#views_num_'+id).show();
		$('#views_num_'+id).text(views);
	});

}
