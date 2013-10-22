<?php
require_once dirname(__FILE__) . '/GoogleClientApi/src/Google_Client.php';
require_once dirname(__FILE__) . '/GoogleClientApi/src/contrib/Google_CalendarService.php';
require_once dirname(__FILE__) . '/classes/calendarsclass.php';
require_once dirname(__FILE__) . '/config/development.php';

session_start();

// $scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];
$scriptUri = "http://www.whosin.com/oauth2callback";

$client = new Google_Client();
$client->setApplicationName("WhosIn");

// $client->setClientId('31669776438-62i79u9cn6i4548fngf5dqji7bpsf4v8.apps.googleusercontent.com');
// $client->setClientSecret('9BEsrm2VWKiDHXCuQvP4AxjS');
// $client->setDeveloperKey(AIzaSyArat8OjTNb1VzhhpQnXPxJzctiyICwJV4); // API key

$client->setClientId('31669776438-cb41m01m3e4rsdn4usgoqliok1rcms8c.apps.googleusercontent.com');
$client->setClientSecret('LAvINhUBtrbqKTvKg5kvFEc4');
$client->setDeveloperKey(AIzaSyArat8OjTNb1VzhhpQnXPxJzctiyICwJV4); // API key

$client->setRedirectUri($scriptUri);
$client->setUseObjects(true);

$cal = new Google_CalendarService($client);

if (isset($_GET['logout'])) {
    unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
    echo "rh@talis.com->".$_SESSION['token'];
    $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
    $calList = $cal->calendarList->listCalendarList();
    print "<h1>Calendar List</h1><pre>" . print_r($calList, true) . "</pre>";

    // $userCal = $cal->calendars->get("talis.com_hq7kafi7h29mt3gn61khjjb404@group.calendar.google.com");
    // print "<h1>Calendar</h1><pre>" . print_r($userCal, true) . "</pre>";

    // $events = $cal->events->listEvents('talis.com_hq7kafi7h29mt3gn61khjjb404@group.calendar.google.com');

    // foreach ($events->getItems() as $event) {
    //     print_r($event->getSummary());
    // }


    $userCal = $cal->calendars->get("jb@talis.com");
    print "<h1>Calendar</h1><pre>" . print_r($userCal, true) . "</pre>";

    $events = $cal->events->listEvents('jb@talis.com');
    $today = time();

    foreach ($events->getItems() as $event) {
        $start = $event->start->date;
        $starttime = strtotime($start);
        $end = $event->end->date;
        $endtime = strtotime($end);
        $summary = $event->summary;

        if ($start) {
          if ($today >= $starttime && $today <= $endtime) {
            // echo '<br>today:' . $today . ' start:' . $starttime . ' end:' . $endtime;
            // echo '<br>start:' . $start . ' end:' . $end . ' summary:' . $summary;
            // echo '<br>';
            // print_r($event);

            echo '<br>' . $event->creator->displayName . ' - ' . $event->location;
          }
        }
    }

    $_SESSION['token'] = $client->getAccessToken();
} else {
    $authUrl = $client->createAuthUrl();
    print "<a class='login' href='$authUrl'>Connect Me!</a>";
}


?>
<html>
<body>

</body>
</html>