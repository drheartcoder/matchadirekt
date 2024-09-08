<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}


if(!function_exists('calculateAge')){
	function calculateAge($dateOfBirth){
		if($dateOfBirth != "0000-00-00 00:00:00" || $dateOfBirth != "0000-00-00"  ){
            $today = date("Y-m-d");
            $diff = date_diff(date_create($dateOfBirth), date_create($today));
            $age = $diff->format('%y');
        } else {
            $age="-";
        }
        if($age != date("Y")){
        	$age = $age;
        } else {
        	$age = "-";
        }

        return $age;
	}
}

if(!function_exists('sendSMS')){
	function sendSMS($num, $msg){
		$userName = 'sskwedding';
		$pass= 'Ssk-1234';
		$sender = "WEDSSK";
		$number = $num;
		$message = urlencode($msg);

		$first_number = substr($number, 0, 1); 
		if ($first_number == 0) {
		  $number = substr($number, 1, 999); 
		}
		$url = "";
		$req = curl_init();
		curl_setopt($req, CURLOPT_URL,$url);
		curl_exec($req);
		curl_close($req);
	    //$timeout = 5;
	}
}

/* Create strong password */
if (!function_exists('generateStrongPassword')) {
	function generateStrongPassword($length = 8, $add_dashes = false, $available_sets = 'luds') {
		$sets = array();
		if (strpos($available_sets, 'l') !== false) {
			$sets[] = 'abcdefghjkmnpqrstuvwxyz';
		}

		if (strpos($available_sets, 'u') !== false) {
			$sets[] = 'ABCDEFGHJKMNPQRSTUVWXYZ';
		}

		if (strpos($available_sets, 'd') !== false) {
			$sets[] = '23456789';
		}

		if (strpos($available_sets, 's') !== false) {
			$sets[] = '!@#$%&*?';
		}

		$all = '';
		$password = '';
		foreach ($sets as $set) {
			$password .= $set[array_rand(str_split($set))];
			$all .= $set;
		}

		$all = str_split($all);
		for ($i = 0; $i < $length - count($sets); $i++) {
			$password .= $all[array_rand($all)];
		}

		$password = str_shuffle($password);

		if (!$add_dashes) {
			return $password;
		}

		$dash_len = floor(sqrt($length));
		$dash_str = '';
		while (strlen($password) > $dash_len) {
			$dash_str .= substr($password, 0, $dash_len) . '-';
			$password = substr($password, $dash_len);
		}
		$dash_str .= $password;
		return $dash_str;
	}
}
/* Short cut to print array */
if (!function_exists('myPrint')) {
	function myPrint($temparr) {
		echo "<pre>";
		print_r($temparr);
	}
}