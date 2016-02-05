<?php
class database{
	private $db;
	public function connectDb(){
		if(!isset($this->db))
		{
			$this->db = new mysqli('localhost', 'root', 'admin', 'school');
		}
	}

	public function fetchRows($table, $target, $condition = false, $value = false){
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
	public function idToValue($table, $target, $id){
		$stmt = $this->db->prepare('SELECT ' . $target . ' FROM ' . $table . ' WHERE id = ' . $id);
		$stmt->execute();
		$result = $stmt->get_result()->fetch_row();
		return $result;
	}
	
}
?>