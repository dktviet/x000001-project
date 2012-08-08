function delrow(id){
	var row_id = '#content_id_'+id;
	var tbl = $('h3').attr('tbl_data');
	if(confirm('Bạn có chắc chắn muốn xóa ?')){
		$.post("ajax/content_action.php", {
			fnc:'del',
			tbl: tbl,
			id: id 
		}, function(data) {
			alert(data.msg);
			if(data.error == 'SUCCESS'){
				$(row_id).hide();
			}
		}, 'json');
	}
}
function chkallClick(o) {
  	var form = document.frmForm;
	for (var i = 0; i < form.elements.length; i++) {
		if (form.elements[i].type == "checkbox" && form.elements[i].name!="chkall") {
			form.elements[i].checked = document.frmForm.chkall.checked;
		}
	}
}
function del_multi_row(){
	var tbl = $('h3').attr('tbl_data');
	var multi_id = [];
    $.each($('.chk:checked'), function() {
    	multi_id.push($(this).val()); 
    });
	if(confirm('Bạn có chắc chắn muốn xóa ?')){
		$.post("ajax/content_action.php", {
			fnc:'del_multi',
			tbl: tbl,
			chk: multi_id 
		}, function(data) {
			alert(data.msg);
			if(data.error == 'SUCCESS'){
			    $.each(multi_id, function(id, val) {
			    	$("#content_id_" + val).hide();
			    });
			}
		}, 'json');
	}
}
function up_down_sort(id, sort_index){
	var tbl = $('h3').attr('tbl_data');
	var sort_num_id = '#sort_num_'+id;
	var sort_num = $(sort_num_id).text();
	if(sort_index == '1'){
		sort_num = parseInt(sort_num) + 1;
	}else{
		if(sort_num>0){sort_num = parseInt(sort_num) - 1;}else{sort_num = 0;}
	}
	$.post("ajax/content_action.php", {
		fnc:'sort_row',
		tbl: tbl,
		id: id,
		val: sort_num
	}, function(data) {
		/*alert(data.msg);*/
		if(data.error == 'SUCCESS'){
			$(sort_num_id).text(sort_num);
		}
	}, 'json');
}
function show_hide(id, val){
	var tbl = $('h3').attr('tbl_data');
	var status_icon = '#status_icon_'+id;
	$.post("ajax/content_action.php", {
		fnc:'show_hide',
		tbl: tbl,
		id: id,
		val: val
	}, function(data) {
		/*alert(data.msg);*/
		if(data.error == 'SUCCESS'){
			if(val==0){
				$(status_icon).attr("src","images/check.png");
				$(status_icon).attr("onclick","show_hide('"+id+"','1');");
			}else{
				$(status_icon).attr("src","images/uncheck.png");
				$(status_icon).attr("onclick","show_hide('"+id+"','0');");
			}
		}
	}, 'json');
}
function show_home(id, val){
	var tbl = $('h3').attr('tbl_data');
	var show_home_icon = '#show_home_icon_'+id;
	$.post("ajax/content_action.php", {
		fnc:'show_home',
		tbl: tbl,
		id: id,
		val: val
	}, function(data) {
		/*alert(data.msg);*/
		if(data.error == 'SUCCESS'){
			if(val==0){
				$(show_home_icon).attr('src','images/uncheck.png');
				$(show_home_icon).attr("onclick","show_home('"+id+"','1');");
			}else{
				$(show_home_icon).attr('src','images/check.png');
				$(show_home_icon).attr("onclick","show_home('"+id+"','0');");
			}
		}
	}, 'json');
}
function show_hot(id, val){
	var tbl = $('h3').attr('tbl_data');
	var show_hot_icon = '#show_hot_icon_'+id;
	$.post("ajax/content_action.php", {
		fnc:'show_hot',
		tbl: tbl,
		id: id,
		val: val
	}, function(data) {
		/*alert(data.msg);*/
		if(data.error == 'SUCCESS'){
			if(val==0){
				$(show_hot_icon).attr('src','images/uncheck.png');
				$(show_hot_icon).attr("onclick","show_hot('"+id+"','1');");
			}else{
				$(show_hot_icon).attr('src','images/check.png');
				$(show_hot_icon).attr("onclick","show_hot('"+id+"','0');");
			}
		}
	}, 'json');
}
function show_views_input(id,views){
	$('#views_num_'+id).hide();
	$('#views_input_'+id).show();
	$('#views_input_'+id).focus();
}
function update_views(id,views){
	var tbl = $('h3').attr('tbl_data');
	$.post("ajax/content_action.php", {
		fnc:'update_views',
		tbl: tbl,
		id: id,
		val: views
	}, function(data) {
		/*alert(data.msg);*/
		if(data.error == 'SUCCESS'){
			$('#views_input_'+id).hide();
			$('#views_num_'+id).show();
			$('#views_num_'+id).text(views);
		}
	}, 'json');
}
function edit_name(name_vn, name_en, id){
	var tbl = $('h3').attr('tbl_data');
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
					tbl: tbl,
					id: id,
					val1: name_vn,
					val2: name_en
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#name_vn_'+id).text(name_vn);
						$('#name_vn_'+id).attr('title',name_en);
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;">Tên tiếng Việt:<input type="text" id="name_vn_space" value="" /></div><div style="float:left;padding:20px 0px 20px 20px;">Tên tiếng Anh:<input type="text" id="name_en_space" value="" /></div>');
	$('#name_vn_space').val(name_vn);
	$('#name_en_space').val(name_en);
}
function edit_parent(cat_id, row_id){
	var tbl = $('h3').attr('tbl_data');
	var parent_id = $('h3').attr('parent_id');
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
					fnc:'update_parent',
					tbl: tbl,
					id: row_id,
					val: new_parent_id
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#parent_name_'+row_id).text(new_parent_name);
						$('#parent_name_'+row_id).attr('onclick','edit_parent(\''+new_parent_id+'\',\''+row_id+'\');');
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;">Chọn danh mục:  <span id="parent_space"></span></div>');
	$.post("ajax/content_action.php", {
		fnc:'view_edit_parent',
		parent_id: parent_id,
		id: cat_id
		}, function(data) {
			if(data.error == 'SUCCESS'){
				$('#parent_space').html(data.drop_list);
			}
		}, 'json');
}
function edit_short_detail(id){
	var cur_url = $(location).attr('href');
	var tbl = $('h3').attr('tbl_data');
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
			url: cur_url,
			tbl: tbl,
			id: id
		}, function(data) {
				$('#detail_short_space').html(data);
				$('#detail_short_id').val(id);
		});
}
function edit_detail(id){
	var cur_url = $(location).attr('href');
	var tbl = $('h3').attr('tbl_data');
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
		$.post("ajax/content_action.php", {
			fnc:'view_edit_detail',
			url: cur_url,
			tbl: tbl,
			id: id
		}, function(data) {
				$('#detail_space').html(data);
				$('#detail_id').val(id);
		});
}
function edit_image(id, code){
	var cur_url = $(location).attr('href');
	var tbl = $('h3').attr('tbl_data');
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
			url: cur_url,
			tbl: tbl,
			code: code,
			id: id
		}, function(data) {
			$('#img_space').html(data);
		});
}
function add_new(tbl, parent_id){
        var cur_url = $(location).attr('href');
	$('#dialog').dialog({
		title: 'Thêm nội dung',
		autoOpen: true,
		modal: true,
		width: 800,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				if($('#add_new_form').submit()){
					$(this).dialog('close');
				}
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div id="add_new_space"></div>');
		$.post("ajax/content_action.php", {
			fnc:'view_add_new_content',
			url: cur_url,
			tbl: tbl,
			parent_id: parent_id
		}, function(data) {
			$('#add_new_space').html(data);
		});
}

function choose_cat(){
	var url_cat_id = $(location).attr('href').split('#')[1];
	var cat_id = $('#ddCat').val();
	if(url_cat_id == 'contact'){
		$.post("contact_list.php", {
			cat : cat_id
		}, function(data) {
			$('#toolbar-box div.m').html(data);
		});	
	}else{
		var parent_id = $('h3').attr('parent_id');
		var cat_title = $('h3').text();
		$.post("content_manager.php", {
			id : parent_id,
			cat : cat_id,
			title : cat_title
		}, function(data) {
			$('#toolbar-box div.m').html(data);
		});		
	}
}

function check_contact(id, val){
	var status_icon = '#status_icon_'+id;
	$.post("ajax/content_action.php", {
		fnc:'check_contact',
		id: id,
		val: val
	}, function(data) {
		if(data.error == 'SUCCESS'){
			if(val==0){
				$(status_icon).attr("src","images/check.png");
				$(status_icon).attr("onclick","check_contact('"+id+"','1');");
			}else{
				$(status_icon).attr("src","images/uncheck.png");
				$(status_icon).attr("onclick","check_contact('"+id+"','0');");
			}
		}
	}, 'json');
}

function view_detail(content){
	$('#dialog').dialog({
		title: 'Nội dung chi tiết',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center'
	}).html('<div>'+content+'</div>');
}










