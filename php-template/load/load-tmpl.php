<?php
require('filter.php');

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


function load_tmpl($file_name) {
    
    require("load://{$file_name}");
}
?>