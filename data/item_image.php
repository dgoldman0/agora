<?

require_once 'data.php';

class ItemImage extends BaseObject
{
	public $item_id, $title, $alt_text, $long_desc, $url;
	public function __construct($item_id, $title, $alt_text, $long_desc, $url)
	{
		$this->item_id = $item_id;
		$this->title = $title;
		$this->alt_text = $alt_text;
		$this->long_desc = $long_desc;
		$this->url = $url;
	}
	public static function get($id, $item_id = null)
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
					return ItemImage::getFromRow($row);
			}
		} else
		{
			if (isset($item_id) && is_numeric($item_id))
			{
				$sql = "$select WHERE item_id = $item_id;";
				$response = $con->query($sql);
				$objects = array();
				while ($row = $response->fetch_array())
					$objects[] = ItemImage::getFromRow($row);
				return $objects;
			}
		}
	}
	public static function getFromRow($row)
	{
		$object = new Media($row['item_id'], $row['title'], $row['alt_text'], $row['long_desc'], $row['url']);
		$object->init($row);
		return $object;
	}
	public function write()
	{
		$con = BaseObject::$con;
		if (!$this->live)
		{
			$sql = "INSERT INTO item_image (item_id, title, alt_text, long_desc, url) VALUES (?, ?, ?, ?, ?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('issss', $this->item_id, $this->title, $this->alt_text, $this->long_desc, $this->url);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$sql = "UPDATE item_image SET item_id = ? title = ?, alt_text = ?, long_desc = ?, url = ? WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('isssi', $this->item_id, $this->title, $this->alt_text, $this->long_desc, $this->url, $this->id);
			$stmt->execute();
			$stmt->close();
			return $this->id;
		}
	}
	// Returns an erray of error messages
	public static function validate() {}
}