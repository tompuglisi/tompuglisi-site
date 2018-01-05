<?php
function openElement($name, $attributes = NULL) {
	echo '<', $name;
	if (! is_null ( $attributes )) {
		foreach ( $attributes as $attribute => $value ) {
			echo ' ', $attribute, '="', $value, '"';
		}
	}
	echo '>';
}

function closeElement($name) {
	echo '</', $name, '>';
}

function openCloseElement($name, $attributes = array(), $value) {
	openElement ( $name, $attributes );
	echo $value;
	closeElement ( $name );
}
?>