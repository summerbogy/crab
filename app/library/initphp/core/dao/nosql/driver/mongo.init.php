<?php
if (!defined('IS_INITPHP')) exit('Access Denied!');
/*********************************************************************************
 * InitPHP 3.3 国产PHP开发框架  Dao-Nosql-Mongo 
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 *-------------------------------------------------------------------------------
 * $Author:zhuli
 * $Dtime:2013-5-29 
 * $Modify BY crab running
 * $Mtime :2014-5-18
***********************************************************************************/
class mongoInit {
	
	protected $cursor = '';
	private $mongo; //mongo对象
	private $db; //db mongodb对象数据库
	private $collection; //集合，相当于数据表 
	
	/**
	 * 初始化Mongo
	 * $config = array(
	 * 'server' => ‘127.0.0.1' 服务器地址
	 * ‘port’   => '27017' 端口地址
	 * ‘option’ => array('connect' => true) 参数
	 * 'db_name'=> 'test' 数据库名称
	 * ‘username’=> 'zhuli' 数据库用户名
	 * ‘password’=> '123456' 数据库密码
	 * )
	 * Enter description here ...
	 * @param unknown_type $config
	 */
	public function init($config = array()) {
		$config['password'] = '123456';
		$config['username'] = 'root';
		if ($config['server'] == '')  $config['server'] = '127.0.0.1';
		if ($config['port'] == '')  $config['port'] = '27017';
		if (!$config['option']) $config['option'] = array('connect' => true);
		$server = 'mongodb://' . $config['server'] . ':' . $config['port'];
		$this->mongo = new MongoClient($server, $config['option']);
		if ($config['db_name'] == '') $config['db_name'] = 'crab';
		$this->db = $this->mongo->selectDB($config['db_name']);
		if ($config['username'] != '' && $config['password'] != '') 
			$this->db->authenticate($config['username'], $config['password']);
			
	}
	
	/**
	 * 选择一个集合，相当于选择一个数据表
	 * @param string $collection 集合名称
	 */
	public function selectCollection($collection) {
		return $this->collection = $this->db->selectCollection($collection);
	}
	
	/**
	 * 新增数据
	 * @param array $data 需要新增的数据 例如：array('title' => '1000', 'username' => 'xcxx')
	 * @param array $option 参数
	 */
	public function insert($data, $option = array()) {
		return $this->collection->insert($data, $option);
	}
	
	/**
	 * 批量新增数据
 	 * @param array $data 需要新增的数据 例如：array(0=>array('title' => '1000', 'username' => 'xcxx'))
	 * @param array $option 参数
	 */
	public function batchInsert($data, $option = array()) {
		return $this->collection->batchInsert($data, $option);
	}
	
	/**
	 * 保存数据，如果已经存在在库中，则更新，不存在，则新增
 	 * @param array $data 需要新增的数据 例如：array(0=>array('title' => '1000', 'username' => 'xcxx'))
	 * @param array $option 参数
	 */
	public function save($data, $option = array()) {
		return $this->collection->save($data, $option);
	}
	
	/**
	 * 根据条件移除
 	 * @param array $query  条件 例如：array(('title' => '1000'))
	 * @param array $option 参数
	 */
	public function remove($query, $option = array()) {
		return $this->collection->remove($query, $option);
	}
	
	/**
	 * 根据条件更新数据
 	 * @param array $query  条件 例如：array(('title' => '1000'))
 	 * @param array $data   需要更新的数据 例如：array(0=>array('title' => '1000', 'username' => 'xcxx'))
	 * @param array $option 参数
	 */
	public function update($query, $data, $option = array()) {
		return $this->collection->update($query, $data, $option);
	}
	
	/**
	 * 根据条件查找一条数据
 	 * @param array $query  条件 例如：array(('title' => '1000'))
	 * @param array $fields 参数
	 */
	public function findOne($query, $fields = array()) {
		return $query ? $this->collection->findOne($query, $fields) : $this->collection->findOne();
	}
	
	/**
	 * 根据条件查找一条数据
 	 * @param array $query  条件 例如：array(('title' => '1000'))
	 * @param array $fields 参数
	 */
	public function getOneById($_id, $fields = array()) {
		$_id = new mongoId($_id);
		return $this>findOne(array('_id'=>$_id), $fields);
	}
	
	/**
	 * 根据条件查找多条数据
	 * @param array $query 查询条件
	 * @param array $sort  排序条件 array('age' => -1, 'username' => 1)
	 * @param int   $limit 页面
	 * @param int   $limit 查询到的数据条数
	 * @param array $fields返回的字段
	 */
	public function find($query = '', $sort = array(), $skip = 0, $limit =2, $fields = array()) {
		$this->cursor = $query ? $this->collection->find($query, $fields) : $this->collection->find();
		if ($sort)   $this->cursor->sort($sort);
		if ($skip)  $this->cursor->skip($skip);
        if ($limit) $this->cursor->limit($limit);
		return iterator_to_array($this->cursor);
	}
	
