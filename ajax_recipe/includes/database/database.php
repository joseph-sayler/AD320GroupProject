<?php 

class Database {
	private static $dsn = "mysql:host=127.0.0.1;dbname=recipe2";
	private static $username = "root";
	private static $password = "root";
	private static $db;

	public function __construct() {}

	public static function getDB() {
		if(!isset(self::$db)) {
			try {
				self::$db = new PDO(self::$dsn, self::$username, self::$password);
			} catch (PDOException $e){
				$error_message = $e->getMessage();
				echo "<p>Could not connect to the database: $error_message</p>";
				exit();
			}
		}
		return self::$db;
	}
}

?>
