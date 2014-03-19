<?
require_once 'data.php';

class Page
{
	const TYPE_NORMAL = 1;
	public $title, $perma, $shop_id, $tstamp, $content, $type, $id;
	function __construct($title, $perma, $shop_id, $tstamp, $content, $type, $id)
	{
		$this->title = $title;
		$this->perma = $perma;
		$this->shop_id = $shop_id;
		$this->tstamp = $tstamp;
		$this->content = $content;
		$this->type = $type;
		$this->id = $id;
	}
	function makeInjectionSafe()
	{
		$con = BaseObject::$con;
		return new Page(mysqli_real_escape_string($con, $this->title),
			mysqli_real_escape_string($con, $this->perma),
			$this->shop_id,
			$this->tstamp,
			mysqli_real_escape_string($con, $this->content),
			$this->type,
			$this->id
		);
	}
	function getAbstract()
	{
		$pos = strpos($content, "<!--more");
		if ($pos === false)
			return $content;
		else
			return substr($content, 0, $pos);
	}
	function getCategories()
	{
		
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
