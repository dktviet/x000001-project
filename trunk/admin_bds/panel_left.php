<ul id="menu">
    <li class="node">
    <a class="top <?=$act=='home' 
                                    || $act=='ad_per'
									|| $act=='ad_per_m'
                                    || $act=='user_ip'
                                    || $act=='alexa_rank'
                                    || $act=='member'
									|| $act=='member_m'
                                    || $act=='changepass'
									|| $act=='changepass_m'
                                    || $act=='site_index'
									|| $act=='site_index_m'
                                    || $act=='config'
									|| $act=='config_m'
                                    ? 'opened' : '';?>">Hệ thống</a>
        <ul id="<?=$act=='home' 
                                    || $act=='ad_per'
									|| $act=='ad_per_m'
                                    || $act=='user_ip'
                                    || $act=='alexa_rank'
                                    || $act=='member'
									|| $act=='member_m'
                                    || $act=='changepass'
									|| $act=='changepass_m'
                                    || $act=='site_index'
									|| $act=='site_index_m'
                                    || $act=='config'
									|| $act=='config_m'
                                    ? 'opened' : '';?>">
            <li><a href="./?act=home" <?=$act=='home' ? 'class="current"' : '';?>>Bảng điều khiển</a></li>
            <? if($adminInfo['id']==8388){?>
            <li><a href="./?act=ad_per" <?=$act=='ad_per' || $act=='ad_per_m'? 'class="current"' : '';?>>Quản trị viên</a></li>
            <li><a href="./?act=user_ip" <?=$act=='user_ip'? 'class="current"' : '';?>>Thông tin IP truy cập</a></li>
            <li><a href="./?act=alexa_rank" <?=$act=='alexa_rank'? 'class="current"' : '';?>>Thống kê Alexa</a></li>
            <li><a href="./?act=config" <?=$act=='config' || $act=='config_m'? 'class="current"' : '';?>>Cấu hình</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='member'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=member" <?=$act=='member' || $act=='member_m'? 'class="current"' : '';?>>Thành viên</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='site_index'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=site_index" <?=$act=='site_index' || $act=='site_index_m'? 'class="current"' : '';?>>Chỉ mục Website</a></li>
            <? }?>
            <li><a href="./?act=changepass" <?=$act=='changepass' || $act=='changepass_m'? 'class="current"' : '';?>>Đổi mật khẩu</a></li>
            <li><a href="./?act=logout">Thoát</a></li>
        </ul>
    </li>
    
    <li class="node"><a class="top">Quản Lý Danh mục</a>
        <ul>
        <?php
			$nav_cats = selectMulti(tbl_config::tbl_category, 'id, name', 'status=1 AND parent_id=0', 'ORDER BY sort, date_added ASC');
			foreach($nav_cats as $nav_cat){
				$nav_id = $nav_cat['id'];
				$nav_name = $nav_cat['name'];
		?>
        
            <li class="cat_list_menu"><a cat_id="<?=$nav_id?>"><strong style="color:#fff;float:left;">Danh mục</strong> <?=$nav_name?></a></li>
        <?php }?>
        </ul>
    </li>

    <li class="node" id="content_manager_nav"><a class="top">Quản Lý Nội dung</a>
        <ul>
            <?php
                $nav_cats = selectMulti(tbl_config::tbl_category, 'id, name', 'status=1 AND parent_id=0 AND code IN ("news","product")', 'ORDER BY sort, date_added ASC');
                foreach($nav_cats as $nav_cat){
                        $nav_id = $nav_cat['id'];
                        $nav_name = $nav_cat['name'];
                        $nav_child_cats = selectMulti(tbl_config::tbl_category, 'id, name', 'status=1 AND parent_id = ' . $nav_id, 'ORDER BY sort, date_added ASC');
                        foreach($nav_child_cats as $nav_child_cat){
                                $nav_child_id = $nav_child_cat['id'];
                                $nav_child_name = $nav_child_cat['name'];
            ?>
            <li class="content_list_menu"><a href="#<?=$nav_id.'_'.$nav_child_id?>" parent_cat_id="<?=$nav_id?>" cat_id="<?=$nav_child_id?>"><strong style="color:#fff;float:left;"><?=$nav_name?>:</strong> <?=$nav_child_name?></a></li>
        <?php } }?>
        </ul>
    </li>
    <li class="node" id="properties_manager_nav"><a class="top">Quản Lý Thuộc tính SP</a>
        <ul>
            <?php
                $nav_cat = selectOne(tbl_config::tbl_category, 'status=1 AND parent_id=0 AND code = "properties"', 'sort, date_added ASC');
                $nav_id = $nav_cat['id'];
                $nav_name = $nav_cat['name'];
                $nav_child_cats = selectMulti(tbl_config::tbl_category, 'id, name', 'status=1 AND parent_id = ' . $nav_id, 'ORDER BY sort, date_added ASC');
                foreach($nav_child_cats as $nav_child_cat){
                        $nav_child_id = $nav_child_cat['id'];
                        $nav_child_name = $nav_child_cat['name'];
            ?>
            <li class="content_list_menu"><a href="#<?=$nav_id.'_'.$nav_child_id?>" parent_cat_id="<?=$nav_id?>" cat_id="<?=$nav_child_id?>"><strong style="color:#fff;float:left;"><?=$nav_name?>:</strong> <?=$nav_child_name?></a></li>
        <?php }?>
        </ul>
    </li>
    <li class="node"><a class="top <?=$act=='advup' 
									|| $act=='advup_m'
                                    || $act=='album'
									|| $act=='album_m'
                                    || $act=='gallery'
									|| $act=='gallery_m'
                                    || $act=='video'
									|| $act=='video_m'
                                    || $act=='audio'
									|| $act=='audio_m'
                                    || $act=='link'
									|| $act=='link_m'
                                    ? 'opened' : '';?>">Hình ảnh - Quảng cáo</a>
        <ul id="<?=$act=='advup' 
									|| $act=='advup_m'
                                    || $act=='banner'
									|| $act=='banner_m'
                                   	|| $act=='album'
									|| $act=='album_m'
                                    || $act=='gallery'
									|| $act=='gallery_m'
                                    || $act=='video'
									|| $act=='video_m'
                                    || $act=='audio'
									|| $act=='audio_m'
                                    || $act=='link'
									|| $act=='link_m'
                                    ? 'opened' : '';?>">
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='banner'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=banner"<?=$act=='banner' || $act=='banner_m'? 'class="current"' : '';?>>Banner website</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='advup'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=advup"<?=$act=='advup' || $act=='advup_m'? 'class="current"' : '';?>>Slide hình trang chủ</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='album'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=album"<?=$act=='album' || $act=='album_m'? 'class="current"' : '';?>>Quản lý Album</a></li>
            <li><a href="./?act=gallery"<?=$act=='gallery' || $act=='gallery_m'? 'class="current"' : '';?>>Quản lý hình ảnh</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='video'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=video"<?=$act=='video' || $act=='video_m'? 'class="current"' : '';?>>Quản lý video</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='audio'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=audio"<?=$act=='audio' || $act=='audio_m'? 'class="current"' : '';?>>Quản lý audio</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='link'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=link"<?=$act=='link' || $act=='link_m'? 'class="current"' : '';?>>Liên kết website</a></li>
            <? }?>
        </ul>
    </li>
    <li class="node"><a class="top">Hỗ Trợ - Liên Hệ</a>
    	<ul>
    		 <li class="contact_list_menu"><a href="#contact">Liên Hệ</a></li>
    	</ul>
    </li>
