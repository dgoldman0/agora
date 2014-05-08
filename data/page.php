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
		if (isset($pos))
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
	public static function permaExists($perma, $shop_id)
	{
		$con = BaseObject::$con;
		$sql = "SELECT id FROM pages WHERE perma='$perma' AND shop_id = $shop_id;";
		$response = $con->query($sql);
		if ($row = $response->fetch_array())
		{
			return true;
		}
		return false;
	}
	// If all then get every revision of the page, otherwise just get the newest version
	public static function get($id, $shop_id, $all = false)
	{
		$con = BaseObject::$con;
		$multi = false;
		if (isset($id))
		{
			if (is_numeric($id))
			{
				$sql = "SELECT * FROM pages WHERE id=$id";
			} else
			{
				if (isset($shop_id))
				{
					$perma = $con->real_escape_string($id);
					$sql = "SELECT * FROM pages WHERE perma='$perma' AND shop_id = $shop_id";
				}
			}
		} else {
			if (isset($shop_id))
			{
				$sql = "SELECT * FROM pages WHERE shop_id = $shop_id";
				$multi = true;
			}
		}
		if (isset($sql))
		{
			$response = $con->query($sql." ORDER BY created_on DESC;");
			if ($all || $multi)
			{
				$pages = array();
				while ($row = $response->fetch_array())
				{
					$pages[] = Page::getFromRow($row);
				}
				return $pages;
			} else {
				if ($row = $response->fetch_array())
				{
					return Page::getFromRow($row);
				}
			}
		}
	}
	public static function getFromRow($row)
	{
			$page = new Page($row['title'], $row['perma'], $row['shop_id'], $row['content'], $row['type']);
			$page->init($row);
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
			$sql = "INSERT INTO pages (id, title, perma, shop_id, type, content) VALUES (?, ?,?,?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('issiis', $this->id, $this->title, $this->perma, $this->shop_id, $this->type, $this->content);
		}
		$stmt->execute();
		$stmt->close();
		return $con->insert_id;
		}
	// I want to replace these text errors with an error hierarchy
	public static function validate($page)
	{
		$errors = array();
		if (isset($page->shop_id))
		{
			if ($page->shop_id < 0 || !Shop::exists($page->shop_id))
			{
				$errors[] = new Error("Invalid Shop");
			}
			if ($page->perma)
			{
				if (Page::permaExists($page->perma, $page->shop_id) && !$page->live)
					$errors[] = new Error("Perma Exists");
			} else
			{
				$errors[] = new Error("Perma Blank");
			}
		} else
		{
			$errors[] = new Error("No Shop Specified");
		}
		return $errors;
	}
}