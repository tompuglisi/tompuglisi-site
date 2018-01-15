<?php
require_once ('htmlLibrary.php');

function render($template, $data = array()) {
	$path = __DIR__ . '/../views/templates/' . $template . '.php';
	if (file_exists ( $path )) {
		extract ( $data );
		require ($path);
	}
}

function showRandomQuote() {
	$header = 'Random Quote';
	openElement('div', array('class' => 'container'));
	openElement('div', array('class' => 'starter-template'));
	openCloseElement('h1', null, $header);
	openCloseElement('p', array('class' => 'lead'), getRandomQuote());
	closeElement('div');
	closeElement('div');
}

function getRandomQuote() {
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
	
	$lastQuoteID = -1;
	session_start();
	if(isset($_SESSION['lastQuoteID'])) {
		$lastQuoteID = $_SESSION['lastQuoteID'];
	}
	
	$sql = "SELECT MAX(id) AS max_id, MIN(id) AS min_id FROM quotes";
	$range_result = $conn->query ( $sql );
	$range_row = mysqli_fetch_assoc($range_result);
	
	$random = $lastQuoteID;
	while($random == $lastQuoteID) {
		$random = mt_rand ( $range_row["min_id"], $range_row["max_id"]);
	}
	$_SESSION['lastQuoteID'] = $random;
	session_write_close();
	$result = $conn->query ( "SELECT quote, author FROM quotes WHERE id = $random
			LIMIT 0,1" );
	$conn->close ();
	return mysqli_fetch_assoc($result)["quote"];
}
?>