<?

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
	$sql = "SELECT * FROM US_ZIP_CODES WHERE zip='$zip'";
	$result = BaseObject::$con->query($sql);
	while ($row = $result->fetch_array())
	{
		$zips[] = new Zip($row['zip']);
	}
}
echo json_encode($zips);
