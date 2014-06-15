<?php
if (!defined('IS_INITPHP')) exit('Access Denied!');
/*********************************************************************************
 * InitPHP 3.3 国产PHP开发框架  Dao-pdo 基类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 *-------------------------------------------------------------------------------
 * $Author:crab 
 * $Dtime:2014-4-27 
***********************************************************************************/
class pdoInit extends dbbaseInit{
	public $link_id; 				 //链接对象 
	protected $PDOStatement = null; //PDOStatement对象
	protected $isPrepared = false; //是否已经预处理
	protected $numRows = '';      //上一次操作影响的行数
	protected $transTimes = 0;	 //事务开启的次数
	 
	/**
	 * MYSQL连接器
	 * @param  string $host sql服务器
	 * @param  string $user 数据库用户名
	 * @param  string $password 数据库登录密码
	 * @param  string $database 数据库
	 * @param  string $charset 编码
	 * @param  string $pconnect 是否持久链接
	 * @return source
	 */
	 public function connect($host, $user, $password, $database, $charset = 'utf8', $pconnect = 0) {
		$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '" . $charset . "' ");
		$options_p = array(PDO::ATTR_PERSISTENT=>true, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES '" . $charset . "' ");
		if($pconnect == 0) {
			$this->link_id = new PDO('mysql:host=' . $host . ';dbname=' . $database ,$user, $password, $options ); 
		}else{
			$this->link_id = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $password, $options_p); 
		}
		$this->link_id->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);  
		//if (!$this->link_id) InitPHP::initError('pdo connect error!');		
		return $this->link_id;
	}
	/**
	 * SQL执行器
	 * @param  string $sql  SQL语句
	 * @param  array  $bind 参数绑定
	 */
	public function query($sql, $bind = array()) {	//通过	
		if(empty($bind)) {
			$this->PDOStatement = $this->link_id->query($sql);
		}else{
			if($this->PDOStatement) $this->free_result(); //释放前次的查询结果
			$this->PDOStatement = $this->link_id->prepare($sql, $bind);
			$this->bindPdoParam($bind);
			$result = $this->PDOStatement->execute();
		}
		$this->num_Rows();	
	}
	
	/**
	 * 释放结果内存
	 */
	public function free_result() {
		$this->PDOStatement = null;
	}
	
	/**
	 * 绑定参数
	 * @bind array 
	 */
	public function bindPdoParam($bind) {
		foreach ($bind as $name => &$value) {
            if (is_bool($value)) {
                $type = PDO::PARAM_BOOL;
            } elseif (is_int($value)) {
                $type = PDO::PARAM_INT;
            } else {
                $type = PDO::PARAM_STR;
            }
            $parameter = is_int($name) ? ($name + 1) : $name;
			$this->PDOStatement->bindParam($parameter, $value, $type);
        }	
	}
	
	/**
     * 执行语句
     * @access public
     * @param string $str  sql指令
     * @param array $bind 参数绑定
     * @return integer
     */
	public function execute($sql, $bind = array()){	 //通过
		if (!$this->_linkID )   return false;
		if(!$this->isPrepared)  $this->prepare($sql);
		if($this->PDOStatement) $this->free_result(); //释放前次的查询结果
		if(!empty($bind))		$this->bindPdoParam($bind);        
        $result = $this->PDOStatement->execute();
		if($result === false) $this->error();
		$this->num_Rows();
	}
	
	/*
	 * 执行预处理语句 
	 * @param string $sql 预处理的SQL语句
	 * return void 
	 */
	public function prepare($sql){ //通过
		if(!$this->link_id || $sql == '') return false;
		if($this->isPrepared) InitPHP::initError('This statement has been prepared already');
		$this->link_id->prepare($sql);
		$this->isPrepared = true;
	}
	
	 /**
     * @return bool
     */
    public function isPrepared() {
        return $this->isPrepared;
    }
	
	/**
	 * 开始事务操作
 	 * DAO中使用方法：$this->dao->db->transaction_start()
	 */
	public function transaction_start() {
		if($this->transTimes > 1) return true;//事务嵌套时只提交/回滚最外层的事务
		if($this->transTimes == 0)  $this->link_id->beginTransaction();
		$this->transTimes++;
		return ;
	}

    /**
     * 用于非自动提交状态下面的查询提交
     * @return boolen
     */
    public function transaction_commit() {
		if($this->transTimes > 1) return true; //事务嵌套时只提交/回滚最外层的事务
		if($this->transTimes > 0){
			$result = $this->link_id->commit();
			if(!$result)	return false;
			$this->transTimes = 0;
		}
        return true;
    }
	
	 /**
     * 事务回滚
     * @return boolen
     */
    public function transaction_rollback() {
		if($this->transTimes > 1) return true; //事务嵌套时只提交/回滚最外层的事务
		if($this->transTimes > 0) {
			$result = $this->link_id->rallback();
			if(!$result) return false;
			$this->transTimes = 0;
		}
        return true;
    }
	
	/*
	 *获得一行查询结果
	 *
	 */
	public function getResult($sql, $bind = false){
		$bind ? $this->query($sql,$bind) : $this->query($sql);
		return $this->fetch_assoc();
	}
	
	/*
	 *获得所有查询结果
	 *
	 */
	public function getAllResult($sql, $bind = false){
		$bind ? $this->query($sql,$bind) : $this->query($sql);
		return $this->fetch_all();
	}
	
	public function fetch_all(){
		if(!$this->PDOStatement) {
			$InitPHP_conf = InitPHP::getConfig();
			return $InitPHP_conf['is_debug'] ?	InitPHP::initError('PDOStatement is unexist') : false;
		} 
		return  $this->PDOStatement->fetchAll(PDO::FETCH_ASSOC);
	
	}
   

	/**
	 * 结果集中的行数 PDO支持此功能
	 * @return array
	 */
	public function result() {
		// Not needed for PDO
		$InitPHP_conf = InitPHP::getConfig();
		return $InitPHP_conf['is_debug'] ? InitPHP::initError('pdo unsuported this feature') : true; 
		return true;
	}
		
	/**
	 * 从结果集中取得一行作为关联数组
	 * @return array
	 */
	public function fetch_assoc() {
		if(!$this->PDOStatement) return false;
		return  $this->PDOStatement->fetch(PDO::FETCH_ASSOC);
	}
	
	/**
	 * 从结果集中取得列信息并作为对象返回
	 * 
	 */
	public function fetch_fields() {
		// Not needed for PDO
		$InitPHP_conf = InitPHP::getConfig();
		return $InitPHP_conf['is_debug'] ? InitPHP::initError('pdo unsuported this feature') : true;	
	}
	
	
	/**
	 * 结果集中的字段数量
	 * @return int
	 */
	public function num_fields() {//通过
		return $this->PDOStatement->columnCount();
	}
	
	/**
	 * 结果集中的行数
	 * @return int
	 */
	public function num_rows() {//通过
		if (is_int($this->numRows)) {
			return $this->numRows;
		}elseif(($this->numRows = $this->PDOStatement->rowCount()) > 0) {
			return $this->numRows;
		}else{
			$this->numRows = count($this->PDOStatement->fetchAll(PDO::FETCH_ASSOC));
			$this->PDOStatement->execute(); 
			return $this->numRows;
		}
	}
	/**
	 * 获取上一INSERT的ID值
	 * @return Int
	 */
	public function insert_id($id = null) {
		return $this->link_id->lastInsertId($id) ;
	}
	
	/**
	 * 前一次操作影响的记录数
	 * @return int
	 */
	public function affected_rows() {
		return $this->numRows;
	}
	
	/**
	 * 关闭连接
	 * @return bool
	 */
	public function close() {//通过
		if ($this->link_id !== NULL) $this->link_id = NULL;
		return true; 
	}
	
	/**
	 * 错误信息
	 * @return array
	 */
	public function error() {
		return $this->PDOStatement->errorInfo();
	}
	
	
}