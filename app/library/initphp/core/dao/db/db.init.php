<?php
if (!defined('IS_INITPHP')) exit('Access Denied!');
/*********************************************************************************
 * InitPHP 3.3 国产PHP开发框架  Dao-db 常用SQL方法封装
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 *-------------------------------------------------------------------------------
 * $Author:zhuli
 * $Dtime:2013-5-29 
***********************************************************************************/
require_once("sqlbuild.init.php");  
class dbInit extends sqlbuildInit {   

	/**
	 * 重写MYSQL中的QUERY，对SQL语句进行监控
	 * @param string $sql
	 */
	public function query($sql, $is_set_default = true, $bind = '') {
		$this->get_link_id($sql); //link_id获取
		$query = $bind ? $this->db->query($sql) : $this->db->query($sql, $bind) ;
		//if ($this->db->error()) InitPHP::initError($this->db->error()); //pdo成功页返回数组，此处可有可无故而。。。
		$this->set_default_link_id();
		if ($is_set_default) //设置默认的link_id
		return $query;
	}
	
	/**
	 * 结果集中的行数
	 * DAO中使用方法：$this->dao->db->result($param)
	 * @param 数组 $param[0] 为结果集，$param[1]为行数
	 * @return array
	 */
	public function result($param) {
		return empty($param) ? $this->db->result() : $this->db->result($param[0], $param[1]);
	}
	
	/**
	 * 从结果集中取得一行作为关联数组
	 * DAO中使用方法：$this->dao->db->fetch_assoc($result)
	 * @param $result 结果集
	 * @return array
	 */
	public function fetch_assoc($result) {
		return empty($result) ? $this->db->fetch_assoc() : $this->db->fetch_assoc($result);
	}
	
	/**
	 * 从结果集中取得列信息并作为对象返回
	 * DAO中使用方法：$this->dao->db->fetch_fields($result)
	 * @param  $result 结果集
	 * @return array
	 */
	public function fetch_fields($result) {
		return empty($result) ? $this->db->fetch_fields() : $this->db->fetch_fields($result);
	}
	

	/**
	 * 结果集中的行数
	 * DAO中使用方法：$this->dao->db->num_rows($result)
	 * @param $result 结果集
	 * @return int
	 */
	public function num_rows($result) {
		return  empty($result) ? $this->db->num_rows() : $this->db->num_rows($result);
	}
	
	/**
     * 执行语句
     * @access public
     * @param string $str  sql指令
     * @param array $bind 参数绑定
     * @return integer
     */
	public function execute($sql, $bind = array()){
		$this->db->execute($sql, $bind);
	
	}
	/**
	 * 结果集中的字段数量
     * DAO中使用方法：$this->dao->db->num_fields($result)
	 * @param $result 结果集
	 * @return int
	 */
	public function num_fields($result) {
		return empty($result) ? $this->db->num_fields() : $this->db->num_fields($result);
	}
	
	/**
	 * 释放结果内存
	 * DAO中使用方法：$this->dao->db->free_result($result)
	 * @param obj $result 需要释放的对象
	 */
	public function free_result($result) {
		return empty($result) ? $this->db->free_result() : $this->db->free_result($result);
	}
	
	/**
	 * 获取上一INSERT的ID值
     * DAO中使用方法：$this->dao->db->insert_id()
	 * @return Int
	 */
	public function insert_id() {
		return $this->db->insert_id();
	}
	
	/**
	 * 前一次操作影响的记录数
	 * DAO中使用方法：$this->dao->db->affected_rows()
	 * @return int
	 */
	public function affected_rows() {
		return $this->db->affected_rows();
	}
	
	/**
	 * 关闭连接
	 * DAO中使用方法：$this->dao->db->close()
	 * @return bool
	 */
	public function close() {
		return $this->db->close();
	}
	
	/**
	 * 错误信息
	 * DAO中使用方法：$this->dao->db->error()
	 * @return string
	 */
	public function error() {
		return $this->db->error();
	}
	
	/**
	 * 开始事务操作
 	 * DAO中使用方法：$this->dao->db->transaction_start()
	 */
	public function transaction_start() {
		return $this->db->transaction_start();
	}
	
