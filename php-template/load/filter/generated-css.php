<?php

$rules = array(
	array(
		'reg'	=> 'p-l-$number',
		'result' => 'padding-left:$numberpx;'
	),
	array(
		'reg'	=> 'p-t-$number',
		'result' => 'padding-top:$numberpx;'
	),
	array(
		'reg'	=> 'p-r-$number',
		'result' => 'padding-right:$numberpx;'
	),
	array(
		'reg'	=> 'p-b-$number',
		'result' => 'padding-bottom:$numberpx;'
	),
	array(
		'reg'	=> 'm-l-$number',
		'result' => 'margin-left:$numberpx;'
	),
	array(
		'reg'	=> 'm-t-$number',
		'result' => 'margin-top:$numberpx;'
	),
	array(
		'reg'	=> 'm-r-$number',
		'result' => 'margin-right:$numberpx;'
	),
	array(
		'reg'	=> 'm-b-$number',
		'result' => 'margin-bottom:$numberpx;'
	),
);


// echo str_replace('$number', '22', 'padding-bottom:$numberpx;');

function replace_num($content, $val) {
	return str_replace('$number', $val, $content);
}

function to_css($arr, $rule) {
	$css = '';

	foreach( $arr as $val ) {
		$css .= '.';
		$css .= replace_num($rule['reg'], $val);
		$css .= '{';
		$css .= replace_num($rule['result'], $val);
		$css .= '}';
	}
	return $css;
}

function css_unique($css) {
	$arr = explode('}', $css);
	$arr = array_unique($arr);
	$arr = array_diff($arr, array(''));
	$arr = array_map(function($item) {
		$item .= '}';
		return $item;
	}, $arr);

	return implode($arr);
}


function create_file($css) {
	$css_path = $GLOBALS['site_data']['dir'] . '\static\css\build.css';
	$old_css = file_get_contents($css_path);
	$css = $old_css . $css;
	$css = css_unique($css);
	$file = fopen($css_path, "w");
	fwrite($file, $css);
	fclose($file);
}


function collect_size() {
    global $Action;
	global $rules;
	$content = $Action->get_option();
	$css = '';

	foreach( $rules as $rule ) {
		$reg = '/' . $rule['reg'] . '/';
		$reg = replace_num($reg, '(.*?\d{1,5})');
		preg_match_all($reg, $content, $arr);

		$styles = array_filter($arr[1], function($item) {
			return is_numeric($item);
		});
		if ( count($styles) ) {
			$css .= to_css($styles, $rule);
		}
	}
	create_file($css);
    // $Action->set_option($content);
}


$Action->add_action('filter_content', 'collect_size');

?>





