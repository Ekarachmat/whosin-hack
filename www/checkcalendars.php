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

$today = time();
$todayFormatted = date('Y-m-d');
$todayStart = $todayFormatted . 'T00:00:00-00:00';
$todayEnd = $todayFormatted . 'T23:59:59-00:00';

foreach ($calendars as $calendar) {
    $optParams = array('timeMin' => $todayStart, 'timeMax' => $todayEnd);
	$events = $cal->events->listEvents($calendar->getEmail(), $optParams);

    $todaysLocation = 'Unknown';

    while (true) {
        foreach ($events->getItems() as $event) {
        	$startdatetime = $event->start->dateTime;
        	$enddatetime = $event->end->dateTime;

            $start = $event->start->date;
            $starttime = strtotime($start);
            $end = $event->end->date;
            $endtime = strtotime($end);
            $summary = $event->summary;

            if ($start) {
              if ($today >= $starttime && $today <= $endtime) {
                if ($event->location) {
                    // echo '<br>TODAY: ' . $event->creator->displayName . ' - ' . $event->location;
                    $todaysLocation = $event->location;
                }
              }
            }
        }

        $pageToken = $events->getNextPageToken();

        if ($pageToken) {
            $optParams = array('timeMin' => $todayStart, 'timeMax' =>  $todayEnd, 'pageToken' => $pageToken);
            $events = $cal->events->listEvents($calendar->getEmail(), $optParams);
        } else {
            break;
        }
    }

    echo '<br>' . $calendar->getFirstName() . ' - ' . $todaysLocation;
}