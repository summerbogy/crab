<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><{$data['detail']['title']}></title>
	<link href="css/ui-lightness/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="js/jquery-1.10.2.js"></script>
	<link href="static/assets/raphaelicons.css" rel="stylesheet">
	<!-- portfolio css file -->
	<link rel="stylesheet" href="static/style/styles.css" />
	<link href="static/style/common.css" rel="stylesheet" type="text/css">
	<!--link href="static/style/Home.css" rel="stylesheet" type="text/css">
	<!--script src="static/js/dialog.js" type="text/javascript"></script-->
	
	<script src="static/js/jquery.js" type="text/javascript"></script>
	<style type="text/css">
		body{
			color:#666;
		}
	</style>
</head>
<body>
<{layout:Common/lmenu}>
<{layout:Common/header}>

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
	
			<span class="icon">F</span><span1><{$data['detail']['title']}></span1>
			<span1 style="float:right"> <{$data['detail']['time']}></span1><span class="icon" style="float:right">É</span>
			
		</div>	
		<div class="textwrap">
			<p><{$data['detail']['content']}>	</p>		
		</div>
		<div class="more_f">
		<span class="icon">L</span><span1 ><{$data['detail']['author']}></span1>
		<a href="javascript:void(0)" class="dscomment"><span class="icon">[</span><span1>发表评论</span1></a>
		<a href="#" ><span class="icon">J</span><span1>阅读: <{$data['detail']['clicknum']}> </span1></a>
		<a href="#"> <span class="icon">[</span><span1>评论 :10</span1></a>
		<a href="#"><span class="icon">y</span><span1>标签：<{$data['detail']['keyword']}></span1></a>
		</div>	
	</div>
	<script type="text/javascript">
		$(function(){
					
			$(".dscomment").toggle(function(){
					$(this).html("收起评论框");
					$(".usercomment").slideDown();	
					
					//var y = window.pageYOffset;
					$('#nickname').focus();
			},function(){
					$(this).html("发表评论");
					$(".usercomment").slideUp();
					
			});
		});
		
		$(function(){
			var num = Math.ceil(Math.random()*3);
			$('.sidebar2').css({background:'url(/static/thumb/'+num+'.jpg) no-repeat'});
		})
		
		$(function(){
			$('.reply').toggle(
				function(){
					$(".usercomment").slideDown();	
					
					$id = $(this).attr('id');
					var add = '<p><input type=hidden name=replyTo value='+$id+'/></p>';
					$('#nickname').parent().next().append(add);
				},
				function(){
					$(".usercomment").slideUp();
				});
		
		})
		
	</script>
	<div class="comment">
		<{if(!empty($data['comments']))}>
		<{foreach($data[comments] as $clist)}>
		<div class="context">
			<div class="avatar"><img src="static/images/thumb/usericon.jpg"/></div>
			<div class="textwrap" style="background:#fff;">
				<hr/>
				<p style="padding:5px"><{$clist['content']}>	</p>		
			</div>
			<div class="more">
				<span class="icon">L</span><span1><{$clist['nickName']}></span1>
				<a href="javascript:void(0);" class="reply" id="<{$clist['_id']}>" ><span class="icon">O</span><span1>回复</span1></a>
				<a href="#" title="赞一下"><span1><span class="icon">1</span><{$data['detail']['clicknum']}></span1></a>
				<a href="#"  title="黑一下"><span1><span class="icon">2</span></span1></a>
				
			</div>	
		</div>
		<{/foreach}>
		<{else}>
		<div class="context">
			<p1>暂时没有评论~！</p1>
		</div>
		<{/if}>
		<div class="usercomment">
		<form method="post" action="">
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