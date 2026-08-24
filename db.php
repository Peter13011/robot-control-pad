<?php
$host = "your host name";      
$user = "username";                
$pass = "password";           
$dbname = "DBname";   

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "فشل الاتصال: " . $conn->connect_error]));
}
?>