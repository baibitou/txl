<?php

include("./includes/common.php");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;
$url=daddslashes($_GET['url']);
$authcode=daddslashes($_GET['authcode']);

@header('Content-Type: application/json; charset=UTF-8');

if($act=='shop')
{
	$rs=$DB->query("SELECT * FROM shua_tools WHERE active=1 order by sort asc");
	while($res = $DB->fetch($rs)){
		$data[]=array('tid'=>$res['tid'],'name'=>$res['name'],'price'=>$res['price']);
	}
	$result=array("code"=>1,"msg"=>$conf['anounce'],"data"=>$data,"kaurl"=>$conf['kaurl']);
}
elseif($act=='add')
{
	$tid=intval($_GET['tid']);
	$km=daddslashes($_GET['km']);
	$qq=daddslashes($_GET['qq']);

	if(!$qq||!$km||!$tid)exit('{"code":-4,"msg":"确保各项不能为空"}');

	$tool=$DB->get_row("select * from shua_tools where tid='$tid' limit 1");
	if($tool && $tool['active']==1){

	$myrow=$DB->get_row("select * from shua_kms where km='$km' and tid='$tid' limit 1");

	if(!$myrow)
	{
		$result=array("code"=>-1,"msg"=>"此卡密不存在，不同代刷功能的卡密不能通用！");
	}
	elseif($myrow['user']!=0){
		$result=array("code"=>-1,"msg"=>"此卡密已被使用！");
	}
	else
	{
		$thtime=date("Y-m-d").' 00:00:00';
		$row=$DB->get_row("select * from shua_orders where tid='$tid' and input='$qq' order by id desc limit 1");
		if($row['qq'] && $row['status']==0)
			$result=array("code"=>1,"msg"=>"您今天添加的".$tool['name']."正在排队中，请勿重复提交！","qq"=>$qq);
		elseif($row['addtime']>$thtime)
			$result=array("code"=>1,"msg"=>"您今天已添加过".$tool['name']."，请勿重复提交！","qq"=>$qq);
		else
		{
			$value=$myrow['value']?$myrow['value']:'1000';
			$sql="insert into `shua_orders` (`tid`,`input`,`value`,`addtime`,`status`,`url`) values ('".$tid."','".$qq."','".$value."','".$date."','0','".$url."')";
			if($DB->query($sql)){
				$DB->query("update `shua_kms` set `user` ='$qq',`usetime` ='".$date."' where `kid`='{$myrow['kid']}'");
				$result=array("code"=>1,"msg"=>"添加".$tool['name']."代刷任务成功！","qq"=>$qq);
			}else{
				$result=array("code"=>-2,"msg"=>"添加".$tool['name']."代刷任务失败！".$DB->error(),"qq"=>$qq);
			}
		}
	}
	}else{
		$result=array("code"=>-4,"msg"=>"该商品不存在");
	}
}
elseif($act=='delete')
{
	$tid=intval($_GET['tid']);
	$qq=daddslashes($_GET['qq']);

	if(!$tid||!$qq)exit('确保各项不能为空');

	$row=$DB->get_row("SELECT * FROM shua_orders WHERE input='{$input}' and tid='{$tid}' order by id desc limit 1");
	if($id=$row['id']) {
		$sql="delete `shua_orders` where `id`='{$id}' limit 1";

		if($DB->query($sql)){
			$result=array("code"=>1,"msg"=>"删除任务成功","id"=>$id,"uin"=>$uin);
		}else{
			$result=array("code"=>-2,"msg"=>"删除任务失败","id"=>$id,"uin"=>$uin);
		}
	}
	else
	{
		$result=array("code"=>-1,"msg"=>"没有此记录");
	}
}
elseif($act=='list')
{
	$qq=daddslashes($_GET['qq']);
	$limit=isset($_GET['limit'])?intval($_GET['limit']):10;
	if(!$qq)exit('确保各项不能为空');
	$rs=$DB->query("SELECT * FROM shua_tools WHERE active=1 order by sort asc");
	while($res = $DB->fetch($rs)){
		$shop[]=array('tid'=>$res['tid'],'name'=>$res['name'],'price'=>$res['price']);
		$shua_func[$res['tid']]=$res['name'];
	}
	$rs=$DB->query("SELECT * FROM shua_orders WHERE input='{$qq}' order by id desc limit $limit");
	while($res = $DB->fetch($rs)){
		$data[]=array('id'=>$res['id'],'tid'=>$res['tid'],'qq'=>$res['input'],'name'=>$shua_func[$res['tid']],'value'=>$res['value'],'addtime'=>$res['addtime'],'endtime'=>$res['endtime'],'status'=>$res['status']);
	}
	$result=array("code"=>1,"msg"=>$conf['anounce'],"data"=>$data,"shop"=>$shop,"kaurl"=>$conf['kaurl']);
}
elseif($act=='tools')
{
	$key=daddslashes($_GET['key']);
	$limit=isset($_GET['limit'])?intval($_GET['limit']):50;
	if(!$key)exit('{"code":-5,"msg":"确保各项不能为空"}');
	if($key!=$conf['apikey'])exit('{"code":-4,"msg":"API对接密钥错误，请在后台设置密钥"}');
	$rs=$DB->query("SELECT * FROM shua_tools WHERE active=1 order by tid asc limit $limit");
	while($res = $DB->fetch($rs)){
		$data[]=array('tid'=>$res['tid'],'sort'=>$res['sort'],'name'=>$res['name'],'price'=>$res['price']);
	}
	exit(json_encode($data));
}
elseif($act=='orders')
{
	$tid=intval($_GET['tid']);
	$key=daddslashes($_GET['key']);
	$limit=isset($_GET['limit'])?intval($_GET['limit']):50;
	$format=isset($_GET['format'])?daddslashes($_GET['format']):'json';
	if(!$key)exit('{"code":-5,"msg":"确保各项不能为空"}');
	if($key!=$conf['apikey'])exit('{"code":-4,"msg":"API对接密钥错误，请在后台设置密钥"}');
	if($tid){
		$tool=$DB->get_row("SELECT * FROM shua_tools WHERE tid='$tid' and active=1 limit 1");
		if(!$tool)exit('{"code":-5,"msg":"商品ID不存在"}');
		$sqls=" and tid='$tid'";
	}
	$rs=$DB->query("SELECT * FROM shua_orders WHERE status=0{$sqls} order by id asc limit $limit");
	while($res = $DB->fetch($rs)){
		$data[]=array('id'=>$res['id'],'tid'=>$res['tid'],'input'=>$res['input'],'input2'=>$res['input2'],'input3'=>$res['input3'],'input4'=>$res['input4'],'input5'=>$res['input5'],'value'=>$res['value'],'status'=>$res['status']);
		if($_GET['sign']==1)$DB->query("update `shua_orders` set status=1 where `id`='{$res['id']}'");
	}
	if($format=='text'){
		$txt = '';
		foreach($data as $row){
			$txt .= $row['input'] . ($row['input2']?'----'.$row['input2']:null) . ($row['input3']?'----'.$row['input3']:null) . ($row['input4']?'----'.$row['input4']:null) . ($row['input5']?'----'.$row['input5']:null) . '----' . $row['value'] . "\r\n";
		}
		exit($txt);
	}else{
		exit(json_encode($data));
	}
}
elseif($act=='change')
{
	$id=intval($_GET['id']);
	$key=daddslashes($_GET['key']);
	$status=intval($_GET['zt']); //1:已完成,2:正在处理,3:异常,4:待处理
	if(!$id || !$key)exit('{"code":-5,"msg":"确保各项不能为空"}');
	if($key!=$conf['apikey'])exit('{"code":-4,"msg":"API对接密钥错误，请在后台设置密钥"}');
	$row=$DB->get_row("SELECT * FROM shua_orders WHERE id='$id' limit 1");
	if($id=$row['id']) {
		$sql="update `shua_orders` set `status`='$status' where `id`='{$id}' limit 1";
		if($DB->query($sql)){
			$result=array("code"=>1,"msg"=>"修改成功","id"=>$id);
		}else{
			$result=array("code"=>-2,"msg"=>"修改失败","id"=>$id);
		}
	}
	else
	{
		$result=array("code"=>-5,"msg"=>"订单ID不存在");
	}
}
else
{
	$result=array("code"=>-5,"msg"=>"No Act!");
}

echo json_encode($result);
$DB->close();
?>