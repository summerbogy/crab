<?php
abstract class BaseDao extends Dao{
	protected $collection = '';
	/**
	 * 缓存KEY
	 * @param string $data
	
	
	public function cacheKey($data) {
		if(!$data) return true;
		foreach($data as $key=>$val){
			$val = substr() $string .= $key . $val;
		}
		return $this->collection . $string;
	} */
	
	public function __construct(){
		$this->mongo = $this->getMongo();
		$this->mongo->selectCollection($this->collection);
		return $this->mongo;
	}
	
	
	
	/*
	*统计
	*/
	public function getCounts($query) {
		return $this->mongo->count($query);
	}
	
	/*
	*获取一个
	*/
	public function getOne($query){
		return $this->mongo->findOne($query);
	}
	
	public function getAll($query = array(), $sort = array(), $skip = 0, $limit = 10, $fields = array()){
		return $this->mongo->find($query, $sort, $skip, $limit, $fields);
	}
	
	public function update($query, $data){//通过
		if(!$query or !$data) return false;
		$this->mongo->update($query,$data);
	}
	
	public function insert($data, $options = array()){//通过
		if(empty($data)) return false;
		$this->mongo->insert($data, $options);
	}
	public function delete($query, $options = array()){//通过
		if(!$query) return false;
		return $this->mongo->remove($query, $options);
	}
	
	public function count($query){
		return $this->mongo->count($query);
	}
		
	








}

?>