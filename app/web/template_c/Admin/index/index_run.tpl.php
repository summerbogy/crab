<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2014-06-12 13:39:07, compiled from app/web/template/Admin/index/index_run.html */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--{if (STATIC_PATH != '') {}-->
<base href="<!--{echo STATIC_PATH}-->" />
<!--{}}-->
<link href="static/style/admin/comm.css" rel="stylesheet" type="text/css">
<link href="static/style/admin/index.css" rel="stylesheet" type="text/css">
<script src="static/js/jquery.js" type="text/javascript"></script>
<title>一款通用后台</title>
</head>
<body>
<div class="warp">
  <div class="header">
    <div class="logo">通用管理后台</div>
    <div class="banner">
      <ul id="nav">
        <!--{foreach($navConfig['nav'] as $key => $val) { }-->
        <li title="initapp_sidebar_<!--{echo $key;}-->">
          <!--{echo $val;}-->
        </li>
        <!--{}}-->
      </ul>
    </div>
	 <div class="head_right">当前用户：<!--{echo $userInfo['username'];}-->&nbsp;&nbsp;|&nbsp;&nbsp;<a href="<!--{echo $indexLoginout;}-->">[注销]</a></div>
  </div>
  <div class="main">
	<div class="left">
			<div id="initapp_sidebar_system">
			<?php foreach ($data['fnode'] as $fnode) { ?>
			<div class="title" title="initapp_option_<?php echo $fnode['nodeId'];?>"><?php echo $fnode['title'];?></div>
			<ul class="hidden sidebar_list" id="initapp_option_<?php echo $fnode['nodeId'];?>">
				<?php foreach ($data['snode'] as $key=>$val) { ?>
					<?php if ($val['nodeId'] == $fnode['nodeId']) { ?>
					<li onclick="javascript:iframeOpen('index.php?c=adminuser&a=run', '管理员管理', 'adminuser_run')">
					<?php echo $val['groupName'];?> 
					</li> 
					<?php } ?>
				<?php } ?>
			</ul>
			<?php } ?>
			</div>
				<ul class="hidden sidebar_list" id="initapp_option_2">  
				<li onclick="javascript:iframeOpen('index.php?c=adminuser&a=run', '新增广告', 'adminuser_run')">
					新增广告</li>	  
				<li onclick="javascript:iframeOpen('index.php?c=admingroup&a=run', '广告收入', 'admingroup_run')">
					广告收入</li>
				<li onclick="javascript:iframeOpen('index.php?c=adminlog&a=run', '广告日志', 'adminlog_run')">
					广告日志</li>
				</ul>
			
			
	</div>

    <div class="right">
	<iframe name="content_iframe" class="iframepage" id="iframepage" onload="iframHeight('iframepage')" src="/?m=Admin&c=index&a=def" style="border:0px; width:100%;" frameborder="no" border="0" marginwidth="0" marginheight="0"  allowtransparency="yes"></iframe>
	
    </div>
  </div>
  <div class="footer">
    <div class="info">Prowerd By initphp.com&nbsp;&nbsp;&nbsp;&nbsp;用简单的代码写强壮的程序，我们一直都在努力！</div>
  </div>
</div>
<script src="static/js/admin/sidebar.js" type="text/javascript"></script>
</body>
</html>