<?php
if (!defined('IS_INITPHP')) exit('Access Denied!');
/*********************************************************************************
 * InitPHP 3.3 国产PHP开发框架  Dao-mysqli 基类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 *-------------------------------------------------------------------------------
 * $Author:zhuli
 * $Dtime:2013-5-29 
***********************************************************************************/
class mysqliInit extends dbbaseInit{
	
	public $link_id;          	//链接对象 
	protected $transTimes = 0; //事务开启的次数 
	 
	/* public function __construct(){
		$this->connect($host, $user, $password, $database, $charset = 'utf8', $pconnect = 0);
	} */
	/**
	 * MYSQL连接器
	 * @param  string $host sql服务器
	 * @param  string $user 数据库用户名
	 * @param  string $password 数据库登录密码
	 * @param  string $database 数据库
	 * @param  string $charset 编码
	 * @param  string $pconnect 是否持久链接
	 * @return obj
	 */
	public function connect($host, $user, $password, $database, $charset = 'utf8', $pconnect = 0) {
		$link_id = ($pconnect == 0) ? mysqli_connect($host, $user, $password) : mysqli_pconnect($host, $user, $password);
		if (!$link_id) InitPHP::initError('mysql connect error!');
		mysqli_query($link_id, 'SET NAMES ' . $charset);
		if (!mysqli_select_db($link_id, $database)) InitPHP::initError('database is not exist!');
		return $link_id;
	}
	
	/**
	 * SQL执行器
	 * @param  string $sql SQL语句
	 * @return obj
	 */
	public function query($sql) {
		return mysqli_query($this->link_id, $sql);
	}
	
	/**
	 * 结果集中的行数
	 * @param $result 结果集
	 * @return array
	 */
	public function result($result, $num=1) {
		return mysqli_result($result, $num);
	}
		
	/**
	 * 从结果集中取得一行作为关联数组
	 * @param $result 结果集
	 * @return array
	 */
	public function fetch_assoc($result) {
		return mysqli_fetch_assoc($result);
	}
	
	/**
	 * 从结果集中取得列信息并作为对象返回
	 * @param  $result 结果集
	 * @return array
	 */
	public function fetch_fields($result) {
		return mysqli_fetch_field($result);
	}
	
	/**
	 * 结果集中的行数
	 * @param $result 结果集
	 * @return int
	 */
	public function num_rows($result) {
		return mysqli_num_rows($result);
	}
	
	/**
	 * 结果集中的字段数量
	 * @param $result 结果集
	 * @return int
	 */
	public function num_fields($result) {
		return mysqli_num_fields($result);
	}
	
	/**
	 * 释放结果内存
	 * @param obj $result 需要释放的对象
	 */
	public function free_result($result) {
		return mysqli_free_result($result);
	}
	
	/**
	 * 获取上一INSERT的ID值
	 * @return Int
	 */
	public function insert_id() {
		return mysqli_insert_id($this->link_id);
	}
	
	/**
	 * 前一次操作影响的记录数
	 * @return int
	 */
	public function affected_rows() {
		return mysqli_affected_rows($this->link_id);
	}
	
	/**
	 * 关闭连接
	 * @return bool
	 */
	public function close() {
		if ($this->link_id !== NULL) @mysqli_close($this->link_id);
		$this->link_id = NULL;
		return true;
	}
	
	/**
	 * 错误信息
	 * @return string
	 */
	public function error() {
		return mysqli_error($this->link_id);
	}
	
	
	/**
	 *开始事务操作
 	 * DAO中使用方法：$this->dao->db->transaction_start()
     * 用于非自动提交状态下面的查询提交
     * @return boolen
     */
    public function transaction_start() {
		if($this->transTimes > 1) return true; //事务嵌套时只提交/回滚最外层的事务
		if($this->transTimes > 0){
			$result = $this->query("START TRANSACTION");
			if(!$result)	return false;
			$this->transTimes = 0;
		}
        return true;
    }
	
	
	/**
	 * 提交事务
 	 * DAO中使用方法：$this->dao->db->transaction_commit()
	 */
	public function transaction_commit() {
		if($this->transTimes > 1) return true; //事务嵌套时只提交/回滚最外层的事务
		if($this->transTimes > 0){
			$result = $this->query("COMMIT");
			if(!$result)	return false;
			$this->transTimes = 0;
		}
        return true;
	}
	
	/**
	 * 回滚事务
	 * DAO中使用方法：$this->dao->db->transaction_rollback()
	 */
	public function transaction_rollback() {
		if($this->transTimes > 1) return true; //事务嵌套时只提交/回滚最外层的事务
		if($this->transTimes > 0){
			$result = $this->query("ROLLBACK");
			if(!$result)	return false;
			$this->transTimes = 0;
		}
        return true;
	}
	
	/*
	 *获得一行查询结果
	 *
	 */
	public function getResult($sql) {
		$result = $this->query($sql);
		$result = $this->fetch_assoc($result);
		return $result;
	}
	
	/*
	 *获得所有查询结果
	 *
	 */
	public function getAllResult($sql) {
		
		$result = $this->query($sql);
		return $this->fetch_all($result);
	}
	
	/**
	 * 从结果集中取得关联数组返回
	 * @param $result 结果集
	 * @return array
	 */
	public function fetch_all($result) {
		while($row = $this->fetch_assoc($result)) {
			$rows[] = $row;
		}
		return $rows;
	}
	
}
