//Place this Database folder in the same folder as htdocs of XAMPP server//
//Because of that a user cannot access the database connection php code//
//You have to create a database user of the name keltago4_admins and if you have inserted password then use it here to access it//
//Like if the database password in '123456' then assign it to variable dbpassword, here in this code //

<?php

$servername = "localhost";
$dbpassword = "******"; // enter the database user's password
$username = "keltago4_admins";
$database = "keltago4_Chat";

$conn = new mysqli($servername, $username, $dbpassword, $database);

if($conn->connect_error)
{
    die("something went wrong:$conn->connect_error");
}

?>
