<?php
class UsersloginDao extend BaseDao {
	
	protected $tableName = 'cg_users';
	protected $pk		 = 'uid';
	/**
	 * ������¼
	 * @param array $data
	 * @return int
	 */
	public function add($data) {
		if (!$data) return false;
		return $this->dao->db->insert($data, $this->tableName);
	}
	
	/**
	 * ���¼�¼
	 * @param array $data
	 * @return int
	 */
	public function update($id) {
		$id = intval($id);
		if (!$id or $id < 0) return false;
		return $this->dao->db->update($id, $data, $this->tableName, $this->_pk);
	}
	
	/*
	*ͨ���û�����ü�¼
	* @param array $string
	* @return array
	*/
	public function getByUsername($userName){
		$username = trim($username);
		$field = array('username' => $username);
		return $this->dao->db->get_one_by_field($field, $this->tableName);
	}
	
	/*
	*�����Ϣ����
	*
	*/
	public function getNotifications(){
		
	
	
	
	}









}