<?

require_once 'data.php';

class Media extends BaseObject
{
	public $shop_id, $title, $alt_text, $long_desc, $url;
	public function __construct($shop_id, $title, $alt_text, $long_desc, $url)
	{
		$this->shop_id = $shop_id;
		$this->title = $title;
		$this->alt_text = $alt_text;
		$this->long_desc = $long_desc;
		$this->url = $url;
	}
	public static function get($id, $shop_id = null)
	{
		$con = BaseObject::$con;
		$select = "SELECT * FROM media";
		if (isset($id))
		{
			if (is_numeric($id))
			{
				$sql = "$select WHERE id = $id;";
				$response = $con->query($sql);
				if ($row = $response->fetch_array())
					return Media::getFromRow($row);
			}
		} else
		{
			if (isset($shop_id) && is_numeric($shop_id))
			{
				$sql = "$select WHERE shop_id = $shop_id;";
				$response = $con->query($sql);
				$objects = array();
				while ($row = $response->fetch_array())
					$objects[] = Media::getFromRow($row);
				return $objects;
			}
		}
	}
	public static function getFromRow($row)
	{
		$object = new Media($row['shop_id'], $row['title'], $row['alt_text'], $row['long_desc'], $row['url']);
		$object->init($row);
		return $object;
	}
	public function write()
	{
		$con = BaseObject::$con;
		if (!$this->live)
		{
			$sql = "INSERT INTO media (shop_id, title, alt_text, long_desc, url) VALUES (?, ?, ?, ?, ?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('issss', $this->shop_id, $this->title, $this->alt_text, $this->long_desc, $this->url);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$sql = "UPDATE media SET shop_id = ? title = ?, alt_text = ?, long_desc = ?, url = ? WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('isssi', $this->shop_id, $this->title, $this->alt_text, $this->long_desc, $this->url, $this->id);
			$stmt->execute();
			$stmt->close();
			return $this->id;
		}
	}
	// Returns an erray of error messages
	public static function validate() {
		
	}
}