<?php
class database{
	private $db;
	public function addRow($table, $values)
	{
		$columns = ' (';
		$placeholders = '(';
		$fields = array();
		$first = true;
		$vartype = '';

		foreach($values as $key => $value)
		{
			if($first === false)
			{
				$columns .= ',';
				$placeholders .= ',';
			}
			else
			{
				$first = false;
			}

			$vartype .= gettype($value)[0];
			$columns .= $key;
			$placeholders .= '?';
			$fields[] .= $value;
		}

		$columns .= ') VALUES ';
		$placeholders .= ')';
		$query = 'INSERT INTO ' . $table . $columns . $placeholders;

		$params = array($vartype);
		$params = array_merge($params, $fields);
		$tmp = array();
		foreach($params as $key => $value)
		{
			$tmp[$key] = &$params[$key];
		}

		$stmt = $this->db->prepare($query);
		call_user_func_array(array($stmt, 'bind_param'), $tmp);
		$stmt->execute();
	}

	public function connectDb()
	{
		if(!isset($this->db))
		{
			$this->db = new mysqli('localhost', 'root', 'admin', 'school');
		}
	}

	public function fetchRows($table, $target, $condition = false, $value = false)
	{
		$query = 'SELECT ' . $target . ' FROM ' . $table;
		if ($condition !== false)
		{
			$query .= ' WHERE ' . $condition . ' = ?';
		}

		$stmt = $this->db->prepare($query);

		if ($condition !== false)
		{
			$vartype = gettype($value);
			$stmt->bind_param($vartype[0], $value);
		}

		$stmt->execute();
		return $stmt->get_result();
	}

	public function idToValue($table, $target, $id)
	{
		$stmt = $this->db->prepare('SELECT ' . $target . ' FROM ' . $table . ' WHERE id = ' . $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_row();
		return $result;
	}

}
?>