	/**
	 * 提交事务
 	 * DAO中使用方法：$this->dao->db->transaction_commit()
	 */
	public function transaction_commit() {
		return $this->db->transaction_commit();
	}
	
	/**
	 * 回滚事务
	 * DAO中使用方法：$this->dao->db->transaction_rollback()
	 */
	public function transaction_rollback() {
		return $this->db->transaction_rollback();
	}
	
	/** 
	 * SQL操作-插入一条数据
	 * DAO中使用方法：$this->dao->db->insert($data, $table_name)
	 * @param array  $data array('key值'=>'值')
	 * @param string $table_name 表名
	 * @return id
	 */
	public function insert($data, $table_name) {
		if (!is_array($data) || empty($data)) return 0;
		$data = $this->build_insert($data);
		$sql = sprintf("INSERT INTO %s %s", $table_name, $data);
		$result = $this->query($sql, true);
		if (!$result) return 0;
		$id = $this->insert_id();
		$this->set_default_link_id(); //设置默认的link_id
		return $id;
	}
	
	/**
	 * SQL操作-插入多条数据
	 * DAO中使用方法：$this->dao->db->insert_more($field, $data, $table_name)
	 * @param array $field 字段
	 * @param array $data  对应的值，array(array('test1'),array('test2'))
	 * @param string $table_name 表名
	 * @return id
	 */
	public function insert_more($field, $data, $table_name) {
		if (!is_array($data) || empty($data)) return false;
		if (!is_array($field) || empty($field)) return false;
		$sql = $this->build_insertmore($field, $data);
		$sql = sprintf("INSERT INTO %s %s", $table_name, $sql);
		return $this->query($sql);
	}
	
	/**
	 * SQL操作-根据主键id更新数据
	 * DAO中使用方法：$this->dao->db->update($id, $data, $table_name, $id_key = 'id')
	 * @param  int    $id 主键ID
	 * @param  array  $data 参数
	 * @param  string $table_name 表名
	 * @param  string $id_key 主键名
	 * @return bool
	 */
	public function update($id, $data, $table_name, $id_key = 'id') {
		$id = (int) $id;
		if ($id < 1) return false;
		$data = $this->build_update($data);
		$where = $this->build_where(array($id_key=>$id));
		$sql = sprintf("UPDATE %s %s %s", $table_name, $data, $where);
		return $this->query($sql);
	}
	
	/**
	 * SQL操作-根据字段更新数据
	 * DAO中使用方法：$this->dao->db->update_by_field($data, $field, $table_name)
	 * @param  array  $data 参数
	 * @param  array  $field 字段参数
	 * @param  string $table_name 表名
	 * @return bool
	 */
	public function update_by_field($data, $field, $table_name) {
		if (!is_array($data) || empty($data)) return false;
		if (!is_array($field) || empty($field)) return false;
		$data = $this->build_update($data);
		$field = $this->build_where($field);
		$sql = sprintf("UPDATE %s %s %s", $table_name, $data, $field);
		return $this->query($sql);
	}
	
	/**
	 * SQL操作-删除数据
	 * DAO中使用方法：$this->dao->db->delete($ids, $table_name, $id_key = 'id')
	 * @param  int|array $ids 单个id或者多个id
	 * @param  string $table_name 表名
	 * @param  string $id_key 主键名
	 * @return bool
	 */
	public function delete($ids, $table_name, $id_key = 'id') {
		if (is_array($ids)) {
			$ids = $this->build_in($ids);
			$sql = sprintf("DELETE FROM %s WHERE %s %s", $table_name, $id_key, $ids);
		} else {
			$where = $this->build_where(array($id_key=>$ids));
			$sql = sprintf("DELETE FROM %s %s", $table_name, $where);
		}
		return $this->query($sql);
	}
	
	/**
	 * SQL操作-通过条件语句删除数据
	 * DAO中使用方法：$this->dao->db->delete_by_field($field, $table_name)
	 * @param  array  $field 条件数组
	 * @param  string $table_name 表名
	 * @return bool
	 */
	public function delete_by_field($field, $table_name) {
		if (!is_array($field) || empty($field)) return false;
		$where = $this->build_where($field);
		$sql = sprintf("DELETE FROM %s %s", $table_name, $where);
		return $this->query($sql);
	}
	
