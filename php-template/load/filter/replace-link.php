
<?php


function replace_rule($arr) {
    global $base_path;
    $rule = array();
    $arr = array_unique($arr);

    foreach( $arr as $href ) {

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
    $content = str_replace('@/', "<?php bloginfo('template_url')?>/", $content);
    $reg = '/<a(.*?)href="(.*?)"(.*?)>/';
    preg_match_all($reg, $content, $arr);
    $rules = replace_rule($arr[2]);

    foreach( $rules as $rule ) {
        $content = str_replace($rule['old'], $rule['new'], $content);
    }

    $Action->set_option($content);
}


$Action->add_action('route_ugly', 'replace_link')

?>