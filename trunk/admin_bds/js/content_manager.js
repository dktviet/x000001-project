function delrow(id){
	var parent_cat_id = $('h3').attr('parent_id');
        var cat_id = $('h3').attr('cat_id');
        var para = 'parent_id='+parent_cat_id+'&id='+cat_id;
	var tbl = $('h3').attr('tbl_data');
	if(confirm('Bạn có chắc chắn muốn xóa ?')){
		$.post("ajax/content_action.php", {
			fnc:'del',
			tbl: tbl,
			id: id 
		}, function(data) {
			if(data.error == 'SUCCESS'){
				load_content_manager(para);
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
	var tbl = $('h3').attr('tbl_data');
	var parent_cat_id = $('h3').attr('parent_id');
        var cat_id = $('h3').attr('cat_id');
        var para = 'parent_id='+parent_cat_id+'&id='+cat_id;
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
			    load_content_manager(para);
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
function show_home(id, val){
	var tbl = $('h3').attr('tbl_data');
	var show_home_icon = '#show_home_icon_'+id;
	$.post("ajax/content_action.php", {
		fnc:'show_home',
		tbl: tbl,
		id: id,
		val: val
	}, function(data) {
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
function show_views_input(id){
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
		if(data.error == 'SUCCESS'){
			$('#views_input_'+id).hide();
			$('#views_num_'+id).show();
			$('#views_num_'+id).text(views);
		}
	}, 'json');
}
function show_price_input(id){
	$('#price_num_'+id).hide();
	$('#price_input_'+id).show();
	$('#price_input_'+id).focus();
}
function update_price(id,price){
	var tbl = $('h3').attr('tbl_data');
	$.post("ajax/content_action.php", {
		fnc:'update_price',
		tbl: tbl,
		id: id,
		val: price
	}, function(data) {
		if(data.error == 'SUCCESS'){
			$('#price_input_'+id).hide();
			$('#price_num_'+id).show();
			$('#price_num_'+id).text(price);
		}
	}, 'json');
}
function edit_name(name, id){
	var tbl = $('h3').attr('tbl_data');
	$('#dialog').dialog({
		title: 'Sửa tên',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var name = $('#name_space').val();
				$.post("ajax/content_action.php", {
					fnc:'edit_name',
					tbl: tbl,
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
	}).html('<div style="float:left;padding: 20px;">Tên nội dung:<input type="text" id="name_space" value="" size="32" /></div>');
	$('#name_space').val(name);
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
				$.post("ajax/content_action.php", {
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
function edit_parent(row_id){
	var tbl = $('h3').attr('tbl_data');
        var parent_cat_id = $('h3').attr('parent_id');
        var cat_id = $('h3').attr('cat_id');
        var para = 'parent_id='+parent_cat_id+'&id='+cat_id;
	$('#dialog').dialog({
		title: 'Sửa danh mục',
		autoOpen: true,
		modal: true,
		width: 350,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var new_parent_id = $('#parent_space select option:selected').val();
				$.post("ajax/content_action.php", {
					fnc:'update_parent',
					tbl: tbl,
					id: row_id,
					val: new_parent_id
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						load_content_manager(para);
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
		parent_cat_id: parent_cat_id,
		cat_id: cat_id
		}, function(data) {
			if(data.error == 'SUCCESS'){
				$('#parent_space').html(data.drop_list);
                                $('#parent_space select').removeAttr('onchange');
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
function edit_adv_desc(desc, id){
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
				$.post("ajax/content_action.php", {
					fnc:'edit_adv_desc',
					tbl: tbl,
					id: id,
					val: desc
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#adv_desc_'+id).text(desc);
                                                $('#adv_desc_'+id).attr('onclick','edit_adv_desc(\''+desc+'\','+id+');');
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
function edit_support_code(support, id){
	var tbl = $('h3').attr('tbl_data');
	$('#dialog').dialog({
		title: 'Sửa hỗ trợ trực tuyến',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var support = $('#support_space').val();
				$.post("ajax/content_action.php", {
					fnc:'edit_support_code',
					tbl: tbl,
					id: id,
					val: support
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#support_code_'+id).text(support);
                                                $('#support_code_'+id).attr('onclick','edit_support_code(\''+support+'\','+id+');');
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;"><input id="support_space" name="support_space" size="40" /></div>');
	$('#support_space').val(support);
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
function edit_adv_link(link, id){
	var tbl = $('h3').attr('tbl_data');
	$('#dialog').dialog({
		title: 'Sửa đường dẫn site',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
				var link = $('#adv_link_space').val();
				$.post("ajax/content_action.php", {
					fnc:'edit_adv_link',
					tbl: tbl,
					id: id,
					val: link
				}, function(data) {
					alert(data.msg);
					if(data.error == 'SUCCESS'){
						$('#adv_link_'+id).text(link);
                                                $('#adv_link_'+id).attr('onclick','edit_adv_link(\''+link+'\','+id+');');
					}
				}, 'json');
				$(this).dialog('close');
			},
			'Hủy': function() {
				$(this).dialog('close');
			}
		}
	}).html('<div style="float:left;padding: 20px;"><input id="adv_link_space" name="adv_link_space" size="40" /></div>');
	$('#adv_link_space').val(link);
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
function add_new(tbl, parent_cat_id, cat_id){
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
                        parent_cat_id: parent_cat_id,
			cat_id: cat_id
		}, function(data) {
			$('#add_new_space').html(data);
		});
}
function add_new_properties(tbl, parent_cat_id, cat_id){
	$('#dialog').dialog({
		title: 'Thêm thuộc tính',
		autoOpen: true,
		modal: true,
		width: 400,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
                            var name = $('#txtName').val();
                            var sort = $('#txtSort').val();
                            $.post("ajax/content_action.php", {
                                    fnc:'add_new_properties',
                                    cat_id: cat_id,
                                    name: name,
                                    sort: sort
                            }, function(data) {
                                    if(data.error == 'SUCCESS'){
                                        var param = 'parent_id='+parent_cat_id+'&id='+cat_id;
                                        load_content_manager(param);
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
		$.post("ajax/content_action.php", {
			fnc:'view_add_new_content',
			tbl: tbl,
                        parent_cat_id: parent_cat_id,
			cat_id: cat_id
		}, function(data) {
			$('#add_new_space').html(data);
		});
}
function add_new_support(tbl, parent_cat_id, cat_id){
	$('#dialog').dialog({
		title: 'Thêm hỗ trợ trực tuyến',
		autoOpen: true,
		modal: true,
		width: 570,
		position: 'center',
		buttons: {
			'Cập nhật': function() {
                            var name = $('#txtName').val();
                            var detail_short = $('#txtshort').val();
                            var sort = $('#txtSort').val();
                            $.post("ajax/content_action.php", {
                                    fnc:'add_new_support',
                                    tbl: tbl,
                                    parent_cat_id: parent_cat_id,
                                    cat_id: cat_id,
                                    name: name,
                                    detail_short: detail_short,
                                    sort: sort
                            }, function(data) {
                                    if(data.error == 'SUCCESS'){
                                        var param = 'parent_id='+parent_cat_id+'&id='+cat_id;
                                        load_content_manager(param);
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
		$.post("ajax/content_action.php", {
			fnc:'view_add_new_content',
			tbl: tbl,
                        parent_cat_id: parent_cat_id,
			cat_id: cat_id
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
function choose_properties(properties_id, ext_id, prod_id){
        var parent_cat_id = $('h3').attr('parent_id');
        var cat_id = $('h3').attr('cat_id');
        var para = 'parent_id='+parent_cat_id+'&id='+cat_id;

        $.post("ajax/content_action.php", {
                fnc: 'update_properties',
                ext_id: ext_id,
                pr_id : properties_id,
                prod_id: prod_id
        }, function(data) {
                if(data.error == 'SUCCESS'){
                    load_content_manager(para);
                }else{
                    alert(data.msg);
                }
        }, 'json');
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

function change_page(page){
	var parent_id = $('h3').attr('parent_id');
	var cat_id = $('h3').attr('cat_id');
	$.post("content_manager.php", {
		parent_id : parent_id,
		id : cat_id,
		page : page
	}, function(data) {
		$('#toolbar-box div.m').html(data);
	});
}









