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
$statusArray = array();

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

    // construct status array
    // $statusArray[$calendar->getFirstName()] = $todaysLocation;
    $statusArray[] = array("name" => $calendar->getFirstName(), "location" => $todaysLocation);
}
?>
<!DOCTYPE html>
<html style="height:100%;">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<title>WhosIn - LiveBoard</title>
<!--Adobe Edge Runtime-->
    <script type="text/javascript" charset="utf-8" src="Flip2_edgePreload.js"></script>
    <style>
        .edgeLoad-EDGE-3123259 { visibility:hidden; }
    </style>
<!--Adobe Edge Runtime End-->

</head>
<body style="margin:0;padding:0;height:100%;">
	<div id="Stage" class="EDGE-3123259">
	
        <div id="Stage_world-map-dotted-black" class="edgeLoad-EDGE-3123259"></div>
        <div id="Stage_Rectangle4" class="edgeLoad-EDGE-3123259"></div>
        <div id="Stage_Line1" class="edgeLoad-EDGE-3123259">
            <div id="Stage_Line1_locationCharacter1">
                <div id="Stage_Line1_locationCharacter1_topFlap"></div>
                <div id="Stage_Line1_locationCharacter1_Character">J</div>
                <div id="Stage_Line1_locationCharacter1_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter2">
                <div id="Stage_Line1_locationCharacter2_topFlap"></div>
                <div id="Stage_Line1_locationCharacter2_Character">J</div>
                <div id="Stage_Line1_locationCharacter2_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter3">
                <div id="Stage_Line1_locationCharacter3_topFlap"></div>
                <div id="Stage_Line1_locationCharacter3_Character">J</div>
                <div id="Stage_Line1_locationCharacter3_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter4">
                <div id="Stage_Line1_locationCharacter4_topFlap"></div>
                <div id="Stage_Line1_locationCharacter4_Character">J</div>
                <div id="Stage_Line1_locationCharacter4_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter5">
                <div id="Stage_Line1_locationCharacter5_topFlap"></div>
                <div id="Stage_Line1_locationCharacter5_Character">J</div>
                <div id="Stage_Line1_locationCharacter5_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter6">
                <div id="Stage_Line1_locationCharacter6_topFlap"></div>
                <div id="Stage_Line1_locationCharacter6_Character">J</div>
                <div id="Stage_Line1_locationCharacter6_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter7">
                <div id="Stage_Line1_locationCharacter7_topFlap"></div>
                <div id="Stage_Line1_locationCharacter7_Character">J</div>
                <div id="Stage_Line1_locationCharacter7_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter8">
                <div id="Stage_Line1_locationCharacter8_topFlap"></div>
                <div id="Stage_Line1_locationCharacter8_Character">J</div>
                <div id="Stage_Line1_locationCharacter8_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter9">
                <div id="Stage_Line1_locationCharacter9_topFlap"></div>
                <div id="Stage_Line1_locationCharacter9_Character">J</div>
                <div id="Stage_Line1_locationCharacter9_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter10">
                <div id="Stage_Line1_locationCharacter10_topFlap"></div>
                <div id="Stage_Line1_locationCharacter10_Character">J</div>
                <div id="Stage_Line1_locationCharacter10_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter11">
                <div id="Stage_Line1_locationCharacter11_topFlap"></div>
                <div id="Stage_Line1_locationCharacter11_Character">J</div>
                <div id="Stage_Line1_locationCharacter11_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter12">
                <div id="Stage_Line1_locationCharacter12_topFlap"></div>
                <div id="Stage_Line1_locationCharacter12_Character">J</div>
                <div id="Stage_Line1_locationCharacter12_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter13">
                <div id="Stage_Line1_locationCharacter13_topFlap"></div>
                <div id="Stage_Line1_locationCharacter13_Character">J</div>
                <div id="Stage_Line1_locationCharacter13_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter14">
                <div id="Stage_Line1_locationCharacter14_topFlap"></div>
                <div id="Stage_Line1_locationCharacter14_Character">J</div>
                <div id="Stage_Line1_locationCharacter14_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter15">
                <div id="Stage_Line1_locationCharacter15_topFlap"></div>
                <div id="Stage_Line1_locationCharacter15_Character">J</div>
                <div id="Stage_Line1_locationCharacter15_divider"></div>
            </div>
            <div id="Stage_Line1_locationCharacter16">
                <div id="Stage_Line1_locationCharacter16_topFlap"></div>
                <div id="Stage_Line1_locationCharacter16_Character">J</div>
                <div id="Stage_Line1_locationCharacter16_divider"></div>
            </div>
            <div id="Stage_Line1_topFlap"></div>
            <div id="Stage_Line1_Character">NAME</div>
            <div id="Stage_Line1_divider"></div>
        </div>
        <div id="Stage_Line2" class="edgeLoad-EDGE-3123259">
            <div id="Stage_Line2_locationCharacter1">
                <div id="Stage_Line2_locationCharacter1_topFlap"></div>
                <div id="Stage_Line2_locationCharacter1_Character">J</div>
                <div id="Stage_Line2_locationCharacter1_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter2">
                <div id="Stage_Line2_locationCharacter2_topFlap"></div>
                <div id="Stage_Line2_locationCharacter2_Character">J</div>
                <div id="Stage_Line2_locationCharacter2_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter3">
                <div id="Stage_Line2_locationCharacter3_topFlap"></div>
                <div id="Stage_Line2_locationCharacter3_Character">J</div>
                <div id="Stage_Line2_locationCharacter3_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter4">
                <div id="Stage_Line2_locationCharacter4_topFlap"></div>
                <div id="Stage_Line2_locationCharacter4_Character">J</div>
                <div id="Stage_Line2_locationCharacter4_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter5">
                <div id="Stage_Line2_locationCharacter5_topFlap"></div>
                <div id="Stage_Line2_locationCharacter5_Character">J</div>
                <div id="Stage_Line2_locationCharacter5_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter6">
                <div id="Stage_Line2_locationCharacter6_topFlap"></div>
                <div id="Stage_Line2_locationCharacter6_Character">J</div>
                <div id="Stage_Line2_locationCharacter6_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter7">
                <div id="Stage_Line2_locationCharacter7_topFlap"></div>
                <div id="Stage_Line2_locationCharacter7_Character">J</div>
                <div id="Stage_Line2_locationCharacter7_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter8">
                <div id="Stage_Line2_locationCharacter8_topFlap"></div>
                <div id="Stage_Line2_locationCharacter8_Character">J</div>
                <div id="Stage_Line2_locationCharacter8_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter9">
                <div id="Stage_Line2_locationCharacter9_topFlap"></div>
                <div id="Stage_Line2_locationCharacter9_Character">J</div>
                <div id="Stage_Line2_locationCharacter9_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter10">
                <div id="Stage_Line2_locationCharacter10_topFlap"></div>
                <div id="Stage_Line2_locationCharacter10_Character">J</div>
                <div id="Stage_Line2_locationCharacter10_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter11">
                <div id="Stage_Line2_locationCharacter11_topFlap"></div>
                <div id="Stage_Line2_locationCharacter11_Character">J</div>
                <div id="Stage_Line2_locationCharacter11_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter12">
                <div id="Stage_Line2_locationCharacter12_topFlap"></div>
                <div id="Stage_Line2_locationCharacter12_Character">J</div>
                <div id="Stage_Line2_locationCharacter12_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter13">
                <div id="Stage_Line2_locationCharacter13_topFlap"></div>
                <div id="Stage_Line2_locationCharacter13_Character">J</div>
                <div id="Stage_Line2_locationCharacter13_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter14">
                <div id="Stage_Line2_locationCharacter14_topFlap"></div>
                <div id="Stage_Line2_locationCharacter14_Character">J</div>
                <div id="Stage_Line2_locationCharacter14_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter15">
                <div id="Stage_Line2_locationCharacter15_topFlap"></div>
                <div id="Stage_Line2_locationCharacter15_Character">J</div>
                <div id="Stage_Line2_locationCharacter15_divider"></div>
            </div>
            <div id="Stage_Line2_locationCharacter16">
                <div id="Stage_Line2_locationCharacter16_topFlap"></div>
                <div id="Stage_Line2_locationCharacter16_Character">J</div>
                <div id="Stage_Line2_locationCharacter16_divider"></div>
            </div>
            <div id="Stage_Line2_topFlap"></div>
            <div id="Stage_Line2_Character">NAME</div>
            <div id="Stage_Line2_divider"></div>
        </div>
        <div id="Stage_Line3" class="edgeLoad-EDGE-3123259">
            <div id="Stage_Line3_locationCharacter1">
                <div id="Stage_Line3_locationCharacter1_topFlap"></div>
                <div id="Stage_Line3_locationCharacter1_Character">J</div>
                <div id="Stage_Line3_locationCharacter1_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter2">
                <div id="Stage_Line3_locationCharacter2_topFlap"></div>
                <div id="Stage_Line3_locationCharacter2_Character">J</div>
                <div id="Stage_Line3_locationCharacter2_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter3">
                <div id="Stage_Line3_locationCharacter3_topFlap"></div>
                <div id="Stage_Line3_locationCharacter3_Character">J</div>
                <div id="Stage_Line3_locationCharacter3_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter4">
                <div id="Stage_Line3_locationCharacter4_topFlap"></div>
                <div id="Stage_Line3_locationCharacter4_Character">J</div>
                <div id="Stage_Line3_locationCharacter4_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter5">
                <div id="Stage_Line3_locationCharacter5_topFlap"></div>
                <div id="Stage_Line3_locationCharacter5_Character">J</div>
                <div id="Stage_Line3_locationCharacter5_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter6">
                <div id="Stage_Line3_locationCharacter6_topFlap"></div>
                <div id="Stage_Line3_locationCharacter6_Character">J</div>
                <div id="Stage_Line3_locationCharacter6_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter7">
                <div id="Stage_Line3_locationCharacter7_topFlap"></div>
                <div id="Stage_Line3_locationCharacter7_Character">J</div>
                <div id="Stage_Line3_locationCharacter7_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter8">
                <div id="Stage_Line3_locationCharacter8_topFlap"></div>
                <div id="Stage_Line3_locationCharacter8_Character">J</div>
                <div id="Stage_Line3_locationCharacter8_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter9">
                <div id="Stage_Line3_locationCharacter9_topFlap"></div>
                <div id="Stage_Line3_locationCharacter9_Character">J</div>
                <div id="Stage_Line3_locationCharacter9_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter10">
                <div id="Stage_Line3_locationCharacter10_topFlap"></div>
                <div id="Stage_Line3_locationCharacter10_Character">J</div>
                <div id="Stage_Line3_locationCharacter10_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter11">
                <div id="Stage_Line3_locationCharacter11_topFlap"></div>
                <div id="Stage_Line3_locationCharacter11_Character">J</div>
                <div id="Stage_Line3_locationCharacter11_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter12">
                <div id="Stage_Line3_locationCharacter12_topFlap"></div>
                <div id="Stage_Line3_locationCharacter12_Character">J</div>
                <div id="Stage_Line3_locationCharacter12_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter13">
                <div id="Stage_Line3_locationCharacter13_topFlap"></div>
                <div id="Stage_Line3_locationCharacter13_Character">J</div>
                <div id="Stage_Line3_locationCharacter13_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter14">
                <div id="Stage_Line3_locationCharacter14_topFlap"></div>
                <div id="Stage_Line3_locationCharacter14_Character">J</div>
                <div id="Stage_Line3_locationCharacter14_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter15">
                <div id="Stage_Line3_locationCharacter15_topFlap"></div>
                <div id="Stage_Line3_locationCharacter15_Character">J</div>
                <div id="Stage_Line3_locationCharacter15_divider"></div>
            </div>
            <div id="Stage_Line3_locationCharacter16">
                <div id="Stage_Line3_locationCharacter16_topFlap"></div>
                <div id="Stage_Line3_locationCharacter16_Character">J</div>
                <div id="Stage_Line3_locationCharacter16_divider"></div>
            </div>
            <div id="Stage_Line3_topFlap"></div>
            <div id="Stage_Line3_Character">NAME</div>
            <div id="Stage_Line3_divider"></div>
        </div>
        <div id="Stage_Line4" class="edgeLoad-EDGE-3123259">
            <div id="Stage_Line4_locationCharacter1">
                <div id="Stage_Line4_locationCharacter1_topFlap"></div>
                <div id="Stage_Line4_locationCharacter1_Character">J</div>
                <div id="Stage_Line4_locationCharacter1_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter2">
                <div id="Stage_Line4_locationCharacter2_topFlap"></div>
                <div id="Stage_Line4_locationCharacter2_Character">J</div>
                <div id="Stage_Line4_locationCharacter2_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter3">
                <div id="Stage_Line4_locationCharacter3_topFlap"></div>
                <div id="Stage_Line4_locationCharacter3_Character">J</div>
                <div id="Stage_Line4_locationCharacter3_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter4">
                <div id="Stage_Line4_locationCharacter4_topFlap"></div>
                <div id="Stage_Line4_locationCharacter4_Character">J</div>
                <div id="Stage_Line4_locationCharacter4_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter5">
                <div id="Stage_Line4_locationCharacter5_topFlap"></div>
                <div id="Stage_Line4_locationCharacter5_Character">J</div>
                <div id="Stage_Line4_locationCharacter5_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter6">
                <div id="Stage_Line4_locationCharacter6_topFlap"></div>
                <div id="Stage_Line4_locationCharacter6_Character">J</div>
                <div id="Stage_Line4_locationCharacter6_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter7">
                <div id="Stage_Line4_locationCharacter7_topFlap"></div>
                <div id="Stage_Line4_locationCharacter7_Character">J</div>
                <div id="Stage_Line4_locationCharacter7_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter8">
                <div id="Stage_Line4_locationCharacter8_topFlap"></div>
                <div id="Stage_Line4_locationCharacter8_Character">J</div>
                <div id="Stage_Line4_locationCharacter8_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter9">
                <div id="Stage_Line4_locationCharacter9_topFlap"></div>
                <div id="Stage_Line4_locationCharacter9_Character">J</div>
                <div id="Stage_Line4_locationCharacter9_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter10">
                <div id="Stage_Line4_locationCharacter10_topFlap"></div>
                <div id="Stage_Line4_locationCharacter10_Character">J</div>
                <div id="Stage_Line4_locationCharacter10_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter11">
                <div id="Stage_Line4_locationCharacter11_topFlap"></div>
                <div id="Stage_Line4_locationCharacter11_Character">J</div>
                <div id="Stage_Line4_locationCharacter11_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter12">
                <div id="Stage_Line4_locationCharacter12_topFlap"></div>
                <div id="Stage_Line4_locationCharacter12_Character">J</div>
                <div id="Stage_Line4_locationCharacter12_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter13">
                <div id="Stage_Line4_locationCharacter13_topFlap"></div>
                <div id="Stage_Line4_locationCharacter13_Character">J</div>
                <div id="Stage_Line4_locationCharacter13_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter14">
                <div id="Stage_Line4_locationCharacter14_topFlap"></div>
                <div id="Stage_Line4_locationCharacter14_Character">J</div>
                <div id="Stage_Line4_locationCharacter14_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter15">
                <div id="Stage_Line4_locationCharacter15_topFlap"></div>
                <div id="Stage_Line4_locationCharacter15_Character">J</div>
                <div id="Stage_Line4_locationCharacter15_divider"></div>
            </div>
            <div id="Stage_Line4_locationCharacter16">
                <div id="Stage_Line4_locationCharacter16_topFlap"></div>
                <div id="Stage_Line4_locationCharacter16_Character">J</div>
                <div id="Stage_Line4_locationCharacter16_divider"></div>
            </div>
            <div id="Stage_Line4_topFlap"></div>
            <div id="Stage_Line4_Character">NAME</div>
            <div id="Stage_Line4_divider"></div>
        </div>
        <div id="Stage_Line5" class="edgeLoad-EDGE-3123259">
            <div id="Stage_Line5_locationCharacter1">
                <div id="Stage_Line5_locationCharacter1_topFlap"></div>
                <div id="Stage_Line5_locationCharacter1_Character">J</div>
                <div id="Stage_Line5_locationCharacter1_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter2">
                <div id="Stage_Line5_locationCharacter2_topFlap"></div>
                <div id="Stage_Line5_locationCharacter2_Character">J</div>
                <div id="Stage_Line5_locationCharacter2_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter3">
                <div id="Stage_Line5_locationCharacter3_topFlap"></div>
                <div id="Stage_Line5_locationCharacter3_Character">J</div>
                <div id="Stage_Line5_locationCharacter3_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter4">
                <div id="Stage_Line5_locationCharacter4_topFlap"></div>
                <div id="Stage_Line5_locationCharacter4_Character">J</div>
                <div id="Stage_Line5_locationCharacter4_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter5">
                <div id="Stage_Line5_locationCharacter5_topFlap"></div>
                <div id="Stage_Line5_locationCharacter5_Character">J</div>
                <div id="Stage_Line5_locationCharacter5_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter6">
                <div id="Stage_Line5_locationCharacter6_topFlap"></div>
                <div id="Stage_Line5_locationCharacter6_Character">J</div>
                <div id="Stage_Line5_locationCharacter6_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter7">
                <div id="Stage_Line5_locationCharacter7_topFlap"></div>
                <div id="Stage_Line5_locationCharacter7_Character">J</div>
                <div id="Stage_Line5_locationCharacter7_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter8">
                <div id="Stage_Line5_locationCharacter8_topFlap"></div>
                <div id="Stage_Line5_locationCharacter8_Character">J</div>
                <div id="Stage_Line5_locationCharacter8_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter9">
                <div id="Stage_Line5_locationCharacter9_topFlap"></div>
                <div id="Stage_Line5_locationCharacter9_Character">J</div>
                <div id="Stage_Line5_locationCharacter9_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter10">
                <div id="Stage_Line5_locationCharacter10_topFlap"></div>
                <div id="Stage_Line5_locationCharacter10_Character">J</div>
                <div id="Stage_Line5_locationCharacter10_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter11">
                <div id="Stage_Line5_locationCharacter11_topFlap"></div>
                <div id="Stage_Line5_locationCharacter11_Character">J</div>
                <div id="Stage_Line5_locationCharacter11_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter12">
                <div id="Stage_Line5_locationCharacter12_topFlap"></div>
                <div id="Stage_Line5_locationCharacter12_Character">J</div>
                <div id="Stage_Line5_locationCharacter12_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter13">
                <div id="Stage_Line5_locationCharacter13_topFlap"></div>
                <div id="Stage_Line5_locationCharacter13_Character">J</div>
                <div id="Stage_Line5_locationCharacter13_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter14">
                <div id="Stage_Line5_locationCharacter14_topFlap"></div>
                <div id="Stage_Line5_locationCharacter14_Character">J</div>
                <div id="Stage_Line5_locationCharacter14_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter15">
                <div id="Stage_Line5_locationCharacter15_topFlap"></div>
                <div id="Stage_Line5_locationCharacter15_Character">J</div>
                <div id="Stage_Line5_locationCharacter15_divider"></div>
            </div>
            <div id="Stage_Line5_locationCharacter16">
                <div id="Stage_Line5_locationCharacter16_topFlap"></div>
                <div id="Stage_Line5_locationCharacter16_Character">J</div>
                <div id="Stage_Line5_locationCharacter16_divider"></div>
            </div>
            <div id="Stage_Line5_topFlap"></div>
            <div id="Stage_Line5_Character">NAME</div>
            <div id="Stage_Line5_divider"></div>
        </div>
        <div id="Stage_Line6" class="edgeLoad-EDGE-3123259">
            <div id="Stage_Line6_locationCharacter1">
                <div id="Stage_Line6_locationCharacter1_topFlap"></div>
                <div id="Stage_Line6_locationCharacter1_Character">J</div>
                <div id="Stage_Line6_locationCharacter1_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter2">
                <div id="Stage_Line6_locationCharacter2_topFlap"></div>
                <div id="Stage_Line6_locationCharacter2_Character">J</div>
                <div id="Stage_Line6_locationCharacter2_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter3">
                <div id="Stage_Line6_locationCharacter3_topFlap"></div>
                <div id="Stage_Line6_locationCharacter3_Character">J</div>
                <div id="Stage_Line6_locationCharacter3_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter4">
                <div id="Stage_Line6_locationCharacter4_topFlap"></div>
                <div id="Stage_Line6_locationCharacter4_Character">J</div>
                <div id="Stage_Line6_locationCharacter4_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter5">
                <div id="Stage_Line6_locationCharacter5_topFlap"></div>
                <div id="Stage_Line6_locationCharacter5_Character">J</div>
                <div id="Stage_Line6_locationCharacter5_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter6">
                <div id="Stage_Line6_locationCharacter6_topFlap"></div>
                <div id="Stage_Line6_locationCharacter6_Character">J</div>
                <div id="Stage_Line6_locationCharacter6_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter7">
                <div id="Stage_Line6_locationCharacter7_topFlap"></div>
                <div id="Stage_Line6_locationCharacter7_Character">J</div>
                <div id="Stage_Line6_locationCharacter7_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter8">
                <div id="Stage_Line6_locationCharacter8_topFlap"></div>
                <div id="Stage_Line6_locationCharacter8_Character">J</div>
                <div id="Stage_Line6_locationCharacter8_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter9">
                <div id="Stage_Line6_locationCharacter9_topFlap"></div>
                <div id="Stage_Line6_locationCharacter9_Character">J</div>
                <div id="Stage_Line6_locationCharacter9_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter10">
                <div id="Stage_Line6_locationCharacter10_topFlap"></div>
                <div id="Stage_Line6_locationCharacter10_Character">J</div>
                <div id="Stage_Line6_locationCharacter10_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter11">
                <div id="Stage_Line6_locationCharacter11_topFlap"></div>
                <div id="Stage_Line6_locationCharacter11_Character">J</div>
                <div id="Stage_Line6_locationCharacter11_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter12">
                <div id="Stage_Line6_locationCharacter12_topFlap"></div>
                <div id="Stage_Line6_locationCharacter12_Character">J</div>
                <div id="Stage_Line6_locationCharacter12_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter13">
                <div id="Stage_Line6_locationCharacter13_topFlap"></div>
                <div id="Stage_Line6_locationCharacter13_Character">J</div>
                <div id="Stage_Line6_locationCharacter13_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter14">
                <div id="Stage_Line6_locationCharacter14_topFlap"></div>
                <div id="Stage_Line6_locationCharacter14_Character">J</div>
                <div id="Stage_Line6_locationCharacter14_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter15">
                <div id="Stage_Line6_locationCharacter15_topFlap"></div>
                <div id="Stage_Line6_locationCharacter15_Character">J</div>
                <div id="Stage_Line6_locationCharacter15_divider"></div>
            </div>
            <div id="Stage_Line6_locationCharacter16">
                <div id="Stage_Line6_locationCharacter16_topFlap"></div>
                <div id="Stage_Line6_locationCharacter16_Character">J</div>
                <div id="Stage_Line6_locationCharacter16_divider"></div>
            </div>
            <div id="Stage_Line6_topFlap"></div>
            <div id="Stage_Line6_Character">NAME</div>
            <div id="Stage_Line6_divider"></div>
        </div>
        <div id="Stage_labelName" class="edgeLoad-EDGE-3123259">NAME</div>
        <div id="Stage_loadingAnimation" class="edgeLoad-EDGE-3123259">
            <div id="Stage_loadingAnimation_labelNameCopy">ACTIVATING TALISNET<br>LOCATING DAVE<br>DEPLOYING DRONES<br>STALKING EMPLOYEES<br>FINDING SALES AGENTS<br>ACTIVATING TALISNET</div>
            <div id="Stage_loadingAnimation_Rectangle"></div>
        </div>
        <div id="Stage_blueDotAnimation" class="edgeLoad-EDGE-3123259">
            <div id="Stage_blueDotAnimation_blueDot">
                <div id="Stage_blueDotAnimation_blueDot_Ellipse"></div>
            </div>
            <div id="Stage_blueDotAnimation_blueDotCopy">
                <div id="Stage_blueDotAnimation_blueDotCopy_Ellipse"></div>
            </div>
        </div>
        <div id="Stage_blueDotAnimationCopy" class="edgeLoad-EDGE-3123259">
            <div id="Stage_blueDotAnimationCopy_blueDot">
                <div id="Stage_blueDotAnimationCopy_blueDot_Ellipse"></div>
            </div>
            <div id="Stage_blueDotAnimationCopy_blueDotCopy">
                <div id="Stage_blueDotAnimationCopy_blueDotCopy_Ellipse"></div>
            </div>
        </div>
        <div id="Stage_blueDotAnimationCopy3" class="edgeLoad-EDGE-3123259">
            <div id="Stage_blueDotAnimationCopy3_blueDot">
                <div id="Stage_blueDotAnimationCopy3_blueDot_Ellipse"></div>
            </div>
            <div id="Stage_blueDotAnimationCopy3_blueDotCopy">
                <div id="Stage_blueDotAnimationCopy3_blueDotCopy_Ellipse"></div>
            </div>
        </div>
        <div id="Stage_blueDotAnimationCopy7" class="edgeLoad-EDGE-3123259">
            <div id="Stage_blueDotAnimationCopy7_blueDot">
                <div id="Stage_blueDotAnimationCopy7_blueDot_Ellipse"></div>
            </div>
            <div id="Stage_blueDotAnimationCopy7_blueDotCopy">
                <div id="Stage_blueDotAnimationCopy7_blueDotCopy_Ellipse"></div>
            </div>
        </div>
        <div id="Stage_blueDotAnimationCopy8" class="edgeLoad-EDGE-3123259">
            <div id="Stage_blueDotAnimationCopy8_blueDot">
                <div id="Stage_blueDotAnimationCopy8_blueDot_Ellipse"></div>
            </div>
            <div id="Stage_blueDotAnimationCopy8_blueDotCopy">
                <div id="Stage_blueDotAnimationCopy8_blueDotCopy_Ellipse"></div>
            </div>
        </div>
        <div id="Stage_blueDotAnimationCopy4" class="edgeLoad-EDGE-3123259">
            <div id="Stage_blueDotAnimationCopy4_blueDot">
                <div id="Stage_blueDotAnimationCopy4_blueDot_Ellipse"></div>
            </div>
            <div id="Stage_blueDotAnimationCopy4_blueDotCopy">
                <div id="Stage_blueDotAnimationCopy4_blueDotCopy_Ellipse"></div>
            </div>
        </div>
        <div id="Stage_CharaterCopy3" class="edgeLoad-EDGE-3123259">LOCATION</div>
        <div id="Stage_beam" class="edgeLoad-EDGE-3123259">
            <div id="Stage_beam_Rectangle7"></div>
        </div>
        <div id="Stage_beamCopy" class="edgeLoad-EDGE-3123259">
            <div id="Stage_beamCopy_Rectangle7"></div>
        </div>
        <div id="Stage_Rectangle8" class="edgeLoad-EDGE-3123259"></div>
        <div id="Stage_Rectangle8Copy" class="edgeLoad-EDGE-3123259"></div>
        <div id="Stage_Rectangle8Copy2" class="edgeLoad-EDGE-3123259"></div>
        <div id="Stage_Rectangle8Copy3" class="edgeLoad-EDGE-3123259"></div>
        <div id="Stage_Rectangle8Copy4" class="edgeLoad-EDGE-3123259"></div>
        <div id="Stage_Rectangle8Copy5" class="edgeLoad-EDGE-3123259"></div>
    </div>
    <script src="assets/js/jquery-2.0.3.js"></script>
    <script>
		// perform all actions on completion of Adobe composition
		AdobeEdge.bootstrapCallback(function(compId) {
    		AdobeEdge.Symbol.bindElementAction(compId, 'stage', 'document', 'compositionReady', function(sym, e){

			var letters = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ ";
	    	var status = <?php echo json_encode($statusArray) ?>;

	    	function flipToNameFunction(id, nameFrom, nameTo) {
	    		var index = 0;

	    		var startPos = nameFrom;
	    		var endPos = nameTo;

		        if (startPos == endPos) {
					var charName = sym.$(id);
					charName.text(status[startPos].name.toUpperCase());
		        } else {
			        var intObject = setInterval(function() {
						var charName = sym.$(id);

						charName.text(status[startPos].name.toUpperCase());

						startPos++;

						if(startPos == endPos){
							charName.text(status[startPos].name.toUpperCase());
						    clearInterval(intObject);
						}
					}, 50);
			    }
	    	}

			function flipToLetterFunction(id, letterFrom, letterTo){
		        var index = 0;

		        var startPos = letters.indexOf(letterFrom);
		        var endPos = letters.indexOf(letterTo);

		        if (startPos == endPos) {
					var charName = sym.$(id);
					charName.text(letters[startPos]);
		        } else {
			        var intObject = setInterval(function() {
						var charName = sym.$(id);

						charName.text(letters[startPos]);

						startPos++;

						if(startPos == endPos){
							charName.text(letters[startPos]);
						    clearInterval(intObject);
						}
					}, 50);
			    }
			}

        	for (var row=0; row < status.length; row++) {
				var name = status[row].name.toUpperCase();
				var location = status[row].location.toUpperCase();

				console.log(name + ' - ' + location);

        		// var rowName = sym.$("Stage_Line" + row + "_Character");

        		flipToNameFunction("Stage_Line" + row + "_Character", 0, row);
        		// rowName.text(name);

        		for (var character=0; character < 16; character++) {
        			var charName = sym.$("Stage_Line" + row + "_locationCharacter" + (character + 1) + "_Character");
        			var flipToLetter = "";

        			if (character < location.length) {
	        			flipToLetter = location[character];
        			} else {
	        			flipToLetter = " ";        				        				
        			}

        			flipToLetterFunction("Stage_Line" + row + "_locationCharacter" + (character + 1) + "_Character", "A", flipToLetter);
        		}
        	}

    	});
	});
    </script>
</body>
</html>
