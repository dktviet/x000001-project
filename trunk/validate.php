<?php
// Set IP BEGIN:
if(!isset($_SESSION['USER_IP']) || $_SESSION['USER_IP'] == NULL){
	session_register('USER_IP');
	$_SESSION['USER_IP'] = get_real_ip();
	update_ip($_SESSION['USER_IP'],0);
}
// Set IP END.
//set giá trị khởi tạo
if(isset($_GET['ali'])){
	$frame=killInjection(substr($_GET['ali'],0,strpos($_GET['ali'],'-')));
    if(isset($_GET['cat'])=="category")$frame=8;
	switch ($frame){
		case 1:
			$pages='product_detail';
			break;
		case 2:
			$pages='news';
			break;
		case 3:
			$pages='news_detail';
			break;
		case 4:
			$pages='product_sub';
			break;
		case 5:
			$pages='contact_pro';
			break;
		case 6:
			$pages='news_sub';
			break;
        case 7:
			$pages='product';
			break;
        case 8:
			$pages='keyword';
			break;
		default: $pages=utf8_to_ascii($_GET['frame']);
			break;
	}
}else{
    $pages=utf8_to_ascii($_REQUEST['frame']);
}
if(isset($_GET['cat'])) $cat=killInjection(substr($_GET['cat'],0,strpos($_GET['cat'],'-')));
if(isset($_GET['p'])) $p = intval(killInjection($_GET['p']));
if(isset($_GET['cat'])){
	if($pages=='product_detail'){
		$product = getRecord('xteam_product','id='.$cat);
		$description = catchu(strip_tags($product['detail_short']),200);
		$title=$product['title']!=''?$product['title']:'';
	}
	
	if($pages=='product' || $pages=='product_sub'){
		$category = getRecord('xteam_category','id='.$cat);
		$description = $category['detail_short']!=''?$category['detail_short']:$mydescription['detail'];
		$title=$category['title']!=''?$category['title']:'';
	}
	
	if($pages=='news_detail'){
		$news = getRecord('xteam_content','id='.$cat);
		$description = catchu(strip_tags($news['detail_short']),200);
		$title=$news['title']!=''?$news['title']:'';
	}
	
	if($pages=='news' || $pages=='news_sub'){
		$category = getRecord('xteam_category','id='.$cat);
		$description = $category['detail_short']!=''?$category['detail_short']:$mydescription['detail'];
		$title=$category['title']!=''?$category['title']:'';
	}
	
}else{
	$description =$mydescription['detail'];
}
$title = $title!=='' ? $title : $mykeywords['detail'];
$getpro= getRecord('xteam_category', 'code="product"');
$getnews= getRecord('xteam_category', 'code="news"');
$cat_news =  getArray('xteam_category','status=1 AND parent_id='.$getnews['id'],NULL,"sort");
$cat_pro =  getArray('xteam_category','status=1 AND parent_id='.$getpro['id'],NULL,"sort");
$top_news = getArray('xteam_content','status=1');
$top_pro = getArray('xteam_product','status=1');
if($pages=="news") $news = getArray('xteam_content','parent_id='.$cat.' AND status=0');
?>