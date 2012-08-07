<?
switch ($_REQUEST['act']){
	case "category_manager"    			: $title = 'Quản lý Danh mục';break;
	
//---------------------------------------------------------------------

	case "site_index" : $title = 'Chỉ mục site';break;
	case "site_index_m" : $title = 'Hiệu chỉnh / Cập nhật : Chỉ mục site';break;
	
	case "notice" : $title = 'Thông báo';break;
	case "notice_m" : $title = 'Hiệu chỉnh / Cập nhật : Thông báo';break;
	
	case "news_special" : $title = 'Tin bài đặc biệt';break;
	case "news_hot" : $title = 'Tin bài tiêu biểu';break;
	case "news_topview" : $title = 'Tin bài xem nhiều';break;

//Home ---------------------------------------------------------------------
	case "general_category" : $title = 'Danh mục Trang chủ';break;
	case "general_category_m" : $title = 'Hiệu chỉnh / Cập nhật : Danh mục Trang chủ';break;
	
	case "general" : $title = 'Nội dung Trang chủ';break;
	case "general_m" : $title = 'Hiệu chỉnh / Cập nhật : Nội dung Trang chủ';break;

//Web ---------------------------------------------------------------------
	case "web_category" : $title = 'Danh mục Web';break;
	case "web_category_m" : $title = 'Hiệu chỉnh / Cập nhật : Danh mục Web';break;
	
	case "web" : $title = 'Nội dung Web';break;
	case "web_m" : $title = 'Hiệu chỉnh / Cập nhật : Nội dung Web';break;

//Game ---------------------------------------------------------------------
	case "game_category" : $title = 'Danh mục Game';break;
	case "game_category_m" : $title = 'Hiệu chỉnh / Cập nhật : Danh mục Game';break;
	
	case "game" : $title = 'Nội dung Game';break;
	case "game_m" : $title = 'Hiệu chỉnh / Cập nhật : Nội dung Game';break;

	case "game_flash_category" : $title = 'Danh mục Game flash';break;
	case "game_flash_category_m" : $title = 'Hiệu chỉnh / Cập nhật : Danh mục Game flash';break;
	
	case "game_flash" : $title = 'Danh sách Game flash';break;
	case "game_flash_m" : $title = 'Hiệu chỉnh / Cập nhật : Danh sách Game flash';break;

//Web project ---------------------------------------------------------------------
	case "project_category" : $title = 'Danh mục dự án web';break;
	case "project_category_m" : $title = 'Hiệu chỉnh / Cập nhật : Danh mục dự án web';break;

	case "project" : $title = 'Các dự án web';break;
	case "project_m" : $title = 'Hiệu chỉnh / Cập nhật : Các dự án web';break;

	case "project_gallery" : $title = 'Hình ảnh mô tả dự án';break;
	case "project_gallery_m" : $title = 'Hiệu chỉnh / Cập nhật :Hình ảnh mô tả dự án';break;

//News ---------------------------------------------------------------------
	case "news_category" : $title = 'Danh mục Tin tức';break;
	case "news_category_m" : $title = 'Hiệu chỉnh / Cập nhật : Danh mục Tin tức';break;
	case "news" : $title = 'Nội dung Tin tức';break;
	case "news_m" : $title = 'Hiệu chỉnh / Cập nhật : Nội dung Tin tức';break;

//Album ---------------------------------------------------------------------
	case "album" : $title = 'Quản lý Album ảnh';break;
	case "album_m" : $title = 'Hiệu chỉnh / Cập nhật : Quản lý Album ảnh';break;

	case "gallery" : $title = 'Quản lý hình ảnh';break;
	case "gallery_m" : $title = 'Hiệu chỉnh / Cập nhật : Quản lý hình ảnh';break;

//Support online ---------------------------------------------------------------------
	case "yahoo" : $title = 'Hỗ trợ Yahoo';break;
	case "yahoo_m" : $title = 'Hiệu chỉnh / Cập nhật : Hỗ trợ Yahoo';break;

	case "skype" : $title = 'Hỗ trợ Skype';break;
	case "skype_m" : $title = 'Hiệu chỉnh / Cập nhật : Hỗ trợ Skype';break;

	case "hotline" : $title = 'Hỗ trợ Đường dây nóng';break;
	case "hotline_m" : $title = 'Hiệu chỉnh / Cập nhật : Hỗ trợ Đường dây nóng';break;

	case "email" : $title = 'Hỗ trợ Thư điện tử';break;
	case "email_m" : $title = 'Hiệu chỉnh / Cập nhật : Hỗ trợ Thư điện tử';break;

//---------------------------------------------------------------------

	case "video" : $title = 'Quản lý video';break;
	case "video_m" : $title = 'Hiệu chỉnh / Cập nhật : Quản lý video';break;

	case "audio" : $title = 'Quản lý audio';break;
	case "audio_m" : $title = 'Hiệu chỉnh / Cập nhật : Quản lýAudio';break;
	
	case "download" : $title = 'Tải tài liệu';break;
	case "download_m" : $title = 'Hiệu chỉnh / Cập nhật : Tải tài liệu';break;
		
	case "contact" : $title = 'Liên hệ';break;
	case "contact_m" : $title = 'Hiệu chỉnh / Cập nhật : Liên hệ';break;
		
	case "map" : $title = 'Bản đồ trực tuyến';break;
	case "map_m" : $title = 'Hiệu chỉnh / Cập nhật : Bản đồ trực tuyến';break;
	
	case "banner" : $title = 'Banner website';break;
	case "banner_m" : $title = 'Hiệu chỉnh / Cập nhật : Banner website';break;
	
	case "link" : $title = 'Link kết website';break;
	case "link_m" : $title = 'Hiệu chỉnh / Cập nhật : Link kết website';break;
	
	case "advleft" : $title = 'Logo đối tác';break;
	case "advleft_m" : $title = 'Hiệu chỉnh / Cập nhật : Logo đối tác';break;
	
	case "advright" : $title = 'Quảng cáo phải';break;
	case "advright_m" : $title = 'Hiệu chỉnh / Cập nhật : Quảng cáo phải';break;

	case "advdown" : $title = 'Quảng cáo giữa';break;
	case "advdown_m" : $title = 'Hiệu chỉnh / Cập nhật : Quảng cáo giữa';break;
	
	case "advup" : $title = 'Hình trang chủ';break;
	case "advup_m" : $title = 'Hiệu chỉnh / Cập nhật : Hình trang chủ';break;
	
	case "user_ip"		: $title = 'Thông tin ip truy cập';break;
	case "alexa_rank"	: $title = 'Thống kê thứ hạng Alexa hàng ngày';break;

	case "ad_per"		: $title = 'Nhóm quản trị viên';break;
	case "ad_per_m" 	: $title = 'Thêm mới / Cập nhật : Nhóm quản trị viên';break;
	
	case "member": $title = 'Thành viên';break;
	case "member_m" : $title = 'Thêm mới / Cập nhật : Thành viên';break;
	
	case "order" : $title = 'Đơn hàng';break;
	case "order_detail" : $title = 'Chi tiết : Đơn hàng';break;
	
	
	case "config"      : $title = 'Cấu hình';break;
	case "config_m"    : $title = 'Cấu hình : Cập nhật';break;
	case "changepass"  : $title = 'Đổi mật khẩu';break;
	
	default : $title = 'Thống kê tổng hợp';break;
}
echo $title;
?>