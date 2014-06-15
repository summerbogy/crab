<?php
class BaseService extends Service {
	
	//protected $_service='';
	
	protected function myDao($daoName,$group) {
		return InitPHP::getDao($daoName, $group);
	}






}
?>