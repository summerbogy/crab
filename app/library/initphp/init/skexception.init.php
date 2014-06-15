<?php
if (!defined('IS_INITPHP')) exit('Access Denied!');
/*********************************************************************************
 * InitPHP 3.5 国产PHP开发框架 - 异常类
 *-------------------------------------------------------------------------------
 * 版权所有: CopyRight By initphp.com
 * 您可以自由使用该源码，但是在使用过程中，请保留作者信息。尊重他人劳动成果就是尊重自己
 *-------------------------------------------------------------------------------
 * $Author:zhuli
 * $Dtime:2013-5-29
 * $Modify Author:SK(michaellee)
 * $Modify Time:2014-4-22
 ***********************************************************************************/
class exceptionInit extends Exception{
	/**
	 * error log path
	 * @var string
	 */
	private $_errorLogPath='data/errorLog/';
	/**
	 * show error message
	 */
	public function errorMessage() {
		$InitPHP_conf = InitPHP::getConfig();
		$msg = $this->message;
		if (!$InitPHP_conf['is_debug'] && $this->code == 10000) {
			$msg = '系统繁忙，请稍后再试';
		}
		if ($this->is_ajax()) {
			$arr = array('status' => 0, 'message' => $msg, 'data' => array('code' => $this->code));
			echo json_encode($arr);
		} else {
			//如果debug关闭，则不显示debug错误信息
			if (!$InitPHP_conf['is_debug']) {
				return;
			}
			$mainErrorCode=$this->getLineCode($this->getFile(), $this->getLine());
			$trace=$this->getTrace();
			$runTrace=$this->getTrace();
			krsort($runTrace);
			$traceMessageHtml=null;$k=1;
			foreach ($runTrace as $v) {
				$traceMessageHtml.='<tr class="bg1"><td>'.$k.'</td><td>'.$v['file'].'</td><td>'.$v['line'].'</td><td>'.$this->getLineCode($v['file'], $v['line']).'</td></tr>';
				$k++;
			}
			unset($k);unset($trace);unset($runTrace);unset($trace);
			if (isset($InitPHP_conf['sqlcontrolarr']) && is_array($InitPHP_conf['sqlcontrolarr'])) {
				foreach ($InitPHP_conf['sqlcontrolarr'] as $k => $v) {
					$sqlTraceHtml.='<tr class="bg1"><td>'.($k+1).'</td><td>'.$v['sql'].'</td><td>'.$v['queryTime'].'s</td><td>'.$v['affectedRows'].'</td></tr>';
				}
			}
			echo '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html><head><title>'.$_SERVER['HTTP_HOST'].' - PHP Error</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="ROBOTS" content="NOINDEX,NOFOLLOW,NOARCHIVE" />
<style type="text/css">
<!--
body { background-color: white; color: black; font: 9pt/11pt verdana, arial, sans-serif;}
#container { width: 90%;margin-left:auto;margin-right:auto; }
#message   { width: 90%; color: black; }
.red  {color: red;}
a:link     { font: 9pt/11pt verdana, arial, sans-serif; color: red; }
a:visited  { font: 9pt/11pt verdana, arial, sans-serif; color: #4e4e4e; }
h1 { color: #FF0000; font: 18pt "Verdana"; margin-bottom: 0.5em;}
.bg1{ background-color: #FFFFCC;}
.bg2{ background-color: #EEEEEE;}
.table {background: #AAAAAA; font: 11pt Menlo,Consolas,"Lucida Console"}
.info {background: none repeat scroll 0 0 #F3F3F3;border: 0px solid #aaaaaa;border-radius: 10px 10px 10px 10px;color: #000000;font-size: 11pt;line-height: 160%;margin-bottom: 1em;padding: 1em;}
.help {
background: #F3F3F3;border-radius: 10px 10px 10px 10px;font: 12px verdana, arial, sans-serif;text-align: center;line-height: 160%;padding: 1em;}
.mind {
background: none repeat scroll 0 0 #FFFFCC;
border: 1px solid #aaaaaa;
color: #000000;
font: arial, sans-serif;
font-size: 9pt;
line-height: 160%;
margin-top: 1em;
padding: 4px;}
	-->
	</style></head><body><div id="container"><h1>InitPHP DEBUG</h1><div class="info">(1146)'.$msg.'</div><div class="info"><p><strong>PHP Trace</strong></p><table cellpadding="5" cellspacing="1" width="100%" class="table"><tr class="bg2"><td style="width:2%">No.</td><td style="width:45%">File</td><td style="width:5%">Line</td><td style="width:48%">Code</td></tr>'.$traceMessageHtml.'</table><p><strong>SQL Query</strong></p><table cellpadding="5" cellspacing="1" width="100%" class="table"><tr class="bg2"><td style="width:2%">No.</td><td style="width:73%">SQL</td><td style="width:10%">Cost Time</td><td style="width:15%">Affected Rows</td></tr>'.$sqlTraceHtml.'</table></div> <div class="help"><a href="http://'.$_SERVER['HTTP_HOST'].'">'.$_SERVER['HTTP_HOST'].'</a> 已经将此出错信息详细记录, 由此给您带来的访问不便我们深感歉意.</div></div></body></html>';
			$InitPHP_conf = InitPHP::getConfig();
			if($InitPHP_conf['record_error_log']==true){
				$this->_recordError($msg,$this->getFile(),$this->getLine(),$mainErrorCode);
			}
			exit;
		}
	}

	/**
	 * @return bool
	 */
	private function is_ajax() {
		if ($_SERVER['HTTP_X_REQUESTED_WITH'] && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') return true;
		if ($_POST['initphp_ajax'] || $_GET['initphp_ajax']) return true; //程序中自定义AJAX标识
		return false;
	}
	/**
	 *
	 * get error file line code
	 * @param string $file
	 * @param int $line
	 * @return string
	 */
	private function getLineCode($file,$line) {
		$fp = fopen($file,'r');
		$i = 0;
		while(!feof($fp)) {
			$i++;
			$c = fgets($fp);
			if($i==$line) {
				return $c;
				break;
			}
		}
	}
	/**
	 * record error log
	 * @param string $msg
	 * @param string $file
	 * @param int $line
	 * @param string $code
	 */
	private function _recordError($msg,$file,$line,$code){
		$errorLogPaTh=APP_PATH.$this->_errorLogPath;
		if(!is_dir($errorLogPath))mkdir($errorLogPath);
		$errorLogFilePath=$errorLogPaTh.$this->_errorLogFileName();
		$string=file_get_contents($errorLogFilePath);
		$string.='['.date('Y-m-d h:i:s').']msg:'.$msg.';file:'.$file.';line:'.$line.';code:'.$code.'';
		file_put_contents($errorLogFilePath,$string);
	}
	/**
	 *
	 * @return string
	 */
	private function _errorLogFileName(){
		return date('Y-m-d').'.log';
	}
}