<?php

class BaseAdminController extends BaseController {
	protected $_AdminService = '';
	public $data =array();

	public $initphp_list = array('run','login', 'verify', 'general',
							'checkLogin', 'def');
							
	public function before(){
		$this->_AdminService = $this->_getService('Admin', 'Admin');
		$action = $this->controller->get_gp('a');
		$state = $this->userState();
		$access = array('login', 'verify');
		if(!$state && !in_array($action ,$access)) 
			$this->controller->redirect('/?m=Admin&c=index&a=login');   
	}

	public function after(){
		$c = $this->controller->get_gp('c');
		$a = $this->controller->get_gp('a');
		if (!($c == 'index' && $a == 'run') && !($c == 'index' && $a == 'login')) {
			$this->view->set_tpl('Admin/common/header', 'F');	
			$this->view->set_tpl('Admin/common/footer', 'L');	
		}
		$this->view->assign('data', $this->data);
		$this->view->display();
	}

	public function run() {
		$this->view->assign('data', $this->data);
		$this->view->set_tpl('Admin/index/index_run');

	}
	public function userState() {//通过
		$userInfo = $this->_AdminService->checkUserState();
		return $userInfo;
	}
	
	public function def(){
		$phpInfo = array();
		$phpInfo['version']     = PHP_VERSION;
		$phpInfo['system']      = PHP_OS;
		$phpInfo['max_time']    = ini_get("max_execution_time")." 秒";
		$phpInfo['max_upload']  = ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled";
		if(function_exists("gd_info")){
			$gd = gd_info();
			$phpInfo['gd'] = $gd["GD Version"];
		}else{
			$phpInfo['gd'] = "<span style='color:red'>Unknow</span>";
		}
		$phpInfo['now_time'] = date("Y-m-d H:i:s");
		$phpInfo['memory']   =  get_cfg_var("memory_limit") ? get_cfg_var("memory_limit") : "无";
		$phpInfo['server']   =  $_SERVER ['SERVER_SOFTWARE']; 
		$phpInfo['zend']     =  zend_version(); 
		$this->view->assign('phpInfo', $phpInfo);
		$this->view->set_tpl('Admin/index/index_default');
	}
	public function login(){ //通过
		$verify = '/?m=Users&c=index&a=verify';
		$this->view->assign("verify", $verify);
		$this->view->set_tpl('Admin/index/index_login');
		$this->view->display();

	}

	public function verify(){ //通过
		$code = $this->getLibrary('code');
		//$this->dump($code);
		$code->getcode('admin'); //可以带上key，区分不同用法的验证码

	}

	public function checkLogin(){ //待改进
		$username = $this->controller->get_gp('username');
		$password = $this->controller->get_gp('password');
		$ip = $this->controller->get_ip();
		$result = $this->_AdminService->checkUser($username, $password, $ip);
		if ($result[0] == false) {
			//$this->_AdminService->addLoginError($ip, $info['username']);
			$this->controller->ajax_return($result[0], $result[1]);
		}else{	
			$this->controller->redirect('/?m=Admin&c=index&a=run');
		}
		//$this->controller->redirect('Home','index', 3,'登录成功！');

	}
	
	/**
	 * 后台防止暴力破解
	 * @param string $ip
	 */
	public function checkLoginErrorNum($ip) { //未改
		$time     = 60 * 60; // 一个小时
		$allowNum = 5; //每小时5次 
		$AdminUserLoginDao = $this->_getAdminUserLoginDao(); //获取AdminUserLoginDao
		$num  = $AdminUserLoginDao->getCount($ip, $time);
		if ($num < $allowNum) return true;
		return false;
	}
	

	
	
	
}