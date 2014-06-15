<?php

class BaseUserController extends BaseController {

	protected $_uService = '';
	protected $data =array();
	public $initphp_list = array('run','login', 'verify', 'general',
							'checkLogin', 'submit','', 'addArt',
							'artManage', 'modifyInfo', 'visitor','addmblog'
							);


	public function before(){
		$this->_uService = $this->_getService('Ucenter', 'Ucenter');
		$action = $this->controller->get_gp('a');
		$access = array('login', 'checkLogin', 'verify'); 
		if(!in_array($action ,$access)){
			$state = $this->userState();
			if(!$state)	$this->controller->redirect('/?m=Ucenter&c=index&a=login'); 
		}
	}

	public function after(){
		$this->view->assign('data', $this->data);
		//$this->view->display();
	}

	public function run() {
		

	}
	public function userState() {//通过
		$userInfo = $this->_uService->checkUserState();
		$this->register_global('userInfo', $userInfo);
		//$this->dump($this->userInfo);
		return $userInfo;
	}

	public function login(){ //通过
		$verify = '/?m=Ucenter&c=index&a=verify';
		$this->view->assign("verify", $verify);
		$this->view->set_tpl('Ucenter/login');
		$this->view->display();

	}

	public function verify(){ //通过
		$code = $this->getLibrary('code');
		$code->getcode('Ucenter');  //可以带上key，区分不同用法的验证码
	}

	
	
	/*
	*注册
	*/
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
	

	
	
	
}