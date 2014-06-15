﻿<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><{title}></title>
	<link rel="stylesheet" href="static/style/styles.css" />
	<link href="../../style/common.css" rel="stylesheet" type="text/css">
	<link href="../../assets/raphaelicons.css" rel="stylesheet">
	<script src="../../js/jquery.js" type="text/javascript"></script>
</head>
<body>
<div class="l_menu">
	<ul>
		<a href="#"><li><span class="icon">S</span></li></a>
		<a href="#"><li><span class="icon">?</span></li></a>
		<a href="#"><li><span class="icon">1</span></li></a>
		<a href="#"><li><span class="icon">M</span></li></a>
		<a href="#"><li><span class="icon">Ü</span></li></a>
		<a href="#"><li><span class="icon">R</span></li></a>
		<a href="#"><li><span class="icon">+</span></li></a>
		<a href="#"><li><span class="icon">\</span></li></a>
	</ul>
</div>
<div id="top">
	<ul>
		<li><a href="http://www.crab.cc/?m=Home&c=index&a=run">首页</a></li> <em>/</em>
		<li><a href="http://www.crab.cc/?m=Home&c=index&a=run&topic=weiyan">微言微语</a></li> <em>/</em>
		<li><a href="http://www.crab.cc/?m=Home&c=index&a=run&topic=weiyan">慢生活</a></li> <em>/</em>
		<li><a href="http://www.crab.cc/?m=Home&c=index&a=run">他山之石</a></li> <em>/</em>
		<li><a href="http://www.crab.cc/?m=Home&c=index&a=run">周边</a></li> <em>/</em>
		<li><a href="http://www.crab.cc/?m=Home&c=index&a=run">推荐</a></li> <em>/</em>
		<li><a href="http://www.crab.cc/?m=Home&c=index&a=run">足迹</a></li> <em>/</em>
	</ul>
	<form method="post" action="/?m=Home&c=index&a=search">
		<div class="search">
			<input type="text" id="keyword" name="search" />
		</div>
		<button type="submit"><span class="icon" style="font-size:22px;line-height:24px;margin-left:5px;">z</span></button>
	
		
	</form>
	<div class="signx">
		<div class="usericon"><img src="static/thumb/usericon.jpg"/></div>

		</div>
</div>




<div class="sidebar2">
	<div class="userinfo">
		<div class="uname">crab</div>
	</div>
</div>
<div class="contentw">
	<div class="header"><span class="icon">;</span><span1>文章</span1></div>
	<div class="vline"></div>
	<div class="context">
		<div class="avatar"><img src="static/images/thumb/usericon.jpg"/></div>
		<div class="more_h">
			<span class="icon">F</span><span1><{title}></span1>
			<span1 style="float:right"> <{time}></span1><span class="icon" style="float:right">É</span>
		</div>	
		<div class="textwrap">
			<p><{content}>	</p>		
		</div>
		<div class="more_f">
		<span class="icon">L</span><span1 ><{author}></span1>
		<a href="javascript:void(0)" class="dscomment"><span class="icon">[</span><span1>发表评论</span1></a>
		<a href="#" ><span class="icon">J</span><span1>阅读: <{clicknum}> </span1></a>
		<a href="#"> <span class="icon">[</span><span1>评论 :<{replyNum}></span1></a>
		<a href="#"><span class="icon">y</span><span1>标签：<{tag}></span1></a>
		</div>	
	</div>
	<script type="text/javascript" src="../../js/art.js">	</script>
	<div class="comment">
		<!--addCommentSide-->
		<div class="usercomment">
		<form method="post" action="" onclick="reply(this)">
			<p><input type="text" id="nickname" name="nickName" placeholder="昵称"  required="required">
			<input type="email" name="email" placeholder="邮箱" required="required"></p>			
			<p><textarea name="content"></textarea></p>
			<p><input type="text" name="verify" placeholder="验证码" required="required"></p>
			<p><input type="hidden" name="id" value="<{$data['detail']['_id']}>" /></p>
			<p><button type="submit"><span class="icon">Ã</span></button></p>
		</form>
		</div>
	</div>
</div>
	


</body>
</html>