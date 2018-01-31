<?php
require_once ('../includes/Helper.php');
Helper::render('Header', array(
    'title' => 'tompuglisi.com'
));
Helper::showRandomQuote();
Helper::render('Footer');
?>
