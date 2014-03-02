<?

require_once 'data.php';

class Group extends BaseClass
{
	public function write()
	{	
	}
	public function getFromRow($row)
	{	
	}
}

class GroupMember extends BaseClass
{
	public $group_id, $user_id;
	public function write()
	{	
	}
	public function getFromRow($row)
	{	
	}
}
