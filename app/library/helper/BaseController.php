<?php
/**
 * author weiyuhe123@163.com
 */

class BaseController extends Controller {
	
	//public $data = array();
	
	public function error($msg) {
		$error= $this->getUtil('error'); 
		$error->send_error($msg, 'html');
	}
	
	public function dump($var){
		$debug = $this->getUtil('debug');
		$debug->dump($var);
	}
	
	/**
	 * AJAX操作统一返回值函数
	 * @param string $status 状态
	 * @param string $msg    错误信息
	 */
	/*public function ajax_return($status, $msg) {
		 $data = array(
			'username' => $this->userInfo['username'],
			'ip' => $this->controller->get_ip(),
			'controller' => $this->controller->get_gp('c'),
			'action' => $this->controller->get_gp('a'),
			'msg' => $msg,
			'data' => $this->controller->filter_escape($_POST)
		);
		if (isset($data['data']['password'])) 
			$data['data']['password'] = '******';
		if ($data['username'] == '')
			$data['username'] = $data['data']['username'];
		$this->_getAdminLogService()->addLog($data); 
		return $this->controller->ajax_return($status, $msg); 
	}*/
	
	/**
	 * 获取service对象
	 * @param string $serviceName	
	 * @param string $serviceGroup
	 * @return Service object
	 */
	protected function _getService($serviceName, $serviceGroup) {
		return InitPHP::getService($serviceName, $serviceGroup);
	}
	
	/**
	 * 公用URL组装函数
	 * @param string $c
	 * @param string $a
	 */
	public function getUrl($m, $c, $a) {
		$config = InitPHP::getConfig();
		return InitPHP::url($m . '|' . $c . '|' . $a);
	}
	
	/**
	 * 分页类
	 * @param int $count
	 */
	public function page($count, $page, $pagesize, $pagelist, $url = '') {
		
		
		$c   = $this->controller->get_gp('c');
		$a   = $this->controller->get_gp('a');
		$m	 = $this->controller->get_gp('m');
		//$url = $this->getUrl($m, $c, $a) . $url;
		$cpage= $this->getLibrary('cpage'); //分页加载
		$cpage->pager( $count , $page , $pagesize , $pagelist  , $url);
		$this->data['page'] = $cpage->getpagelist();
	}

	/**
	 * 如果POST操作都需要带Token
	 */
	public function isPostAction() {
		$isToken = $this->controller->check_token();
		if (!$isToken)  {
			return $this->controller->ajax_return(0, '非法Token！');
		}
	}
	
	/**
     * 日期处理
     */
	public function _getDateTime($dates) {
		if ($dates == '') return 0;
		$dtime[0] = substr($dates, 0, 10);
		$dtime[1] = substr($dates, -8, 8);
		$date     = explode('-', $dtime[0]);
		$time     = explode(':', $dtime[1]);
		return mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);	
	}
	
	/**
	 * 后台图片压缩 对InitPHP框架图片类进行封装
	 * @param string $source 原图片地址
	 * @param array  $param  参数
	 * 如果多张压缩图，这个数组为多维：
	 * array(
	 * 	 0=>array('_small', 50, 50)  
	 * )
	 * _small：最后图片名称 原名称：2011213902103.jpg,压缩图：2011213902103_small.jpg
	 * 如果第一个参数 _small 设置为空，则会覆盖原图
	 * 50, 50分别为：宽和高
	 */
	public function imageThumb($source, $param = array(0=>array('_small', 50, 50))) {
		$image   = $this->getLibrary('image'); //图片类加载
		$newName = str_replace(strstr($source, '.'), '', $source);
		foreach ($param as $val) {
       		$image->make_thumb($source, $newName . $val[0], $val[1], $val[2], true); //缩略图
		}
		return true;
	}


















}

?>