<?php
require_once ('../includes/helper.php');
render('header', array('title' => 'Hello'));
showRandomQuote();
render('footer');
?>
