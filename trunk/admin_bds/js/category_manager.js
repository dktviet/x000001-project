function delrow(id){
	var cat_id = $('h3').attr('cat_id');
        var para = 'id='+cat_id;
	if(confirm('Bạn có chắc chắn muốn xóa ?')){
		$.post("ajax/category_action.php", {
			fnc:'del',
			id: id 
		}, function(data) {
			if(data.error == 'SUCCESS'){
				load_category_manager(para);
			}else{
                            alert(data.msg);
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
	var cat_id = $('h3').attr('cat_id');
        var para = 'id='+cat_id;
        var multi_id = [];
        $.each($('.chk:checked'), function() {
            multi_id.push($(this).val());
        });
	if(confirm('Bạn có chắc chắn muốn xóa ?')){
		$.post("ajax/category_action.php", {
			fnc:'del_multi',
			chk: multi_id 
		}, function(data) {
			alert(data.msg);
			if(data.error == 'SUCCESS'){
				load_category_manager(para);
			}
		}, 'json');
	}
}
function up_down_sort(id, sort_index){
	var sort_num_id = '#sort_num_'+id;
	var sort_num = $(sort_num_id).text();
	if(sort_index == '1'){
		sort_num = parseInt(sort_num) + 1;
	}else{
		if(sort_num>0){sort_num = parseInt(sort_num) - 1;}else{sort_num = 0;}
	}
	$.post("ajax/category_action.php", {
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
	$.post("ajax/category_action.php", {
		fnc:'show_hide',
		id: id,
		val: val
	}, function(data) {
		if(data.error == 'SUCCESS'){
			if(val==1){
				$(status_icon).attr('src','images/check.png');
				$(status_icon).attr("onclick","show_hide('"+id+"','0');");
			}else{
				$(status_icon).attr('src','images/uncheck.png');
				$(status_icon).attr("onclick","show_hide('"+id+"','1');");
			}
		}
	}, 'json');
}
function top_menu(id, val){
	var top_menu_icon = '#top_menu_icon_'+id;
	$.post("ajax/category_action.php", {
		fnc:'top_menu',
		id: id,
		val: val
	}, function(data) {
		if(data.error == 'SUCCESS'){
			if(val==0){
				$(top_menu_icon).attr('src','images/uncheck.png');
				$(top_menu_icon).attr("onclick","top_menu('"+id+"','1');");
			}else{
				$(top_menu_icon).attr('src','images/check.png');
				$(top_menu_icon).attr("onclick","top_menu('"+id+"','0');");
			}
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
				$.post("ajax/category_action.php", {
					fnc:'edit_name',
					id: id,
					val: name
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#name_'+id).text(name);
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;">Tên danh mục:<input type="text" id="name_space" value="" size="32" /></div>');
	$('#name_space').val(name);
	$('#name_space').focus(function(){$('#name_space').val('');});
}
function edit_seo_key(seo_key, id){
	var tbl = $('h3').attr('tbl_data');
	$('#dialog').dialog({
		title: 'Sửa SEO KEY',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var seo_key = $('#seo_key_space').val();
				$.post("ajax/category_action.php", {
					fnc:'edit_seo_key',
					tbl: tbl,
					id: id,
					val: seo_key
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#seo_key_'+id).text(seo_key);
                                                $('#seo_key_'+id).attr('onclick','edit_seo_key(\''+seo_key+'\','+id+');');
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;">SEO KEY:<input type="text" id="seo_key_space" value="" size="32" /></div>');
	$('#seo_key_space').val(seo_key);
}
function edit_title(title, id){
	var tbl = $('h3').attr('tbl_data');
	$('#dialog').dialog({
		title: 'Sửa title cho SEO',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var title = $('#title_space').val();
				$.post("ajax/category_action.php", {
					fnc:'edit_title',
					tbl: tbl,
					id: id,
					val: title
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#title_'+id).text(title);
                                                $('#title_'+id).attr('onclick','edit_title(\''+title+'\','+id+');');
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;">Tiêu đề cho SEO:<input type="text" id="title_space" value="" size="32" /></div>');
	$('#title_space').val(title);
}
function edit_desc(desc, id){
	var tbl = $('h3').attr('tbl_data');
	$('#dialog').dialog({
		title: 'Sửa mô tả',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var desc = $('#desc_space').val();
				$.post("ajax/category_action.php", {
					fnc:'edit_desc',
					tbl: tbl,
					id: id,
					val: desc
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#desc_'+id).text(desc);
                                                $('#desc_'+id).attr('onclick','edit_desc(\''+desc+'\','+id+');');
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;"><textarea id="desc_space" name="desc_space" cols="42" rows="10"></textarea></div>');
	$('#desc_space').val(desc);
}

function add_new(id){
	$('#dialog').dialog({
		title: 'Thêm danh mục',
		autoOpen: true,
		modal: true,
		width: 380,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var name = $('#name_space').val();
                                var desc = $('#desc_space').val();
                                var seo_key = $('#seo_key_space').val();
                                var title = $('#title_space').val();
				$.post("ajax/category_action.php", {
					fnc:'add_new',
					name:name,
                                        desc:desc,
                                        seo_key:seo_key,
                                        title:title,
					id:id
				}, function(data) {
					if(data.error=='SUCCESS'){
                                                var para = 'id='+id;
                                                load_category_manager(para);
					}else{
						alert(data.msg);
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div id="add_new_space"></div>');
        $.post("ajax/category_action.php", {
                fnc:'view_add_new',
                id: id
        }, function(data) {
                $('#add_new_space').html(data);
        });
}
