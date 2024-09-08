<?php
if(!((isset($_REQUEST['username']) || isset($_REQUEST['email']) || isset($_REQUEST['password'])) && isset($_REQUEST['id_username']))) {
    echo "update failed\nerror: missing parameter\n";
}else {
    $uname_update = 0;
    $pass_update = 0;
    $email_update = 0;
    $response['id_username'] = $_REQUEST['id_username'];
    if (isset($_REQUEST['username'])) {
        $response['username'] = $_REQUEST['username'];
        echo $response['username'];
        $uname_update = 1;
    }
    if (isset($_REQUEST['password'])) {
        $response['password'] = $_REQUEST['password'];
        #hashing password to be inserted
        $password = mb_convert_encoding($response['password'], "ASCII", "auto");
        $hash = hash('sha256', $password);
        $hash_encoded = mb_convert_encoding($hash, "UTF-8", "auto");
        $hashed_password_ = password_hash($hash_encoded, PASSWORD_BCRYPT, ['cost' => 10,]);
        $hashed_password_[2] = 'a';
        $pass_update=1;
        echo $hashed_password_."\n";
        $hashed_password = mb_convert_encoding($hashed_password_, "UTF-8", "auto");

    }
    if (isset($_REQUEST['email'])) {
        $response['email'] = $_REQUEST['email'];
        $email_update=1;
    }

    $sum = $uname_update + $pass_update + $email_update;
    echo "\n".$sum;
    $datetime = new MongoDB\BSON\UTCDateTime();
    $date_str = $datetime->toDateTime()->format(\DateTime::ISO8601);
    $date_date = new MongoDB\BSON\UTCDateTime((new DateTime($date_str))->getTimestamp() * 1000);

// connect to mongodb
    try {

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite;

        if($sum == 3){
            $bulk->update(['username'=> $response['id_username']],['$set' => ['emails.address'=>$response['email']]]);
            $bulk->update(['username'=> $response['id_username']],['$set' => ['services.password.bcrypt'=>$hashed_password]]);
            $bulk->update(['username'=>$response['id_username']],['$set' => ['username' => $response['username']]]);
        }
        elseif($sum == 2){
            if($uname_update == 0){
            $bulk->update(['username'=> $response['id_username']],['$set' => ['services.password.bcrypt'=>$hashed_password]]);
            $bulk->update(['username'=> $response['id_username']],['$set' => ['emails.address'=>$response['email']]]);
            }
            elseif($pass_update == 0){
                $bulk->update(['username'=> $response['id_username']],['$set' => ['emails.address'=>$response['email']]]);
                $bulk->update(['username'=>$response['id_username']],['$set' => ['username' => $response['username']]]);
            }
            elseif($email_update == 0){
                $bulk->update(['username'=> $response['id_username']],['$set' => ['services.password.bcrypt'=>$hashed_password]]);
                $bulk->update(['username'=>$response['id_username']],['$set' => ['username' => $response['username']]]);
            }
        }
        elseif($sum == 1){
            if($uname_update == 1)
                $bulk->update(['username'=>$response['id_username']],['$set' => ['username' => $response['username']]]);
            elseif($pass_update == 1)
                $bulk->update(['username'=> $response['id_username']],['$set' => ['services.password.bcrypt'=>$hashed_password]]);
            elseif($email_update == 1)
                $bulk->update(['username'=> $response['id_username']],['$set' => ['emails.address'=>$response['email']]]);
        }

        $mng->executeBulkWrite("parties.users", $bulk);

    } catch (MongoDB\Driver\Exception\Exception $e) {

        echo "Exception:", $e->getMessage(), "\n";

    }

}


