<?php
/* An example for using txton which was developed by @bilawalhameed */
require 'txton.php';

/* @note: Let's make up array data. */
$test_data = array(
	'userid' => 1,
	'username' => 'John Smith',
	'location' => 'San Francisco',
	'age' => 40,
	'connections' => array(
		'facebook' => 10,
		'twitter' => 65,
		'linkedin' => 100
	)
);

/* @note: Let's get the txton structure of this array. */
$structure = txton_structure( $test_data );
$serialized = serialize($structure);

/* @note: Let's convert it into a single string. */
$output = txton_encode( $test_data );
echo $output;

/* @note: Say we wanted to decode the data above. Let's do it. */
// $decoded_output = txton_decode( $output, unserialize( $serialized ) );