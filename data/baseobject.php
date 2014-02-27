<?
class BaseObject
{
	public $id, $created_on, $updated_on, $live;
	public $table, $columns;
	public static $con;
	/*
	public static function con()
	{
		if ($con == null)
		{
			$con = mysqli_connect(DB_LOCATION, DB_USERNAME, DB_PASSWORD, DB_NAME);
		}
		return $con;
	}
    */
	public function __construct($table, $columns)
	{
		$this->table = $table;
		$this->columns = $columns;
	}
	public function get($id = null)
	{
		
	}
	public function fromRow($row)
	{
		
	}
	// Fills in root column information from sql row
	public function write()
	{
		$object = (array) $this;
		if (!$live)
		{
			$first = true;
			foreach ($this->columns as $column)
			{
				$value = $object[$column];
				if (!is_numeric($value))
				{
					$value = mysqli_real_escape_string(BaseObject::$con, $value);
					$value = "'{$value}'";
				}
				if ($first)
				{
					$first = false;
					$list = $column;
					$values = $value;
				} else
				{
					$list = "{$list},{$column}";
					$values = "{$values},{$value}";
				}
			}
			$sql = "INSERT INTO {$this->table} ({$list}) VALUES ({$values});";
			mysqli_query(BaseObject::$con, $sql);
			return mysqli_insert_id(BaseObject::$con);
		} else
		{
			$first = true;
			foreach ($this->columns as $column)
			{
				$value = $object[$column];
				if (!is_numeric($value))
				{
					$value = mysqli_real_escape_string(BaseObject::$con, $value);
					$value = "'{$value}'";
				}
				if ($first)
				{
					$first = false;
					$list = $column;
					$values = $value;
				} else
				{
					$list = "{$list},{$column}={$value}";
				}
			}
			$sql = "UPDATE {$this->table} SET {$list} WHERE id={$this->id};";
			mysqli_query(BaseObject::$con, $sql);
			return $this->id;
		}
	}
	public function jsonEncode()
	{
		$object = (array) $this;
		$result = array();
		foreach ($this->columns as $column)
		{
			$value = $object[$column];
			$result[$column] = $value;
		}
		return json_encode($result);
	}
	public function init($row)
	{
		$this->id = $row['id'];
		$this->created_on = $row['created_on'];
		$this->updated_on = $row['updated_on'];
		$this->live = true;
		return $this;
	}
}