	/**
	 * SQL操作-获取单条信息
	 * DAO中使用方法：$this->dao->db->get_one($id, $table_name, $id_key = 'id')
	 * @param int    $id 主键ID
	 * @param string $table_name 表名
	 * @param string $id_key 主键名称，默认id
	 * @return array
	 */
	public function get_one($id, $table_name, $id_key = 'id') {
		$id = (int) $id;
		if ($id < 1) return array(); 
		$where = $this->build_where(array($id_key=>$id));
		$sql = sprintf("SELECT * FROM %s %s LIMIT 1", $table_name, $where);
		$result = $this->db->getResult($sql);
		$this->set_default_link_id(); //设置默认的link_id
		return $result;
	}
	
	/**
	 * SQL操作-通过条件语句获取一条信息
	 * DAO中使用方法：$this->dao->db->get_one_by_field($field, $table_name)
	 * @param  array  $field 条件数组 array('username' => 'username')
	 * @param  string $table_name 表名
	 * @return bool
	 */
	public function get_one_by_field($field, $table_name) {
		if (!is_array($field) || empty($field)) return array();
		$where = $this->build_where($field);
		$sql = sprintf("SELECT * FROM %s %s LIMIT 1", $table_name, $where);
		$result = $this->db->getResult($sql);
		$this->set_default_link_id(); //设置默认的link_id
		return $result ? $result : false;
	}
	
	/**
	 * SQL操作-获取单条信息-sql语句方式
	 * DAO中使用方法：$this->dao->db->get_one_sql($sql)
	 * @param  string $sql 数据库语句
	 * @return array
	 */
	public function get_one_sql($sql, $bind = false) {
		$sql = trim($sql . ' ' .$this->build_limit(1));
		$this->set_default_link_id(); //设置默认的link_id
		$result = $bind ? $this->db->getResult($sql, $bind) : $this->db->getResult($sql);
		return $result;
	}
	
	/**
	 * SQL操作-获取全部数据
	 * DAO中使用方法：$this->dao->db->get_all()
	 * @param string $table_name 表名
	 * @param array  $field 条件语句
	 * @param int    $num 分页参数
	 * @param int    $offest 获取总条数
	 * @param int    $key_id KEY值
	 * @param string $sort 排序键
	 * @return array array(数组数据，统计数)
	 */
	public function get_all($table_name, $num = 20, $offest = 0, $field = array(), $id_key = 'id', $sort = 'DESC') {
		$where = $this->build_where($field);
		$limit = $this->build_limit($offest, $num);
		$sql = sprintf("SELECT * FROM %s %s ORDER BY %s %s %s", $table_name, $where, $id_key, $sort, $limit);
		$this->set_default_link_id(); //设置默认的link_id
		$result = $this->db->getAllResult($sql);
		$count = $this->get_count($table_name, $field);
		return array($result, $count);
	}
	
	/**
	 * SQL操作-获取所有数据
	 * DAO中使用方法：$this->dao->db->get_all_sql($sql)
	 * @param string $sql SQL语句
	 * @return array
	 */
	public function get_all_sql($sql) {
		$sql = trim($sql);
		$result = $this->db->getAllResult($sql);
		$this->set_default_link_id(); //设置默认的link_id
		return $result ? $result : false;
	}
	
	/**
	 * SQL操作-获取数据总数
	 * DAO中使用方法：$this->dao->db->get_count($table_name, $field = array())
	 * @param  string $table_name 表名
	 * @param  array  $field 条件语句
	 * @return int
	 */
	public function get_count($table_name, $field = array()) {
		$where = $this->build_where($field);
		$sql = sprintf("SELECT COUNT(*) as count FROM %s %s LIMIT 1", $table_name, $where);
		$result = $this->db->getResult($sql, false);
		$this->set_default_link_id(); //设置默认的link_id
		return $result['count'];
	}
	
	public function executed($sql, $bind = array()) {
		$this->db->execute($sql, $bind);
	}
	
}
