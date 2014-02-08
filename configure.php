<?php
// Make sure that HTTPS is being used!
require_once 'settings.php';
require_once 'data.php';

function configurationView()
{
?>
<!DOCTYPE html>
<html><head><title>Agora Configuration</title><?php include 'include.php'?></head><body>
	<div class="container">
		<form class="form-horizontal" action="configure.php" method="post">
			<fieldset>
				<legend>Agora Configuration</legend>
				<div class="form-group">
					<label class="col-md-4 control-label" for="site_name">Site Name</label>
					<div class="col-md-4">
						<input id="site_name" name="site_name" type="text" placeholder="Site Name" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="username">URL</label>
					<div class="col-md-4">
						<input id="url" name="url" type="text" placeholder="URL" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="username">Username</label>
					<div class="col-md-4">
						<input id="username" name="username" type="text" placeholder="Username" class="form-control input-md">
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="password1">Password</label>
					<div class="col-md-4"><input id="password1" name="password1" type="password" placeholder="Password" class="form-control input-md"></div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="password2">Repeat Password</label>
						<div class="col-md-4"><input id="password2" name="password2" type="password" placeholder="Repeat Password" class="form-control input-md"></div>
					</div>
					<div class="form-group">
						<label class="col-md-4 control-label" for="email">Email</label>
               	    	<div class="col-md-4">
 						<input id="email" name="email" type="text" placeholder="Email" class="form-control input-md">
               		</div>
				</div>
				<div class="form-group">
					<label class="col-md-4 control-label" for="singlebutton">Create Market</label>
					<div class="col-md-4">
						<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	</body></head></html>
	<?php
}
if (!mysqli_connect_errno($con))
{
	// Check to see if the database is empty
	$result = mysqli_query($con, "select Count(*) as tcnt from information_schema.tables where table_type='BASE TABLE' and table_schema='".DB_NAME."'");
	if ($row = mysqli_fetch_array($result))
	{
		if ($row['tcnt'] == 0)
		{
			if ($_POST["site_name"] == "")
			{
				configurationView();
			} else
			{
				// Validate form data and protect against SQL injection
				$site_name = $_POST['site_name'];
				$email = $_POST['email'];
				$username = $_POST['username'];
				$password = $_POST['password1'];
				$url = $_POST['url'];
				
				if ($password == $_POST["password2"])
				{
					// Create system wide tables
					mysqli_query($con, "CREATE TABLE agora (site_name varchar (255) NOT NULL default '', email varchar (255) NOT NULL DEFAULT '', url VARCHAR(255) NOT NULL, PRIMARY KEY (site_name));");
					// Add a stylized name column and set naming requirements similar to shop names
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE users (id INT(11) unsigned NOT NULL auto_increment, username varchar (50) NOT NULL DEFAULT '', password varchar (255) NOT NULL, user_role INT(11) unsigned NOT NULL default '1', email VARCHAR (50) NOT NULL DEFAULT '', first VARCHAR(50) NOT NULL DEFAULT '', last VARCHAR(50) NOT NULL, PRIMARY KEY (id), UNIQUE KEY(username));");
					
					// Will have to do something about expired sessions
					// Rename user->user_id
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE sessions (id VARCHAR (255) NOT NULL DEFAULT '', user INT(11) UNSIGNED NOT NULL, expires BIGINT(12) UNSIGNED, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE user_roles (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE user_role_capabilities (capability INT(11) UNSIGNED NOT NULL DEFAULT 0, role_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(capability, role_id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shipping (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, user_id INT(11) UNSIGNED NOT NULL, name VARCHAR(50) NOT NULL, first VARCHAR(50) NOT NULL, last VARCHAR(50) NOT NULL, street1 VARCHAR(255) NOT NULL, street2 VARCHAR(255) NOT NULL, locality VARCHAR(50) NOT NULL, postal VARCHAR(20) NOT NULL, state VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE billing (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, user_id INT(11) UNSIGNED NOT NULL, name VARCHAR(50) NOT NULL, first VARCHAR(50) NOT NULL, last VARCHAR(50) NOT NULL, street1 VARCHAR(255) NOT NULL, street2 VARCHAR(255) NOT NULL, locality VARCHAR(50) NOT NULL, postal VARCHAR(20) NOT NULL, state VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, PRIMARY KEY(id));");

					// Shop tables
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shops (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL DEFAULT '', stylized VARCHAR(255) NOT NULL, short_desc VARCHAR(156) NOT NULL DEFAULT '', url VARCHAR(255) NOT NULL, PRIMARY KEY(id), UNIQUE KEY(name), UNIQUE KEY(url));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shop_users (id INT(11) UNSIGNED NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, role_id INT(11), home TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY(id, shop_id));");

					// Should I have two separate sets of tables or just use shop_id = 0 for master roles: Second option seems better
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shop_user_roles (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, shop_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shop_user_role_capabilities (capability INT(11) UNSIGNED NOT NULL DEFAULT 0, role_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(capability, role_id));");
					
					// Items
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE items (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, shop_id INT(11) UNSIGNED NOT NULL, name VARCHAR(50) NOT NULL, sku VARCHAR(50) NOT NULL, short_desc VARCHAR(156), long_desc TEXT NOT NULL, PRIMARY KEY(id), UNIQUE KEY(sku));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE item_images (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, item_id INT(11) UNSIGNED NOT NULL, medium_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id));");
					
					// Default shop id is 0 ie marketwide
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE item_price_categories (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, shop_id INT(11) NOT NULL DEFAULT 0, description VARCHAR(156) NOT NULL, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE item_prices (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, item_id INT(11) UNSIGNED NOT NULL, price_category INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id));");

					// Cart & Bag tables
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shopping_carts (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, owner_id INT(11) UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL DEFAULT '', wishlist TINYINT(1) NOT NULL DEFAULT 0, active TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shopping_bags (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, cart_id INT(11) UNSIGNED NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, active TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE bag_items (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, bag_id INT(11) UNSIGNED NOT NULL, item_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id), cnt INT(11) UNSIGNED NOT NULL DEFAULT 1, UNIQUE KEY(bag_id, item_id));");
					// Invoice tables

					// Product Reviews
					
					// Modules
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE modules (location VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY(location))");
					// Templates
					
					// Custom content
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE media (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL, type SMALLINT(5), data LONGBLOB NOT NULL, alt_text VARCHAR(255), long_desc TEXT NOT NULL, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE pages (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, title VARCHAR(255) NOT NULL, perma VARCHAR(255) NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, tstamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, content MEDIUMBLOB NOT NULL, type SMALLINT(5) UNSIGNED NOT NULL DEFAULT 1, PRIMARY KEY(id));");

					// Social Networking
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE friends (id INT(11) UNSIGNED NOT NULL, friend1 INT(11)UNSIGNED NOT NULL, friend2 INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE activity (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, tstamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, from_id INT(11) UNSIGNED NOT NULL, to_id INT(11) UNSIGNED NOT NULL, shop_id INT(11) UNSIGNED NOT NULL DEFAULT 0, type SMALLINT(5) UNSIGNED NOT NULL DEFAULT 1, content MEDIUMBLOB NOT NULL, privacy_level SMALLINT(5), PRIMARY KEY(id));");
					
					// Add settings info & create administrator account
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO agora VALUES ('".$site_name."', '".$email."', '".$url."');");
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO users (username, password, user_role, email) VALUES ('".$username."', SHA2('".$password."', 512), 0, '".$email."');");
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO item_price_categories (shop_id, description) VALUES (0, 'list');");
					if (mysqli_error($con) == "")
					{
						// Redirect to login
						header("Location: /login.php");
						die();
					} else
					{
						echo "SQL Error: ".mysqli_error($con);
					}
				} else
				{
				}
			}
		} else
		{
			echo "<html>The database isn't empty</html>";
		}
	} else
	{
		echo "<html>Not sure</html>";
	}
} else
{
	echo mysqli_connect_error();
}
$mysqli_close($con);
?>
