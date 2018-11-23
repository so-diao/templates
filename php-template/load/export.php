
<?php

require('load-tmpl.php');
require('functions.php');



$loadpath = $query_path;
$path = isset($_GET['path']) ? $_GET['path'] : '';

if ( $path ) {

    $loadpath = $path;
}


load_tmpl($loadpath);

?>
