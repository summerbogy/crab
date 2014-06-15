<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2014-06-13 17:01:09, compiled from app/web/template/Home/mblog.html */ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>bogy</title>
	<link href="static/assets/raphaelicons.css" rel="stylesheet">
	<link href="static/style/mblog.css" rel="stylesheet" type="text/css">
	<!--link href="static/style/Home.css" rel="stylesheet" type="text/css">
	<!--script src="static/js/dialog.js" type="text/javascript"></script-->
	
	<script src="static/js/jquery.js" type="text/javascript"></script>
	<style type="text/css">
		body{
			color:#666;
			background:#efefef;
		}
		.contentw{
			width:55%;
		}
	</style>
</head>
<body>
<?php include('app/web/template_c/Common/lmenu.tpl.php'); ?>
<?php include('app/web/template_c/Common/header.tpl.php'); ?>

<div class="sidebar2">
	
	<div class="userinfo">
	
		<div class="uname"></div>
		
	</div>
	

</div>
<div class="contentw" >
	<div class="header"><span class="icon">;</span><span1>轻博客</span1></div>
	<div class="vline"></div>
	<div class=""></div>
	<?php foreach ($data['mblog'] as $list) { ?>
	<div class="context">
		<div class="avatar"><img src="static/thumb/usericon.jpg"/></div>
		<div class="front"></div>
		<div class="micbox">
			<div class="title">
				<span class="icon">Û</span>
				<?php echo $list['title'];?>
				<span style="float:right"><span class="icon">É</span><?php echo date('Y-m-d',$list['time']) ?></span>
			</div>
			<img src="static/images/test/test.jpg" class="bimg" style="display:none" />
			<main>
			<?php if ($list['imgpath']) { ?>
			<div class="lpart"><img src="<?php echo $list['imgpath'];?>" class="m_img" width="220" height="205" /></div>
			<div class="rpart"><?php echo $list['content'];?></div>
			<?php } else { ?>
				<div class="onlyword"><?php echo $list['content'];?></div>
			<?php } ?>
			</main>
			<div class="info">
				<span class="icon">L</span>
				<span1><?php echo $list['author'];?></span1>
				<span class="icon opt"></span>
				<a href="javascript:void(0);"><span class="icon opt" title="说点什么">[</span></a>
				
				<a href="javascript:void(0);"><span class="icon opt" title="赞一下">1</span></a>
				<a href="javascript:void(0);"><span class="icon opt" title="黑一下">2</span></a>
			</div>
		</div>
	</div>
	<?php } ?>
</div>
	
<script>
var main0 = '';
/*$('.m_img').click(function(){
		main0 = $('main').html();
		var imgpath = $(this).attr('src');
		//alert(imgpath);
		var html = '<img src='+imgpath+' class="bimg" />';
		$('main').html(html);
		$('.bimg').click(function(){
			$('main').html(main0);
		})
})*/
$('.m_img').click(function(){
		var bimg = $(this).parent().parent().prev();
		var main = $(this).parent().parent();
		bimg.css("display", "inline");
		main.css("display", "none");
		bimg.click(function(){
			bimg.css("display", "none");
			main.css("display", "inline");
		})
})

</script>

</body>
</html>