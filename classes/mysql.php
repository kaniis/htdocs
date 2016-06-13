<?php
class database{
	private static $db;
	public static function addRow($table, $values)
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

		$stmt = self::$db->prepare($query);
		call_user_func_array(array($stmt, 'bind_param'), $tmp);
		$stmt->execute();
	}

	public static function connectDb()
	{
		self::$db = new mysqli('localhost', 'root', 'admin', 'school');
	}

	public static function fetchRows($table, $target, $condition = false, $value = false)
	{
		$query = 'SELECT ' . $target . ' FROM ' . $table;
		if ($condition !== false)
		{
			$query .= ' WHERE ' . $condition . ' = ?';
		}

		$stmt = self::$db->prepare($query);

		if ($condition !== false)
		{
			$vartype = gettype($value);
			$stmt->bind_param($vartype[0], $value);
		}

		$stmt->execute();
		return $stmt->get_result();
	}

	public static function searchRows($table, $target, $condition, $condValue)
	{
		$query = 'SELECT ' . $target . ' FROM ' . $table;
		if (is_array($condition))
		{
			$query .= ' WHERE ';
			$vartype[0] = '';
			$values = array();
			foreach($condition as $key => $value)
			{
				$query .= $value . ' LIKE ? OR ';
				$vartype[0] .= gettype($condValue)[0];
				$values[] = '%' . $condValue . '%';
			}
			$query = rtrim($query, ' OR ');
			$stmt = self::$db->prepare($query);

			$values = array_merge($vartype, $values);
			$tmp = array();
			foreach($values as $key => $value)
			{
				$tmp[$key] = &$values[$key];
			}

			call_user_func_array(array($stmt, 'bind_param'), $tmp);
		}
		else
		{
			$query .= ' WHERE ' . $condition . ' LIKE ?';
			$vartype = gettype($condValue)[0];
			$condValue =  '%' . $condValue . '%';
			$stmt = self::$db->prepare($query);
			$stmt->bind_param($vartype[0], $condValue);
		}

		$stmt->execute();
		return $stmt->get_result();
	}

	public static function idToValue($table, $target, $id)
	{
		$stmt = self::$db->prepare('SELECT ' . $target . ' FROM ' . $table . ' WHERE id = ' . $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_row();
		return $result;
	}

	public static function updateRow($table, $target, $changeTo, $condition, $condValue)
	{
		$changeToType = '';
		$change = '';
		$i = 0;
		$values = array();
		$valueTypes[0] = '';

		foreach($target as $key => $value)
		{
			$change .= $value . ' = ?, ';
			$changeToType .= gettype($changeTo[$i++])[0];
		}

		foreach($changeTo as $key => $value)
		{
			$values[] = $value;
			$valueTypes[0] .= gettype($value)[0];
		}
		$valueTypes[0] .= gettype($condValue)[0];

		$params = array_merge($valueTypes, $values);
		$params[] = $condValue;
		$tmp = array();

		foreach($params as $key => $value)
		{
			$tmp[$key] = &$params[$key];
		}

		$query = 'UPDATE ' . $table . ' SET ' . rtrim($change, ', ') . ' WHERE ' . $condition . ' = ?';
		$stmt = self::$db->prepare($query);
		call_user_func_array(array($stmt, 'bind_param'), $tmp);
		$stmt->execute();
	}

}
?>