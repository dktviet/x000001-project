<?
switch ($_REQUEST['act']){
	case "category_manager"    			: include("category_manager.php");break;

	//General page ----------------------------------------------------------------------------------
	case "general_category"    	: include("content_category.php");break;
	case "general_category_m"  	: include("content_category_m.php");break;
	case "general"             	: include("content_manager.php");break;
	case "general_m"           	: include("content_m.php");break;

	//Web page ----------------------------------------------------------------------------------
	case "web_category"    		: include("content_category.php");break;
	case "web_category_m"  		: include("content_category_m.php");break;
	case "web"             		: include("content_manager.php");break;
	case "web_m"           		: include("content_m.php");break;

	//Game page ----------------------------------------------------------------------------------
	case "game_category"    	: include("content_category.php");break;
	case "game_category_m"  	: include("content_category_m.php");break;
	case "game"             	: include("content_manager.php");break;
	case "game_m"           	: include("content_m.php");break;

	case "game_flash_category"  : include("game_flash_category.php");break;
	case "game_flash_category_m": include("game_flash_category_m.php");break;
	case "game_flash"           : include("game_flash.php");break;
	case "game_flash_m"         : include("game_flash_m.php");break;

	//Web project page ----------------------------------------------------------------------------------
	case "project_category"    	: include("content_category.php");break;
	case "project_category_m"  	: include("content_category_m.php");break;
	case "project"             	: include("content_manager.php");break;
	case "project_m"           	: include("content_m.php");break;

	case "project_gallery"     	: include("project_gallery.php");break;
	case "project_gallery_m"   	: include("project_gallery_m.php");break;	

	//News page ----------------------------------------------------------------------------------
	case "news_category"        : include("news_category.php");break;
	case "news_category_m"      : include("news_category_m.php");break;
	case "news"             	: include("news.php");break;
	case "news_m"           	: include("news_m.php");break;

	//Album page ----------------------------------------------------------------------------------
	case "album"        		: include("album.php");break;
	case "album_m"      		: include("album_m.php");break;	

	case "gallery"      		: include("gallery.php");break;
	case "gallery_m"    		: include("gallery_m.php");break;	

	//Support page ----------------------------------------------------------------------------------
	case "yahoo"      			: include("support.php");break;
	case "yahoo_m"    			: include("support_m.php");break;

	case "skype"      			: include("support.php");break;
	case "skype_m"    			: include("support_m.php");break;

	case "hotline"      		: include("support.php");break;
	case "hotline_m"    		: include("support_m.php");break;

	case "email"      			: include("support.php");break;
	case "email_m"    			: include("support_m.php");break;

	//Multi page -----------------------------------------------------------------------------------

	case "site_index"       	: include("site_index.php");break;
	case "site_index_m"     	: include("site_index_m.php");break;

	case "video"           		: include("video.php");break;
	case "video_m"         		: include("video_m.php");break;	

	case "audio"           		: include("audio.php");break;
	case "audio_m"         		: include("audio_m.php");break;	
	
	case "download"       		: include("download.php");break;
	case "download_m"     		: include("download_m.php");break;
	
	//----------------------------------------------------------------------------------------------
		
	case "contact"        		: include("contact.php");break;
	case "contact_m"      		: include("contact_m.php");break;
		
	case "map"        			: include("map.php");break;
	case "map_m"      			: include("map_m.php");break;
		
	//----------------------------------------------------------------------------------------------
			
	case "banner"       		: include("banner.php");break;
	case "banner_m"     		: include("banner_m.php");break;
			
	case "link"       			: include("link.php");break;
	case "link_m"     			: include("link_m.php");break;
	
	case "advleft"    			: include("advleft.php");break;
	case "advleft_m"  			: include("advleft_m.php");break;
	
	case "advright"    			: include("advright.php");break;
	case "advright_m"  			: include("advright_m.php");break;

	case "advdown"    			: include("advdown.php");break;
	case "advdown_m"  			: include("advdown_m.php");break;
	
	case "advup"      			: include("advup.php");break;
	case "advup_m"    			: include("advup_m.php");break;
	
	//----------------------------------------------------------------------------------------------

	case "user_ip"     			: include("user_ip.php");break;
	case "alexa_rank"  			: include("alexa_rank.php");break;

	case "ad_per"     			: include("ad_per.php");break;
	case "ad_per_m"				: include("ad_per_m.php");break;
	
	case "member"         		: include("member.php");break;
	case "member_m"       		: include("member_m.php");break;
	case "order"          		: include("order.php");break;
	case "order_detail"   		: include("order_detail.php");break;
	
	//----------------------------------------------------------------------------------------------
	
	case "config"         		: include("config.php");break;
	case "config_m"       		: include("config_m.php");break;
	
	case "changepass"     		: include("changePassword.php");break;
	case "login"          		: include("login.php");break;
	case "logout" :
		unset($_SESSION['log']);
		unset($_SESSION['ADMIN_IP']);
		echo "<script>window.location='./?frame=home'</script>";
		break;
	
	//----------------------------------------------------------------------------------------------
	
	case "home"          : include("home.php");break;
	default              : include("home.php");break;
}
?>