<?php
require_once 'settings.php';
require_once 'data.php';
// Check if there's incoming information
$username = $_POST["username"];
$password = $_POST["password"];
if ($_GET["logout"] == "true")
{
	setcookie("session", "", time() - 3600);
	mysqli_query($con, "DELETE FROM sessions WHERE session='".$session."';");
	header("Location: index.php");
	die();
} else if ($username == "")
{
	?>
	<!DOCTYPE html>
	<html><head><title>Agora Login</title><?php include 'include.php'?></head><body>
	<div class="container">
	<form class="form-horizontal" action="login.php" method="post">
		<fieldset>
			<legend>Agora Login</legend>
			<div class="form-group">
				<label class="col-md-2 control-label" for="username">Username</label>
				<div class="col-md-4">
					<input id="username" name="username" type="text" placeholder="Username" class="form-control input-md">
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="password">Password</label>
				<div class="col-md-4"><input id="password" name="password" type="password" placeholder="Password" class="form-control input-md"></div>
			</div>
			<div class="form-group">
				<label class="col-md-2 control-label" for="singlebutton">Login</label>
				<div class="col-md-2">
					<button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit</button>
				</div>
				<div class="col-md-2">
					<a href="register.php">Register</a>
				</div>
			</div>
		</fiedset>
	</form></div></body></html>
	<?php
} else
{
	// Validate Form Data and Check for Security Problems
	$result = mysqli_query($con, "SELECT password=SHA2('{$password}', 512), id FROM users where username='{$username}';");
	$row = mysqli_fetch_array($result);
	$rkeys = array_keys($row);
	if ($row[$rkeys[0]] == 1)
	{
		// Login successful
		$first = true;
		$uuid = 0;
		$expires = 0;
		do
		{
				$uuid = uniqid();
				$expires = time()+3600;
				mysqli_query($con, "INSERT INTO sessions VALUES ('{$uuid}', '{$row['id']}', '{$expires}');");
				$first = false;
		} while (mysql_errno() == 1062 || $first);
		// Add cookie
		echo $uuid;
		setcookie("session", $uuid, $expires);
		// Redirect to index
		header('Location: index.php');
		die();
	} else
	{
		// Incorrect username or password
	}
}
?>
