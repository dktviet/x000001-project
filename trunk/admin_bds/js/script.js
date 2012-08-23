var admin = {
    url: '',
    main_url: '',
    param_url: '',
    page_num: 0,
    parent_cat_id: 0,
    cat_id: 0,
    param: ''
};
$(document).ready(function() {
        admin.url = $(location).attr('href');
        admin.main_url = admin.url.split('#')[0];
        admin.param_url = admin.url.split('#')[1];
        if(admin.param_url){
            if(admin.param_url == 'static'){
		$('.static_list_menu').parent('ul').parent('li').find('a.top').addClass('opened');
                $('.static_list_menu').parent('ul').slideDown();
                $('.static_list_menu').find('a').addClass('current');
                load_static_manager();
            }
            if(admin.param_url.split('_')[1]){
                admin.parent_cat_id = admin.param_url.split('_')[0];
                admin.cat_id = admin.param_url.split('_')[1];
            }else{
                admin.parent_cat_id = admin.param_url;
            }
            if(admin.url.split('#')[2]){
                    admin.page_num = admin.url.split('#')[2].split('_')[1];
            }
            if(admin.parent_cat_id > 0 && admin.cat_id > 0){
                var cur_li_act = $('.content_list_menu a[cat_id="'+admin.cat_id+'"]');
                cur_li_act.parent('li').parent('ul').slideDown();
                cur_li_act.parent('li').parent('ul').parent('li').find('a.top').addClass('opened');
                cur_li_act.addClass('current');

                admin.param = 'parent_id='+admin.parent_cat_id+'&id='+admin.cat_id;
                if(admin.page_num > 0){
                    admin.param += '&page='+admin.page_num;
                }
                load_content_manager(admin.param);
            }
        }
	$('#menu li').click(function() {
		$('#menu li ul').slideUp();
		$(this).find('ul').slideDown();
		$('#menu li a.top').removeClass('opened');
		$(this).find('a.top').addClass('opened');
	});
	
	$('.cat_list_menu').click(function() {
		$('.cat_list_menu').find('a.current').removeClass('current');
		$(this).find('a').addClass('current');
		var cat_id = $(this).find('a').attr('cat_id');
                admin.param = 'id='+cat_id;
		load_category_manager(admin.param);
	});
	$('.static_list_menu').click(function() {
                $('.content_list_menu').find('a.current').removeClass('current');
		$('.static_list_menu').find('a.current').removeClass('current');
		$(this).find('a').addClass('current');
                load_static_manager();
	});

	$('.content_list_menu').click(function() {
		$('.content_list_menu').find('a.current').removeClass('current');
                $('.static_list_menu').find('a.current').removeClass('current');
		$(this).find('a').addClass('current');
                var parent_cat_id = $(this).find('a').attr('parent_cat_id');
		var cat_id = $(this).find('a').attr('cat_id');
                admin.param = 'parent_id='+parent_cat_id+'&id='+cat_id;
                load_content_manager(admin.param);
	});
        
	$('.properties_list_menu').click(function() {
		$('.properties_list_menu').find('a.current').removeClass('current');
		$(this).find('a').addClass('current');
		var parent_cat_id = $(this).find('a').attr('parent_cat_id');
		var cat_id = $(this).find('a').attr('cat_id');
                admin.param = 'parent_id='+parent_cat_id+'&id='+cat_id;
                load_content_manager(admin.param);
	});
        
	$('.contact_list_menu').click(function() {
		$('.contact_list_menu').find('a.current').removeClass('current');
		$(this).find('a').addClass('current');
		load_contact_list();
	});

        $("#loading").bind("ajaxStart", function(){
            $(this).fadeIn();
        }).bind("ajaxComplete", function(){
            $(this).fadeOut();
        });

});
function load_contact_list(){
	$('#toolbar-box div.m').load('contact_list.php');
}
function load_category_manager(para){
    $('#toolbar-box div.m').load(admin.main_url+'category_manager.php?'+para);
}
function load_content_manager(para){
    $('#toolbar-box div.m').load(admin.main_url+'content_manager.php?'+para);
}
function load_static_manager(){
    $('#toolbar-box div.m').load(admin.main_url+'static_manager.php');
}
function change_pass(){
    $('#dialog').dialog({
            title: 'Đổi mật khẩu',
            autoOpen: true,
            modal: true,
            width: 500,
            position: 'center',
            buttons: {
                    'Cập nhật': function() {
                            var old_pw = $('#txtPwdOld').val();
                            var new_pw_1 = $('#txtPwdNew1').val();
                            var new_pw_2 = $('#txtPwdNew2').val();
                            if(test_empty(old_pw)){
                                    alert('Hãy nhập "mật khẩu cũ" !');$('#txtPwdOld').focus();return false;
                            }
                            if(test_empty(new_pw_1)){
                                    alert('Hãy nhập "mật khẩu" !');$('#txtPwdNew1').focus();return false;
                            }
                            if(test_empty(new_pw_2)){
                                    alert('Hãy nhập "mật khẩu" lần 2 !');$('#txtPwdNew2').focus();return false;
                            }
                            if(!test_confirm_pass(new_pw_1,new_pw_2)){
                                    alert('Hai mật khẩu phải đồng nhất !');
                                    $('#txtPwdNew1').val('');
                                    $('#txtPwdNew2').val('');
                                    $('#txtPwdNew1').focus();return false;
                            }
                            old_pw = hex_md5(old_pw);
                            new_pw_1 = hex_md5(new_pw_1);
                            $.post('first_run.php', {
                                    val:'check_pw',
                                    oldPw: old_pw
                            }, function(data) {
                                    if(data.error == 'err'){
                                            alert(data.msg);
                                    }else{
                                            $.post('first_run.php', {
                                                    val:'change_pw',
                                                    new_pw: new_pw_1
                                            }, function(data) {
                                                    alert(data.msg);
                                                    if(data.error == 'ok'){
                                                        $('#dialog').dialog('close');
                                                    }
                                            }, 'json');
                                    }
                            }, 'json');
                    },
                    'Hủy': function() {
                            $(this).dialog('close');
                    }
            }
    }).load('template/top_panel/changePassword.html');
}
