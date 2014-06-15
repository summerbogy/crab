<?php  if (!defined("IS_INITPHP")) exit("Access Denied!");  /* INITPHP Version 1.0 ,Create on 2014-06-12 13:39:07, compiled from app/web/template/Admin/index/index_default.html */ ?>
<div class="content_tab">
  <ul>
    <li class="checked"  name="<?php echo $indexDefault; ?>">一款通用后台</li>
  </ul>
</div>
<div class="content"">
  <h1>系统参数</h1>
  <table>
    <tr>
      <th width="200">版本</th>
      <td class="top_broder"><?php echo $phpInfo['version']; ?></td>
    </tr>
    <tr>
      <th width="200">系统</th>
      <td class="top_broder"><?php echo $phpInfo['system']; ?></td>
    </tr>
    <tr>
      <th width="200">最大执行时间</th>
      <td class="top_broder"><?php echo $phpInfo['max_time']; ?></td>
    </tr>
    <tr>
      <th width="200">最大上传文件</th>
      <td class="top_broder"><?php echo $phpInfo['max_upload']; ?></td>
    </tr>
    <tr>
      <th width="200">GD库版本</th>
      <td class="top_broder"><?php echo $phpInfo['gd']; ?></td>
    </tr>
    <tr>
      <th width="200">脚本运行占用最大内存</th>
      <td class="top_broder"><?php echo $phpInfo['memory']; ?></td>
    </tr>
    <tr>
      <th width="200">服务器端信息</th>
      <td class="top_broder"><?php echo $phpInfo['server']; ?></td>
    </tr>
    <tr>
      <th width="200">Zend版本</th>
      <td class="top_broder"><?php echo $phpInfo['zend']; ?></td>
    </tr>
    <tr>
      <th width="200">当前时间</th>
      <td class="top_broder"><?php echo $phpInfo['now_time']; ?></td>
    </tr>
    <tr>
      <th width="200">系统开发</th>
      <td class="top_broder">zhuli,小耗子,Yongliang</td>
    </tr>
	
  </table>
</div>
