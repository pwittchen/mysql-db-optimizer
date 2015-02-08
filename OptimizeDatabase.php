<?php

class OptimizeDatabase {
	private $host;
	private $user;
	private $password;
	private $db_name;
	private $connection;

	public function set_connection_config($host, $user, $password, $db_name) {
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->db_name = $db_name;
	}

	private function connect() {
		$this->connection = mysql_connect($this->host,$this->user,$this->password);

		if(!$this->connection) {
			throw new Exception('Error: cannot connect to database.');
		}

		if(!mysql_select_db($this->db_name)) {
			throw new Exception('Error cannot select database with name: '.$this->db_name.'.');
		}
	}

	private function disconnect() {
		mysql_close($this->connection);
	}

	private function mysql_fetch_all($query) {
		$result = array();
		$executed_query = mysql_query($query);

		if(mysql_num_rows($executed_query)) {
			while($row = mysql_fetch_array($executed_query)) {
				$result[$row['Name']] = $row;
			}
		}

		return $result;
	}

	private function get_tables() {
		$this->connect();
		$result = $this->mysql_fetch_all('SHOW TABLE STATUS');
		return $result;
	}

	private function get_overloaded_tables() {
		$tables = $this->get_tables();

		foreach($tables as $table => $value) {
			if($value['Data_free'] > 0) {
				$result[$table] = $value;
			}
		}

		return $result;
	}

	public function do_optimization() {
		$array = $this->get_overloaded_tables();
		$count = count($array);

		if($count > 0) {
			foreach($array as $table => $value) {
				$data_free += $value['Data_free'];
				mysql_query('OPTIMIZE TABLE `'.$table.'`');
			}
		} else {
			$data_free = 0;
		}

		$this->disconnect();
		return array('data_free' => $data_free, 'overloaded_tables' => $count);
	}
}

?>
