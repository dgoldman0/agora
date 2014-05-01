<?
require_once 'data.php';

class ItemReview extends BaseObject
{
	public $item_id, $reviewer_id, $content, $score;
	
	public function __construct($item_id, $reviewer_id, $title, $content, $score)
	{
		$this->$item_id = $item_id;
		$this->reviewer_id = $reviewer_id;
		$this->title = $title;
		$this->content = $content;
		$this->score = $score;
	}
	public static function get($id, $item_id = null, $reviewer_id = null)
	{
		$con = BaseObject::$con;
		$select = "SELECT * FROM item_reviews";
		if (isset($id))
		{
			if (is_numeric($id))
			{
				$sql = "$select WHERE id = $id;";
				$response = $con->query($sql);
				if ($row = $response->fetch_array())
					return ItemReview::getFromRow($row);
			}
		} else
		{
			if (isset($item_id))
			{
				if (is_numeric($item_id))
				{
					if (isset($reviewer_id))
					{
						$sql = "$select WHERE item_id = $item_id AND reviewer_id = $reviewer_id;";
						$response = $con->query($sql);
						if ($row = $response->fetch_array())
							return ItemReview::getFromRow($row);
					} else
					{
						$sql = "$select WHERE item_id = $item_id;";
						$objects = array();
						$response = $con->query($sql);
						while ($row = $response->fetch_array())
						{
							$objects[] = ItemReview::getFromRow($row);
						}
						return $objects;
					}
				}
			} else if (isset($reviewer_id))
			{
				if ($is_numeric($reviewer_id))
				{
					$sql = "$select WHERE reviewer_id = $reviewer_id;";
					$objects = array();
					$response = $con->query($sql);
					while ($row = $response->fetch_array())
					{
						$objects[] = ItemReview::getFromRow($row);
					}
					return $objects;
					
				}
			}
		}
	}
	public static function getFromRow($row)
	{
		$object = new ItemReview($row['item_id'], $row['reviewer_id'], $row['title'], $row['content'], $row['score']);
		$object->init($row);
		return $object;
	}
	public function write()
	{
		if (!$this->live)
		{
			$con = BaseObject::$con;
			$sql = "INSERT INTO user_roles (item_id, reviewer_id, title, content, score) VALUES (?,?, ?, ?, ?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iissi', $this->item_id, $this->reviewer_id, $this->title, $this->content, $this->score);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		} else
		{
			$con = BaseObject::$con;
			$sql = "UPDATE user_roles SET item_id = ?, reviewer_id = ?, title = '?', content = '?', score = ? WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iisssii', $this->item_id, $this->reviewer_id, $this->title, $this->content, $this->score, $this->id);
			$stmt->execute();
			$stmt->close();
			return $id;
		}
	}
	// Returns an erray of error messages
	public static function validate() {}
}