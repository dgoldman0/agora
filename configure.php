<?php
// Make sure that HTTPS is being used!
require_once 'settings.php';
require_once 'data.php';
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
				</body></head>
				<?php
			} else
			{
				// Validate form data and protect against SQL injection
				$site_name = $_POST["site_name"];
				$email = $_POST["email"];
				$username = $_POST["username"];
				$password = $_POST["password1"];
				if ($password == $_POST["password2"])
				{
					// Create system wide tables
					mysqli_query($con, "CREATE TABLE agora (site_name varchar (255) NOT NULL default '', email varchar (255) NOT NULL DEFAULT '', PRIMARY KEY (site_name));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE users (id INT(11) unsigned NOT NULL auto_increment, username varchar (255) NOT NULL DEFAULT '', password varchar (40), user_role INT(11) unsigned NOT NULL default '1', email VARCHAR (255) NOT NULL DEFAULT '', PRIMARY KEY (id));");
					// Will have to do something about expired sessions
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE sessions (id VARCHAR (255) NOT NULL DEFAULT '', user INT(11), expires BIGINT(12) UNSIGNED, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE user_roles (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE user_role_capabilities (capability INT(11) UNSIGNED NOT NULL DEFAULT 0, role_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(capability, role_id));");

					// Shop tables
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shops (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(255) UNSIGNED NOT NULL DEFAULT '', PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shop_users (id INT(11) UNSIGNED NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, home TINYINT(1) NOT NULL DEFUALT 0, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shop_user_roles (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, shop_id INT(11) USNIGNED NOT NULL, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shop_user_role_capabilities (capability INT(11) UNSIGNED NOT NULL DEFAULT 0, role_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(capability));");
					
					// Cart tables
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shopping_carts (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL DEFAULT '', wishlist TINYINT(1) NOT NULL DEFAULT 0, PRIMAY KEY(id);");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE cart_items (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, item_id INT(11) UNSIGNED NOT NULL, public TINYINT(1), PRIMARY KEY(id));");
					// Invoice tables

					// Add settings info & create administrator account
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO agora VALUES ('".$site_name."', '".$email."');");
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO users (username, password, user_role, email) VALUES ('".$username."', SHA('".$password."'), 0, '".$email."');");
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
	echo "<html>Error Connecting</html>";
}
$mysqli_close($con);
?>
