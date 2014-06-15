<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2014-06-13 17:01:23, compiled from app/web/template/Ucenter/index.html */ ?>

<?php include('app/web/template_c/Common/lmenu.tpl.php'); ?>
<?php include('app/web/template_c/Common/aheader.tpl.php'); ?>

<div class="sidebar-u">
<div class="usericon"><img src="static/thumb/usericon.jpg"  width=145 height=150 /></div>
<div class="userinfo">
	<div class="uname">crab</div>
	<dl>
		<dt>博客(<?php echo $data['count']['artCount'];?>)</dt>
		<dt>轻博(<?php echo $data['count']['mblogCount'];?>)</dt>
		<dt>粉丝</dt>
		<dt>关注</dt>
		<dt>消息</dt>
		<dt>等级</dt>
	</dl>
</div>

</div>
<div class="contentw" style="background:#f6f6f6">
		<input id="tab1" type="radio" class="tabsinput" name="tabs" checked>
		<label for="tab1">文章</label>

		<input id="tab2" type="radio" class="tabsinput" name="tabs">
		<label for="tab2">轻博客</label>

		<input id="tab3" type="radio" class="tabsinput" name="tabs">
		<label for="tab3">问答</label>

		<input id="tab4" type="radio" class="tabsinput" name="tabs">
		<label for="tab4">我参与</label>	
	<section id="content1">
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
					<a href="javascript:void(0);" onclick=edit(this) url="<?php echo $data['url']['edit'].'id='.$art['_id'] ?>">
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
			<?php foreach ($data['mblog'] as $list) { ?>
			
			<div class="avatar"><p style="text-align:center; line-height:40px;font-size:18px;"><?php echo ++$j ?></p></div>
			<p0>
			<div class="front">	</div>
			<div class="micbox">
				<div class="title">
					<?php echo $list['title'];?>
					<div class="doright">
					<a href="javascript:void(0);" onclick=del(this) t="art" url="<?php echo $data['url']['delArt'].'id='.$art['_id'] ?>">
						<span class="icon">Â</span>
					</a>
					</div>
					<div class="doright"><span class="icon">></span>
					</div>
				</div>
				<img src="static/images/test/test.jpg" class="bimg" style="display:none" />
				<main>
				<?php if ($list['imgpath']) { ?>
				<div class="lpart"><img src="<?php echo $list['imgpath'];?>" width="220" height="205"/></div>
				<div class="rpart"><?php echo mb_substr($list['content'], 0, 500,'UTF-8') ?></div>
				<?php } else { ?>
				<div class="onlyword"><?php echo $list['content'];?></div>
				<?php } ?>
				</main>
				<div class="info"><span1><?php echo $list['author'];?></span1></div>
			</div>
			</p0>
			<?php } ?>
	</section>
	<section id="content3">
		<div class="avatar"><p style="text-align:center; line-height:40px;font-size:18px;"><?php echo ++$j ?></p></div>
		<div class="ask">
			<div class="ask-title"><p>你好吗，天气好吗</p></div>
			<div class="info"><span1>pangxie</span1></div>
		</div>
	</section>
</div>
<script>
$(".title").hover(function(){
	$doright = $(this).children(".doright");
	$(this).css("background","#faa");
	$doright.css('display','inline');
})
$(".title").mouseleave(function(){
	$doright = $(this).children(".doright");
	$(this).css("background","");
	$doright.css('display','none');
})
function del(obj){
	var ensure=confirm("删除不可逆，数据无价");
	
	if(ensure){
		var a = $(obj);
		var url = a.attr('url');
		var t = a.attr('t');
		//alert(t);
		$.get(
			url,
			{ type: t}, 
			function(data){
				var jdata =  eval('(' + data + ')');
				if(jdata.status == true){
					window.location.reload();	
				}else{
					alert('休息一下,那里错了!');
				}
		})
		//
	}
}
function edit(obj){
	var a = $(obj);
	var url = a.attr('url');
	var t = a.attr('t');
	$.get(
		url,
		{ type: t}, 
		function(data){
			var jdata =  eval('(' + data + ')');
			if(jdata.status == true){
				window.location.reload();	
			}else{
				alert('休息一下,那里错了!');
			}
		})
}
</script>
</body>
</html>