	/**
	 * 数据统计
	 * @param array $query 统计条件
	 */
	public function count($query = array()) {
		return $this->collection->count($query);
	}
	/**
	 * 错误信息
	 */
	public function error() {
		return $this->db->lastError();
	}
	
	/**
	 * 获取集合对象
	 */
	public function getCollection() {
		return $this->collection;
	}
	
	/**
	 * 获取DB对象
	 */
	public function getDb() {
		return $this->db;
	}
	
	/**
	 * 释放结果游标
	 */
	public function free(){
		$this->cursor = null;
	}
	
	
	/*
	 * 分组
	 * @param array $key  按$key进行分组,形式：array('init'=>1)
	 * @param array $init  初始文档
	 * @param string $reduce js函数function (obj, prev)  obj指当前文档(对应当前collection),prev 初始文档(对应$init)
	 * @param array $options 更多选项，如查询条件...
	*/
	public function group($key, $init, $reduce, $options = array()){
		return $this->collection->group($key, $init, $reduce, $options);
	}
	
	 /**
     * 执行命令 mongo 所有CURD 都可以通过command来实现
     * @param array $command  指令 example： array("distinct" => "collectionName", "key" => "age") 按键名age去重复查找
     * @return array
	 * 
     */
    public function command($cmd){
        return $this->db->command($cmd);
		
    }
	
	 /**
     * 查找并更改
     * @ param array 查询条件
	 * @ parm array 更新的数据
     * @ param array $field  返回的字段 
     * @ return array 返回的结果集
     */
	public function findAndModify($query, $data = array(), $options = array()){
		return $this->collection->findAndModify($query, $data, $options);
	
	}
	
	/**
	 * mapreduce 方法
	 * @param  js function $map 映射函数
	 * @param js function $reduce  统计处理函数
	 * @param string outputCollection 统计结果存放集合
	 
	 * @param array  $query 过滤条件 如：array('uid'=>123)
     * @param array  $sort 排序
     * @param number $limit 限制的目标记录数
     * @param string $out 统计结果存放集合 (不指定则使用tmp_mr_res_$table_name, 1.8以上版本需指定)
     * @param bool   $keeptemp 是否保留临时集合
     * @param string $finalize 最终处理函数 (对reduce返回结果进行最终整理后存入结果集合)
     * @param string $scope 向 map、reduce、finalize 导入外部js变量
     * @param bool   $jsMode 是否减少执行过程中BSON和JS的转换，默认true(注：false时 BSON-->JS-->map-->BSON-->JS-->reduce-->BSON,可处理非常大的mapreduce,//true时BSON-->js-->map-->reduce-->BSON)
     * @param bool   $verbose 是否产生更加详细的服务器日志
	
	 */
	
	public function mapReduce($map, $reduce, $outputCollection = '',$query = null, $sort = null, $limit = null, $keeptemp = true, $finalize = null, $scope = null, $jsMode = true, $verbose = true){
		if(empty($map) || empty($reduce)) return false;
		if(empty($outputCollection)) $outputCollection = 'tmp_mr_res_'.$this->collection->getName();
		$cmd = array('mapreduce'=>$this->collection->getName(),
					'map'=>$map,
					'reduce'=>$reduce,
					'out'=>$outputCollection);
	    if(!empty($query) && is_array($query)){
			$cmd['query'] = $query;
		}
		if(!empty($sort) && is_array($sort)){
			$cmd['sort'] = $query;
		}
		if(!empty($limit) && is_int($limit) && $limit>0){
			$cmd['limit'] = $limit;
		}
		if(!empty($keeptemp) && is_bool($keeptemp)){
			$cmd['keeptemp'] = $keeptemp;
		}
		if(!empty($finalize)){
			$finalize = new Mongocode($finalize);
			$cmd['finalize'] = $finalize;
		}
		if(!empty($scope)){
			$cmd['scope'] = $scope;
		}
		if(!empty($jsMode) && is_bool($jsMode)){
			$cmd['jsMode'] = $jsMode;
		}
		if(!empty($verbose) && is_bool($verbose)){
			$cmd['verbose'] = $verbose;
		}
		$cmdResult = $this->command($cmd);
		if($cmdResult['ok'] == 1){
			$this->selectCollection($outputCollection);
			$result = $this->find(); 	
		}else{
			return false;
		}
		if(isset($keeptemp) && $keeptemp==false) $this->mongo->$dbname->dropCollection($out);//删除集合
		return $result;
	}
	
	
	/**
	 * 按$key去重复
	 *	@param string 键名
	 *	@param query 查询条件
	 *  @return array 
	 */
	public function distinct($key, $query = array()){
		return $this->collection->distinct($key, $query);
	}
	
}