<?php

class indexController extends BaseAdminController {

	protected $_pService = '';
	public $data =array();

	public $initphp_list = array('run','login', 'verify', 'general',
							'checkLogin', 'submit','', 'addArt',
							'artManage', 'modifyInfo', 'visitor','addmblog',
							'def'
							);
	public function before(){
		parent::before();
		$this->_pService = $this->_getService('AdminPermission', 'Admin');
	}

	public function after(){
		parent::after();
		$this->view->assign('data', $this->data);
	}

	public function run() {
		$nodes = $this->_pService->getNode();
		$this->data['fnode'] = $nodes[1];
		$this->data['snode'] = $nodes[0];
		//$this->data['snode'] = $this->snode();		
		/* $this->dump($this->data['snode']);
		$this->dump($this->data['fnode']); */
		$this->view->set_tpl('Admin/index/index_run');

	}
	
	public function snode(){
		return  $this->_pService->getSecondNode();
	}
	
	public function node(){
		$pService = $this->_getService('AdminPermission', 'Admin');;
		return  $pService->getFirstNode();
	}
}
	
	