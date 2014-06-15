<?php 
class HomeTagsDao extends BaseDao{
	public $collection = 'tags';
	public $mongo = '';
	
	 function __construct(){
		$this->mongo = $this->getMongo();
		$this->mongo->selectCollection($this->collection);
		return $this->mongo;
	}
	
	
/* 	public function getNew($query, $sort = array(), $skip = 0, $limit = 10, $fields = array()){
		$query = array('time'=>array('$lt'=>time()));
		return $this->mongo->find($query, $sort, $skip, $limit, $fields);
	}
	
	public function getHot($query, $sort = array('clicknum'=>1), $skip = 0, $limit = 10, $fields = array()){
		$query = array('time'=>array('$lt'=>time()));
		return $this->mongo->find($query, $sort = array(), $skip, $limit, $fields);
	} */
	
	
	public function group($key='', $initial='', $reduce='', $options= array()) {//通过
		
		return $this->mongo->group($key, $initial, $reduce, $options);
		
	} 
	
	public function findAndModify($query, $data, $options){//通过
		return $this->mongo->findAndModify($query, $data, $options);
	}














}
?>