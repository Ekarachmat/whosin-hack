<?php
require_once dirname(__FILE__) . '/GoogleClientApi/src/Google_Client.php';
require_once dirname(__FILE__) . '/GoogleClientApi/src/contrib/Google_CalendarService.php';
require_once dirname(__FILE__) . '/config/development.php';
require_once dirname(__FILE__) . '/classes/allcalendarsclass.php';
require_once dirname(__FILE__) . '/classes/configclass.php';

session_start();

$config = new Config();
$config->load();

$allCalendars = new AllCalendars();

$query = array();

$calendars = $allCalendars->getCalendars($query);

$client = new Google_Client();
$client->setApplicationName("WhosIn");

$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setDeveloperKey(GOOGLE_API_KEY); // API key

$client->setRedirectUri($scriptUri);
$client->setUseObjects(true);
$client->setAccessToken($config->getAuthToken());

$cal = new Google_CalendarService($client);

// $calList = $cal->calendarList->listCalendarList();
// print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";

$holidayCal = "talis.com_hq7kafi7h29mt3gn61khjjb404@group.calendar.google.com";

$specificDay = strtotime("2013-10-28");

$todayFormatted = date('Y-m-d', $specificDay);
$todayStart = $todayFormatted . 'T00:00:00-00:00';
$todayEnd = $todayFormatted . 'T23:59:59-00:00';

$optParams = array('timeMin' => $todayStart, 'timeMax' => $todayEnd);
$events = $cal->events->listEvents($holidayCal, $optParams);

foreach ($events->getItems() as $event) {
    echo "<br>User:" . $event->creator->displayName . " - " . $event->creator->email;
}
?>