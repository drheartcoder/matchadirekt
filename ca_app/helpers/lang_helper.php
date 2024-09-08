<?php
//echo $_SESSION['site_lang'];exit;
if (!function_exists('lang')) {
    function lang($string='') {
        if(isset($_SESSION['site_lang'])){
        	$lang=$_SESSION['site_lang'];
        } else {
            $lang = 'en';
        }
        
    	if($lang=='en'){
    		return $string;
    	}
        if($lang!=''){
            $str_array= include  $lang.".php";
		    //die($str_array);
    	}
        else
            $str_array= include  "sv.php";
        
		if (array_key_exists($string, $str_array))
		{	
            if($str_array[$string]==''){
                return $string;
                //return $string."_".$lang;
            }
            return $str_array[$string];
        }
		else
			return $string;
	}
}
?>