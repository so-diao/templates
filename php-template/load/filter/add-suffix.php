
<?php

function add_suffix() {
    global $Action;

    $content = $Action->get_option();
    $re = '/<(link|script)(.*)(src|href)=\"(.*)\"/U';
    $date = time();
    $content = preg_replace($re, '<$1$2$3="$4?' . $date . '"', $content);

    // 匹配内容中的 src/href ，添加时间戳阻止缓存
    $Action->set_option($content);
}


$Action->add_action('filter_content', 'add_suffix');

?>
