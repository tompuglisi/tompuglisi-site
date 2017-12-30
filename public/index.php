<?php
require_once ('../includes/helper.php');

?>

<?php render('header', array('title' => 'Hello')); ?>

<div class="container">

	<div class="starter-template">
		<h1>Quote of the Day</h1>
		<p class="lead"><?php getQOTD(); ?></p>
	</div>

</div>

<?php render('footer'); ?>
