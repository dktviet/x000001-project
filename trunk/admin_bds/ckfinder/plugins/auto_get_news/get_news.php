<?php
	require_once '../../config.php';
	require_once '../../lib/func.lib.php';
	//require_once '../../lib/GTranslate.php';
	include 'simplehtmldom/simple_html_dom.php';
	
	function getHtml($url, $class_1, $class_2, $class_3, $class_4) { 
	    $linkarray=array(); 
	    $html = file_get_html($url); 
	    
	    foreach ($html->find($class_1) as $link){             
	        if ($link->href==NULL)  continue; 
	        if ($link->plaintext==NULL) continue; 
	        $text=str_replace("&nbsp;"," ",$link->plaintext); 
	        $text=trim($text);         
	        if ($text=="") continue; 
	        if (substr($link->href,0,1)=="/") $link->href=$url. $link->href; 
	        if (in_array($link->href,$linkarray)==false) $linkarray[$text]=$link->href; 
		}
	    foreach ($html->find($class_2) as $link){             
	        if ($link->href==NULL)  continue; 
	        if ($link->plaintext==NULL) continue; 
	        $text=str_replace("&nbsp;"," ",$link->plaintext); 
	        $text=trim($text);         
	        if ($text=="") continue; 
	        if (substr($link->href,0,1)=="/") $link->href=$url. $link->href; 
	        if (in_array($link->href,$linkarray)==false) $linkarray[$text]=$link->href; 
	    } 
	    foreach ($html->find($class_3) as $link){             
	        if ($link->href==NULL)  continue; 
	        if ($link->plaintext==NULL) continue; 
	        $text=str_replace("&nbsp;"," ",$link->plaintext); 
	        $text=trim($text);         
	        if ($text=="") continue; 
	        if (substr($link->href,0,1)=="/") $link->href=$url. $link->href; 
	        if (in_array($link->href,$linkarray)==false) $linkarray[$text]=$link->href; 
	    } 
	    foreach ($html->find($class_4) as $link){             
	        if ($link->href==NULL)  continue; 
	        if ($link->plaintext==NULL) continue; 
	        $text=str_replace("&nbsp;"," ",$link->plaintext); 
	        $text=trim($text);         
	        if ($text=="") continue; 
	        if (substr($link->href,0,1)=="/") $link->href=$url. $link->href; 
	        if (in_array($link->href,$linkarray)==false) $linkarray[$text]=$link->href; 
	    } 
	    $html->clear(); 
	    unset($html); 
	    return $linkarray; 
	} 
	
	function getOneNews($urlwebsite,$url,$class_title,$class_short_detail,$class_detail,$multi_detail=false) { 
	    $html = file_get_html($url); 
	    $news = array(); 
	    $td = $html->find($class_title,0); 
		if(!$td){
	    	$td = $html->find('div.title_news',0); 
	    	if(@$td->find('h1',0))
	    		$td = @$td->find('h1',0);
	    }
	    $news['name_vn']=$td->innertext;
	    $td->outertext=''; 
	    $tt = $html->find($class_short_detail,0); 
		if(!$tt){
	    	$tt = $html->find('div.short_intro',0); 
	    }
	    $news['detail_short_vn']=$tt->innertext; 
	    $news['detail_short_vn'] = preg_replace('/\<[\/]?(a)([^\>]*)\>/i', '', $news['detail_short_vn']);
	    $news['detail_short_vn'] = str_replace('>', '', $news['detail_short_vn']); 
	    $tt->outertext = ''; 
	    $detail_vn = '';
	    if($multi_detail == true){
	    	$domain = explode("/",$url);
	    	$cur_domain = 'http://'.$domain[2];
	    	$wraper = @$html->find($class_detail,0);
	    	if(!$wraper){
	    		$wraper = $html->find('div.content',0);
		    	if(!$wraper){
		    		$wraper = $html->find('div.w480',0);
		    	}
	    	}
	    	$content = @$wraper->find('div.ov',0);
	    	if(!$content){
	    		$content = @$wraper->find('div.fck_detail',0);
		    	if(!$content){
		    		$content = @$wraper->find('div',0);
			    	if(!$content){
			    		$content = $wraper;
			    	}
		    	}
		    	
	    	}
	    	$detail_vn = $content->innertext;
	    	$img_html = @$content->find('img');
	    	$image_url = '';	
		    if($img_html){
		    	$i=0;
			    foreach( $img_html as $img) {
			        if (substr($img->src,0,1) == '/'){  
			        	$img->src = $cur_domain.$img->src;
			        }
			        if($i == 0 && substr($img->src,-3) == 'jpg'){
						$image_url = $img->src;
					}
					$i++;
				}
		    }
		    $detail_vn = preg_replace('/\<[\/]?(a|table|tr|td|div)([^\>]*)\>/i', '', $detail_vn);
			$pos = strpos($detail_vn, 'src="/');	
			if ($pos !== false) {
			     $detail_vn = preg_replace('/<img.*src="(.*?)".*\/?>/', '<img src="'.'http://'.$domain[2].'\1" />', $detail_vn);
			}
		    $detail_vn = preg_replace ('/<div class=\"box-more\">.*?<\/div>/', '', $detail_vn);
	    }else{
		    $detail_vn_div = $html->find($class_detail,0);
		    $img_html = @$detail_vn_div->find('img');
		    if($img_html){
		    	$i=0;
			    foreach( $img_html as $img) {         
			        if (substr($img->src,0,1) == "/")  
			        $img->src = $urlwebsite.$img->src;
					if($i==0){
						$image_url = $img->src;
					}
					$i++;
				}
		    }
		    $detail_vn = $detail_vn_div->innertext; 
	    }
	    $news['detail_vn'] = $detail_vn; 
	    $news['img'] = $image_url; 
	    $html->clear(); 
	    unset($html); 
	    return $news; 
	} 
	function getNewsCat($url, $source){
		$str = explode('/',$url);
		if($source == 'dantri.com.vn'){
			$news_cat = $str[3];
			switch($news_cat){
				case 'c728'	: $news_cat = 'su-kien';break;
				case 'c20'	: $news_cat = 'xa-hoi';break;
				case 'c36'	: $news_cat = 'the-gioi';break;
				case 'c26'	: $news_cat = 'the-thao';break;
				case 'c25'	: $news_cat = 'giao-duc';break;
				case 'c167'	: $news_cat = 'van-hoa';break;
				case 'c76'	: $news_cat = 'kinh-doanh';break;
				case 'c23'	: $news_cat = 'van-hoa';break;
				case 'c170'	: $news_cat = 'phap-luat';break;
				case 'c135'	: $news_cat = 'doi-song';break;
				case 'c130'	: $news_cat = 'tinh-yeu';break;
				case 'c7'	: $news_cat = 'suc-khoe';break;
				case 'c119'	: $news_cat = 'cong-nghe';break;
				case 'c111'	: $news_cat = 'oto-xe-may';break;
				case 'c132'	: $news_cat = 'chuyen-la';break;
				case 'c202'	: $news_cat = 'ban-doc-viet';break;
				case 'c673'	: $news_cat = 'dien-dan';break;
				case 'c133'	: $news_cat = 'nghe-nghiep';break;
				case 'c772'	: $news_cat = 'the-thao';break;
			}
		}else if($source == 'vnexpress.net'){
			$news_cat = $str[4];
			switch($news_cat){
				case 'vi-tinh': $news_cat = 'cong-nghe';break;
				case 'ebank': $news_cat = 'su-kien';break;
				case 'tin-tuc': $news_cat = 'su-kien';break;
				case 'binh-luan-vien'	: $news_cat = 'the-thao';break;
			}
		}
		return $news_cat;
	}
	function getNewsUrlId($url, $source){
		$news_url_id = '';
		if($source == 'dantri.com.vn'){
			$str = explode('/',substr($url,21));
			$news_url_id = $str[1];
		}
		return $news_url_id;
	}
	function getNewsUrlName($url, $source){
		$news_url_name = '';
		if($source == 'dantri.com.vn'){
			$str = explode('/',substr($url,21));
			$news_url_name = $str[2];
		}
		return $news_url_name;
	}
	function insertToDB($news, $url, $source){
		if(substr($url,-1) == '/'){
			$url = substr($url,0,-1);
		}
		//$gt = new gTranslate;
		//$gt->setRequestType('http');
	    $name_vn = trim(mysql_real_escape_string(strip_tags($news['name_vn']))); 
	    //$name_en = $gt->vietnamese_to_english($name_vn);    
	    $detail_short_vn = trim(mysql_real_escape_string(strip_tags($news['detail_short_vn'])));  
		$detail_short_vn = str_replace('(Dân trí) - ','',$detail_short_vn);
		$detail_short_vn = str_replace('(Dân trí)- ','',$detail_short_vn);
		$detail_short_vn = str_replace('(D&acirc;n tr&iacute;) - ','',$detail_short_vn);
		$detail_short_vn = str_replace('(Dân trí) - ','',$detail_short_vn);
		//$detail_short_en = $gt->vietnamese_to_english($detail_short_vn);
	    $detail_vn = trim(mysql_real_escape_string($news['detail_vn'])); 
	    //$detail_en = $gt->vietnamese_to_english($detail_vn);
	    $image_url = trim(mysql_real_escape_string($news['img'])); 
		//cat lay ma loai tin qua url
		$news_cat = getNewsCat($url, $source);
		//cat lay id tin tren url
		$news_url_id = getNewsUrlId($url, $source);
		//cat lay ten tin tren url
		$news_url_name = getNewsUrlName($url, $source);
		//ktra tin da ton tai chua qua url
		$countExist1 = countRecord(tbl_config::tbl_news,"url_goc = '".$url."'");
		$countExist2 = countRecord(tbl_config::tbl_news,"url_goc like '%".$news_url_name."%' OR url_goc like '%".$news_url_id."%'");
		$countExist3 = countRecord(tbl_config::tbl_news,"name_vn = '".$name_vn."'");
		if($countExist1 > 0 || $name_vn == '' || (($countExist2 > 0 || $countExist3 > 0) && $source == 'dantri.com.vn')){
			return false;
		} else {
			$image_thumbs 	= '';
			$image			= '';
			if($image_url || $image_url != ''){
				$news_img_name = rand(0,100).'_'.time().'.jpg';
			    auto_save_image($image_url,'../../images/news/'.$news_img_name);
			    change_img_size('../../images/news/'.$news_img_name,'../../images/news/'.$news_img_name,340,340);
				$image = 'images/news/'.$news_img_name;
				change_img_size('../../images/news/'.$news_img_name,'../../images/news/thumbs/thumbs_'.$news_img_name,140,100);
				$image_thumbs = 'images/news/thumbs/thumbs_'.$news_img_name;
			}
			
			$get_cat = getRecord(tbl_config::tbl_category,"code='".$news_cat."'");
			$parent = $get_cat['id'];
			$fields_news_arr = array(
				"name_vn"          	=> "'".killInjection($name_vn)."'",
				//"name_en"          	=> "'".killInjection($name_en)."'",
				"url_goc"          	=> "'$url'",
				"parent"          	=> "$parent",
				"source"  			=> "'$source'",
				"image_thumbs"		=> "'$image_thumbs'",
				"image"  			=> "'$image'",
				"detail_short_vn"  	=> "'$detail_short_vn'",
				//"detail_short_en"  	=> "'$detail_short_en'",
				"detail_vn"        	=> "'$detail_vn'",
				//"detail_en"        	=> "'$detail_en'",
				"status"        	=> 0,
				"date_added"        => time(),
				"last_modified"     => time(),
			);
			if(insert(tbl_config::tbl_news,$fields_news_arr)){
				return true;
			}else{
				echo 'error!';
				return false;
			}
		}
	} 
	
	// chay...
	switch($_POST['fnc']){
		case 'dantri': get_news_from_dantri(); break;
		case 'vnexpress': get_news_from_vnexpress(); break;
	}
	
	function get_news_from_dantri(){
		set_time_limit(0);  
		$urlwebsite='http://dantri.com.vn';
		$class_1 = '.fon1 mt2';
		$class_2 = '.fon6';
		$class_3 = '.ul1 li a';
		$class_4 = '.fon4';
		$url_goc = 'dantri.com.vn';
		$class_title = 'h1.fon31';
		$class_short_detail = 'h2.fon33';
		$class_detail = 'div.fon34';
		$links_dantri=getHtml($urlwebsite, $class_1, $class_2, $class_3, $class_4);
		foreach ($links_dantri as $td => $url_dantri){
			$news=getOneNews($urlwebsite,$url_dantri,$class_title,$class_short_detail,$class_detail,false);
			flush();
			$insert = insertToDB($news, $url_dantri, $url_goc);
			if(!$insert){
				echo $url_dantri.'<br>';
				next($links_dantri);//break;
			}
		}
	}
	function get_news_from_vnexpress(){
		set_time_limit(0);  
		$urlwebsite='http://vnexpress.net';
		$class_1 = '.link-topnews';
		$class_2 = '.link-title';
		$class_3 = '.link-toplist';
		$class_4 = '.link-othernews';
		$url_goc = 'vnexpress.net';
		$class_title = 'h1.Title';
		$class_short_detail = 'h2.Lead';
		$class_detail = 'div.ctmain';
		$links_vnexpress=getHtml($urlwebsite, $class_1, $class_2, $class_3, $class_4);
		foreach ($links_vnexpress as $td => $url_vnexpress){
			$news=getOneNews($urlwebsite,$url_vnexpress,$class_title,$class_short_detail,$class_detail,true);
			flush();
			$insert = insertToDB($news, $url_vnexpress, $url_goc);
			if(!$insert){
				echo $url_vnexpress.'<br>';
				next($links_vnexpress);//break;
			}
		}
	}
?>