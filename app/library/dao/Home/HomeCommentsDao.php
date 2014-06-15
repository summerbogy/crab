<?php
/*
*评论dao
*/
 
class HomeCommentsDao extends BaseDao{
	public $collection = 'comments';
	
	 function __construct(){
		parent::__construct();
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






