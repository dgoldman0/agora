<?
require_once 'data.php';

abstract class BaseObject
{
	public $id, $created_on, $updated_on, $live;
	public $table, $columns;
	public static $con;

	public function __construct($table, $columns)
	{
		$this->table = $table;
		$this->columns = $columns;
	}
	// Fix this... should be static
	public function getAllFromResult($result)
	{
		$arr = array();
		while ($row = mysqli_fetch_array($result))
		{
			$arr[] = static::getFromRow($row);
		}
		return $arr;
	}
	public function getFromResult($result)
	{
		if ($row = $result->fetch_array())
			return static::getFromRow($row);
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
	public static function execSQL($sql, $types, $bind)
	{
			$con = BaseObject::$con;
			$stmt = $con->prepare($sql);
			$stmt->bind_param($types, $bind);
			$stmt->execute();
			$stmt->close();
	}
	public static function get($id) {}
	public static function getFromRow($row) {}
	public function write() {}
	// Returns an erray of error messages
	public static function validate() {}
}