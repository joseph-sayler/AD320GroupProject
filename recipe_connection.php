 <?php
$servername = "localhost";
$username = "root";
$dbname = "recipe_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully\n"; 
    }
catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    }

?>