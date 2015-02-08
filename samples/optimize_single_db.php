<?php

require_once('../optimize_database.php');

try {
	$optimize_database = new OptimizeDatabase;
	$optimize_database->set_connection_config('localhost', 'user', 'password', 'database');
	$optimization = $optimize_database->do_optimization();

	echo 'Optimization of tables in a single database finished<br/>';
 	echo 'Retrieved '.$optimization['data_free'].' bytes.<br/>';
 	echo 'Number of tables with data excess: '.$optimization['overloaded_tables'].'.';
}

catch(Exception $e) {
	echo $e->getMessage();
}

?>
