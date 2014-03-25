<?php

define("MONGO_HOST", "127.0.0.1");
define("MONGO_USER", "");
define("MONGO_PASSWORD", "");
define("MONGO_REPSET", "");
define("WHOSINDB", "whosin");
define("CALENDARS_COLLECTION", "calendars");
define("CONFIG_COLLECTION", "config");

// get from environment variables...
$googleClientId = getenv('WHOSIN_GOOGLE_CLIENT_ID');
$googleClientSecret = getenv('WHOSIN_GOOGLE_CLIENT_SECRET');
$googleAPIKey = getenv('WHOSIN_GOOGLE_API_KEY');

define("GOOGLE_CLIENT_ID", $googleClientId);
define("GOOGLE_CLIENT_SECRET", $googleClientSecret);
define("GOOGLE_API_KEY", $googleAPIKey);