<?php
if (!function_exists("openContainer")) {
	function openContainer($tag, $atts = array()) {
		$allowed = ['div','section','article','ul','li','header','footer','aside','main','h1','h2','h3','h4','h5','h6','p','small','strong','span'];

		if (!in_array($tag,$allowed)) {
		    $tag = 'div';
		}

		$aux = "";
		foreach ($atts as $key => $value) {
			$aux .= ' '.$key.'="'.$value.'"';
		}
		
		return '<'.$tag.$aux.'>';
	}
}
if (!function_exists("closeContainer")) {
	function closeContainer($tag) {
		$allowed = ['div','section','article','ul','li','header','footer','aside','main','h1','h2','h3','h4','h5','h6','p','small','strong','span'];

		if (!in_array($tag,$allowed)) {
		    $tag = 'div';
		}

		return '</'.$tag.'>';
	}
}