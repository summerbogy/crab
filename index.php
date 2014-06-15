<?php
define("APP_PATH", 'app/'); 
header("Content-Type:text/html; charset=utf-8");   
require_once(APP_PATH . 'library/initphp/initphp.php'); //导入配置文件-必须载入
require_once(APP_PATH . 'conf/comm.conf.php'); //后台配置
require_once(APP_PATH . 'conf/index.conf.php'); //首页配置

InitPHP::import('library/helper/BaseDao.php');
InitPHP::import('library/helper/BaseController.php'); 
InitPHP::import('library/helper/BaseUserController.php'); 
InitPHP::import('library/helper/BaseUcenterController.php'); 
InitPHP::import('library/helper/BaseAdminController.php'); 
InitPHP::init(); 
?>