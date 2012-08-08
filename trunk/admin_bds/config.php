<?
date_default_timezone_set('Asia/Bangkok');
// Set System data:
class system_config{
	const visitorTimeout 	= 3600;
	const maxpage 			= 20;
	const maxpageclient		= 10;
	const multiLanguage 	= 1; /* 0 : single  ;  1 : multi */
	
	public function inLocal(){
		return $_SERVER['HTTP_HOST']=='localhost'?'/batdongsan/':'/';
	}
	public function curHost(){
		return 'http://'.$_SERVER['HTTP_HOST'].$this->inLocal();
	}
	public function arrLanguage(){
		return array(array('vn','Việt Nam'),array('en','English'));
	}
	public function randNum(){
		return date('dmYH');
	}
	public function frame(){
		return $_REQUEST['frame'];
	}
        public function para_request($para_name){
                // para_name: frame, parent, cat, id, page
		return $_REQUEST[$para_name];
	}
	public function cTitle(){
		return $_REQUEST['cTitle'];
	}
	public function cTitle2(){
		return $_REQUEST['cTitle2'];
	}
	public function pTitle(){
		return $_REQUEST['pTitle'];
	}
}
// Set Table data:
class tbl_config{
	const tbl_category 		= 'tddb_category';
	const tbl_content 		= 'tddb_content';
	const tbl_news 			= 'tddb_news';
	const tbl_contact 		= 'tddb_contact';
	const tbl_controller            = 'tddb_controller';
	const tbl_controller_per        = 'tddb_controller_per';
	const tbl_member 		= 'tddb_member';
	const tbl_guest_ip 		= 'tddb_guest_ip';
	const tbl_site_rank             = 'tddb_site_rank';
	const tbl_config 		= 'tddb_config';
	const tbl_visitor 		= 'tddb_visitor';
	const tbl_total_visits          = 'tddb_total_visits';
}
include '#connect/config.php';
?>
