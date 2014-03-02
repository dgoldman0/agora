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
	abstract public function get($id);
	abstract public function getFromRow($row);
	public function getAllFromResult($result)
	{
		$arr = array();
		while ($row = mysqli_fetch_array($result))
		{
			$arr[] = $this->getFromRow($row);
		}
		return $arr;
	}
	abstract public function write();
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