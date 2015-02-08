<?php

require_once('../OptimizeDatabase.php');
require_once('../OptimizeDatabases.php');

try {
	$optimize_databases = new OptimizeDatabases('localhost', 'dbs.php', 'optimization.log');
	$optimization = $optimize_databases->do_optimization(true);

	echo 'Tables optimization in databases was finished<br/>';
	echo 'Retrieved '.$optimization['data_free'].' bytes.<br/>';
 	echo 'Number of tables with data excess: '.$optimization['overloaded_tables'].'.<br/>';
	echo 'Number of optimized databases: '.$optimization['databases_amount'].'.';
}

catch(Exception $e) {
	echo $e->getMessage();
}

?>
