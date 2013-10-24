<?php
require_once dirname(__FILE__) . '/../GoogleClientApi/src/Google_Client.php';
require_once dirname(__FILE__) . '/../GoogleClientApi/src/contrib/Google_CalendarService.php';
require_once dirname(__FILE__) . '/../config/development.php';
require_once dirname(__FILE__) . '/../classes/allcalendarsclass.php';
require_once dirname(__FILE__) . '/../classes/configclass.php';

session_start();

function checkCalendar($cal, $calendarId, $date, $isHoliday, $userArray) {
    $userEmail = ($isHoliday ? "" : $calendarId);

    $todayFormatted = date('Y-m-d', $date);
    $todayStart = $todayFormatted . 'T00:00:00-00:00';
    $todayEnd = $todayFormatted . 'T23:59:59-00:00';

    $optParams = array('timeMin' => $fromDate, 'timeMax' => $toDate);
    $events = $cal->events->listEvents($calendarId, $optParams);

    $todaysLocation = 'Unknown';

    while (true) {
        foreach ($events->getItems() as $event) {
            $start = $event->start->date;
            $starttime = strtotime($start);
            $end = $event->end->date;
            $endtime = strtotime($end);

            if ($start) {
              if ($date >= $starttime && $date <= $endtime) {
                if ($event->location) {
                    $todaysLocation = $event->location;
                }

                if ($isHoliday) {
                    $userEmail = $event->creator->email;
                    $todaysLocation = "Holiday" . ($todaysLocation ? " - " . $todaysLocation : "" );
                
                    if (!array_key_exists($userEmail, $userArray)) {
                        $userArray[$userEmail] = $todaysLocation;
                    }
                }
              }
            }
        }

        $pageToken = $events->getNextPageToken();

        if ($pageToken) {
            $optParams = array('timeMin' => $todayStart, 'timeMax' =>  $todayEnd, 'pageToken' => $pageToken);
            $events = $cal->events->listEvents($calendarId, $optParams);
        } else {
            break;
        }
    }    

    if (!$isHoliday) {
        if (!array_key_exists($userEmail, $userArray)) {
            $userArray[$userEmail] = $todaysLocation;
        }
    }

    return $userArray;
}

function getUserNameForEmail($calendars, $email) {
    $firstName = "";

    foreach ($calendars as $calendar) {
        if ($calendar->getEmail() === $email) {
            $firstName = $calendar->getFirstName();
            break;
        }
    }

    return $firstName;
}

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

$statusArray = array();

// TODO - store in mongo config
$holidayCal = "talis.com_hq7kafi7h29mt3gn61khjjb404@group.calendar.google.com";

$userArray = array();
$specificDay = time(); //strtotime("2013-10-28");

$userArray = checkCalendar($cal, $holidayCal, $specificDay, true, $userArray);

foreach ($calendars as $calendar) {
    $userArray = checkCalendar($cal, $calendar->getEmail(), $specificDay, false, $userArray);
}

// re-order array for return
foreach ($userArray as $key => $value) {
    $firstName = getUserNameForEmail($calendars, $key);
    $statusArray[] = array("email" => $key, "name" => ($firstName ? $firstName : $key), "location" => $value);
}

header('Content-Type: application/json');
echo json_encode($statusArray);