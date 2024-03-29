<?php
/*
* 用户service
* @author weiyuhe123@163.com
*/
class UcenterService extends Service {
	
	public $_dao = '';//调用dao的游标
	public $_uDao = '';
	
	/*
	*
	*/
	public function __construct() {
		$this->_dao = InitPHP :: getDao('Common', 'Common');//获得CommonDao类的工厂接口
		$this->_uDao = $this->_dao->fDao('Ucenter', 'Ucenter');
	}
	public function getAll($query, $option){
		return $this->_uDao->getAll($query, $option);//
	}
	
	/**
	 * 检测用户是否是登录状态
	 */
	public function checkUserState() {
			if(isset($_SESSION['_id']) && isset($_SESSION['username'])){
				$_id = new mongoId($_SESSION['_id']);
				$userData = $this->_uDao->getOne(array('_id'=>$_id, 'username'=>$_SESSION['username']));
			}else{
				$cookie   = $this->getUtil('cookie');
				//$cookie->del('crab_running');
				$userInfo = $cookie->get('crab_running');
				
				if (!$userInfo) return false;
				$function = $this->getLibrary('function');
				$userInfo = $function->str_code($userInfo, ADMIN_KEY, 'DECODE');
				$userInfo = explode("\t", $userInfo);
				$userData = $this->getUser($userInfo[1]);
				
			}
			$this->register_global('userData', $userData);//将用户信息注册全局变量
		return $userData;
		
	}
	
	/**
	 * 通过UID获取用户信息接口
	 * 参数：
	 * uid = 1
	 * @param int $uid 用户UID
	 * @return Array
	 */
	public function getUser($_id) {//通过
		if($_id =='') return false;
		$_id = new mongoId($_id);
		$query = array('_id'=>$_id);
		$userInfo = $this->_uDao->getOne($query);
		return $userInfo;
	}
	/**
	 * 检测用户是否已经登录
	 * @param string $username 用户名
	 * @param string $password 密码
	 * @return ArrayIterator
	 */
	public function checkUser($username, $password, $ip) {
		if (!$username || !$password) {
			return $this->return_msg($state = false, 'username or passw are empty');
		}
		$userInfo = $this->_uDao->getUserByname($username);
		if (!$userInfo['username']) {
			return $this->return_msg($state = false, 'user is not exist');
		}
		
		$checkPassword = $this->_password($password, $userInfo['hash']);
		if ($checkPassword !== $userInfo['password']) {
			return $this->return_msg($state = false, 'password error');
		}
		$time = time();
		$update =  array('$set'=>array('lastlogin'=>$time, 'ip'=>$ip));
		$this->_uDao->update(array('username'=>$userInfo['username'], 'password'=>$userInfo['password']), $update);
		//var_dump($userInfo);
		/* session */
		$session = $this->getUtil('session');
		$session->set('uid', $userInfo['uid']);
		$session->set('_id', $userInfo['_id']);
		$session->set('username', $userInfo['username']);
		/* cookie */
		$str = '';
		$str .= $time . "\t";
		$str .= $userInfo['_id'] . "\t";
		$str .= $userInfo['username'] . "\t";
		$str .= $userInfo['uid'] . "\t";
		$str .= $userInfo['password'] . "\t";
		$str .= $ip; 
		$function = $this->getLibrary('function');
		$str = $function->str_code($str, ADMIN_KEY, 'ENCODE');
		$cookie = $this->getUtil('cookie');
		$cookie->set('crab_running', $str, 0, '/'); 
		$c = $cookie->get('crab_running');
		$c = $function->str_code($c, ADMIN_KEY, 'DECODE');
		$c = explode("\t",$c);//不能使用'\t'
		return $c;
	}
	
	/*
	 *
	 */
	public function addUser($data){
		if(!is_array($data)) return false;
		$userDao = $this->_dao->fDao('Ucenter', 'Ucenter');
		$r = $userDao->add($data);
		return $r ? true : false;
	
	}
	
	public function _password($password, $hash){
		$relpassword = md5($password.$hash);
		return $relpassword;	
	}
	
	public function visitLog($info, $act){
		$query = array('info'=>$info, 'ip'=>'127.0.0.1','time'=>time(), 'visitnum'=>1, 'actNum'=>1, 'act'=>$act );
		$visit = $this->_dao->fDao('HomeVisit', 'Home');
		$update = array('$inc'=>array('visitnum'=>1, 'actNum'=>1));
		$result = $visit->findAndModify(array('info'=>$info, 'act'=>$act),$update);
		if(empty($result)){
			$visit->insert($query);
			$result = $visit->getOne($query);
		}
		return  $result;
	}

	
	public function return_msg($status, $msg, $data = '') {
		return array($status, $msg, $data);
	}
	
	public function getNewArt($username){
		$art = $this->_dao->fDao('HomeArt', 'Home');
		$query = array('author'=>$username);
		$newArt = $art->getNew($query);
		return $newArt;
	
	
	}
 








}
?>