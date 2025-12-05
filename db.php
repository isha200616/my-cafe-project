<?php
function get_db_connection() {
    $host = "localhost";
    $username = "root";
    $password = "";  
    $dbname = "cozycafe";

    
    $conn = new mysqli($host, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>