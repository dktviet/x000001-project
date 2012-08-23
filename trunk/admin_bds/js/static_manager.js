function up_down_sort(id, sort_index){
	var sort_num_id = '#sort_num_'+id;
	var sort_num = $(sort_num_id).text();
	if(sort_index == '1'){
		sort_num = parseInt(sort_num) + 1;
	}else{
		if(sort_num>0){sort_num = parseInt(sort_num) - 1;}else{sort_num = 0;}
	}
	$.post("ajax/static_action.php", {
		fnc:'sort_row',
		id: id,
		val: sort_num
	}, function(data) {
		if(data.error == 'SUCCESS'){
			$(sort_num_id).text(sort_num);
		}
	}, 'json');
}
function show_hide(id, val){
	var status_icon = '#status_icon_'+id;
	$.post("ajax/static_action.php", {
		fnc:'show_hide',
		id: id,
		val: val
	}, function(data) {
		if(data.error == 'SUCCESS'){
			if(val==1){
				$(status_icon).attr("src","images/check.png");
				$(status_icon).attr("onclick","show_hide('"+id+"','0');");
			}else{
				$(status_icon).attr("src","images/uncheck.png");
				$(status_icon).attr("onclick","show_hide('"+id+"','1');");
			}
		}
	}, 'json');
}
function show_views_input(id){
	$('#views_num_'+id).hide();
	$('#views_input_'+id).show();
	$('#views_input_'+id).focus();
}

function update_views(id,views){
	$.post("ajax/static_action.php", {
		fnc:'update_views',
		id: id,
		val: views
	}, function(data) {
		if(data.error == 'SUCCESS'){
			$('#views_input_'+id).hide();
			$('#views_num_'+id).show();
			$('#views_num_'+id).text(views);
		}
	}, 'json');
}
function edit_name(name, id){
	$('#dialog').dialog({
		title: 'Sửa tên',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var name = $('#name_space').val();
				$.post("ajax/static_action.php", {
					fnc:'edit_name',
					id: id,
					val: name
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#name_'+id).text(name);
                                                $('#name_'+id).attr('onclick','edit_name(\''+name+'\','+id+');');
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;">Tên nội dung:<input type="text" id="name_space" value="" /></div>');
	$('#name_space').val(name);
}
function edit_detail(id){
	var cur_url = $(location).attr('href');
	$('#detail_space').html('');
	$('#dialog').dialog({
		title: 'Sửa nội dung chi tiết',
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
		$.post("ajax/static_action.php", {
			fnc:'view_edit_detail',
			url: cur_url,
			id: id
		}, function(data) {
				$('#detail_space').html(data);
				$('#detail_id').val(id);
		});
}
function edit_image(id, code){
	var cur_url = $(location).attr('href');
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
		$.post("ajax/static_action.php", {
			fnc:'view_edit_image',
			url: cur_url,
			code: code,
			id: id
		}, function(data) {
			$('#img_space').html(data);
		});
}

function change_page(page){
	var parent_id = $('h3').attr('parent_id');
	var cat_id = $('#ddCat').val();
	var cat_title = $('h3').text();
	$.post("static_manager.php", {
		id : parent_id,
		cat : cat_id,
		title : cat_title,
		page : page
	}, function(data) {
		$('#toolbar-box div.m').html(data);
	});
}








