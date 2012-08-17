<?

switch ($pages){

	case "product" :

		$catInfo = getRecord("xteam_category","id=".$cat);

		$title = $catInfo['name'];

		break;
		
	case "product_sub" :

		$catInfo = getRecord("xteam_category","id=".$cat);

		$title = $catInfo['name'];

		break;
		
	case "news_sub" :

		$catInfo = getRecord("xteam_category","id=".$cat);

		$title = $catInfo['name'];

		break;

	case "product_detail" :

		$catInfo = getRecord("xteam_product","id=".$cat);

		$title = $catInfo['name'];

		break;

	case "product_category"  : $title = $_lang=="vn" ? "DANH MỤC SẢN PHẨM" : "PRODUCT CATEGORY";break;
	
	case "product_toc"  : $title = $_lang=="vn" ? "SẢN PHẨM CỦA TÓC" : "PRODUCT CATEGORY";break;
	
	case "contact_pro"  : $title = $_lang=="vn" ? "GỬI YÊU CẦU SẢN PHẨM" : "REQUEST PRODUCT";break;

	case "map"         : $title = $_lang=="vn" ? "BẢN ĐỒ" : "MAP";	break;

	case "contact"         : $title = $_lang=="vn" ? "LIÊN HỆ" : "CONTACT";	break;

	case "intro"           : $title = $_lang=="vn" ? "GIỚI THIỆU" : "ABOUT US";break;

	case "album"           : $title = $_lang=="vn" ? "ALBUM ẢNH" : "PICTURE ALBUM";break;

	case "recuit"          : $title = $_lang=="vn" ? "TIN TUYỂN DỤNG" : "RECUIT NEWS";break;

	case "general_news"     : $title = $_lang=="vn" ? "TIN TỨC CHUNG" : "GENERAL NEWS";break;

	case "news_detail"     : $title = $_lang=="vn" ? "TIN CHI TIẾT" : "NEWS DETAIL";break;

	case "encourage"	   : $title = $_lang=="vn" ? "TIN KHUYẾN MÃI" : "ENCOURAGE NEWS";break;

	case "encourage_detail": $title = $_lang=="vn" ? "CHI TIẾT TIN KHUYẾN MÃI" : "ENCOURAGE DETAIL";break;

	case "download"        : $title = $_lang=="vn" ? "Tải tài liệu" : "Download";break;

	case "support"        : $title = $_lang=="vn" ? "Hỗ trợ kỹ thuật" : "support";break;

	case "cart"            : $title = $_lang=="vn" ? "Giỏ hàng" : "Cart";break;

	case "checkout"        : $title = $_lang=="vn" ? "Đơn hàng" : "Order form";break;

	case "solution"          : $title = $_lang=="vn" ? "Giải Pháp" : "Solution";break;

	case "quality"          : $title = $_lang=="vn" ? "Hệ thống chất lượng" : "Quality system";break;

	case "search"          : $title = $_lang=="vn" ? "Tìm kiếm" : "Search";break;

	case "registry"        : $title = $_lang=="vn" ? "Đăng ký thành viên" : "Registry";break;

	case "member"          : $title = $_lang=="vn" ? "Thành viên" : "Login";break;

	case "login"           : $title = $_lang=="vn" ? "Đăng nhập" : "Login";break;

	case "forgotpass"      : $title = $_lang=="vn" ? "Quên mật khẩu" : "Forgot password";break;

	case "news" :

		$catInfo = getRecord("xteam_category","id=".$cat);

		$title = $catInfo['name'];

		break;

	case "news_detail"     :
			if($_lang=="vn") $title = "TIN CHI TIẾT"; 
			else if($_lang=="en") $title = "NEWS DETAIL";
			else $title = "新聞詳情";
		break;

	case "home"            : $title = $_lang=="vn" ? "Trang chủ" : "Home";break;

	default                : $title = $_lang=="vn" ? "Trang chủ" : "Home";break;

}

echo $title;

?>