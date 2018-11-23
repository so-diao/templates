

<?php
require('action.php');



function get_file($path) {
    $contents = file_get_contents($path);

    return get_file_after($contents);
}

function get_file_after($contents) {

    global $Action;
    $Action->set_option($contents);
    $Action->do_action('filter_content');

    // 获取字符串后，加一层过滤
    return $Action->option;
}

function add_suffix() {
    global $Action;

    $content = $Action->get_option();
    $re = '/<(link|script)(.*)(src|href)=\"(.*)\"/U';
    $date = time();
    $content = preg_replace($re, '<$1$2$3="$4?' . $date . '"', $content);

    // 匹配内容中的 src/href ，添加时间戳阻止缓存
    $Action->set_option($content);
}

function replace_rule($arr) {
    global $base_path;
    $rule = array();
    $arr = array_unique($arr);

    foreach( $arr as $href ) {
        // $href = str_replace($base_path. '/', '', $href);
        $suffix = strstr($href, '?>/');
        if ( $suffix ) {
            $query_path = str_replace('?>/', '', $suffix);
            $parse_result = parse_url($query_path);
            // http_build_query parse_url
            
            if ( isset($parse_result['query']) ) {
                $parse_result['query'] .= '&path=' . $parse_result['path'];
            } else {
                $parse_result['query'] = 'path=' . $query_path;
            }

            array_push($rule, array(
                'old' => $suffix,
                'new' => '?>/load.php?' . $parse_result['query']
            ));
        }
    }

    return $rule;
}

function replace_link() {
    global $Action;

    $content = $Action->get_option();

    $re = '/<a(.*?)href="(.*?)"(.*?)>/';
    preg_match_all($re, $content, $arr);
    $rules = replace_rule($arr[2]);

    foreach( $rules as $rule ) {
        $content = str_replace($rule['old'], $rule['new'], $content);
    }

    $Action->set_option($content);
}


?>

