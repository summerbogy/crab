<?php
if (!defined('IS_INITPHP')) exit('Access Denied!');
/*********************************************************************************
 * InitPHP 3.3 国产PHP开发框架  Dao-dbbase Driver DB基类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 *-------------------------------------------------------------------------------
 * $Author:zhuli
 * $Dtime:2013-5-29 
***********************************************************************************/
abstract class dbbaseInit{

	/**
	 * 抽象数据库链接
	 * @param  string $host sql服务器
	 * @param  string $user 数据库用户名
	 * @param  string $password 数据库登录密码
	 * @param  string $database 数据库
	 * @param  string $charset 编码
	 * @param  string $pconnect 是否持久链接
	 */
	abstract protected function connect($host, $user, $password, $database, $charset = 'utf8', $pconnect = 0);
	
	
	/**
	 * 抽象数据库-前一次操作影响的记录数
	 * @return int
	 
	abstract protected function affected_rows();*/
	
	
	/**
	 * 抽象数据库-获取上一INSERT的ID值
	 * @return Int
	 */
	abstract protected function insert_id();
	
	
	
	/**
	 * 抽象数据库链接关闭
	 * @param  string $sql SQL语句
	 * @return obj
	 */
	abstract protected function close();
	
	/**
	 * 错误信息
	 * @return string
	 */
	abstract protected function error();
	
	/**
	 * 开始事务操作
 	 * DAO中使用方法：$this->dao->db->transaction_start()
	 */
	abstract protected function transaction_start();
	
	/**
     * 用于非自动提交状态下面的查询提交
     * @return boolen
     */
   abstract protected function transaction_commit();
	
	 /**
     * 事务回滚
     * @return boolen
     */
   abstract protected function transaction_rollback();
}
