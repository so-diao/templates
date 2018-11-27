

<?php
require('action.php');

$dir = dirname(__FILE__);
$filter_files = array_diff(scandir($dir . '\filter'), array('.', '..'));

foreach($filter_files as $file) {
    require('filter/' .$file);
}


$history_path = array();
function get_file($path) {
    global $history_path;

    if ( isset($history_path[$path]) ) {
        return $history_path[$path];
    }
    $contents = file_get_contents($path);
    $new_contents = get_file_after($contents);

    $history_path[$path] = $new_contents;
    return $new_contents;
}

function get_file_after($contents) {

    global $Action;
    global $config;
    $Action->set_option($contents);
    $Action->do_action('filter_content');
    if ( $config['route-mode'] === 'ugly' ) {
        $Action->do_action('route_ugly');
    }

    return $Action->get_option();
}


?>

