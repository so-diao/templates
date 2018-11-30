<?php

$base_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$query_path = str_replace($base_path. '/', '', $_SERVER['REQUEST_URI']);



/**
 * 
 * route-mode   路由模式, 不支持伪静态的情况下可以使用ugly，将转换为 load.php?path= 加载
 */

$config = array(
    'route-mode' => 'ugly',      //  pretty | ugly
    'build-css'  => 1,           //  0 | 1
    'build-css-prefix'  => array('pad', 'mobile'),      // 输出不同的css文件
);



$GLOBALS['site_data'] = array(
    'bloginfo' => array(
        'template_url' => $base_path
    ),
    'dir' => dirname(__FILE__)
);

require('load/export.php');

?>
