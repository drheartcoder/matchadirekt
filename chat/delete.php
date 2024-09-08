<?php
// receiving the post params
if(!(isset($_REQUEST['username']))) {
    echo "delete failed\nerror: missing parameter\n";
}else {
        $response['username'] = $_REQUEST['username'];
    }
// connect to mongodb
try {
    $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->delete(['username' => $response['username']]);
    $mng->executeBulkWrite("parties.users", $bulk);
    echo "delete done successfully";
} catch (MongoDB\Driver\Exception\Exception $e) {
    echo "Exception:", $e->getMessage(), "\n";
}



