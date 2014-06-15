<?php

class indexController extends BaseUserController {
	
	protected $_uhService = '';
	protected $data =array();
	//全局变量：$userData;
	//白名单
	public $initphp_list = array('run','login', 'verify', 'general',
							'checkLogin', 'submit','', 'addArt',
							'artManage', 'modifyInfo', 'delArt','addmblog', 'makeComment'
							);


	public function before(){
		parent::before();
		$this->_uhService = $this->_getService('UcenterUhome', 'Ucenter');
		
	}
	public function after(){
		$this->view->assign('data', $this->data);
		$this->view->display();
	}

	 public function run() {
		
		$this->controller->redirect('/?m=Ucenter&c=uhome&a=run'); 

	}
/* 	public function userState() {//通过
		$userInfo = $this->_uService->checkUserState();
		return $userInfo;
	}  */

	public function login(){ //通过
		$verify = '/?m=Ucenter&c=index&a=verify';
		$this->view->assign("verify", $verify);
		$this->view->set_tpl('Ucenter/login');
		$this->view->display();

	}


	public function checkLogin(){ //待改进
		$username = $this->controller->get_gp('username');
		$password = $this->controller->get_gp('password');
		$verify = $this->controller->get_gp('verify');
		$code = $this->getLibrary('code');
		if(!$code->checkCode($verify, 'Ucenter')) {
			$this->controller->ajax_return(false, 'verify fail');
		}
		$ip = $this->controller->get_ip();
		$check = $this->_uService->checkUser($username, $password, $ip);
		if ($check[0] == false) {
			//$this->_AdminService->addLoginError($ip, $info['username']);
			$this->controller->ajax_return($check[0], $check[1]);
		}else{
			$this->controller->ajax_return($check[0], $check[1]);
		}
	}
	
		public function register(){
		$this->view->set_tpl('Users/register');
		$this->view->display();
	}
	

	public function checkRegister(){
		$data['username'] = $this->controller->get_gp('username');
		$data['password'] = $this->controller->get_gp('password');
		$data['email'] = $this->controller->get_gp('email');
		$data['nickname'] = $this->controller->get_gp('nickname');
		$verify = md5($this->controller->get_gp('verify'));
		if(!$data['username'] || !$data['password'] || !$data['email'] || !$data['nickname'] || !$verify)	return false;
		if($this->getLibrary('code')->checkCode($verify, 'users') == false)	return false;
		$data['ip'] = $this->controller->get_ip();
		$data['hash'] = mt_rand(713, 2014);
		$userService = $this->_getService('Users', 'Users');	
		if($userService->addUser($data)){
			$this->controller->redirect($this->getUrl('Users', 'uhome', 'run'), 3, '恭喜你成为我们的一员');
			$this->register_global('userInfo', $data);
		}else{
			$this->error('呵呵，哪里出错了额~！');
		}
	} 
	
	
	public function makeComment(){
		$this->dump($this->userInfo);
	
	}
	
	
}