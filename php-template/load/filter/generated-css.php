<?php

$match_keys = array(
	'$number' => '(.*?\d{1,5})',
	'$color'  => '(.?\w{1,6})'
);

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
	array(
		'reg'	=> 'f-s-$number',
		'result' => 'font-size:$numberpx;'
	),
	array(
		'reg'	=> 'tc-$color',
		'result' => 'color:#$color;'
	),
	array(
		'reg'	=> 'bg-$color',
		'result' => 'background-color:#$color;'
	),
);


function replace_key($content, $val = null) {
	global $match_keys;
	foreach ( $match_keys as $key =>$reg ) {
		if ( strpos($content, $key) ) {
			$val = isset($val) ? $val : $reg;
			return str_replace($key, $val, $content);
		}
	}
	return false;
}

function to_css($arr, $rule) {
	$css = '';
	foreach( $arr as $val ) {
		$css .= '.';
		$css .= replace_key($rule['reg'], $val);
		$css .= '{';
		$css .= replace_key($rule['result'], $val);
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


function create_file($css, $prefix) {
	$key = empty($prefix) ? '' : '-' . $prefix;
	$css_path = $GLOBALS['site_data']['dir'] . '\static\css\build'. $key .'.css';
	$file = fopen($css_path, 'w');
	$old_css = file_get_contents($css_path);
	$css = $old_css . $css;
	$css = css_unique($css);
	fwrite($file, $css);
	fclose($file);
}

function build($rules, $prefix = '') {
	global $Action;
	$content = $Action->get_option();
	$key = empty($prefix) ? '' : $prefix . '-';
	$css = '';

	foreach( $rules as $rule ) {
		$reg = '/["|\s|=|\']' . $key . $rule['reg'] . '/';
		$reg = replace_key($reg);

		preg_match_all($reg, $content, $arr);

		$styles = array_filter($arr[1], function($item) {
			return !empty($item);
		});

		if ( count($styles) ) {
			$css .= to_css($styles, $rule);
		}
	}
	if ( $css ) {
		create_file($css, $prefix);
	}
}


function collect_size() {
    global $config;
	global $rules;
	$prefix = isset($config['build-css-prefix']) ? $config['build-css-prefix'] : array();
	array_push($prefix, '');

	foreach( $prefix as $pre ) {
		build($rules, $pre);
	}
}

if ( $config['build-css'] ) {
	$Action->add_action('filter_content', 'collect_size');
}

?>





