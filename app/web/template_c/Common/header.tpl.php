<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2014-06-13 17:01:18, compiled from app/web/template/Common/header.html */ ?>
<div id="top">
	<ul>
		<li><a href="/?m=Home&c=index&a=run">首页</a></li> <em>/</em>
		<li><a href="/?m=Home&c=mblog&a=run">轻博客</a></li> <em>/</em>
		<li><a href="/?m=Home&c=topic&a=run">专题</a></li> <em>/</em>
		<li><a href="/?m=Ask&c=index&a=run">问答</a></li> <em>/</em>
		<li>周边</li> <em>/</em>
		<li>推荐</li> <em>/</em>
		<li>足迹</li> <em>/</em>
	</ul>
	<form method="post" action="/?m=Home&c=art&a=search">
		<div class="search">
			<input type="text" id="keyword" name="search" />
		</div>
		<button type="submit"><span class="icon" style="font-size:22px;line-height:24px;margin-left:5px;">z</span></button>
	
		
	</form>
	<div class="signx">
		<div class="usericon"><a href="/?m=Ucenter&c=index&a=run"><img src="static/thumb/usericon.jpg"/></a></div>

		</div>
</div>


