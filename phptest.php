<?php


$servername = "localhost";
$username = "l5lpcuqo_jobsys2";
$password = "jobsystemv2dev";
$db = "l5lpcuqo_jobsystemv2dev";

for($i=0;$i<1000;$i++)
{
// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else
{
    $conn->close();

echo "Connected successfully $i time<br>";
}
}



// Show all information, defaults to INFO_ALL
phpinfo();

// Show just the module information.
// phpinfo(8) yields identical results.
phpinfo(INFO_MODULES);

?>