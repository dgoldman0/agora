<?
require_once 'data.php';

class UserRole extends BaseObject
{
	public $shop_id, $title, $stylized;
	
	public function __construct($shop_id, $title, $stylized)
	{
		$this->shop_id = $shop_id;
		$this->title = $title;
		$this->stylized = $stylized;
	}
	public static function get($id, $shop_id = null)
	{
		$con = BaseObject::$con;
		$select = "SELECT shops.stylized, shops.id, user_roles.* FROM user_roles INNER JOIN shops ON user_roles.shop_id = shops.id";
		if (isset($id))
		{
			if (is_numeric($id))
			{
				$sql = "$select WHERE user_roles.id = $id;";
			} else if (isset($shop_id) && is_numeric($shop_id))
			{
				$id = $con->real_escape_string($id);
				$sql = "$select WHERE title = '$id' AND shop_id = $shop_id;";
			}
			$response = $con->query($sql);
			if ($row = $response->fetch_array())
				return UserRole::getFromRow($row);
		} else
		{
			if (isset($shop_id))
			{
				if (is_numeric($shop_id))
				{
					$sql = "$select WHERE shop_id = $shop_id;";
					$objects = array();
					$response = $con->query($sql);
					while ($row = $response->fetch_array())
					{
						$objects[] = UserRole::getFromRow($row);
					}
					return $objects;
				}
			} else
			{
				$sql = "$select;";
				$objects = array();
				$response = $con->query($sql);
				while ($row = $response->fetch_array())
				{
					$objects[] = UserRole::getFromRow($row);
				}
				return $objects;
			}
		}
	}
	public static function getFromRow($row)
	{
		$object = new UserRole($row['shop_id'], $row['title'], $row['stylized']);
		$object->init($row);
		return $object;
	}
	public function write()
	{
		if (!$this->live)
		{
			$con = BaseObject::$con;
			$sql = "INSERT INTO user_roles (shop_id, title) VALUES (?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('is', $this->shop_id, $this->title);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$con = BaseObject::$con;
			$sql = "UPDATE user_roles SET shop_id = ?, title = ? WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('isi', $this->shop_id, $this->title, $this->id);
			$stmt->execute();
			$stmt->close();
			return $id;
		}
	}
	// Returns an erray of error messages
	public static function validate() {}
}