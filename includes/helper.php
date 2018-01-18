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
	$quoteArr = getRandomQuote();
	$quote = $quoteArr['quote'];
	$author = $quoteArr['author'];
	openCloseElement('p', array('class' => 'lead'), $quote);
	if($author != null && $author != 'Anonymous') {
		openElement('p', array('class' => 'lead'));
		openCloseElement('a', array('href' => "https://en.wikipedia.org/w/index.php?search=" . urlencode($author)), "-" . $author);
		closeElement('p');
	} else {
		openCloseElement('p', array('class' => 'lead'), "-Anonymous");
	}
	closeElement('div');
	closeElement('div');
}

function getRandomQuote() {
	$connection = getMySQLConnection();
	if($connection == NULL) {
		return array('quote' => "What's the point?", 'author' => 'Tom Puglisi');
	}
	$lastQuoteID = -1;
	session_start();
	if(isset($_SESSION['lastQuoteID'])) {
		$lastQuoteID = $_SESSION['lastQuoteID'];
	}
	
	$sql = "SELECT MAX(id) AS max_id, MIN(id) AS min_id FROM quotes";
	$range_result = $connection->query($sql);
	$range_row = mysqli_fetch_assoc($range_result);
	
	$random = $lastQuoteID;
	while($random == $lastQuoteID) {
		$random = mt_rand($range_row['min_id'], $range_row['max_id']);
	}
	$_SESSION['lastQuoteID'] = $random;
	session_write_close();
	$result = $connection->query("SELECT quote, author FROM quotes WHERE id = $random
			LIMIT 0,1");
	$connection->close();
	return mysqli_fetch_assoc($result);
}

function getMySQLConnection() {
	$config = include(__DIR__ . '/../config.php');
	$servername = $config['servername'];
	$username = $config['username'];
	$password = $config['password'];
	$dbname = $config['dbname'];
	$connection = new mysqli($servername, $username, $password, $dbname);
	if ($connection->connect_error) {
		return NULL;
	}
	return $connection;
}
?>