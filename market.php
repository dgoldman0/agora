<?php
function printVender($heading, $description)
{
	echo '<div class="col-md-4"><div class="panel panel-default"><div class="panel-heading">'.$heading.'</div><div class="panel-body"><p>'.$description.'</p></div></div></div>';
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Agora: The Social eCommerce System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="css/agora.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <div class="container">
		<?php include 'menu.php'?>
                <!-- Marketing area -->
                <div class="jumbotron">
                        <h1>Wander the Market...</h1>
                </div>
                <!-- Content Sections -->
		<div class="vendor-container">
			<div class="row">
				<?php printVender("Billy Bob's BBQ", "Billy Bob’s is a place where we want you to feel comfortable. We want you to join us for some good food and good drinks. And most of all we want you to have FUN!!!");?>
				<div class="col-md-4 walkway-block">
				</div>
				<?php printVender("Allen's Falafel", "Delicious, authentic home-made Israeli cuisine. Everything’s made fresh… daily.
We use the freshest ingredients for our delicious, authentic food.");?>
			</div>
		</div>
</div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
