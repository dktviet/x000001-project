$(document).ready(function() {
	/* Load top menu - status bar: */
	$('#module-status').load('template/top_panel/module_status.html', function() {
		/* Load admin name: */
		$.post('first_run.php', { val:'admin_log' }, function(data) {
			$('#module-status .loggedin-users a').text(data);
		});
		/* Admin change pass: */
		$('#module-status .loggedin-users a').click(function() {
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
							if(data[2]+data[3] != 'ok'){
								alert(data);
							}else{
								$.post('first_run.php', {
									val:'change_pw',
									new_pw: new_pw_1
								}, function(data) {
									alert(data);
								});
							}
						});
						$(this).dialog('close');
					},
					'Hủy': function() {
						$(this).dialog('close');
					}
				}
			}).load('template/top_panel/changePassword.html');
		});
		/* For empty cache dir control: */
		    $('#module-status .empty-cache ul').hide();
		    $('#module-status .empty-cache').click(function () {
		    	$('#module-status .empty-cache ul').slideToggle();
		    });
		/* Empty cache select: */
		$('#module-status .empty-cache ul li a').click(function() {
			var cache_val = $(this).attr('title');
			var cache_text = $(this).text();
			$.post('first_run.php', {
				val:'empty_cache',
				cache_val: cache_val,
				cache_text: cache_text 
			}, function(data) {
				alert(data.msg);
			}, 'json');
		});
		/* Logout: */
		$('#module-status .logout a').click(function() {
			$.post('first_run.php', {
				val:'logout'
			}, function(data) {
				window.location='./?frame=home';
			});
		});
		/* Get news: */
		$('#module-status .get-news a').click(function() {
			$.post('../plugins/auto_get_news/get_news.php',{ fnc: 'dantri' });
			$.post('../plugins/auto_get_news/get_news.php', { fnc: 'vnexpress' }, function(data) {
				alert('Cập nhật tin tức thành công!');
				window.location='#3';
				location.reload();
			});
		});
	});
	/* Load admin theme bar: */
	$('#admin-theme').load('template/top_panel/admin_theme.html', function(){
		/* Load admin theme: */
		$.post('first_run.php', { val:'admin_theme' }, function(data) {
			var find_img = '.ad-bg div a img[alt='+data+']';
			$('#body_main').removeClass().addClass(data);
			$(find_img).removeClass().addClass('set-bg');
		});
		/* Set admin theme: */
		$('.ad-bg div a').click(function() {
			var theme_name = $(this).attr('title');
			var img_child = $(this).find('img');
			$.post('first_run.php', {
				val:'set_theme',
				ad_theme: theme_name
			}, function(data) {
				$('#body_main').removeClass().addClass(theme_name);
				img_child.addClass('set-bg');
			});
		});
	});
	/* Load horizontal menu: */
	$('#border-top').load('template/top_panel/hor_menu.html');
});


