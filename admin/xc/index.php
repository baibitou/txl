<?php
header("Content-Type:text/html;charset=gb2312");
echo "
<html>
<head>
<title>͵������̨</title>
</head>
<body bgcolor=ffffff>
<center>
<h1>ͼ��<h1>
<font size=2 color=red>";//���html��ش���
$page=$_GET['page'];//��ȡ��ǰҳ��
$max=10;//����ÿҳ��ʾͼƬ�������
$handle = opendir('./'); //��ǰĿ¼
  while (false !== ($file = readdir($handle))) { //������php�ļ�����Ŀ¼
   list($filesname,$kzm)=explode(".",$file);//��ȡ��չ��
    if($kzm=="gif" or $kzm=="jpg" or $kzm=="JPG") { //�ļ�����
     if (!is_dir('./'.$file)) { //�ļ��й���
      $array[]=$file;//����ͼƬ����
      $i++;//��¼ͼƬ������
              }
          }
      }
  for ($j=$max*$page;$j<($max*$page+$max)&&$j<$i;++$j){//ѭ������������ʾͼƬ����
  echo "<img widht=500 height=1180 src=\"$array[$j]\"><br>";//���ͼƬ����
  }
  $realpage=@ceil($i/$imgnums)-1;
  $Prepage=$page-1;
  $Nextpage=$page+1;
  if ($Prepage<0){
           echo "��һҳ ";
       echo "<a href=?page=$Nextpage>��һҳ</a> ";
       echo "<a href=?page=$realpage>��ĩҳ</a> ";
    }elseif($Nextpage >= $realpage){
       echo "<a href=?page=0>��ҳ</a> ";
       echo " <a href=?page=$Prepage>��һҳ</a> ";
       echo " ��һҳ";
    }else{
       echo "<a href=?page=0>��ҳ</a> ";
       echo "<a href=?page=$Prepage>��һҳ</a> ";
       echo "<a href=?page=$Nextpage>��һҳ</a> ";
       echo "<a href=?page=$realpage>��ĩҳ</a> ";
  }
  echo "
</center>
</body>
</html>";
?>