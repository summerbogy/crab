<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2014-06-12 13:35:03, compiled from app/web/template/Admin/index/index_login.html */ ?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!--{if (STATIC_PATH != '') {}-->
<base href="<!--{echo STATIC_PATH}-->" />
<!--{}}-->
<title>一款通用后台</title>
<link href="static/style/admin/comm.css" rel="stylesheet" type="text/css">
<link href="static/style/admin/login.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="login_main">
  <div class="login_title"></div>
  <div class="login_form">
    <form id="login" action="/?m=Admin&c=index&a=checkLogin" method="post" name="login"> 
      <input type="hidden" value="c9a36196" name="initphp_token">
      <input id="admin_name" class="login_input" type="text" name="username" tabindex="1" required > 
      <input id="admin_pwd" class="login_input" type="password" name="password" tabindex="2" required > 
      <input class="login_btn" type="image" name="submit" src="static/images/admin/btn2.png" required >
    </form>
  </div>
  <div class="login_msg" id="msg">
  <div class="login_msg_img"><img src="static/images/admin/no.gif"></div>
  <div id="login_msg_str"></div>
  </div>
</div>
<script src="static/js/jquery.js" type="text/javascript"></script>
<script src="static/js/common/jquery.form.js" type="text/javascript"></script>
<!-- <script type="text/javascript">
var loginForm = function (id, url) {
	 $('#' + id).ajaxForm(function(result) {
			if (url == '') url = location.href;
	 		//result = eval('(' + result + ')');
            /*if (result.status == 0) {
				$("#msg").show();
				$("#login_msg_str").html(result.message);
			} else {
				location.href = url;
			}*/
			location.href=url;
     });	
}
$(document).ready(function() {
	loginForm('login', '/?m=Admin&c=index&a=checkLogin');
});
</script> -->
</body>
</html>
