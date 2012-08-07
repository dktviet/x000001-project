$(document).ready(function() {
	var url_page = '';
	var url_cat_id = $(location).attr('href').split('#')[1];
	if($(location).attr('href').split('#')[2]){
		url_page = $(location).attr('href').split('#')[2].split('_')[1];
	}
	if(url_cat_id){
		if(url_cat_id == 'contact'){
			load_contact_list();
		}else{
			if(url_page){
				url_page = url_page - 1;
				var cur_menu_element = $('#menu li.node ul li.content_list_menu a[cat_id="'+url_cat_id+'"]');
				var cat_title = cur_menu_element.text();
				var cur_menu_parent = cur_menu_element.parent().parent().parent('li.node');
				cur_menu_parent.find('ul').slideDown();
				cur_menu_parent.find('a[class="top"]').addClass('opened');
				cur_menu_element.addClass('current');
				$.post("content_manager.php", {
					id : url_cat_id,
					cat : cat_id,
					title : cat_title,
					page : url_page
				}, function(data) {
					$('#toolbar-box div.m').html(data);
				});	
			}else{
				var cur_menu_element = $('#menu li.node ul li.content_list_menu a[cat_id="'+url_cat_id+'"]');
				var cat_id = url_cat_id;
				var cat_title = cur_menu_element.text();
				var cur_menu_parent = cur_menu_element.parent().parent().parent('li.node');
				cur_menu_parent.find('ul').slideDown();
				cur_menu_parent.find('a[class="top"]').addClass('opened');
				cur_menu_element.addClass('current');
				$.post("content_manager.php", {
					id : cat_id,
					title : cat_title
				}, function(data) {
					$('#toolbar-box div.m').html(data);
				});
			}		
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
		var cat_title = $(this).find('a').text();
		$.post("category_manager.php", {
			id : cat_id,
			title : cat_title
		}, function(data) {
			$('#toolbar-box div.m').html(data);
		});
	});

	$('.content_list_menu').click(function() {
		$('.content_list_menu').find('a.current').removeClass('current');
		$(this).find('a').addClass('current');
		var cat_id = $(this).find('a').attr('cat_id');
		var cat_title = $(this).find('a').text();
		$.post("content_manager.php", {
			id : cat_id,
			title : cat_title
		}, function(data) {
			$('#toolbar-box div.m').html(data);
		});
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
