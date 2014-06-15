<?php
/*
* 用户service
* @author weiyuhe123@163.com
*/
class UcenterUhomeService extends Service {
	
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

	public function getAllCount(){
		$mblog = $this->_dao->fDao('HomeMblog', 'Home');
		$count['mblogCount'] = $mblog->count();
		$art = $this->_dao->fDao('HomeArt', 'Home');
		$count['artCount'] = $art->count();
		
		return $count;
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

	public function delArt($id){
		if($id == '') return false;
		$_id = new mongoId($id);
		$query = array('_id'=>$_id);
		$art = $this->_dao->fDao('HomeArt', 'Home');
		$res = $art->delete($query);
		return $res;
	
	}
	
	public function return_msg($status, $msg, $data = '') {
		return array($status, $msg, $data);
	}
	
	public function getNewArt($username){
		$art = $this->_dao->fDao('HomeArt', 'Home');
		$query = array('author'=>$username);
		$newArt = $art->getNew();//$query);
		return $newArt;
	
	
	}
 








}
?>