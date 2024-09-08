<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 3/21/18
 * Time: 3:03 PM
 */// Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

function CallAPI($method, $url, $data = false)
{
    $curl = curl_init();
    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data){
                $encoded = "";
                foreach($data as $name => $value) {
                    $encoded .= urlencode($name).'='.urlencode($value).'&';
                }

                // chop off last ampersand
                $encoded = substr($encoded, 0, strlen($encoded)-1);

                curl_setopt($curl, CURLOPT_POSTFIELDS,  $encoded);

                }
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

//    // Optional Authentication:
//    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
//    curl_setopt($curl, CURLOPT_USERPWD, "username:password");
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
header('Access-Control-Allow-Credentials: true');
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

try {
    

    $result= CallAPI("POST","http://matchadirekt.com:3000/api/v1/login",array("user" => $_POST['user'], "password" => $_POST['password']));
    $result=json_decode($result, true);
    if (isset($result["data"]["authToken"])){
        http_response_code(200);
        echo json_encode(array('success'=>'true',"loginToken"=>$result["data"]["authToken"],'userId'=>$result["data"]["userId"]));
    }
    else{

        http_response_code(401);
        
        echo json_encode(array('success'=>'false','user'=>$_POST['user'],"msg"=>$result));
    }



} catch (Exception $e) {
    die($e->getMessage());
}


