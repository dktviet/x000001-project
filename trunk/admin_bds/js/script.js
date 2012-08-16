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

	$('.content_list_menu').click(function() {
		$('.content_list_menu').find('a.current').removeClass('current');
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

// Display and Hide Eng block BEGIN
	$('#short_en_show').hide();
	$('#long_en_show').hide();
	$('#short_en_call input').click(function() {
		$('#short_en_show').slideToggle('slow');
	});
	$('#long_en_call input').click(function() {
		$('#long_en_show').slideToggle('slow');
	});
// Display and Hide Eng block END

});

function load_contact_list(){
	$('#toolbar-box div.m').load('contact_list.php');
}
function change_page(page){
	var parent_id = $('h3').attr('parent_id');
	var cat_id = $('#ddCat').val();
	var cat_title = $('h3').text();
	$.post("content_manager.php", {
		id : parent_id,
		cat : cat_id,
		title : cat_title,
		page : page
	}, function(data) {
		$('#toolbar-box div.m').html(data);
	});	
}

function load_category_manager(para){
    $('#toolbar-box div.m').load(admin.main_url+'category_manager.php?'+para);
}
function load_content_manager(para){
    $('#toolbar-box div.m').load(admin.main_url+'content_manager.php?'+para);
}