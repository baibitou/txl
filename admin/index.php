<?php
/**
 * 自助下单系统
**/
include("../includes/common.php");
$title='后台管理中心 欢迎老大！';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<?php
$sum=$DB->count("SELECT count(*) from shua_pay WHERE 1");
$mysqlversion=$DB->count("select VERSION()");
?>
<div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<div class="panel panel-primary">
        <a href="../"><div class="panel-heading"><h3 class="panel-title"><span class="glyphicon glyphicon-home"> 前往网站主页(<?=date("Y-m-d/H:i:s");?>)</span></h3></div></a>
      </div>
<div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title"><span class="glyphicon glyphicon-search"></span>搜索 共计<b><?=$sum?></b>个美丽的账号</h3></div>
        <div class="panel-body">
          <form action="fish.php" method="get" class="form-inline" role="form">
            <div class="form-group">
              <label>类别</label>
              <select class="form-control">
                <option value="1">ＱＱ</option>
              </select>
            </div>
            <div class="form-group">
              <label>内容</label>
              <input type="text" name="kw" value="" class="form-control" autocomplete="off" required/>
            </div>
			<div class="form-group">
              <select name="method" class="form-control">
                <option value="0">模糊搜索(推荐)</option>
                <option value="1">精确搜索</option>
              </select>
            </div>
            <input type="submit" value="查询" class="btn btn-primary form-control"/>
          </form>
        </div>
      </div>
<div class="panel panel-primary">

	<div class="panel-heading">
		<h3 class="panel-title">服务器信息</h3>
	</div>
	<ul class="list-group">
		<li class="list-group-item">
			<b>PHP 版本：</b><?php echo phpversion() ?>
			<?php if(ini_get('safe_mode')) { echo '线程安全'; } else { echo '非线程安全'; } ?>
		</li>
		<li class="list-group-item">
			<b>MySQL 版本：</b><?php echo $mysqlversion ?>
		</li>
		<li class="list-group-item">
			<b>服务器软件：</b><?php echo $_SERVER['SERVER_SOFTWARE'] ?>
		</li>
		
		<li class="list-group-item">
			<b>程序最大运行时间：</b><?php echo ini_get('max_execution_time') ?>s
		</li>
		<li class="list-group-item">
			<b>POST许可：</b><?php echo ini_get('post_max_size'); ?>
		</li>
		<li class="list-group-item">
			<b>文件上传许可：</b><?php echo ini_get('upload_max_filesize'); ?>
		</li>
	</ul>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title"><span class="glyphicon glyphicon-info-sign">使用必看：</span></h3>
	</div>
	<ul class="list-group">
					 <li class="list-group-item"> <b>法律相关注释:</b></li><b>
		<li class="list-group-item">
			<b>全国人民代表大会常务委员会于2000年12月28日通过的《关于维护互 联网安全的决定》第四条第（二）项规定：“非法截获、篡改、删除他人电子邮件或者其他数据资料，侵犯公民通信自由和通信秘密的，依照刑法有关规定追究刑事责任。</b>
					  </li><li class="list-group-item"> <b> 法律责任申明：</b></li><b>
		<li class="list-group-item">
			<b>（一）猫九</b></li><b>
		<li class="list-group-item">
			<b>（二）由本程序所导致的所有后果，均与发布人无任何责任关系，并且不接受任何采访，调查的配合！网站数据是完全保密的，不对任何人，部门开放性透露！</b></li><b>
      <li class="list-group-item"></li></ul></div>
    </div>
  </div>