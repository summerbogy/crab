<?php

 class HomeDao extends Dao {

	private static $_instance = null;
	private $tableName = '';
		
	public static function getInstance(){
		if(!self::$_instance){
			self::$_instance = new self();
		}
		return self::$_instance;
	}
		
	public function fDao($daoName, $group) {
		$this->tableName = $InitPHP_conf['db']['table_pre'].str_replace(strtolower(basename($gourp)), '', $daoName);
		$this->_pk = substr($daoName, 0, 1).'id';
		$dao = InitPHP::getdao($daoName, $group);
		return $dao ? $dao : false;
	}
	
	
	

	
}
?>