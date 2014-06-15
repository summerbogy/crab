<?php 
class AdminPermissionService extends Service {
	protected $_dao = '';//调用dao的游标
	public $node = '';
	public $groups = '';
	public $rule ='';
	public $hold = '';
	public function __construct() {
		$this->_dao = InitPHP :: getDao('Common', 'Common');//设计的失误
	}
	
	public function __destruct(){
		unset($this->node);
		unset($this->groups);
		unset($this->rule);
	}
	public function nodeDao(){
		$this->node = InitPHP::getDao('AdminNode', 'Admin');
	}
	
	public function groupsDao(){
		$this->groups = InitPHP::getDao('AdminGroups', 'Admin');
	}

	public function ruleDao(){
		$this->rule = InitPHP::getDao('AdminRule', 'Admin');
	}
	
	public function getUser(){
		$session = $this->getUtil('session');
		$uid = $session->get('uid');
		/* $query = array('_id'=>$id);
		$user = getDao('Admin':'Admin');
		$userInfo = $user->getOne($query);*/
		return $uid;
	}
	
	public function checkGroup(){
		$uid[] =$this->getUser();
		$this->groupsDao();
		$query = array("userId"=>array('$in'=>array($uid)));//
		$fields = array('groupId');
		$groupId = $this->groups->getAll($query);
		
		return $groupId;
	}
	
	public function checkNode(){
		$groupId =$this->checkGroup();
		$nodeId = array();
		foreach($groupId as $key=>$val){
			if(array_key_exists('nodeId', $val)) $nodeId = array_merge($val['nodeId'],$nodeId);
		}
		//var_dump($nodeId);
		return array_unique($nodeId);
	}
	
	public function checkRule(){
		$nodeId = $this->checkNode();
		/* foreach($nodeId as $id){
			$rules[] = array('nodeId'=>$id);
		} */
		$query = array("nodeId"=>array('$in'=>$nodeId));
		$this->ruleDao();
		return $this->rule->getAll($query);	
	}
	
	public function checkAction(){
		$rule = $this->checkRule();
		foreach($rule as $key=>$val){
			$module['module'] = $val;
			$controller['controller'] = $val;
			$controller['action'] = $val;
		}
	}
	
	public function getNode(){
		$nodes =array();
		$nodeId =$this->checkNode();
		$rule = $this->checkRule();
		/* foreach($rule as $key=>$val){
			if(array_key_exists('level', $val) && $val['level'] ==1) {
				$snode[]['nodeId'] = $val['nodeId'];
				$snode[]['groupName'] = $val['groupName'];				
			}
		} */
		$nodes[] = $rule;
		$this->nodeDao();
		$query = array("nodeId"=>array('$in'=>$nodeId));
		$fields = array('nodeId','title');
		$fnode = $this->node->getAll($query, $a, $b, $c,$fields);
		$nodes[] = $fnode;
		
		return $nodes;
	}
	
	
	public function getMenu(){
	
	}
	
	public function map(){

	}
	
	public function _list(){
	
	}
	
	public function forbid(){
	
	}
	
	public function resume(){
	
	}




























}