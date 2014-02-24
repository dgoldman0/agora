<?
class BaseObject
{
	public $id, $created_on, $updated_on;
	public function init($id, $created_on, $updated_on)
	{
		$this->id = $id;
		$this->created_on = $created_on;
		$this->updated_on = $updated_on;
		return $this;
	}
}
