<?
	require_once '../config.php';
	require_once '../lib/func.lib.php';
	// Get alexa rank
	$parent = getRecord(tbl_config::tbl_category,'code = "alexa_rank"');
	$parent_id = $parent['id'];
	$last_rank = getRecord(tbl_config::tbl_site_rank);
	$current_rank = alexaRank('haytuyet.net');
	echo $last_rank['rank'].'-'.$current_rank;
	$compare_value = 'Không đổi';
	$compare = (int)$last_rank['rank'] - (int)$current_rank;
	if($compare > 0){
		$compare_value = 'Tăng '.number_format($compare).' hạng';
	}else if($compare < 0){
		$compare_value = 'Tụt '.number_format($compare).' hạng';
	}
	$fields_rank_arr = array(
		'rank'        	=> (int)$current_rank,
		'parent'		=> $parent_id,
		'compare' 		=> '"'.$compare_value.'"',
		'date_added'    => time()
	);
	$last_rank = getRecord(tbl_config::tbl_site_rank);
	if($compare != 0 && $current_rank != 0 && time()-43200 >= $last_rank['date_added']){
		$insert = insert(tbl_config::tbl_site_rank,$fields_rank_arr);
		if($insert){
			echo 'Insert rank success: '.number_format($current_rank);
		}else{
			echo 'Can not insert. Current rank: '.number_format($current_rank);
		}
	}else{
		echo 'Rank not change. Current rank: '.number_format($current_rank);
	}
?>