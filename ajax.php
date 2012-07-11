<?php 
 

//Only allow logged in users to send an ajax request

// if logged in:
do_action( 'wp_ajax_' . $_POST['action'] );

add_action( 'wp_ajax_ajax_fetch_auto_group', 'ajax_fetch_auto_group' );

function ajax_fetch_auto_group() {
	// get the submitted parameters
echo "Yes";

	// IMPORTANT: don't forget to "exit"
	die();
exit;
}




?>