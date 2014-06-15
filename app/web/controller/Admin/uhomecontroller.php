<?php
//InitPHP::import('library/helper/BaseUserController.php');
class uhomecontroller extends Controller {

	public $initphp_list = array('run','login', 'verify', 'register', 'checklogin', 'checkRegister');
	
	public function before(){
	
	}
	
	public function after(){
		$this->view->display();
	}
	public function run(){
		$this->view->set_tpl('Users/uhome');
	}






























}