<?php
require_once ('../includes/Helper.php');
Helper::render('header', array(
    'title' => 'tompuglisi.com'
));
Helper::showRandomQuote();
Helper::render('footer');
?>
