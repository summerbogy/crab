<?php
/* 框架全局配置变量 */
$InitPHP_conf = array();
/**
 * 站点URL配置
 * 必选参数
 */
$InitPHP_conf['url'] = 'http://www.bogy.cc/'; 
/**
 * 是否开启调试
 */
$InitPHP_conf['is_debug'] = true; //开启-正式上线请关闭
/**
 * 路由访问方式
 * 1. 如果为true 则开启path访问方式，否则关闭
 * 2. default：index.php?m=user&c=index&a=run
 * 3. rewrite：/user/index/run/?id=100
 * 4. path: /user/index/run/id/100
 * 5. html: user-index-run.htm?uid=100
 * 6. 开启PATH需要开启APACHE的rewrite模块，详细使用会在文档中体现
 */
$InitPHP_conf['isuri'] = 'default'; 
/**
 * 是否开启输出自动过滤
 * 1. 对多人合作，安全性可控比较差的项目建议开启
 * 2. 对HTML进行转义，可以放置XSS攻击
 * 3. 如果不开启，则提供InitPHP::output()函数来过滤
 */
$InitPHP_conf['isviewfilter'] = false; 
/**
 * Error模板
 * 如果使用工具库中的error，需要配置
 */
$InitPHP_conf['error']['template'] = 'library/helper/error.tpl.php';

$InitPHP_conf['ismodule'] =	false; //开启module方式
$InitPHP_conf['controller']['path']                  = 'app/web/controller/Home/'; 
$InitPHP_conf['controller']['controller_postfix']    = 'Controller'; //控制器文件后缀名
$InitPHP_conf['controller']['action_postfix']        = ''; //Action函数名称后缀
$InitPHP_conf['controller']['default_controller']    = 'index'; //默认执行的控制器名称
$InitPHP_conf['controller']['default_action']        = 'run'; //默认执行的Action函数
$InitPHP_conf['controller']['module_list']           = array('Home', 'default'); //module白名单
$InitPHP_conf['controller']['default_module']        = 'index'; //默认执行module
$InitPHP_conf['controller']['default_before_action'] = 'before'; //默认前置的ACTION名称  
$InitPHP_conf['controller']['default_after_action']  = 'after'; //默认后置ACTION名称

/**
 * 模板配置
 * 1. 可以自定义模板的文件夹，编译模板路径，模板文件后缀名称，编译模板后缀名称
 * 是否编译，模板的驱动和模板的主题
 * 2. 一般情况下，默认配置是最优的配置方案，你可以不选择修改模板文件参数
 */
$InitPHP_conf['template']['template_path']      = 'web/template'; //模板路径
$InitPHP_conf['template']['template_c_path']    = 'web/template_c'; //模板编译路径 
$InitPHP_conf['template']['template_type']      = 'htm'; //模板文件类型  
$InitPHP_conf['template']['template_c_type']    = 'tpl.php';//模板编译文件类型 
$InitPHP_conf['template']['template_tag_left']  = '<{';//模板左标签
$InitPHP_conf['template']['template_tag_right'] = '}>';//模板右标签
$InitPHP_conf['template']['is_compile']         = true;//模板每次编译-系统上线后可以关闭此功能
$InitPHP_conf['template']['driver']             = 'simple'; //不同的模板驱动编译
$InitPHP_conf['template']['theme']              = ''; //模板主题

/**
 * Service配置参数
 * 1. 你可以配置service的路径和文件（类名称）的后缀名
 * 2. 一般情况下您不需要改动此配置
 */
$InitPHP_conf['service']['service_postfix']  = 'Service'; //后缀
$InitPHP_conf['service']['path'] = 'library/service/'; //service路径

/**
 * 数据库配置
 * 1. 根据项目的数据库情况配置
 * 2. 支持单数据库服务器，读写分离，随机分布的方式
 * 3. 可以根据$InitPHP_conf['db']['default']['db_type'] 选择mysql mysqli（暂时支持这两种）
 * 4. 支持多库配置 $InitPHP_conf['db']['default']
 * 5. 详细见文档
 */
$InitPHP_conf['db']['driver']	= 'mysqli'; //选择不同的数据库DB 引擎，一般默认mysqli,或者mysqls
//default数据库配置 一般使用中 $this->init_db('default')-> 或者 $this->init_db()-> 为默认的模型
$InitPHP_conf['db']['default']['db_type']					= 0; //0-单个服务器，1-读写分离，2-随机
$InitPHP_conf['db']['default'][0]['host']                  	= '127.0.0.1'; //主机
$InitPHP_conf['db']['default'][0]['username']              	= 'root'; //数据库用户名
$InitPHP_conf['db']['default'][0]['password']              	= '123456'; //数据库密码
$InitPHP_conf['db']['default'][0]['database']              	= 'cargo'; //数据库
$InitPHP_conf['db']['default'][0]['charset']               	= 'utf8'; //数据库编码   
$InitPHP_conf['db']['default'][0]['pconnect']              	= 0; //是否持久链接

$InitPHP_conf['db']['table_pre']			              	= 'cg_';

























?>