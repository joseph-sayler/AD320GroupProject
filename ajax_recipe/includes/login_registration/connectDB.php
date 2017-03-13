<?php
/**
 * Created by PhpStorm.
 * User: James No
 * Date: 3/10/2017
 * Time: 4:39 PM
 */

$dsn = 'mysql:host=localhost;dbname=icoolsho_jno';
$username = "icoolsho_jno";
$password = "$!985-81-2029";

try {
// Create connection
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
