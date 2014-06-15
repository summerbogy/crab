<?php 
class siteDao extends BaseDao{
	public $collection = 'site';
	
	
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
	/**
     * mapReduce分组
     *
     * @param string $table_name 表名(要操作的目标集合名)
     * @param string $map 映射函数(生成键值对序列,作为 reduce 函数参数)
     * @param string $reduce 统计处理函数
     * @param array  $query 过滤条件 如：array('uid'=>123)
     * @param array  $sort 排序
     * @param number $limit 限制的目标记录数
     * @param string $out 统计结果存放集合 (不指定则使用tmp_mr_res_$table_name, 1.8以上版本需指定)
     * @param bool   $keeptemp 是否保留临时集合
     * @param string $finalize 最终处理函数 (对reduce返回结果进行最终整理后存入结果集合)
     * @param string $scope 向 map、reduce、finalize 导入外部js变量
     * @param bool   $jsMode 是否减少执行过程中BSON和JS的转换，默认true(注：false时 BSON-->JS-->map-->BSON-->JS-->reduce-->BSON,可处理非常大的mapreduce,//true时BSON-->js-->map-->reduce-->BSON)
     * @param bool   $verbose 是否产生更加详细的服务器日志
     * @param bool   $returnresult 是否返回新的结果集
     * @param array  &$cmdresult 返回mp命令执行结果 array("errmsg"=>"","code"=>13606,"ok"=>0) ok=1表示执行命令成功
     * @return
     *
    /*function mapReduce($table_name,$map,$reduce,$query=null){
     if(empty($table_name) || empty($map) || empty($reduce)){
      return null;
     }
     $map = new MongoCode($map);
     $reduce = new MongoCode($reduce);
     if(empty($out)){
      $out = 'tmp_mr_res_article';
     }
     $cmd = array(
       'mapreduce' => $table_name,
       'map'       => $map,
       'reduce'    => $reduce,
       'out'  =>$out
     );
      if(!empty($query) && is_array($query)){
      array_push($cmd, array('query'=>$query));
     }
     if(!empty($sort) && is_array($sort)){
      array_push($cmd, array('sort'=>$query));
     }
     if(!empty($limit) && is_int($limit) && $limit>0){
      array_push($cmd, array('limit'=>$limit));
     } 
     if(!empty($keeptemp) && is_bool($keeptemp)){
      array_push($cmd, array('keeptemp'=>$keeptemp));
     }
     if(!empty($finalize)){
      $finalize = new Mongocode($finalize);
      array_push($cmd, array('finalize'=>$finalize));
     }
     if(!empty($scope)){
      array_push($cmd, array('scope'=>$scope));
     }
     if(!empty($jsMode) && is_bool($jsMode)){
      array_push($cmd, array('jsMode'=>$jsMode));
     }
     if(!empty($verbose) && is_bool($verbose)){
      array_push($cmd, array('verbose'=>$verbose));
     }
     $dbname = $this->curr_db_name;
	 var_dump($dbname);
	
     $cmdresult = $this->mongo->command($cmd); //var_dump($cmdresult);
	 $this->collection = 'tmp_mr_res_article';
	 $this->mongo->selectCollection($this->collection);
	 $aa = $this->mongo->find();
	 var_dump($aa);
      if($returnresult){
      if($cmdresult && $cmdresult['ok']==1){
       $result = $this->getAll($out, array());
      }
     }
     if($keeptemp==false){
      //删除集合
      $this->mongo->$dbname->dropCollection($out);
     } 
	 
	$result = $this->mongo->find($out, array());
    return $result;
    }*/












}
?>