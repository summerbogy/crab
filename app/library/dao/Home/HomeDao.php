<?php 
class HomeDao extends BaseDao{
	public $collection = 'article';
	
	
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
	
	public function findAndModify($query, $data, $options = array()){//通过
		return $this->mongo->findAndModify($query, $data, $options);
	}
	
	//按key去重
	public function distinct($key, $query=array()){
		$result = $this->mongo->distinct($key, $query);
		return $result;
	}
	
	public function mapreduce(){
	/* 	var key = {title:this.title,author:this.author};
		var value = {count:1};
		var ret = {count:0};
				for(var i in values) {
					ret.count += 1;
				} */
		$map = '
			 function() { emit(this.title, 1) 

		} ';
		$reduce = '
			function(key, values) { 

			var x = 0; 

			values.forEach(function(v) { x += v }); 

			return x; 

			} 
		';
		return $this->mongo->mapreduce($map, $reduce);
	
	}












}
?>