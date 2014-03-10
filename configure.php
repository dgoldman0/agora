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
					// Add a stylized name column and set naming requirements similar to shop names
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE users (id INT(11) unsigned NOT NULL auto_increment, username varchar (50) NOT NULL DEFAULT '', password varchar (255) NOT NULL, user_role INT(11) unsigned NOT NULL default '1', email VARCHAR (50) NOT NULL DEFAULT '', first VARCHAR(50) NOT NULL DEFAULT '', last VARCHAR(50) NOT NULL DEFAULT '', PRIMARY KEY (id), UNIQUE KEY(username)) ENGINE=InnoDB;");
					
					// Will have to do something about expired sessions
					// Rename user->user_id
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE sessions (id VARCHAR (255) NOT NULL DEFAULT '', user INT(11) UNSIGNED NOT NULL, expires BIGINT(12) UNSIGNED, PRIMARY KEY(id), FOREIGN KEY (user) REFERENCES users(id) ON DELETE CASCADE) ENGINE = MEMORY;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE session_notifications (id INT(11) NOT NULL AUTO_INCREMENT, created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, session_id VARCHAR(255) NOT NULL, activity_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(session_id) REFERENCES sessions(id) ON DELETE CASCADE, FOREIGN KEY(activity_id) REFERENCES activity(id) ON DELETE CASCADE) ENGINE=MEMORY;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE user_roles (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, PRIMARY KEY(id));");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE user_role_capabilities (capability INT(11) UNSIGNED NOT NULL DEFAULT 0, role_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(capability, role_id), FOREIGN KEY(role_id) REFERENCES user_roles(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shipping (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, user_id INT(11) UNSIGNED NOT NULL, name VARCHAR(50) NOT NULL, first VARCHAR(50) NOT NULL, last VARCHAR(50) NOT NULL, street1 VARCHAR(255) NOT NULL, street2 VARCHAR(255) NOT NULL, locality VARCHAR(50) NOT NULL, postal VARCHAR(20) NOT NULL, state VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, PRIMARY KEY(id), FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE billing (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, user_id INT(11) UNSIGNED NOT NULL, name VARCHAR(50) NOT NULL, first VARCHAR(50) NOT NULL, last VARCHAR(50) NOT NULL, street1 VARCHAR(255) NOT NULL, street2 VARCHAR(255) NOT NULL, locality VARCHAR(50) NOT NULL, postal VARCHAR(20) NOT NULL, state VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, PRIMARY KEY(id), FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB;");

					// Shop tables
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shop_types (id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT, title VARCHAR(255) NOT NULL, description LONGBLOB NOT NULL, PRIMARY KEY(id)) ENGINE=InnoDB;");
					// Need on delete change to different shop type?
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shops (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL DEFAULT '', stylized VARCHAR(255) NOT NULL, short_desc VARCHAR(156) NOT NULL DEFAULT '', url VARCHAR(255) NOT NULL, shop_type SMALLINT(5) UNSIGNED NOT NULL DEFAULT 0, PRIMARY KEY(id), FOREIGN KEY(shop_type) REFERENCES shop_types(id), UNIQUE KEY(name), UNIQUE KEY(url)) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shop_hours (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, day SMALLINT(5) UNSIGNED NOT NULL, open TIME NOT NULL, close TIME NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(shop_id) REFERENCES shops(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					
					// Items
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE items (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, shop_id INT(11) UNSIGNED NOT NULL, name VARCHAR(50) NOT NULL, sku VARCHAR(50) NOT NULL, short_desc VARCHAR(156), long_desc TEXT NOT NULL, PRIMARY KEY(id), UNIQUE KEY(sku), FOREIGN KEY(shop_id) REFERENCES shops(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE item_images (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, item_id INT(11) UNSIGNED NOT NULL, medium_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE CASCADE, FOREIGN KEY(medium_id) REFERENCES media(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					
					// Default shop id is 0 ie marketwide
					// Should really change the name of item_price_categories to just price_categories...
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE item_price_categories (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, shop_id INT(11) UNSIGNED NOT NULL, description VARCHAR(156) NOT NULL, PRIMARY KEY(id), FOREIGN KEY(shop_id) REFERENCES shops(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE item_prices (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, item_id INT(11) UNSIGNED NOT NULL, price_category INT(11) UNSIGNED NOT NULL, currency INT(11) UNSIGNED NOT NULL, value DECIMAL(10,3) NOT NULL DEFAULT 0, PRIMARY KEY(id), FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE CASCADE, FOREIGN KEY(price_category) REFERENCES item_price_categories(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE tax_categories (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL, type SMALLINT(5) NOT NULL, value DECIMAL(6, 3), PRIMARY KEY(id)) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE item_tax_categories (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, item_id INT(11) UNSIGNED NOT NULL, cat_id INT (11) UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE CASCADE, FOREIGN KEY(cat_id) REFERENCES tax_categories(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					// I don't really want to cascade on delete. I want to set to 0 on delete
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE item_category_codes (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL, parent INT(11) UNSIGNED NOT NULL DEFAULT 0, PRIMARY KEY(id), FOREIGN KEY(parent) REFERENCES item_category_codes(id) ON DELETE CASCADE);");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE item_categories (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, cat_code INT(11) UNSIGNED NOT NULL DEFAULT 0, PRIMARY KEY(id), FOREIGN KEY(cat_code) REFERENCES item_category_codes(id) ON DELETE CASCADE);");

					// Cart & Bag tables
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shopping_carts (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, owner_id INT(11) UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL DEFAULT '', wishlist TINYINT(1) NOT NULL DEFAULT 0, active TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY(id), FOREIGN KEY(owner_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE shopping_bags (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP, cart_id INT(11) UNSIGNED NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, active TINYINT(1) UNSIGNED NOT NULL DEFAULT 0, PRIMARY KEY(id), FOREIGN KEY(cart_id) REFERENCES shopping_carts(id) ON DELETE CASCADE, FOREIGN KEY(shop_id) REFERENCES shops(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE bag_items (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, bag_id INT(11) UNSIGNED NOT NULL, item_id INT(11) UNSIGNED NOT NULL, cnt INT(11) UNSIGNED NOT NULL DEFAULT 1, PRIMARY KEY(id), UNIQUE KEY(bag_id, item_id), FOREIGN KEY(bag_id) REFERENCES shopping_bags(id) ON DELETE CASCADE, FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					
					// Payment tables
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE payment_info (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, name VARCHAR(255) NOT NULL DEFAULT '', user_id INT(11) UNSIGNED NOT NULL, payment_type SMALLINT(5) UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE);");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE credit_cards (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, piid INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id), uri VARCHAR(255) NOT NULL, FOREIGN KEY(piid) REFERENCES payment_info(id) ON DELETE CASCADE);");

					// Order & Invoice tables
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE orders (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, user_id INT(11) UNSIGNED NOT NULL, placed_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id), FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE invoices (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, order_id INT(11) UNSIGNED NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, payment_method INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE, FOREIGN KEY(shop_id) REFERENCES shops(id) ON DELETE CASCADE, FOREIGN KEY(payment_method) REFERENCES payment_info(id)) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE invoice_items (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, invoice_id INT(11) UNSIGNED NOT NULL, item_id INT(11) UNSIGNED NOT NULL, cnt INT(11) UNSIGNED NOT NULL DEFAULT 1, price DECIMAL(10, 3) NOT NULL DEFAULT 0, PRIMARY KEY(id), UNIQUE KEY(invoice_id, item_id), FOREIGN KEY(invoice_id) REFERENCES invoices(id) ON DELETE CASCADE, FOREIGN KEY(item_id) REFERENCES items(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					// Product Reviews
					
					// Modules
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE modules (location VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY(location)) ENGINE=InnoDB");
					// Templates
					
					// Custom content
					// Need to add shop_id for media
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE media (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, uploaded_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP, name VARCHAR(255) NOT NULL, type SMALLINT(5), data LONGBLOB NOT NULL, alt_text VARCHAR(255), long_desc TEXT NOT NULL, PRIMARY KEY(id)) ENGINE=InnoDB;");
					// Do some kind of on delete set default thing here
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE badges (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, medium_id INT(11) UNSIGNED NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, name VARCHAR(255) NOT NULL, description LONGBLOB NOT NULL, free TINYINT(1) NOT NULL DEFAULT 1, PRIMARY KEY(id), FOREIGN KEY(medium_id) REFERENCES media(id), FOREIGN KEY(shop_id) REFERENCES shops(id)) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE user_badges (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, user_id INT(11) UNSIGNED NOT NULL, badge_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(user_id) REFERENCES users(id), FOREIGN KEY(badge_id) REFERENCES badges(id)) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE pages (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, title VARCHAR(255) NOT NULL, perma VARCHAR(255) NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, tstamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, content MEDIUMBLOB NOT NULL, type SMALLINT(5) UNSIGNED NOT NULL DEFAULT 1, PRIMARY KEY(id), FOREIGN KEY(shop_id) REFERENCES shops(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					// Should I use this or just reuse item tables? It would be cleaner if I did it this way. The other way might end up with restaurants looking like an afterthought
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE restaurant_menus (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, title VARCHAR(255) NOT NULL, description LONGBLOB NOT NULL, shop_id INT(11) UNSIGNED NOT NULL, created_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(id), FOREIGN KEY(shop_id) REFERENCES shops(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE restaurant_menu_items (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, menu_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(id) REFERENCES items(id), FOREIGN KEY(menu_id) REFERENCES restaurant_menus(id)) ENGINE=InnoDB;");

					// Social Networking
					if ($con->error == "") $con->query("CREATE TABLE friends (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, created_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, user_id INT(11) UNSIGNED NOT NULL, friend_id INT(11) UNSIGNED NOT NULL, PRIMARY KEY(id), FOREIGN KEY(friend_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if ($con->error == "") $con->query("CREATE TABLE invites (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, created_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, updated_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, invited_by INT(11) UNSIGNED NOT NULL, expires TIMESTAMP NOT NULL, PRIMARY KEY(id), FOREIGN KEY(invited_by) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					// If no to_id is specified, it defaults to 0, which is the admin. Need to still block the admin from seeing anything that's not public
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE activity (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, created_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP, updated_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, from_id INT(11) UNSIGNED NOT NULL, to_id INT(11) UNSIGNED NOT NULL, shop_id INT(11) UNSIGNED NOT NULL DEFAULT 0, type SMALLINT(5) UNSIGNED NOT NULL DEFAULT 1, content MEDIUMBLOB NOT NULL, privacy_level SMALLINT(5), PRIMARY KEY(id), FOREIGN KEY(from_id) REFERENCES users(id) ON DELETE CASCADE, FOREIGN KEY(to_id) REFERENCES users(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TABLE board (id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT, shop_id INT(11) UNSIGNED NOT NULL, title VARCHAR(60) NOT NULL, open TINYINT(1) NOT NULL DEFAULT 0, PRIMARY KEY(id), FOREIGN KEY(shop_id) REFERENCES shops(id) ON DELETE CASCADE) ENGINE=InnoDB;");
					// Add settings info & create administrator account
					if (mysqli_error($con == "")) mysqli_query($con, "SET sql_mode='NO_AUTO_VALUE_ON_ZERO';");
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO shop_types (id, title, description) VALUES (0, 'store', '');");
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO shop_types (id, title, description) VALUES (1, 'restaurant', '');");
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO shops (id, name, url, short_desc, stylized) VALUES (0, '{$site_name}', '{$url}', '', '{$site_name}');");
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO users (id, username, password, user_role, email) VALUES (0, '{$username}', SHA2('{$password}', 512), 0, '{$email}');");
					if (mysqli_error($con) == "") mysqli_query($con, "INSERT INTO item_price_categories (id, shop_id, description) VALUES (0, 0, 'list');");

					// Add procedures, triggers, events, etc
					if (mysqli_error($con) == "") mysqli_query($con, "CREATE EVENT clean ON SCHEDULE EVERY 1 HOUR DO DELETE FROM sessions WHERE expires < UNIX_TIMESTAMP();");
//					if (mysqli_error($con) == "") mysqli_query($con, "CREATE TRIGGER rmi_add AFTER INSERT on items BEGIN IF (SELECT shop_type FROM shops WHERE id=NEW.shop_id)=1 THEN INSERT INTO restaurant_menu_items  END IF; END; delimiter ;

					if (mysqli_error($con) == "")
					{
						// Redirect to login
						header("Location: /login.php");
						die();
					} else
					{
						echo "SQL Error: {mysqli_error($con)}";
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
