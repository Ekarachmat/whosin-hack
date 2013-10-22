<?php
require_once dirname(__FILE__) . '/../GoogleClientApi/src/Google_Client.php';
require_once dirname(__FILE__) . '/../GoogleClientApi/src/contrib/Google_CalendarService.php';

$scriptUri = "http://www.whosin.com/oauth2callback";

$client = new Google_Client();
$client->setApplicationName("WhosIn");

$client->setClientId('31669776438-cb41m01m3e4rsdn4usgoqliok1rcms8c.apps.googleusercontent.com');
$client->setClientSecret('LAvINhUBtrbqKTvKg5kvFEc4');
$client->setDeveloperKey(AIzaSyArat8OjTNb1VzhhpQnXPxJzctiyICwJV4); // API key

$client->setRedirectUri($scriptUri);
$client->setUseObjects(true);

if (isset($_GET['logout'])) {
    unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}
?>