<?
require_once 'data.php';

class Page extends 
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
