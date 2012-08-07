<?php
$urllist = fopen("urllist.txt", "w+");
fwrite($urllist,$curHost);
fwrite($urllist,$curHost."trang-chu.html\n");
fwrite($urllist,$curHost."gioi-thieu.html\n");
fwrite($urllist,$curHost."lien-he.html\n");
urllist($cat_news,"news");
urllist($cat_pro,"product");
fclose($urllist);
function urllist($arrItem, $type="", $parent_id = ""){
	global $curHost;
	global $urllist;
	global $top_news;
	global $top_pro;
	$_return = '';

	$parent_id = $parent_id != '' ? $parent_id : 1;
	for($i=0; $i<count($arrItem); $i++){
		if($arrItem[$i]['parent'] == $parent_id){
			if(countArray($arrItem,'parent',$arrItem[$i]['id'])){$dem=1;}
			if($type=='news'){
				if($dem>0){$MenuPage = "6-";}else{$MenuPage = "2-";}
				$link = $curHost.$arrItem[$i]['id'].'-'.str_replace(' ','-',$arrItem[$i]['subject'])."/".$MenuPage.str_replace(' ','-',$arrItem[$i]['name']).".html";
				foreach($top_news as $itemnews){
					if($itemnews['parent']==$arrItem[$i]['id']){
						fwrite($urllist, $curHost.$itemnews['id'].'-'.str_replace(' ','-',$itemnews['subject'])."/3-".str_replace(' ','-',$itemnews['name']).".html\n");
					}
				}
			}else{
				if($dem>0){$MenuPage = "4-";}else{$MenuPage = "7-";}
				$link = $curHost.$arrItem[$i]['id'].'-'.str_replace(' ','-',$arrItem[$i]['subject'])."/".$MenuPage.str_replace(' ','-',$arrItem[$i]['name']).".html";
				foreach($top_pro as $itempro){
					if($itempro['parent']==$arrItem[$i]['id']){
						fwrite($urllist, $curHost.$itempro['id'].'-'.str_replace(' ','-',$itempro['subject'])."/1-".str_replace(' ','-',$itempro['name']).".html\n");
					}
				}
			}
			$_return.=fwrite($urllist, $link."\n");
			$_return.=urllist($arrItem, $type, $arrItem[$i]['id']);
			$dem=0;
		}
	}		
	return $_return;
}
?>