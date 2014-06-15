<?php 
class uhomeController extends BaseUserController {
	public $initphp_list = array('run','login', 'verify', 'general', 'addArt', 'del', 'submit',
			'makeComment'
			);
	private $_uhService = '';
	//全局变量：$userData;
	
	public function before(){
		parent::before();
		$this->_uhService = $this->_getService('UcenterUhome', 'Ucenter');
	}
	public function after(){
		$this->view->assign('data', $this->data);
		$this->view->display();
	}
	
	//显示基本信息
	public function run(){
		$this->data['count'] = $this->_uhService->getAllCount();
		$this->data['art'] = $this->_uhService->getNewArt($username);
		$this->data['url'] = $this->urlTogather();
		$this->myMblog();
		$this->view->set_tpl('Ucenter/index');
	}
	
	//所有前端调用到的url，方便修改url模式时，不受影响
	public function urlTogather(){
		$url['delArt'] = $this->getUrl('Ucenter', 'uhome', 'del');
		$url['uhome']  = $this->getUrl('Ucenter', 'uhome', 'run');
		$url['login']  = $this->getUrl('Ucenter', 'uhome', 'login');
		return $url;
	}
	
	//轻博
	public function myMblog(){
		$mblog = InitPHP::getDao('Mblog', 'Mblog');
		$this->data['mblog'] = $mblog->getNew();
	}
	
	public function general(){
		$time = (int) (time()-604800);
		$query = array('time'=>array('$lt'=>$time));
		$comments = $this->getDao('HomeComments', 'Home');//1
		$this->data['comCount'] = $comments->count($query);
		$this->data['comments'] = $comments->getAll(array('isread'=>1), array('time'=> -1), $skip = 0);
		$art = $this->getDao('Home', 'Home');//2 nosqlinit 使用了单例，不能乱了顺序
		$this->data['newArt'] = $art->getAll($query);
		$this->data['artCount'] = $art->count($query);
		$visitor = $this->getDao('visit', 'Common');
		$this->view->set_tpl('Ucenter/index');
		//$this->dump($this->data['newArt']);
	}

	//文章和轻博客提交处理
	public function submit(){
		$data['type'] =  $this->controller->get_gp('type');
		echo $data['type'];
		$data['content'] = $this->controller->get_gp('content');
		$data['title']  = $this->controller->get_gp('title');
		$data['author']  = $this->controller->get_gp('author');
		$tag  = $this->controller->get_gp('tag');
		$data['tag'] = $tag;
		$data['time']  = $this->controller->get_gp('time');
		$data['cate']  = $this->controller->get_gp('cate');
		$data['from']  = $this->controller->get_gp('from');
		if(empty($data['content'])) $this->controller->ajax_return(false,'empty');
		$data['time'] 	= $data['time'] ? strtotime($data['time']) : time();
		$data['author'] = $data['author'] ? $data['author'] : '螃蟹在晨跑';
		$data['cate'] 	= $data['cate'] ? $data['cate'] : 'web';
		$filename = time().mt_rand(793, 1991).'.html';
		/* if($tag != ''){
			$data['tag'] = explode(' ', $tag);
			foreach($data['tag'] as $val){
				$tag[$val] = 0;
			}
			$data['tag'] = $tag;
		} */
		$data = array_filter($data);
		if($type = 'article'){
			$path = 'static/data/art/';
			$data['url'] 	= $path . $filename;
			$ArtDao = $this->getDao('Art', 'Art');
			$insert = $ArtDao->insert($data);
		}else{
			$path = 'static/data/mblog/';
			//$mblog = $this->getDao('Home/mblog');
			//$insert = $mblog->insert($data);
		}
		//echo APP_PATH .'static/artTpl/art.tpl';
		$pattern = array(
			'/<{title}>/',
			'/<{title}>/',
			'/<{time}>/',
			'/<{content}>/',
			'/<{author}>/',
			'/<{clicknum}>/',
			'/<{replyNum}>/',
			'/<{tag}>/'
		);
		$replace = array(
			$data['title'],
			$data['title'],
			date('Y-m-d', $data['time']),
			$data['content'],
			$data['author'],
			0,
			0,
			$tag
		);
		$html = file_get_contents('static/artTpl/art.tpl');
		$html = preg_replace($pattern, $replace, $html);
		file_put_contents($path . $filename, $html);
		$this->dump($html);
		//if(!empty($data)) $this->controller->redirect('/?m=Ucenter&c=index&a=gernal', 3, '文章发表成功');
	}
	
	public function makeComment(){
		$this->dump($this->userData);
	
	}
	
	public function artManage(){
		$art = $this->getDao('Home', 'Home');
		$this->data['artList'] = $art->getAll();
		$this->view->set_tpl('Ucetner/artManage');
	}

	public function getDao($daoName, $group = 'Ucenter'){
		return InitPHP::getDao($daoName, $group);

	}
	public function modifyInfo(){

		$this->view->set_tpl('Ucenter/modifyInfo');
	}

	public function addArt(){
		$this->view->set_tpl('Ucenter/addArt');
	}

	public function addmblog(){
		$this->view->set_tpl('Admin/addMblog');
	}
	
	public function del(){
		$id = $this->controller->get_gp('id');
		$type = $id = $this->controller->get_gp('type');
		switch ($type){
			case 'art': 
				$res = $this->_uhService->delArt($id);
				break;
			case 'mblog' :
				$res = $this->_uhService->mblog($id);
				break;
		} 
		if(!empty($res)){
			$this->controller->ajax_return(true,'success');
		}else{
			$this->controller->ajax_return(false,'fail');
		}
	}
}