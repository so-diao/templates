<?php


/**
 * 
 * route-mode   路由模式, 不支持伪静态的情况下可以使用ugly，将转换为 load.php?path= 加载
 */

$config = array(
    'route-mode' => 'ugly'      //  pretty | ugly
);

require('load/export.php');

?>
