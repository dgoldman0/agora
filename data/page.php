<?
require_once 'data.php';

// Helper class which is used to list pages on the menu without having to fetch all of the page information
class PageLink
{
	public $id, $title;
	public function __construct($id, $title)
	{
		$this->id = $id;
		$this->title = $title;
	}
}

class Page extends BaseObject
{
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
	public static function getPageLinks()
	{
		$response = BaseObject::$con->query("SELECT id, title FROM pages WHERE shop_id = $_shop->id AND type = 1");
		$pageLinks = array();
		while ($row = $response->fetch_array)
		{
			$pageLinks[] = new PageLink($row['id'], $row['title']);
		}
		return $pageLinks;
	}
	// If all then get every revision of the page, otherwise just get the newest version
	public static function get($id, $all = false)
	{
		if ($id)
		{
			$con = BaseObject::$con;
			if (is_numeric($id))
			{
				if ($all)
					$response = $con->query("SELECT * FROM pages WHERE id=$id;");
			}
			else
			{
				$perma = $con->real_escape_string($id);
				if ($all)
					$response = $con->query("SELECT * FROM pages WHERE perma=$perma");
			}
			if ($row = $response->fetch_array())
			{
				$user = getFromRow($row);
				$user.init();
				return $user;
			}
		}
	}
	public static function getFromRow($row)
	{
			$page = new Page($row['title'], $row['perma'], $row['shop_id'], $row['content'], $row['type']);
			$page.init();
			return $page;
	}
	public function write()
	{
		$con = BaseObject::$con;	
		if (!$this->live)
		{
			$sql = "INSERT INTO pages (title, perma, shop_id, type, content) VALUES (?,?,?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('ssiis', $this->title, $this->perma, $this->shop_id, $this->type, $this->content);
		} else
		{
			$sql = "INSERT INTO pages (id, title, perma, shop_id, type, content) VALUES (?,?,?,?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('issiis', $this->id, $this->title, $this->perma, $this->shop_id, $this->type, $this->content);
		}
		$stmt->execute();
		$stmt->close();
		return $con->insert_id;
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