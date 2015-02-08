<?php

class OptimizeDatabases {
	private $optimize_database;
	private $host;
	private $file_with_databases;
	private $optimization_log;

	public function __construct($host = 'localhost', $file_with_databases = 'dbs.php', $optimization_log = 'optimization.log')
	{
		$this->optimize_database = new optimize_database;
		$this->host = $host;
		$this->dbs_file = $file_with_databases;
		$this->optimization_log = $optimization_log;
	}

	private function get_dabases_from_file($filename, $separator = '|')
	{
		if(file_exists($filename))
		{
			$file  = file($filename);
			$lines = count($file);

			for ($i = 0; $i < $lines; $i++)
			{
				$line = explode($separator, trim($file[$i]));
				$file[$i] = $line;
			}

		$file = array_slice($file, 1, -1);
		return $file;
		}
	}

	private function count_databases()
	{
		return count(file($this->dbs_file)) - 2;
	}

	public function do_optimization($log = true)
	{
		$array = $this->get_dabases_from_file($this->dbs_file);

		for($i = 0, $count = count($array) - 1; $i <= $count; $i++)
		{
			$this->optimize_database->set_connection_config($this->host, $array[$i][0], $array[$i][1], $array[$i][2]);
			$optimization = $this->optimize_database->do_optimization();
			$data_free += $optimization['data_free'];
			$overloaded_tables += $optimization['overloaded_tables'];
		}

		if($log)
		{
			$file = fopen($this->optimization_log,'a+');
			fwrite($file, date('Y-m-d, H:i:s').' - optimized databases: '.$this->count_databases().', optimized '.$overloaded_tables.' tables, retrieved '.$data_free." bytes\n");
			fclose($file);
		}

		return array('data_free' => $data_free, 'overloaded_tables' => $overloaded_tables, 'databases_amount' => $this->count_databases());
	}
}

?>
