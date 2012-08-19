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
	const tbl_category 		= 'xteam_category';
	const tbl_static 		= 'xteam_static';
	const tbl_content 		= 'xteam_content';
        const tbl_product		= 'xteam_product';
        const tbl_product_extend	= 'xteam_product_extend';
        const tbl_properties		= 'xteam_properties';
	const tbl_news 			= 'xteam_news';
	const tbl_contact 		= 'xteam_contact';
	const tbl_controller            = 'xteam_controller';
	const tbl_controller_per        = 'xteam_controller_per';
	const tbl_member 		= 'xteam_member';
	const tbl_guest_ip 		= 'xteam_guest_ip';
	const tbl_site_rank             = 'xteam_site_rank';
	const tbl_config 		= 'xteam_config';
	const tbl_visitor 		= 'xteam_visitor';
	const tbl_total_visits          = 'xteam_total_visits';
}
include '#connect/config.php';
?>
