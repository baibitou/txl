<?php
/**
 * 系统设置
**/
include("../includes/common.php");
$title='后台管理';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
$mod=isset($_GET['mod'])?$_GET['mod']:null;
if($mod=='site_n'){
	$sitename=$_POST['sitename'];
	$title=$_POST['title'];
	$keywords=$_POST['keywords'];
	$description=$_POST['description'];
	$kfqq=$_POST['kfqq'];
	$kaurl=$_POST['kaurl'];
	$lqqapi=$_POST['lqqapi'];
	$build=$_POST['build'];
	$qqjump=$_POST['qqjump'];
	$apikey=$_POST['apikey'];
	$pwd=$_POST['pwd'];
	saveSetting('sitename',$sitename);
	saveSetting('title',$title);
	saveSetting('keywords',$keywords);
	saveSetting('description',$description);
	saveSetting('kfqq',$kfqq);
	saveSetting('kaurl',$kaurl);
	saveSetting('lqqapi',$lqqapi);
	saveSetting('build',$build);
	saveSetting('qqjump',$qqjump);
	saveSetting('apikey',$apikey);
	if(!empty($pwd))saveSetting('admin_pwd',$pwd);
	$ad=$CACHE->clear();
	if($ad)showmsg('修改成功！',1);
	else showmsg('修改失败！<br/>'.$DB->error(),4);
}elseif($mod=='site'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">网站信息配置</h3></div>
<div class="panel-body">
  <form action="./set.php?mod=site_n" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">网站名称</label>
	  <div class="col-sm-10"><input type="text" name="sitename" value="<?php echo $conf['sitename']; ?>" class="form-control" required/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">标题栏后缀</label>
	  <div class="col-sm-10"><input type="text" name="title" value="<?php echo $conf['title']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">关键字</label>
	  <div class="col-sm-10"><input type="text" name="keywords" value="<?php echo $conf['keywords']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">网站描述</label>
	  <div class="col-sm-10"><input type="text" name="description" value="<?php echo $conf['description']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">客服ＱＱ</label>
	  <div class="col-sm-10"><input type="text" name="kfqq" value="<?php echo $conf['kfqq']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">666</label>
	  <div class="col-sm-10"><input type="text" name="kaurl" value="<?php echo $conf['kaurl']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">网站创建时间</label>
	  <div class="col-sm-10"><input type="date" name="build" value="<?php echo $conf['build']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">拉圈圈赞API</label>
	  <div class="col-sm-10"><input type="text" name="lqqapi" value="<?php echo $conf['lqqapi']; ?>" class="form-control" placeholder="填写后将在首页显示免费拉圈圈，没有请留空"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">手机QQ打开网站跳转其他浏览器</label>
	  <div class="col-sm-10"><select class="form-control" name="qqjump" default="<?php echo $conf['qqjump']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">API对接密钥</label>
	  <div class="col-sm-10"><input type="text" name="apikey" value="<?php echo $conf['apikey']; ?>" class="form-control"/></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">密码重置</label>
	  <div class="col-sm-10"><input type="text" name="pwd" value="" class="form-control" placeholder="不修改请留空"/></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<?php
}elseif($mod=='gonggao_n'){
	$anounce=$_POST['anounce'];
	$modal=$_POST['modal'];
	$bottom=$_POST['bottom'];
	saveSetting('anounce',$anounce);
	saveSetting('modal',$modal);
	saveSetting('bottom',$bottom);
	$ad=$CACHE->clear();
	if($ad)showmsg('修改成功！',1);
	else showmsg('修改失败！<br/>'.$DB->error(),4);
}elseif($mod=='gonggao'){
?>
<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">网站公告配置</h3></div>
<div class="panel-body">
  <form action="./set.php?mod=gonggao_n" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-2 control-label">首页公告</label>
	  <div class="col-sm-10"><textarea class="form-control" name="anounce" rows="6"><?php echo htmlspecialchars($conf['anounce']);?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">猫九QQ215087881</label>
	  <div class="col-sm-10"><textarea class="form-control" name="modal" rows="5"><?php echo htmlspecialchars($conf['modal']);?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <label class="col-sm-2 control-label">QQ群暂时没有</label>
	  <div class="col-sm-10"><textarea class="form-control" name="bottom" rows="5"><?php echo htmlspecialchars($conf['bottom']);?></textarea></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	</div>
  </form>
</div>
</div>
<?php
}elseif($mod=='upimg'){
echo '<div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title"> </h3></div><div class="panel-body">';
if($_POST['s']==1){
$extension=explode('.',$_FILES['file']['name']);
if (($length = count($extension)) > 1) {
$ext = strtolower($extension[$length - 1]);
}
if($ext=='png'||$ext=='gif'||$ext=='jpg'||$ext=='jpeg'||$ext=='bmp')$ext='png';
copy($_FILES['file']['tmp_name'], ROOT.'assets/img/logo.'.$ext);
echo "成功上传文件!<br>（可能需要清空浏览器缓存才能看到效果）";
}
echo '<form action="set.php?mod=upimg" method="POST" enctype="multipart/form-data"><label for="file"></label><input type="file" name="file" id="file" /><input type="hidden" name="s" value="1" /><br><input type="submit" class="btn btn-primary btn-block" value="确认上传" /></form><br>现在的图片：<br><img src="../assets/img/logo.png?r='.rand(10000,99999).'" style="max-width:100%">';
echo '</div></div>';
}?>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
</script>
    </div>
  </div>