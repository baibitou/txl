<?php

include("../includes/common.php");

if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");

$date=date("Y-m-d");
$data='';

$rs=$DB->query("SELECT * FROM shua_pay order by addtime asc limit 10000000000");

while($row = $DB->fetch($rs))
{
	$data.=$row['input'] . "提交时间" . $row['addtime']."\r\n";
}

$file_name='output_'.$date.'_'.time().'.txt';
$file_size=strlen($data);
header("Content-Description: File Transfer");
header("Content-Type:application/force-download");
header("Content-Length: {$file_size}");
header("Content-Disposition:attachment; filename={$file_name}");
echo $data;
?>