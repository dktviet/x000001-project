<?php 
	$today 		= strtotime('today');
	$thismonth 	= strtotime(date('Y-m-01'));
?>
<div class="clear"></div>
<div id="element-box">
	<div class="m">
		<table class="adminform">
			<tbody>
				<tr>
					<td valign="top" width="50%">
			            <?php 
				            $get_total_visits	= selectOne(tbl_config::tbl_total_visits,"code = 'total'");
				            $total_visits 		= $get_total_visits['total_visits'];
			           		$get_visits_today 	= selectOne(tbl_config::tbl_total_visits,"code = 'today' AND date_added = " . $today);
							$visits_today 		= $get_visits_today['total_visits'];
				            $guest  			= countRecord(tbl_config::tbl_visitor,"member='n'");
							$members 			= countRecord(tbl_config::tbl_visitor,"member='y'");
			            ?>
			            <table class="adminlist">
							<thead>
								<tr>
									<th class="title" align="center" colspan="4">
										<strong	style="color: #f00;">Thống kê truy cập:</strong>
									</th>
								</tr>
								<tr>
									<th class="title" align="center">
										<strong>Tổng số truy cập</strong>
									</th>
									<th class="title" align="center">
										<strong>Truy cập hôm nay</strong>
									</th>
									<th class="title" align="center">
										<strong>Thành viên đang trực tuyến</strong>
									</th>
									<th class="title" align="center">
										<strong>Khách đang trực tuyến</strong>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="center"><?=$total_visits?></td>
									<td align="center"><?=$visits_today?></td>
									<td align="center"><?=$members?></td>
									<td align="center"><?=$guest?></td>
								</tr>
							</tbody>
						</table>
						<?php 
							$totalContact 	= countRecord(tbl_config::tbl_contact);
							$newContact 	= countRecord(tbl_config::tbl_contact, 'status = 1');
						?>
						<table class="adminlist">
							<thead>
								<tr>
									<th class="title" align="center" colspan="2">
										<strong style="color: #f00;">Thống kê liên hệ:</strong>
									</th>
								</tr>
								<tr>
									<th class="title" align="center"><strong>Tổng số liên hệ</strong></th>
									<th class="title" align="center"><strong>Liên hệ mới</strong></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="center"><?=$totalContact?></td>
									<td align="center"><a href="./#contact" onclick="load_contact_list();"><?=$newContact?></a></td>
								</tr>
							</tbody>
						</table>
						<?php 
							$totalNews 		= countRecord(tbl_config::tbl_news);
							$newsMonth 		= countRecord(tbl_config::tbl_news, 'date_added >= ' . $thismonth);
							$newsDay 		= countRecord(tbl_config::tbl_news, 'date_added >= ' . $today);
							$newsHide 		= countRecord(tbl_config::tbl_news, 'status = 1');
						?>
						<table class="adminlist">
							<thead>
								<tr>
									<th class="title" align="center" colspan="4"><strong
										style="color: #f00;">Thống kê cập nhật tin tức:</strong></th>
								</tr>
								<tr>
									<th class="title" align="center"><strong>Tổng tin tức</strong></th>
									<th class="title" align="center"><strong>Tin cập nhật trong tháng</strong></th>
									<th class="title" align="center"><strong>Tin cập nhật trong ngày</strong></th>
									<th class="title" align="center"><strong>Tin ẩn</strong></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="center"><?=$totalNews?></td>
									<td align="center"><?=$newsMonth?></td>
									<td align="center"><?=$newsDay?></td>
									<td align="center"><?=$newsHide?></td>
								</tr>
							</tbody>
						</table>
					</td>
					<td valign="top" width="50%">
						<div id="content-pane" class="pane-sliders">
							<div class="panel">
								<div style="padding-top: 0px; border-top: medium none; padding-bottom: 0px; border-bottom: medium none; overflow: hidden;" class="jpane-slider content">
									<table class="adminlist">
										<thead>
											<tr>
												<th class="title" align="center" colspan="6">
													<strong	style="color: #f00;">Thống kê trang quản trị:</strong>
												</th>
											</tr>
											<tr>
												<th class="title" align="center"><strong>TT</strong></th>
												<th class="title" align="center"><strong>Tên truy cập</strong></th>
												<th class="title" align="center"><strong>Địa chỉ Ip</strong></th>
												<th class="title" align="center"><strong>Số lần truy cập</strong></th>
												<th class="title" align="center"><strong>Lần truy cập đầu</strong></th>
												<th class="title" align="center"><strong>Lần mới truy cập</strong></th>
											</tr>
										</thead>
										<tbody>
                        				<?php
	                        				$field 	= 'uid, guest_ip, num_in, date_added, last_modified';
	                        				$where  = 'status = 0';
	                        				$sortby = 'ORDER BY last_modified DESC';
	                        				$limit 	= 'LIMIT 0,10';
	                        				$where_admin = $where . ' AND position = 1';
                        					$admin_guest_ips = selectMulti(tbl_config::tbl_guest_ip, $field, $where_admin, $limit);
											$tt = 0;
											foreach($admin_guest_ips as $admin_guest_ip){
												$tt ++;
										?>
                            				<tr>
												<td align="center"><?=$tt?></td>
												<td align="center"><?=$admin_guest_ip['uid']?></td>
												<td align="center"><?=$admin_guest_ip['guest_ip']?></td>
												<td align="center"><?=$admin_guest_ip['num_in']?></td>
												<td align="center"><?=$admin_guest_ip['date_added']?></td>
												<td align="center"><?=$admin_guest_ip['last_modified']?></td>
											</tr>
                            			<?php }?>
                        				</tbody>
									</table>
									<table class="adminlist">
										<thead>
											<tr>
												<th class="title" align="center" colspan="6">
													<strong style="color: #f00;">Thống kê trang chủ:</strong>
												</th>
											</tr>
											<tr>
												<th class="title" align="center"><strong>TT</strong></th>
												<th class="title" align="center"><strong>Tên truy cập</strong></th>
												<th class="title" align="center"><strong>Địa chỉ Ip</strong></th>
												<th class="title" align="center"><strong>Số lần truy cập</strong></th>
												<th class="title" align="center"><strong>Lần truy cập đầu</strong></th>
												<th class="title" align="center"><strong>Lần mới truy cập</strong></th>
											</tr>
										</thead>
										<tbody>
                        				<?php
	                        				$where_home = $where . ' AND position = 0';
                        					$home_guest_ips = selectMulti(tbl_config::tbl_guest_ip, $field, $where_home, $sortby, $limit);
											$tt = 0;
											foreach($home_guest_ips as $home_guest_ip){
												$tt ++;
										?>
                            				<tr>
												<td align="center"><?=$tt?></td>
												<td align="center"><?=$home_guest_ip['uid']?></td>
												<td align="center"><?=$home_guest_ip['guest_ip']?></td>
												<td align="center"><?=$home_guest_ip['num_in']?></td>
												<td align="center"><?=$home_guest_ip['date_added']?></td>
												<td align="center"><?=$home_guest_ip['last_modified']?></td>
											</tr>
                            			<?php }?>
                        				</tbody>
									</table>
								</div>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
<noscript>!Cảnh báo! Javascript phải được bật để chạy được các chức năng trong phần Quản trị</noscript>

