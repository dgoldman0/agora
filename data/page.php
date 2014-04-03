<?
require_once 'data.php';

class Page extends BaseObject
{
	const TYPE_NORMAL = 1;
	public $title, $perma, $shop_id, $content, $type;
	function __construct($title, $perma, $shop_id, $content, $type)
	{
		$this->title = $title;
		$this->perma = $perma;
		$this->shop_id = $shop_id;
		$this->content = $content;
		$this->type = $type;
	}
	function getAbstract()
	{
		$pos = strpos($content, "<!--more");
		if ($pos === false)
			return $content;
		else
			return substr($content, 0, $pos);
	}
	public static function get($id)
	{
	}
	public static function getFromRow($row)
	{
			$page = new Page($row['title'], $row['perma'], $row['shop_id'], $row['content'], $row['type']);
			$page.init();
			return $page;
	}
	public function write()
	{
		if (!$this->live)
		{
			$con = BaseObject::$con;
			$sql = "INSERT INTO pages (title, perma, shop_id, type, content) VALUES (?,?,?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('ssiis', $this->title, $this->perma, $this->shop_id, $this->type, $this->content);
			$stmt->execute();
			$stmt->close();
			return $con->insert_id;
		}
	}
	// I want to replace these text errors with an error hierarchy
	public static function validate()
	{
		$errors = array();
		if ($this->perma)
		{
			if (permaExists($this->perma))
				$errors[] = "Perma Exists";
		} else
		{
			$error = "Perma Blank";
		}
		if ($shop_id)
		{
			if ($shop_id >= 0)
			{
				// Check if shop exists
				if (!Shop::exists($shop_id))
				{
					$errors[] = "Invalid Shop";
				}
			} else {
				$errors[] = "Invalid Shop";
			}
		}
		return $errors;
	}
}
class PageLink
{
	public $perma, $title;
	public function __construct($perma, $title)
	{
		$this->perma = $perma;
		$this->title = $title;
	}
}
?>