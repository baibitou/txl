<?php
include("./includes/common.php");
$act=isset($_GET['act'])?daddslashes($_GET['act']):null;

@header('Content-Type: application/json; charset=UTF-8');

switch($act){
case 'pay':
	$ip = real_ip();
	$tid=intval($_POST['tid']);
	$inputvalue=daddslashes($_POST['inputvalue']);
	$inputvalue2=daddslashes($_POST['inputvalue2']);
	$inputvalue3=daddslashes($_POST['inputvalue3']);
	$inputvalue4=daddslashes($_POST['inputvalue4']);
	$inputvalue5=daddslashes($_POST['inputvalue5']);
	$gkm=$DB->get_row("select * from shua_kms WHERE user=0 order by rand() limit 1");
	$tool=$DB->get_row("select * from shua_tools where tid='$tid' limit 1");
	if($tool && $tool['active']==1){
		if($tool['repeat']==0){
			$thtime=date("Y-m-d").' 00:00:00';
			$row=$DB->get_row("select * from shua_orders where tid='$tid' and input='$inputvalue' order by id desc limit 1");
			if($row['input'] && $row['status']==0)
				exit('{"code":-1,"msg":"您今天添加的'.$tool['name'].'正在排队中，请勿重复提交！"}');
			elseif($row['addtime']>$thtime)
				exit('{"code":-1,"msg":"您今天已添加过'.$tool['name'].'，请勿重复提交！"}');
		}
		$kms=$gkm['km'];
		$need=$tool['price'];
		$trade_no=date("YmdHis").rand(111,999);
		$input=$inputvalue.($inputvalue2?'|'.$inputvalue2:null).($inputvalue3?'|'.$inputvalue3:null).($inputvalue4?'|'.$inputvalue4:null).($inputvalue5?'|'.$inputvalue5:null);
		$sql="insert into `shua_pay` (`trade_no`,`tid`,`input`,`name`,`money`,`addtime`,`ip`,`status`) values ('".$trade_no."','".$tid."','".$input."','".$tool['name']."','".$need."','".$date."','".$ip."','0')";
		if($DB->query($sql)){
			exit('{"code":0,"msg":"提交订单成功！","trade_no":"'.$trade_no.'","need":"'.$need.'","kms":"'.$kms.'"}');
		}else{
			exit('{"code":-1,"msg":"提交订单失败！'.$DB->error().'"}');
		}
	}else{
		exit('{"code":-2,"msg":"该商品不存在"}');
	}
break;
case 'card':
	$qq=daddslashes($_POST['qq']);
	$km=daddslashes($_POST['km']);
	$myrow=$DB->get_row("select * from shua_kms where km='$km' limit 1");
	if(!$myrow)
	{
		exit('{"code":-1,"msg":"此卡密不存在！"}');
	}
	elseif($myrow['user']!=0){
		exit('{"code":-1,"msg":"此卡密已被使用！"}');
	}
	else
	{
		$tid=$myrow['tid'];
		$tool=$DB->get_row("select * from shua_tools where tid='$tid' limit 1");
		if($tool && $tool['active']==1){
			if($tool['repeat']==0){
				$thtime=date("Y-m-d").' 00:00:00';
				$row=$DB->get_row("select * from shua_orders where tid='$tid' and input='$qq' order by id desc limit 1");
				if($row['input'] && $row['status']==0)
					exit('{"code":-1,"msg":"您今天添加的'.$tool['name'].'正在排队中，请勿重复提交！"}');
				elseif($row['addtime']>$thtime)
					exit('{"code":-1,"msg":"您今天已添加过'.$tool['name'].'，请勿重复提交！"}');
			}
			if($row['input'] && $row['status']==0){
				$sql="update `shua_orders` set `value`=`value`+1 where `id`='{$row['id']}'";
			}else{
				$sql="insert into `shua_orders` (`tid`,`input`,`value`,`addtime`,`status`) values ('".$tid."','".$qq."','1','".$date."','0')";
			}
			if($DB->query($sql)){
				$DB->query("update `shua_kms` set `user` ='$qq',`usetime` ='".$date."' where `kid`='{$myrow['kid']}'");
				exit('{"code":0,"msg":"'.$tool['name'].' 下单成功！你可以在进度查询中查看代刷进度"}');
			}else{
				exit('{"code":-1,"msg":"'.$tool['name'].' 下单失败！'.$DB->error().'"}');
			}
		}else{
			exit('{"code":-2,"msg":"该商品不存在"}');
		}
	}
break;
case 'query':
	$qq=daddslashes($_POST['qq']);
	$limit=isset($_POST['limit'])?intval($_POST['limit']):10;
	$rs=$DB->query("SELECT * FROM shua_tools WHERE active=1 order by sort asc");
	while($res = $DB->fetch($rs)){
		$shua_func[$res['tid']]=$res['name'];
	}
	$rs=$DB->query("SELECT * FROM shua_orders WHERE input='{$qq}' order by id desc limit $limit");
	$data=array();
	while($res = $DB->fetch($rs)){
		$data[]=array('id'=>$res['id'],'tid'=>$res['tid'],'input'=>$res['input'],'name'=>$shua_func[$res['tid']],'value'=>$res['value'],'addtime'=>$res['addtime'],'endtime'=>$res['endtime'],'status'=>$res['status']);
	}
	$result=array("code"=>0,"msg"=>"succ","data"=>$data);
	exit(json_encode($result));
break;
case 'lqq':
	$qq=daddslashes($_POST['qq']);
	if(empty($qq) || empty($_SESSION['addsalt']) || $_POST['salt']!=$_SESSION['addsalt'])exit('{"code":-5,"msg":"非法请求"}');
	get_curl($conf['lqqapi'].$qq);
	$result=array("code"=>0,"msg"=>"succ");
	exit(json_encode($result));
break;
default:
	exit('{"code":-4,"msg":"No Act"}');
break;
}