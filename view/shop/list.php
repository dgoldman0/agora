<?
require_once 'data.php';

function printShop($shop)
{
?>
	<div class="col-md-3">
		<div class="panel panel-default">
			<div class="panel-heading">
				<a href="shop.php?sid=<?=$shop->name?>"><?=$shop->stylized?></a>
			</div>
			<div class="panel-body">
				<p><?=$shop->short_desc?></p>
			</div>
		</div>
	</div>	
<?
}


$shops = Shop::get();

switch ($format)
{
	case "json":
		$response = array();
		$response['data'] = $shops;
		echo json_encode($response);
		break;
	default:
		foreach ($shops as $shop)
		{
			printShop($shop);
		}
			
		function javascripts()
		{
			?>
				<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
			<?
		}
}