<?
// Set IP BEGIN:
if(!isset($_SESSION['USER_IP']) || $_SESSION['USER_IP'] == NULL){
	session_register('USER_IP');
	$_SESSION['USER_IP'] = get_real_ip();
	update_ip($_SESSION['USER_IP'],0);
}
// Set IP END.
if(isset($_GET['ali'])) $frame=killInjection(substr($_GET['ali'],0,strpos($_GET['ali'],'-')));
switch ($frame){
	case '7':
		$pages='product';
		break;
	case '1':
		$pages='product_detail';
		break;
	case '2':
		$pages='news';
		break;
	case '3':
		$pages='news_detail';
		break;
	case '4':
		$pages='product_sub';
		break;
	case '5':
		$pages='contact_pro';
		break;
	case '6':
		$pages='news_sub';
		break;
	default: $pages=utf8_to_ascii($_GET['frame']);
		break;
}
$cat=killInjection(substr($_GET['cat'],0,strpos($_GET['cat'],'-')));
if(isset($_GET['p'])) $p = intval(killInjection($_GET['p']));
if($_GET['cat']){
	if($pages=='product_detail'){
		$product = getRecord('bnk_product','id='.$cat);
		$description = catchu(strip_tags($product['detail_short']),200);
		$title=$product['title']!=''?$product['title']:'';
	}
	
	if($pages=='product' || $pages=='product_sub'){
		$category = getRecord('bnk_product_category','id='.$cat);
		$description = $category['detail_short']!=''?$category['detail_short']:$mydescription['detail'];
		$title=$category['title']!=''?$category['title']:'';
	}
	
	if($pages=='news_detail'){
		$news = getRecord('bnk_news','id='.$cat);
		$description = catchu(strip_tags($news['detail_short']),200);
		$title=$news['title']!=''?$news['title']:'';
	}
	
	if($pages=='news' || $pages=='news_sub'){
		$category = getRecord('bnk_news_category','id='.$cat);
		$description = $category['detail_short']!=''?$category['detail_short']:$mydescription['detail'];
		$title=$category['title']!=''?$category['title']:'';
	}
	
}else{
	$description =$mydescription['detail'];
}
$title = $title!=''?$title:$mykeywords['detail'];
$cat_news =  getArray('bnk_news_category','status=0 AND parent>0',NULL,"sort");
$cat_pro =  getArray('bnk_product_category','status=0 AND system=0',NULL,"sort");
$top_news = getArray('bnk_news','status=0');
$top_pro = getArray('bnk_product','status=0');
if($pages=="news") $news = getArray('bnk_news','parent='.$cat.' AND status=0');
if($pages=="product") $products = getArray('bnk_product','parent='.$cat);
if(isset($_GET['style'])){
	$_SESSION['style'] = $_GET['style'];}
?>