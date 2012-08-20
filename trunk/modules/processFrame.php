<?
if($pages==''){
    include("products/product_home.php");
}else{

switch ($pages){
	
	case "product"          : include("modules/products/product_category.php");break;

	case "sitemap"          : include("sitemap.php");break;
	
	case "product_sub"      : include("modules/products/product_category_sub.php");break;
	
	case "news_sub"  	    : include("modules/news/news_category_sub.php");break;

	case "product_detail"   : include("modules/products/product_detail.php");break;
	
	case "contact_pro"   	: include("modules/contact_pro.php");break;

	case "intro"            : include("modules/intro.php");break;

	case "fly_map"        	: include("modules/fly_map.php");break;

	case "news"      		: include("modules/news/news.php");break;	

	case "album"            : include("modules/album.php");break;

	case "recuit"           : include("modules/recuit.php");break;
	
	case "news_detail"      : include("modules/news/news_detail.php");break;	

	case "encourage" 		: include("modules/encourage.php");break;	

	case "encourage_detail" : include("modules/encourage_detail.php");break;	

	case "map"            	: include("modules/map.php");break;

	case "download" 		:

		if(!empty($_SESSION['member'])){

			include("modules/download.php");

		}else{
			
			include("modules/member_login.php");
			
		}
		
		break;

	case "contact"          : include("modules/contact.php");break;

	case "cart"             : include("modules/cart/cart.php");break;

	case "checkout"         : include("modules/cart/checkout.php");break;
	
	case "checkoutok"       : include("modules/cart/checkout.php");break;

	case "search"           : include("modules/search/index.php");break;
	
	case "keyword"          : include("modules/search/keyword.php");break;

	case "registry"         : include("modules/member_registry.php");break;

	case "login"            : include("modules/member_login.php");break;

	case "forgotpass"       : include("modules/member_forgotpass.php");break;

	case "logout"           : 

		unset($_SESSION['member']);

		echo "<script>window.location='dang-nhap.html'</script>";

		break;

	case "forum"            : echo "<script>window.location='forum'</script>";break;

	case "support"          : include("support.php");break;
	
	case "quality"          : include("quality.php");break;
	
	case "solution"         : include("solution.php");break;
	
	case "home"             : include("products/product_home.php");break;

	default                 : include("products/product_home.php");break;

}
}
?>