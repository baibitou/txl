<?php
/**
 * 注册管理
**/
include("../includes/common.php");
$title='注册管理';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
$my=isset($_GET['my'])?$_GET['my']:null;

if($my=='add')
{
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">添加一个注册</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./clist.php?my=add_submit" method="POST">
<div class="form-group">
<label>*名称:</label><br>
<input type="text" class="form-control" name="name" value="" required>
</div>
<div class="form-group">
<label>*白新:</label><br>
<input type="text" class="form-control" name="price" value="" required>
</div>
<div class="form-group">
<label>第一个输入框标题:</label><br>
<input type="text" class="form-control" name="input" value="" placeholder="留空默认为“ＱＱ账号”">
</div>
<div class="form-group">
<label>更多输入框标题:</label><br>
<input type="text" class="form-control" name="inputs" value="" placeholder="留空则不显示更多输入框">
<pre><font color="green">多个输入框请用|隔开(不能超过4个)</font></pre>
</div>
<div class="form-group">
<label>提示内容:</label>(没有请留空)<br>
<input type="text" class="form-control" name="alert" value="" placeholder="当选择该商品时自动弹出提示">
</div>
<div class="form-group">
<label>*允许重复注册:</label><br>
<select class="form-control" name="repeat"><option value="1">1_是</option><option value="0">0_否</option></select>
</div>
<div class="form-group">
<label>*排序(数字越小越靠前):</label><br>
<input type="number" class="form-control" name="sort" value="10" required>
</div>
<div class="form-group">
<label>*是否上架:</label><br>
<select class="form-control" name="active"><option value="1">1_是</option><option value="0">0_否</option></select>
</div>
<input type="submit" class="btn btn-primary btn-block" value="确定添加"></form>';
echo '<br/><a href="./clist.php">>>返回类别列表</a>';
}
elseif($my=='edit')
{
$tid=$_GET['tid'];
$row=$DB->get_row("select * from shua_tools where tid='$tid' limit 1");
echo '<div class="panel panel-primary">
<div class="panel-heading"><h3 class="panel-title">修改注册信息</h3></div>';
echo '<div class="panel-body">';
echo '<form action="./clist.php?my=edit_submit&tid='.$tid.'" method="POST">
<div class="form-group">
<label>名称:</label><br>
<input type="text" class="form-control" name="name" value="'.$row['name'].'" required>
</div>
<div class="form-group">
<label>价格:</label><br>
<input type="text" class="form-control" name="price" value="'.$row['price'].'" required>
</div>
<div class="form-group">
<label>第一个输入框标题:</label><br>
<input type="text" class="form-control" name="input" value="'.$row['input'].'" placeholder="留空默认为“ＱＱ账号”">
</div>
<div class="form-group">
<label>更多输入框标题:</label><br>
<input type="text" class="form-control" name="inputs" value="'.$row['inputs'].'" placeholder="留空则不显示更多输入框">
<pre><font color="green">多个输入框请用|隔开(不能超过4个)</font></pre>
</div>
<div class="form-group">
<label>提示内容:</label>(没有请留空)<br>
<input type="text" class="form-control" name="alert" value="'.$row['alert'].'" placeholder="当选择该注册时自动弹出提示">
</div>
<div class="form-group">
<label>*允许重复注册:</label><br>
<select class="form-control" name="repeat" default="'.$row['repeat'].'"><option value="1">1_是</option><option value="0">0_否</option></select>
</div>
<div class="form-group">
<label>排序(数字越小越靠前):</label><br>
<input type="number" class="form-control" name="sort" value="'.$row['sort'].'" required>
</div>
<div class="form-group">
<label>是否上架:</label><br>
<select class="form-control" name="active" default="'.$row['active'].'"><option value="1">1_是</option><option value="0">0_否</option></select>
</div>
<input type="submit" class="btn btn-primary btn-block"
value="确定修改"></form>
';
echo '<br/><a href="./clist.php">>>返回类别列表</a>';
echo '</div></div>
<script>
$("select[name=\'is_curl\']").change(function(){
	if($(this).val() == 1){
		$("#curl_display").css("display","inherit");
	}else{
		$("#curl_display").css("display","none");
	}
});
function Addstr(id, str) {
	$("#"+id).val($("#"+id).val()+str);
}
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default")||0);
}
</script>';
}
elseif($my=='add_submit')
{
$name=$_POST['name'];
$price=$_POST['price'];
$input=$_POST['input'];
$inputs=$_POST['inputs'];
$alert=$_POST['alert'];
$repeat=$_POST['repeat'];
$sort=$_POST['sort'];
$active=$_POST['active'];
if($name==NULL or $price==NULL){
showmsg('保存错误,请确保每项都不为空!',3);
} else {
$sql="insert into `shua_tools` (`name`,`price`,`input`,`inputs`,`alert`,`repeat`,`sort`,`active`) values ('".$name."','".$price."','".$input."','".$inputs."','".$alert."','".$repeat."','".$sort."','".$active."')";
if($DB->query($sql)){
	showmsg('添加注册成功！<br/><br/><a href="./clist.php">>>返回注册列表</a>',1);
}else
	showmsg('添加注册失败！'.$DB->error(),4);
}
}
elseif($my=='edit_submit')
{
$tid=$_GET['tid'];
$rows=$DB->get_row("select * from shua_tools where tid='$tid' limit 1");
if(!$rows)
	showmsg('当前记录不存在！',3);
$name=$_POST['name'];
$price=$_POST['price'];
$input=$_POST['input'];
$inputs=$_POST['inputs'];
$alert=$_POST['alert'];
$repeat=$_POST['repeat'];
$sort=$_POST['sort'];
$active=$_POST['active'];
if($name==NULL or $price==NULL){
showmsg('保存错误,请确保每项都不为空!',3);
} else {
if($DB->query("update shua_tools set name='$name',price='$price',input='$input',inputs='$inputs',alert='$alert',sort='$sort',`repeat`='$repeat',active='$active' where tid='{$tid}'"))
	showmsg('修改注册成功！<br/><br/><a href="./clist.php">>>返回注册列表</a>',1);
else
	showmsg('修改商品失败！'.$DB->error(),4);
}
}
elseif($my=='delete')
{
$tid=$_GET['tid'];
$sql="DELETE FROM shua_tools WHERE tid='$tid'";
if($DB->query($sql))
	showmsg('删除成功！<br/><br/><a href="./clist.php">>>返回注册列表</a>',1);
else
	showmsg('删除失败！'.$DB->error(),4);
}
else
{

$numrows=$DB->count("SELECT count(*) from shua_tools");
$sql=" 1";
$con='系统共有 <b>'.$numrows.'</b> 个注册<br/><a href="./clist.php?my=add" class="btn btn-primary">添加注册</a>';

echo '<div class="alert alert-info">';
echo $con;
echo '</div>';

?>
				<div class="panel panel-success">
					<div class="panel-heading">
					<span class="glyphicon glyphicon-pencil"> 注册数据列表
					<div class="form-group">
					<div class="input-group">
    </div>
  </div></div>
	<div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>名称</th><th>白新</th><th>状态</th><th>操作</th></tr></thead>
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

$rs=$DB->query("SELECT * FROM shua_tools WHERE{$sql} order by sort asc");
while($res = $DB->fetch($rs))
{
echo '<tr><td><b>'.$res['tid'].'</b></td><td>'.$res['name'].'</td><td>'.$res['price'].'</td><td>'.($res['active']==1?'<font color=green>上架中</font>':'<font color=red>已下架</font>').'</td><td><a href="./clist.php?my=edit&tid='.$res['tid'].'" class="btn btn-info btn-xs">编辑</a>&nbsp;<a href="./clist.php?my=delete&tid='.$res['tid'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此注册吗？\');">删除</a></td></tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php }?>
    </div>
  </div>