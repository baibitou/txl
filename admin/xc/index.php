<?php
header("Content-Type:text/html;charset=gb2312");
echo "
<html>
<head>
<title>偷拍相册后台</title>
</head>
<body bgcolor=ffffff>
<center>
<h1>图库<h1>
<font size=2 color=red>";//输出html相关代码
$page=$_GET['page'];//获取当前页数
$max=10;//设置每页显示图片最大张数
$handle = opendir('./'); //当前目录
  while (false !== ($file = readdir($handle))) { //遍历该php文件所在目录
   list($filesname,$kzm)=explode(".",$file);//获取扩展名
    if($kzm=="gif" or $kzm=="jpg" or $kzm=="JPG") { //文件过滤
     if (!is_dir('./'.$file)) { //文件夹过滤
      $array[]=$file;//保存图片名字
      $i++;//记录图片总张数
              }
          }
      }
  for ($j=$max*$page;$j<($max*$page+$max)&&$j<$i;++$j){//循环条件控制显示图片张数
  echo "<img widht=500 height=1180 src=\"$array[$j]\"><br>";//输出图片数组
  }
  $realpage=@ceil($i/$imgnums)-1;
  $Prepage=$page-1;
  $Nextpage=$page+1;
  if ($Prepage<0){
           echo "上一页 ";
       echo "<a href=?page=$Nextpage>下一页</a> ";
       echo "<a href=?page=$realpage>最末页</a> ";
    }elseif($Nextpage >= $realpage){
       echo "<a href=?page=0>首页</a> ";
       echo " <a href=?page=$Prepage>上一页</a> ";
       echo " 下一页";
    }else{
       echo "<a href=?page=0>首页</a> ";
       echo "<a href=?page=$Prepage>上一页</a> ";
       echo "<a href=?page=$Nextpage>下一页</a> ";
       echo "<a href=?page=$realpage>最末页</a> ";
  }
  echo "
</center>
</body>
</html>";
?>