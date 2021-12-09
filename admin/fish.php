<?php
/**
 * 订单管理
**/
include("../includes/common.php");
$title='注册信息管理';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<div class="modal fade" align="left" id="search" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">搜索QQ号/手机号</h4>
      </div>
      <div class="modal-body">
      <form action="fish.php" method="GET">
			<div class="form-group">
              <select name="method" class="form-control">
                <option value="0">模糊搜索(推荐)</option>
                <option value="1">精确搜索</option>
              </select>
            </div>
            <div class="form-group">
              <input type="text" name="kw" value="" class="form-control" autocomplete="off" placeholder="搜索内容" required/>
            </div>
            <input type="submit" value="查询" class="btn btn-primary form-control"/>
</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php
if($_GET['clear']=='del'){
	$id=intval($_GET['id']);
	$sql="DELETE FROM shua_pay WHERE id='$id' limit 1";
	if($DB->query($sql)){
		showmsg('删除成功！',1,$_SERVER['HTTP_REFERER']);
	}
	else showmsg('删除失败！<br/>'.$DB->error(),4,$_SERVER['HTTP_REFERER']);
}
if($_GET['clear']=='all'){
if($DB->query("DELETE FROM shua_pay WHERE 1")==true){
		showmsg('删除成功！',1,$_SERVER['HTTP_REFERER']);
	}
	else showmsg('删除失败！<br/>'.$DB->error(),4,$_SERVER['HTTP_REFERER']);
}
if(isset($_GET['kw'])) {
	$sql=($_GET['method']==0)?" `input` LIKE '%{$_GET['kw']}%'":" `input`='{$_GET['kw']}'";
	$numrows=$DB->count("SELECT count(*) from shua_pay WHERE{$sql}");
	$con='含 '.$_GET['kw'].' 的共计 <b>'.$numrows.'</b> 条数据';
}else{
	$numrows=$DB->count("SELECT count(*) from shua_pay");
	$sql=" 1";
	$con='系统已记录共计 <b>'.$numrows.'</b> 条无私&美丽的数据';
}
echo '<div class="alert alert-info">';
echo $con;
echo '<a href="download.php" class="btn btn-primary">下载<a href="#" data-toggle="modal" data-target="#search" id="search" class="btn btn-success">搜索<a href="?clear=all" class="btn btn-danger" onclick="return confirm("你确实要清空吗？");">清空</a>';
echo '</div>';
?>
				<div class="panel panel-success">
					<div class="panel-heading">
					<span class="glyphicon glyphicon-pencil"> 鱼仔销售数据列表
					<div class="form-group">
					<div class="input-group">
    </div>
  </div></div>
	<div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>QQ号|手机号</th><th>IP地址</th><th>注册时间</th><th>操作</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM shua_pay WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<tr><td>'.$res['id'].'</td><td>'.$res['input'].'</td><td>'.$res['ip'].'</td><td>'.$res['addtime'].'</td><td><a href="?clear=del&id='.$res['id'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除吗？😄\');">删除</a></td></tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php
echo'<div style="text-align:right;">';
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
echo '<li><a class="btn btn-default">页大小：'.$pagesize.'</a></li>';
echo '<li><a class="btn btn-default">记录傻逼用户总数：'.$numrows.' 条</a></li>';
if ($page>1)
{
echo '<li><a href="list.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="list.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$pages;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="list.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="list.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
    </div>
  </div>