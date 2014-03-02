<?php
define('DB_USERNAME', 'agora');
define('DB_PASSWORD', 'market');
define('DB_LOCATION', 'localhost');
define('DB_NAME', 'agora');

// How often to poll, in microseconds (1,000,000 μs equals 1 s)
define('MESSAGE_POLL_MICROSECONDS', 500000);
// How long to keep the Long Poll open, in seconds
define('MESSAGE_TIMEOUT_SECONDS', 30);
// Timeout padding in seconds, to avoid a premature timeout in case the last call in the loop is taking a while
define('MESSAGE_TIMEOUT_SECONDS_BUFFER', 5);

define('ALLOW_REGISTRATION', true);
define('REQUIRE_INVITE', true);
?>
