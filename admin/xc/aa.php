<?php


$files1 = scandir("images");    //列出文件夹中的文件名和文件夹名,输出为一个数组.开头会有一个 . 和 ..

foreach($files1 as $A){                 //使用foreach循环出文件夹内的数组名
    if($A != "."&& $A!=".."){           //把 . 和 .. 过滤掉
        $arrs[] = array("jrjk" => $A ,"img"=>$A);   //新建一个数组,数组元素为二维数组(二维数组的name值和i均为维原数组的值)
    }
}
