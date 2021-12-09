<?php

$url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$n=substr($_SERVER['PHP_SELF'],strripos($_SERVER['PHP_SELF'],"/")+1);

$host=strstr($url,$n,TRUE);
//本站域名路径

$dirzzz="点我查看所有文件";
//文件保存目录

$hostv=$host.$dirzzz.'/';

define("HOST",$host);

define("DIR",$dirto);

define("DIRZZZ",$dirzzz);

define("ZVA","zvvaa");

define("HOSTV",$hostv);

?>