<?php
require_once dirname(__FILE__) . '/../GoogleClientApi/src/Google_Client.php';
require_once dirname(__FILE__) . '/../GoogleClientApi/src/contrib/Google_CalendarService.php';
require_once dirname(__FILE__) . '/../config/development.php';
require_once dirname(__FILE__) . '/../classes/allcalendarsclass.php';
require_once dirname(__FILE__) . '/../classes/configclass.php';

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

foreach ($calendars as $calendar) {
	$events = $cal->events->listEvents($calendar->getEmail());
    $today = time();

    foreach ($events->getItems() as $event) {
    	// $startdatetime = $event->start->dateTime;
    	// $enddatetime = $event->end->dateTime;

        $start = $event->start->date;
        $starttime = strtotime($start);
        $end = $event->end->date;
        $endtime = strtotime($end);
        $summary = $event->summary;

        // echo '<br>' . $calendar->getEmail() . ' start:' . $event->start->date . ' end:' . $event->end->date . ' summary:' . $event->summary . ' location:' . $event->location;

        if ($start) {
          if ($today >= $starttime && $today <= $endtime) {
            echo '<br>TODAY: ' . $event->creator->displayName . ' - ' . $event->location;
          }
        }
    }
}