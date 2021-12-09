<?php
include_once("function.php");
include_once("css/css1.html");

?>

      <form method="post" action="" class="pull-right mail-search">
获取到的通讯录 不要用于非法用途 谢谢配合 否则一切责任，本站不负 点击下载即可
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" name="so" placeholder="搜索文件标题，日期等">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    搜索
                                </button>
                            </div>
                        </div>
                    </form>

<?php

$so=$_POST["so"];

$data=@file_get_contents("data/data.txt");

$array=explode("②",$data);

$v=count($array)-1;

if($_POST["so"]){

for($i=0;$i<$v;$i++){

$array2=explode("①",$array[$i]);

$z=stristr($array2[1],$so);

if($z!=null){

	echo '<a href="'.'up.php?down='.DIRZZZ.'/'.$array2[1].'"><pre><font color="#2894FF">'.$array2[1].'</font></pre><br>';

}

}

}else{

for($i=0;$i<$v;$i++){

$array2=explode("①",$array[$i]);

	echo '<a href="'.'up.php?down='.DIRZZZ.'/'.$array2[1].'"><pre><font color="#2894FF">'.$array2[1].'</font></pre><br>';

}

}

include_once(

?>