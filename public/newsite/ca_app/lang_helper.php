<?php
if (!function_exists('lang')) {
    function lang($string='') {
$str_array=array();
$str_array=[
	'Top Companies' => 'Toppföretag',
	'Latest Jobs' => 'Senaste jobb',
	'Featured Jobs' => 'Utvalda jobb',
	'Top Cities' => 'Toppstäder',
];
		if (array_key_exists($string, $str_array))
			return $str_array[$string];
		else
			return $string;
	}
}
?>