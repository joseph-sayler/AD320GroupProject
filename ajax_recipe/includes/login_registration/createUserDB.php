<?php
/**
 * Created by PhpStorm.
 * User: James No
 * Date: 3/10/2017
 * Time: 7:02 PM
 */

require 'includes/database/database.php';

try {
    $sql = "DROP TABLE IF EXISTS user_DB;
      CREATE TABLE IF NOT EXISTS user_DB
        (
          userID INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
          userName VARCHAR(30) NOT NULL UNIQUE,
          password VARCHAR(255) NOT NULL,
          email VARCHAR(50) NOT NULL UNIQUE
        )";

    $conn->exec($sql);
    echo "Table user_DB created successfully!"
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage() . "<br>";
} finally {
    $conn = null;
}
