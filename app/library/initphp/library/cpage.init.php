<?php
/* lib_page.php
*  Page
*  @link        http://www.sunboyu.cn
*  @package     OA
*  @version     V1.0
*
*  2008 08 28  sunboyu@gmail.com
*/
class cpageInit
{
	public $count;      #结果总数
	public $page;       #当前页
	public $pagesize;   #每页结果数
	public $pagecount;  #翻页数
	public $baseurl;    #url
	public $result;     #结果数组集
	public $pagelist;   #每翻页数
	
	#构造函数，初始化变量
	function pager( $count , $page , $pagesize = 5, $pagelist =5, $baseurl = false )	{
		$this->count     = $count;
		$this->page      = $page;
		$this->pagesize  = $pagesize;
		$this->baseurl   = isset($baseurl) ? $baseurl : $this->geturl();
		$this->pagelist  = $pagelist;
	}

	#获得当前url
	function geturl()	{
		return ereg_replace("(^|&)page={$page}","",$_SERVER['QUERY_STRING']);
	}
	
	#获得分页列表
	function getpagelist(){
		$this->result['count'] = $this->count;
		$this->result['page'] = $this->page;
		$this->result['pagesize'] = $this->pagesize;
		$pagecount = ceil($this->count / $this->pagesize);
		if ($this->result['page'] < 1)
			$this->result['page'] = 1;
		if ($this->result['page'] > $pagecount)
			$this->result['page'] = $pagecount;			
		if($pagecount <= 1) //只有一页以下
		{
			$this->result['pagecount'] = 1;
		}
		else //一页以上
		{
			#前一页，第一页的算法
			$this->result['first'] = 1;
			$this->result['pre'] = ($this->result['page'] <= 1) ? 1 : $this->result['page']-1;
			#后一页，最后一页的算法
			$this->result['next'] = ($this->result['page'] >= $pagecount ) ? $pagecount : $this->result['page']+1;
			$this->result['last'] = $pagecount;
			#起始
			$pagearray = array();
			$start = intval(($this->page-1)/10)*10+1;
			for($i=0;$i<10;$i++)
			{
				if( ($start+$i) <= $pagecount)
				{
					$pagearray[$i]['page'] = $start+$i;
					if( ($start+$i) != $this->result['page'])
					{
						$pagearray[$i]['link'] = 1;
					}
				}
			}
			$this->result['pagecount'] = $pagecount;

			#分页导航列表
			$this->result['pagelist'] = $pagearray;
			$this->result['baseurl'] = $this->baseurl;
			return $this->result;
		}
	}
}
?>