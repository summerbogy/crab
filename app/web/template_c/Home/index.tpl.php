<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2014-06-13 17:01:18, compiled from app/web/template/Home/index.html */ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>螃蟹快跑</title>
	<script src="js/jquery-1.10.2.js"></script>
	<link href="static/assets/raphaelicons.css" rel="stylesheet">
	<link rel="stylesheet" href="static/style/styles.css" />
	<link href="static/style/common.css" rel="stylesheet" type="text/css">
	<script src="static/js/jquery.js" type="text/javascript"></script>
	<style type="text/css">
		body{
			color:#666;
		}
		section ul{
			display:inline;
			list-style:none;
		}
		section ul li{
			float:left;
			margin:5px;
			padding:2px;
			border:1px solid #efefef;
		
		}
	</style>
</head>
<body>
<?php include('app/web/template_c/Common/lmenu.tpl.php'); ?>
<?php include('app/web/template_c/Common/header.tpl.php'); ?>

<div class="sidebar">
	<!--section>
		<span2><span class="icon">y</span>热门文章</span2>
		<?php foreach  ($data['hotArt'] as $hot) { ?>
		<p><a href="/?m=Home&c=Index&a=readmore&id=<?php echo $hot['_id'];?>"><span class="icon">F</span><?php echo $hot['title'];?></a></p>
		<?php } ?>
	</section-->

	<section>
		<span2><span class="icon">y</span>文章分类</span2>
		<?php foreach  ($data['cate'] as $val) { ?>
		<p><a href="/?m=Home&c=Index&a=readmore&cate=<?php echo $val;?>"><span class="icon">F</span><?php echo $val;?></a></p>
		<?php } ?>
		
	</section>
	<section>
		<span2><span class="icon">y</span>时间轴</span2>
		<p><a href="<?php echo $data['baseUrl'];?>timesort&t=604800">近一个礼拜</a></p>
		<p><a href="<?php echo $data['baseUrl'];?>timesort&t=2592000">近一个月</a></p>
		<p><a href="<?php echo $data['baseUrl'];?>timesort&t=7776000">近三个月</a></p>
		<p><a href="<?php echo $data['baseUrl'];?>timesort&t=15552000">近六个月</a></p>
		<p><a href="<?php echo $data['baseUrl'];?>timesort&t=15552001">更多>></a></p>
	</section>
</div>
<div class="contentw">
	<div class="header"><span class="icon">;</span><span1>文章</span1></div>
	<div class="vline"></div>
	<?php foreach  ($data['artList'] as $info) { ?>
	<div class="context">
		<div class="avatar"><img src="static/thumb/usericon.jpg"/></div>
		<div class="more_h">
			
			<span class="icon">F</span><span1><?php echo $info['title'];?></span1>
			<span1 style="float:right"> <?php echo date('Y-m-d', $info['time']) ?></span1><span class="icon" style="float:right">É</span>
			
		</div>	
		<div class="textwrap">
			<p><?php echo mb_substr($info['content'], 0, 1000,'UTF-8') ?>
			</p>
		
			
		</div>
		<div class="more_f">
			<span class="icon">L</span><span1 ><?php echo $info['author'];?></span1>
			<a href="<?php echo $info['url'];?>"><span class="icon">i</span><span1>阅读全文</span1></a>
			<a href="#"><span class="icon">J</span><span1>点击: <?php echo $info['clicknum'];?> </span1></a>
			<a href="#"><span class="icon">[</span><span1>评论 (10)</span1></a>
			<a href="#"><span class="icon">y</span><span1>标签：<?php echo $info['keyword'];?></span1></a>
		
		</div>
	</div>
	<?php } ?>
	<div class="page">
	<p><span>总记录数</span>:<span><?php echo $data['page']['count'];?></span>
		<span><a href=" <?php echo $data['page']['baseurl'];?>&p=<?php echo $data['page']['first'];?>" >First</a></span>
		<span><a href="<?php echo $data['page']['baseurl'];?>&p=<?php echo $data['page']['pre'];?>">Prev</a></span>
		<?php foreach ($data['page']['pagelist'] as $list) { ?>
		<span><a href="<?php echo $data['page']['baseurl'];?>&p=<?php echo $list['page'];?>"><?php echo $list['page'];?></a></span>
		<?php } ?>
		<span><a href="<?php echo $data['page']['baseurl'];?>&p=<?php echo $data['page']['next'];?>">Next</a></span>
		<span><a href="<?php echo $data['page']['baseurl'];?>&p=<?php echo $data['page']['last'];?>">Last</a></span>
		<span>共</span>:<span><?php echo $data['page']['pagecount'];?></span>页
	</p></div>
	
</div>
<script type="text/javascript">
	window.setInterval(function(){
			var num = Math.ceil(Math.random()*3);
			$('.sidebar').css({background:'url(/static/thumb/'+num+'.jpg) no-repeat'});
	},5000);

</script>
</body>
</html>


</script>
</body>
</html>