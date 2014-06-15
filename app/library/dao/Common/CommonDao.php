<?php

 class CommonDao extends Dao {
	private $collection = '';
		

		
	public function fDao($daoName, $group) {
		$dao = InitPHP::getdao($daoName, $group);
		return $dao ? $dao : false;
	}
	
	
	

	
}
?>