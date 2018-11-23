
<?php

$base_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$query_path = str_replace($base_path. '/', '', $_SERVER['REQUEST_URI']);


require('load-tmpl.php');
require('functions.php');

add_action('filter_content', 'add_suffix');

if ( $config['route-mode'] === 'ugly' ) {
    add_action('filter_content', 'replace_link');
}


$loadpath = $query_path;
$path = isset($_GET['path']) ? $_GET['path'] : '';

if ( $path ) {

    $loadpath = $path;
}


load_tmpl($loadpath || 'index.php');

?>
