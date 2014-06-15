<?php
class UsersloginDao extend BaseDao {
	
	protected $tableName = 'cg_users';
	protected $pk		 = 'uid';
	/**
	 * 新增记录
	 * @param array $data
	 * @return int
	 */
	public function add($data) {
		if (!$data) return false;
		return $this->dao->db->insert($data, $this->tableName);
	}
	
	/**
	 * 更新记录
	 * @param array $data
	 * @return int
	 */
	public function update($id) {
		$id = intval($id);
		if (!$id or $id < 0) return false;
		return $this->dao->db->update($id, $data, $this->tableName, $this->_pk);
	}
	
	/*
	*通过用户名获得记录
	* @param array $string
	* @return array
	*/
	public function getByUsername($userName){
		$username = trim($username);
		$field = array('username' => $username);
		return $this->dao->db->get_one_by_field($field, $this->tableName);
	}
	
	/*
	*获得信息中心
	*
	*/
	public function getNotifications(){
		
	
	
	
	}









}