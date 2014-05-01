<?
require_once 'data.php';

class Invite extends BaseObject
{
	public $invite_code, $invited_by, $expires;
	
	public function __construct($invite_code, $invited_by, $expires)
	{
		$this->invite_code = $invite_code;
		$this->invited_by = $invited_by;
		$this->expires = $expires;
	}
	public function write()
	{
		$con = BaseObject::$con;
		$sql = "INSERT INTO invites (invite_code, invited_by, expires) VALUES (?,?,?);";
		$stmt = $con->prepare($sql);
		$expires = 0;
		$stmt->bind_param('sii', $this->invite_code, $this->invited_by, $expires);
		if (!$this->live)
		{
			$first = true;
			$uuid = 0;
			do
			{
				$uuid = uniqid();
				$expires = time()+3600;
				$stmt->execute();
				$first = false;
			} while (mysql_errno() == 1062 || $first);
			$stmt->close();
			$this->invite_code = $uuid;
			$this->expires = $expires;
			return $con->insert_id;
		}
	}
	public static function get($id)
	{
		$con = BaseObject::$con;
		$result = $con->query("SELECT * FROM invites WHERE id={$id}");
		if ($row = $result->fetch_array())
			return getFromRow($row);
	}
	public static function getFromCode($invite_code)
	{
		$con = BaseObject::$con;
		$result = $con->query("SELECT * FROM invites WHERE invite_code=$invite_code AND expires > UNIX_TIMESTAMP();");
		if ($row = $result->fetch_array())
			return getFromRow($row);
	}
	public static function getFromRow($row)
	{
		$invite = new Invite($row['invite_code'], $row['invited_by'], $row['expires']);
		$invite.init();
		return $invite;
	}
}
