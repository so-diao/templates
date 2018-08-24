<?php


/*

    入口文件
    加载php、html文件
    过滤其中字符串

*/

$base_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$query_path = str_replace($base_path. '/', '', $_SERVER['REQUEST_URI']);


// 自定义require加载协议
class VariableStream {
    private $string;
    private $position;
    public function stream_open($path, $mode, $options, &$opened_path) {
        $url = parse_url($path);
        $path = $url['host'] . (isset($url['path']) ? $url['path'] : '');

        $this->string = get_file($path);
        $this->position = 0;
        return true;
    }
    public function stream_read($count) {
        $ret =  substr($this->string, $this->position, $count);
        $this->position += strlen($ret);
        return $ret;
    }
    public function stream_eof() {}
    public function stream_stat() {}
}

stream_wrapper_register("load", "VariableStream");


function get_file($path) {
    
    $contents = file_get_contents($path);

    return get_file_after($contents);
}


function get_file_after($contents) {

    // 获取字符串后，加一层过滤
    return add_suffix($contents);
}


function add_suffix($conten) {
    $re = '/<(link|script)(.*)(src|href)=\"(.*)\"/U';
    $date = time();
    $conten = preg_replace($re, '<$1$2$3="$4?' . $date . '"', $conten);

    // 匹配内容中的 src/href ，添加时间戳阻止缓存
    return $conten;
}


function load_temp($file_name) {
    // 使用load加载模板

    require("load://{$file_name}");
}



function get_header($name = null) {
    $file_name = 'header.php';

    if( isset($name) ) {
        $file_name = "header-{$name}.php";
    }
    load_temp($file_name);
}

function get_footer($name = null) {
    $file_name = 'footer.php';

    if( isset($name) ) {
        $file_name = "footer-{$name}.php";
    }
    load_temp($file_name);
}


$GLOBALS['site_data'] = array(
    'bloginfo' => array(
        'template_url' => $base_path
    )
);


function get_bloginfo($key) {
    
    if ( isset( $GLOBALS['site_data']['bloginfo'][$key] ) ) {
        return $GLOBALS['site_data']['bloginfo'][$key];
    }
    return '';
}

function bloginfo($key) {

    echo get_bloginfo($key);
}



// function wp_register_style($order_str, $src, $deps, $ver, $media) {


// }




load_temp($query_path);

?>
