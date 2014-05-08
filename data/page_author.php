<?
require_once 'data.php';

class PageAuthor extends BaseObject
{
	public $page_id, $author_id, $coauthor;
	public function __construct($page_id, $author_id, $coauthor)
	{
		$this->page_id = $page_id;
		$this->author_id = $author_id;
		$this->co_author = $coauthor;
	}
	public static function get($id, $page_id, $author_id)
	{
		$con = BaseObject::$con;
	}
	public static function getFromRow($row)
	{
			$page = new Page($row['page_id'], $row['author_id'], $row['coauthor']);
			$page->init($row);
			return $page;
	}
	public function write()
	{
		$con = BaseObject::$con;	
		if (!$this->live)
		{
			$sql = "INSERT INTO page_authors (page_id, author_id, coauthor) VALUES (?,?,?);";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iii', $this->page_id, $this->author_id, $this->coauthor);
		} else
		{
			$sql = "UPDATE page_authors SET page_id = ?, author_id = ?, coauthor = ? WHERE id = ?;";
			$stmt = $con->prepare($sql);
			$stmt->bind_param('iiii', $this->page_id, $this->author_id, $this->coauthor, $this->id);
		}
		$stmt->execute();
		$stmt->close();
		return $con->insert_id;
		}
	// I want to replace these text errors with an error hierarchy
	public static function validate($page)
	{
		$errors = array();
		return $errors;
	}
}
