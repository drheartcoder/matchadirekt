<?php

if (isset($_REQUEST['username']) && isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
    
    // receiving the post params
    $response['username'] = $_REQUEST['username'];
    $response['password'] = $_REQUEST['password'];
    $response['email'] = $_REQUEST['email'];

    #hashing password to be inserted
    $password = mb_convert_encoding($response['password'], "ASCII", "auto");
    $hash = hash('sha256', $password);
    $hash_encoded = mb_convert_encoding($hash, "UTF-8", "auto");
    $hashed_password = password_hash($hash_encoded, PASSWORD_BCRYPT, ['cost' => 10,]);
    $hashed_password[2] = 'a';

    $datetime = new MongoDB\BSON\UTCDateTime();
    $date_str = $datetime->toDateTime()->format(\DateTime::ISO8601);
    $date_date= new MongoDB\BSON\UTCDateTime((new DateTime($date_str))->getTimestamp()*1000);

// connect to mongodb
    try {

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        $bulk = new MongoDB\Driver\BulkWrite;

        $doc = ['username' => $response['username'], 'status' => 'online','statusConnection' => 'online',
            'avatarOrigin' => 'local','roles' => ['user'],'statusDefault' => 'online',
            'utcOffset' => 0, '_updatedAt' => $date_date,
            'active' => True,'_id' => (string)new MongoDB\BSON\ObjectId(), 'type' => 'user',
            'services' => [
                'password' => [
                    'bcrypt' => mb_convert_encoding($hashed_password, "UTF-8", "auto")]],
            'emails' => [
                'address' => $response["email"],
                'verified' => False],
            'createdAt' => $date_date,
            'lastLogin' => $date_date,
            'name' => "Mr. ".$response['username']
        ];

        $bulk->insert($doc);

        $mng->executeBulkWrite("parties.users", $bulk);
        echo "user account added successfully with id "._id;

    } catch (MongoDB\Driver\Exception\Exception $e) {

        echo "Exception:", $e->getMessage(), "\n";

    }
} else {

    echo "insertion failed\nerror: missing parameter\n";
}



