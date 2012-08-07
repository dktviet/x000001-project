<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<ul>
<li><a href="<?=$curHost?>trang-chu.html">Trang Chủ</a></li>
<li><a href="<?=$curHost?>gioi-thieu.html">Giới thiệu</a></li>
<li><a href="<?=$curHost?>lien-he.html">Liên hệ</a></li>
</ul>
<?php
require_once "urllist.php";
$sitemap = fopen("sitemap.xml", "w+");
fwrite($sitemap, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n");
fwrite($sitemap, "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n");
fwrite($sitemap,
"<url>\n
  <loc>".$curHost."</loc>\n
  <changefreq>always</changefreq>\n
  <priority>1.00</priority>\n
</url>\n
<url>\n
  <loc>".$curHost."trang-chu.html</loc>\n
  <changefreq>always</changefreq>\n
  <priority>0.80</priority>\n
</url>\n
<url>\n
  <loc>".$curHost."gioi-thieu.html</loc>\n
  <changefreq>always</changefreq>\n
  <priority>0.80</priority>\n
</url>\n
<url>\n
  <loc>".$curHost."lien-he.html</loc>\n
  <changefreq>always</changefreq>\n
  <priority>0.80</priority>\n
</url>\n
");

Site_map($cat_news,"news");
Site_map($cat_pro,"product");
fwrite($sitemap, "</urlset> \n");
fclose($sitemap);
function Site_map($arrItem, $type="", $parent_id = "",$class=""){
	global $curHost;
	global $sitemap;
	global $top_news;
	global $top_pro;
	$_return = '';
	echo "<ul>";
	$class = $class!="" ? $class : "";
	$parent_id = $parent_id != '' ? $parent_id : 1;
	for($i=0; $i<count($arrItem); $i++){
		if($arrItem[$i]['parent'] == $parent_id){
			if(countArray($arrItem,'parent',$arrItem[$i]['id'])){$dem=1;}
			if($type=='news'){
				if($dem>0){$MenuPage = "6-";}else{$MenuPage = "2-";}
				$link = $curHost.$arrItem[$i]['id'].'-'.str_replace(' ','-',$arrItem[$i]['subject'])."/".$MenuPage.str_replace(' ','-',$arrItem[$i]['name']).".html";
				echo "<li><a href='".$link."'>".$arrItem[$i]['name']."</a><ul>";
					foreach($top_news as $itemnews){
						if($itemnews['parent']==$arrItem[$i]['id']){
							echo "<li><a href='".$curHost.$itemnews['id'].'-'.str_replace(' ','-',$itemnews['subject'])."/3-".str_replace(' ','-',$itemnews['name']).".html'>".$itemnews['name']."</a></li>";
							fwrite($sitemap, "<url>\n");
							fwrite($sitemap, "  <loc>".$curHost.$itemnews['id'].'-'.str_replace(' ','-',$itemnews['subject'])."/3-".str_replace(' ','-',$itemnews['name']).".html</loc>\n");
							fwrite($sitemap, "  <changefreq>always</changefreq>\n");
							fwrite($sitemap, "  <priority>0.8</priority>\n");
							fwrite($sitemap, "</url>\n"); 
						}
					}
				echo "</ul></li>";
				
			}else{
				if($dem>0){$MenuPage = "4-";}else{$MenuPage = "7-";}
				$link = $curHost.$arrItem[$i]['id'].'-'.str_replace(' ','-',$arrItem[$i]['subject'])."/".$MenuPage.str_replace(' ','-',$arrItem[$i]['name']).".html";
				echo "<li><a href='".$link."'>".$arrItem[$i]['name']."</a><ul>";
					foreach($top_pro as $itempro){
						if($itempro['parent']==$arrItem[$i]['id']){
							echo "<li><a href='".$curHost.$itempro['id'].'-'.str_replace(' ','-',$itempro['subject'])."/1-".str_replace(' ','-',$itempro['name']).".html'>".$itempro['name']."</a></li>";
							fwrite($sitemap, "<url>\n");
							fwrite($sitemap, "  <loc>".$curHost.$itempro['id'].'-'.str_replace(' ','-',$itempro['subject'])."/1-".str_replace(' ','-',$itempro['name']).".html</loc>\n");
							fwrite($sitemap, "  <changefreq>always</changefreq>\n");
							fwrite($sitemap, "  <priority>0.8</priority>\n");
							fwrite($sitemap, "</url>\n");
						}
					}
				echo "</ul></li>";
			}
			
			$_return.=$link;
			$_return.=fwrite($sitemap, "<url>\n");
			$_return.=fwrite($sitemap, "  <loc>".$link."</loc>\n");
			$_return.=fwrite($sitemap, "  <changefreq>always</changefreq>\n");
			$_return.=fwrite($sitemap, "  <priority>0.8</priority>\n");
			$_return.=fwrite($sitemap, "</url>\n"); 
			$_return.=Site_map($arrItem, $type, $arrItem[$i]['id']);
			$dem=0;
			
		}
	}		
	echo "</ul>";
	return $_return;
}
?> 