<!--    <li class="node"><a class="top <?=$act=='contact'
									|| $act=='contact_m'
									|| $act=='yahoo'
									|| $act=='yahoo_m'
									|| $act=='skype'
									|| $act=='skype_m'
									|| $act=='hotline'
									|| $act=='hotline_m'
									|| $act=='email'
									|| $act=='email_m'
                                    || $act=='map'
									|| $act=='map_m'
                                    ? 'opened' : '';?>">Hỗ Trợ - Liên Hệ</a>
        <ul id="<?=$act=='contact' 
									|| $act=='contact_m'
									|| $act=='yahoo'
									|| $act=='yahoo_m'
									|| $act=='skype'
									|| $act=='skype_m'
									|| $act=='hotline'
									|| $act=='hotline_m'
									|| $act=='email'
									|| $act=='email_m'
                                    || $act=='map'
									|| $act=='map_m'
                                    ? 'opened' : '';?>">
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='contact_info'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=contact"<?=$act=='contact' || $act=='contact_m'? 'class="current"' : '';?>>Liên Hệ</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='yahoo'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=yahoo"<?=$act=='yahoo' || $act=='yahoo_m'? 'class="current"' : '';?>>Hỗ Trợ Yahoo</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='skype'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=skype"<?=$act=='skype' || $act=='skype_m'? 'class="current"' : '';?>>Hỗ Trợ Skype</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='hotline'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=hotline"<?=$act=='hotline' || $act=='hotline_m'? 'class="current"' : '';?>>Đường dây nóng</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='email'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=email"<?=$act=='email' || $act=='email_m'? 'class="current"' : '';?>>Thư điện tử</a></li>
            <? }?>
            <?
            	$get_cat 	= selectOne(tbl_config::tbl_category,"code='map'");
				$adminPer 	= countRecord(tbl_config::tbl_controller_per,"cat_id=".$get_cat['id']." and cat_code='".$get_cat['code']."' and user_id=".$adminInfo['id']);
				if($adminPer>0){
			?>
            <li><a href="./?act=map"<?=$act=='map' || $act=='map_m'? 'class="current"' : '';?>>Bản đồ trực tuyến</a></li>
            <? }?>
       </ul>
    </li>-->
</ul>
