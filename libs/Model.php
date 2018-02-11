<?php defined('__ROOT__') OR exit('No direct script access allowed');

class Model 
{	
	protected $_table_name = '';
	protected $_primary_key = 'id';
	protected $_order_by = '';
	public $limit = '';
	protected $_timestamps = FALSE;
	protected $_read_only = FALSE;
	protected $db = NULL;
	protected $paranthArr = array( '(', ')' );
	public function __construct()
	{
		$this->db = Db::getInstance();
	}

	public function get($id = NULL, $single = FALSE, $select = '*')
	{
		$statement = "SELECT $select FROM $this->_table_name ";
		if (isset($id)) 
			$statement .= "WHERE $this->_primary_key = :id ";
		if ($this->_order_by)
			$statement .= "ORDER BY $this->_order_by ";
		if ($single)
			$statement .= "LIMIT 1";
		else if ($this->limit)
			$statement .= "$this->limit";
		$stmt = $this->db->prepare($statement);
		if (isset($id))
			$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute ();
		return $stmt->fetchAll();
	}
	
	public function get_by($where, $single = FALSE, $select = '*')
	{
		$statement = "SELECT $select FROM $this->_table_name WHERE ";
		foreach ($where as $key => $value) {
			if(count($value) == 1)
				$statement .= " $value[0]";
			else {
				$statement .= " $value[0]";
				$statement .= " $value[1]";
				$tmp_name = str_replace($this->paranthArr, '', $value[0]);
				$statement .= " :$tmp_name"."_$key";
			}
			
		}
		if ($this->_order_by)
			$statement .= " ORDER BY $this->_order_by ";
		if ($single)
			$statement .= " LIMIT 1 ";
		else if ($this->limit)
			$statement .= " $this->limit ";
		$stmt = $this->db->prepare($statement);
		foreach ($where as $key => $value) {
			if(count($value) == 1)
				continue;
			$tmp_name = str_replace($this->paranthArr, '', $value[0]);
			$stmt->bindParam(":$tmp_name"."_$key", $value[2]);
		}
		$stmt->execute();
		$result = $stmt->fetchAll();
		return $result;
	}
	
	public function save($data, $id = NULL)
	{
		if ( $this->_read_only )
			return 1;
		if ($this->_timestamps == TRUE) 
		{
			$now = date('Y-m-d H:i:s');
			$id || $data['created'] = $now;
			$data['modified'] = $now;
		}
		
		$keys = array_keys($data);
		foreach ($data as $key => $value) {
			$data[":$key"] = $value;		
			unset($data["$key"]);		
		}

		// Insert
		if ($id === NULL) 
		{
			$sql = "INSERT INTO $this->_table_name (".implode(", ",$keys).") ";
			$sql .= "VALUES ( :".implode(", :",$keys).")";
			$stmt = $this->db->prepare($sql);
	  		$stmt->execute($data);
	  		$id = $this->db->lastInsertId();
		}

		// Update
		else 
		{
			$data[":$this->_primary_key"] = $id;
			$sql = "UPDATE $this->_table_name SET";
			foreach ($keys as $key => $value) {
				$sql .= " $value = :$value";
				if ($key != (count($keys) - 1))
					$sql .= ', ';
			}
			$sql .= " WHERE $this->_primary_key = :id";
			$stmt = $this->db->prepare($sql);			                                    
			$stmt->execute($data);
		}
		
		return $id;
	}
	
	public function delete($id)
	{
		if ( $this->_read_only )
			return 1;
		$stmt = $this->db->prepare("DELETE FROM $this->_table_name WHERE $this->_primary_key = :id");
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);   
		$stmt->execute();
		$stmt = $this->db->prepare("ALTER TABLE $this->_table_name AUTO_INCREMENT = 1");
		$stmt->execute();
	}
	
}
