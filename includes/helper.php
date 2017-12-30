<?php
function render($template, $data = array()) {
	$path = __DIR__ . '/../views/templates/' . $template . '.php';
	if (file_exists ( $path )) {
		extract ( $data );
		require ($path);
	}
}
function getQOTD() {
	$config = include(__DIR__ . '/../config.php');
	$servername = $config['servername'];
	$username = $config['username'];
	$password = $config['password'];
	$dbname = $config['dbname'];
	$conn = new mysqli ( $servername, $username, $password, $dbname );
	if ($conn->connect_error) {
		die ( "Connection failed: " . $conn->connect_error );
		echo "What's the point?";
	}
	
	$sql = "SELECT MAX(id) AS max_id, MIN(id) AS min_id FROM quotes";
	$range_result = $conn->query ( $sql );
	$range_row = mysqli_fetch_assoc($range_result);
	$random = mt_rand ( $range_row["min_id"], $range_row["max_id"]);
	$result = $conn->query ( "SELECT quote, author FROM quotes WHERE id = $random
			LIMIT 0,1" );
	echo mysqli_fetch_assoc($result)["quote"];
	$conn->close ();
}
?>