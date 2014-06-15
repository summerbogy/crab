<?php 
class AdminRuleDao extends BaseDao{
	public $collection = 'rule';
	
	
	public function getNew($query, $sort = array(), $skip = 0, $limit = 10, $fields = array()){
		$query = array('time'=>array('$lt'=>time()));
		return $this->mongo->find($query, $sort, $skip, $limit, $fields);
	}
	
	
	public function group($key='', $initial='', $reduce='', $options= array()) {//通过
		return $this->mongo->group($key, $initial, $reduce, $options);
		
	} 
	
	public function findAndModify($query, $data, $options = array()){//通过
		return $this->mongo->findAndModify($query, $data, $options);
	}
	
	//按key去重
	public function distinct($key, $query=array()){
		$result = $this->mongo->distinct($key, $query);
		return $result;
	}
	
	public function getUserByname($username){
		$query = array('username'=>$username);
		return $this->getOne($query);
	}












}
?>