<?php

function do_action(...$arg) {
    global $Action;
    return $Action->do_action(...$arg);
}

function add_action(...$arg) {
    global $Action;
    return $Action->add_action(...$arg);
}

function remove_action(...$arg) {
    global $Action;
    return $Action->remove_action(...$arg);
}

function get_header($name = null) {
    $file_name = 'header.php';

    if( isset($name) ) {
        $file_name = "header-{$name}.php";
    }
    load_tmpl($file_name);
}

function get_footer($name = null) {
    $file_name = 'footer.php';

    if( isset($name) ) {
        $file_name = "footer-{$name}.php";
    }
    load_tmpl($file_name);
}


function get_bloginfo($key) {

    if ( isset( $GLOBALS['site_data']['bloginfo'][$key] ) ) {
        return $GLOBALS['site_data']['bloginfo'][$key];
    }
    return '';
}

function bloginfo($key) {

    echo get_bloginfo($key);
}


?>