<?php


/*

    入口文件
    加载php、html文件
    过滤其中字符串

*/

$base_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])). '/';
$query_path = str_replace($base_path, '', $_SERVER['REQUEST_URI']);


// 自定义require加载协议
class VariableStream {
    private $string;
    private $position;
    public function stream_open($path, $mode, $options, &$opened_path) {
        $url = parse_url($path);

        $this->string = get_file($url['host']);
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
    $handle = fopen($path, "r");
    $contents = fread($handle, filesize($path));

    return get_file_after($contents);
}


function get_file_after($contents) {

    // 获取字符串后，加一层过滤
    return add_suffix($contents);
}


function add_suffix($conten) {
    $re = '/(src|href)=\"(.*)\"/U';
    $date = time();
    $conten = preg_replace($re, '$1="$2?' . $date . '"', $conten);

    // 匹配内容中的 src/href ，添加时间戳
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



load_temp($query_path);

?>
