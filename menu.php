<?php
require_once 'settings.php';
require_once 'data.php';
require_once 'data/shop.php';
require_once 'data/page.php';

?>
<nav class="navbar navbar-default" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
    	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
      	<span class="sr-only">Toggle navigation</span>
      	<span class="icon-bar"></span>
      	<span class="icon-bar"></span>
      	<span class="icon-bar"></span></button>
      	<a class="navbar-brand" href="
	      	<?
			if (!$market->shop == null)
			{
	   			echo "shop.php?shop={$market->shop->name}\">{$market->shop->stylized}";
			} else
			{
				echo 'index.php">Agora';
			}
		?>
		</a>
  	</div>

  	<!-- Collect the nav links, forms, and other content for toggling -->
  	<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
  		<ul class="nav navbar-nav">
  			<?php
  			// List pages as menu items
  			if (!$market->shop == null)
			{
				echo "<li><a href=\"stream.php?shop={$market->shop->name}\">Stream</a></li>";
			} else
			{
				echo '<li><a href="market.php">Market</a></li>';
				echo '<li><a href="stream.php">Stream</a></li>';
	      	}
			// Display pages
//			foreach ($market->getPageLinks() as $page1)
//			{
//				echo "<li><a href=\"page.php?perma={$page1->perma}\">{$page1->title}</a></li>";
//			}
	      	echo "<li><a href=\"user.php\">Members</a></li>";
      		if (isAdmin($market->shop))
      		{
      			echo '<li><a href="admin.php">Administration</a></li>';
      		}
      		?>
    	</ul>
    	<ul class="nav navbar-nav navbar-right">
    		<form class="navbar-form navbar-left" role="search">
	      		<div class="form-group">
	        		<input type="text" class="form-control" placeholder="Search">
	      		</div>
	      		<button type="submit" class="btn btn-default">Submit</button>
	  	  	</form>
	      	<li class="dropdown">
	        	<a href="#" class="dropdown-toggle" data-toggle="dropdown">Account <b class="caret"></b></a>
	        	<ul class="dropdown-menu">
	        		<li><a href="/profile.php">Profile</a></li>
	          		<li><a href="/settings.php">Settings</a></li>
	          		<li class="divider"></li>
			  		<?= (isLoggedIn()) ? '<li><a href="login.php?logout=true">Logout</a></li>' : '<li><a href="login.php">Login</a></li>'?>
				</ul>
			</li>
		</ul>
	</div><!-- /.navbar-collapse -->
</nav>