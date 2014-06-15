<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2014-06-12 13:34:48, compiled from app/web/template/Ask/index.html */ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>bogy</title>
	<link href="static/assets/raphaelicons.css" rel="stylesheet">
	<link href="static/style/Ask/index.css" rel="stylesheet" />
	<link href="static/style/tabs.css" rel="stylesheet" />
	<link href="static/style/common1.css" rel="stylesheet" />
	<script src="static/js/jquery.js" type="text/javascript"></script>
	<style type="text/css">
		body{
			color:#666;
		}
	</style>
</head>
<body>
<?php include('app/web/template_c/Common/lmenu.tpl.php'); ?>
<?php include('app/web/template_c/Common/header.tpl.php'); ?>
<div class="main" style="background:#f6f6f6">
		<input id="tab1" type="radio" class="tabsinput" name="tabs" checked>
		<label for="tab1">文章</label>

		<input id="tab2" type="radio" class="tabsinput" name="tabs">
		<label for="tab2">轻博客</label>

		<input id="tab3" type="radio" class="tabsinput" name="tabs">
		<label for="tab3">问答</label>

		<input id="tab4" type="radio" class="tabsinput" name="tabs">
		<label for="tab4">我参与</label>	
	<section id="main">
		<div class="ask">
			<div class="ask-box">
				<div class="lpart">
					<div class="usericon"><img src="static/thumb/usericon.jpg" width="60" height=60 /></div>
				</div>
				<div class="rpart">
					<div class="title">
						<h4>titletitletitletitletitletitletitletitletitletitletitle
							titletitletitletitletitletitletitletitletitletitletitle
						</h4>
					
						<div class="num">1</div>
					</div>
					<!-- <div class="context">
						<p>text</p>
					</div> -->
					<div class="info">
						<p>info</p>
					</div>
				</div>
				
				
			</div>
		</div>
		<?php foreach ($data['art'] as $art) { ?>
		<div class="avatar"><p style="text-align:center; line-height:40px;font-size:18px;"><?php echo ++$i ?></p></div>
		<p0>
			<div class="title"><?php echo $art['title'];?>
				<div class="doright">
					<a href="javascript:void(0);" onclick=del(this) t="art" url="<?php echo $data['url']['delArt'].'id='.$art['_id'] ?>">
						<span class="icon">Â</span>
					</a>
				</div>
				<div class="doright">
					<a href="javascript:void(0);" onclick=edit(this) url="<?php echo $data['url']['del'].'id='.$art['_id'] ?>">
						<span class="icon">></span>
					</a>
				</div>
			</div>
			<div class="content">
				<p><?php echo mb_substr($art['content'], 0, 500,'UTF-8') ?></p>
			</div>
		</p0>
		<?php } ?>

	</section>
	<section id="content2">
			<?php foreach ($data['art'] as $list) { ?>
			
			<div class="avatar"><p style="text-align:center; line-height:40px;font-size:18px;"><?php echo ++$j ?></p></div>
			<p0>
			<div class="front">
				
			</div>
			<div class="micbox">
				<div class="title">
					<?php echo $list['title'];?>
					<div class="doright"><span class="icon">></span>
					</div>
				</div>
				<div class="lpart"><?php echo $list['image'];?></div>
				<div class="rpart"><?php echo mb_substr($list['content'], 0, 500,'UTF-8') ?></div>
				<div class="info"><span1><?php echo $list['author'];?></span1></div>
			</div>
			</p0>
			<?php } ?>
	</section>
	<section id="content3">
		<div class="text">
			<div class="avatar"><img src="static/images/avatar/defaulticon.jpg"/></div>
			<p0><p>hello world3</p>
			<p>hello world</p></p0>
		</div>
	</section>
</div>
<div class="lside">
sssssssssss<br>ddd
</div>
</body>
</html>