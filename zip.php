<?
require_once 'data.php';

class Zip
{
	public $zip;
	public function __construct($zip)
	{
		$this->zip = $zip;
	}
}
$zips = array();
if ($zip = $_REQUEST['zip'])
{
	$sql = "SELECT * FROM US_Zip_Codes WHERE zip LIKE '$zip%' LIMIT 100000;";
	$result = BaseObject::$con->query($sql);
	while ($row = $result->fetch_array())
	{
		$zips[] = new Zip($row['zip']);
	}
}
echo jsonResponse($zips);
