function delrow(id){
	var row_id = '#cat_id_'+id;
	if(confirm('Bạn có chắc chắn muốn xóa ?')){
		$.post("ajax/category_action.php", {
			fnc:'del',
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
			    $.each(multi_id, function(id, val) {
			    	$("#cat_id_" + val).hide();
			    });
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
		if(sort_num>0){	sort_num = parseInt(sort_num) - 1; }else{ sort_num = 0; }
	}
	$.post("ajax/category_action.php", {
		fnc:'sort_row',
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
	var status_icon = '#status_icon_'+id;
	$.post("ajax/category_action.php", {
		fnc:'show_hide',
		id: id,
		val: val
	}, function(data) {
		/*alert(data.msg);*/
		if(data.error == 'SUCCESS'){
			if(val==0){
				$(status_icon).attr('src','images/check.png');
				$(status_icon).attr("onclick","show_hide('"+id+"','1');");
			}else{
				$(status_icon).attr('src','images/uncheck.png');
				$(status_icon).attr("onclick","show_hide('"+id+"','0');");
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
		/*alert(data.msg);*/
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
function bottom_menu(id, val){
	var bottom_menu_icon = '#bottom_menu_icon_'+id;
	$.post("ajax/category_action.php", {
		fnc:'bottom_menu',
		id: id,
		val: val
	}, function(data) {
		/*alert(data.msg);*/
		if(data.error == 'SUCCESS'){
			if(val==0){
				$(bottom_menu_icon).attr('src','images/uncheck.png');
				$(bottom_menu_icon).attr("onclick","bottom_menu('"+id+"','1');");
			}else{
				$(bottom_menu_icon).attr('src','images/check.png');
				$(bottom_menu_icon).attr("onclick","bottom_menu('"+id+"','0');");
			}
		}
	}, 'json');
}
function admin_menu(id, val){
	var admin_menu_icon = '#admin_menu_icon_'+id;
	$.post("ajax/category_action.php", {
		fnc:'admin_menu',
		id: id,
		val: val
	}, function(data) {
		/*alert(data.msg);*/
		if(data.error == 'SUCCESS'){
			if(val==0){
				$(admin_menu_icon).attr('src','images/uncheck.png');
				$(admin_menu_icon).attr("onclick","admin_menu('"+id+"','1');");
			}else{
				$(admin_menu_icon).attr('src','images/check.png');
				$(admin_menu_icon).attr("onclick","admin_menu('"+id+"','0');");
			}
		}
	}, 'json');
}
function edit_name(name_vn, name_en, id){
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
				$.post("ajax/category_action.php", {
					fnc:'edit_name',
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
	$('#name_vn_space').focus(function(){$('#name_vn_space').val('');});
	$('#name_en_space').val(name_en);
	$('#name_en_space').focus(function(){$('#name_en_space').val('');});
}
function add_new(parent_id){
	$('#dialog').dialog({
		title: 'Thêm danh mục',
		autoOpen: true,
		modal: true,
		width: 380,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var code = $('#code_space').val();
				var name_vn = $('#name_vn_space').val();
				var name_en = $('#name_en_space').val();
				$.post("ajax/category_action.php", {
					fnc:'add_new',
					code:code,
					name_vn:name_vn,
					name_en:name_en,
					parent_id:parent_id
				}, function(data) {
					if(data.error=='SUCCESS'){
						var set_class = $('.adminlist tbody tr:last').attr('class') == 'row0' ? 'row1' : 'row0';
						if($('.adminlist').find('tbody')){
							$('.adminlist tbody').append('<tr id="cat_id_'+data.id+'" class="'+set_class+'"></tr>');
						}else{
							$('.adminlist').append('<tbody><tr id="cat_id_'+data.id+'" class="'+set_class+'"></tr></tbody>');
						}
						var td_1 = '<td align="center" class="smallfont"><input type="checkbox" name="chk[]" value="'+data.id+'"></td>';
						var td_2 = '<td class="smallfont" align="center">'+data.id+'</td>';
						var td_3 = '<td align="center" class="smallfont"><span onClick="delrow(\''+data.id+'\');">Xóa</span></td>';
						var td_4 = '<td class="smallfont" align="center"><span id="code_'+data.id+'" onclick="edit_code(\''+code+'\',\''+data.id+'\');">'+code+'</span></td>';
						var td_5 = '<td class="smallfont" align="center"><span id="name_vn_'+data.id+'" onclick="edit_name(\''+name_vn+'\',\''+name_en+'\',\''+data.id+'\');" title="Name: '+name_en+'">'+name_vn+'</span></td>';
						var td_6 = '<td class="smallfont sort-num" align="center"><img src="images/up.png" alt="" onclick="up_down_sort(\''+data.id+'\',\'1\');" /><div id="sort_num_'+data.id+'" align="center">0</div><img src="images/down.png" alt="" onclick="up_down_sort(\''+data.id+'\',\'0\');" /></td>';
						var td_7 = '<td class="smallfont" align="center"><img id="status_icon_'+data.id+'" src="images/check.png" onclick="show_hide(\''+data.id+'\',\'1\');" style="cursor:pointer;" /></td>';
						var td_8 = '<td class="smallfont" align="center"><img id="top_menu_icon_'+data.id+'" src="images/uncheck.png" onclick="top_menu(\''+data.id+'\',\'1\');" style="cursor:pointer;" /></td>';
						var td_9 = '<td class="smallfont" align="center"><img id="bottom_menu_icon_'+data.id+'" src="images/uncheck.png" onclick="bottom_menu(\''+data.id+'\',\'1\');" style="cursor:pointer;" /></td>';
						var td_10 = '<td class="smallfont" align="center"><img id="admin_menu_icon_'+data.id+'" src="images/uncheck.png" onclick="admin_menu(\''+data.id+'\',\'1\');" style="cursor:pointer;" /></td>';
						var td_11 = '<td class="smallfont" align="center">'+data.time+'</td><td class="smallfont" align="center">'+data.time+'</td>';
						if($('.adminlist tbody tr:last')){
							$('.adminlist tbody tr:last').html(td_1+td_2+td_3+td_4+td_5+td_6+td_7+td_8+td_9+td_10+td_11);
						}else{
							$('.adminlist tbody tr').html(td_1+td_2+td_3+td_4+td_5+td_6+td_7+td_8+td_9+td_10+td_11);
						}
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
	}).html('<div style="float:left;padding: 20px;">Mã code:<input type="text" id="code_space" value="" size="30" /></div><div style="float:left;padding: 20px;">Tên tiếng Việt:<input type="text" id="name_vn_space" value="" size="40" /></div><div style="float:left;padding:20px 0px 20px 20px;">Tên tiếng Anh:<input type="text" id="name_en_space" value="" size="40" /></div>');
	$('#code_space').focus();
}
