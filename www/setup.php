<?php
require_once dirname(__FILE__) . '/../GoogleClientApi/src/Google_Client.php';
require_once dirname(__FILE__) . '/../GoogleClientApi/src/contrib/Google_CalendarService.php';
require_once dirname(__FILE__) . '/../config/development.php';
require_once dirname(__FILE__) . '/../classes/configclass.php';

session_start();

$scriptUri = "http://".$_SERVER["HTTP_HOST"].'/www/setup';

$client = new Google_Client();
$client->setApplicationName("WhosIn");

$client->setClientId(GOOGLE_CLIENT_ID);
$client->setClientSecret(GOOGLE_CLIENT_SECRET);
$client->setDeveloperKey(GOOGLE_API_KEY); // API key

$client->setRedirectUri($scriptUri);
$client->setUseObjects(true);

$cal = new Google_CalendarService($client);

$message = '';
$button = '';

if (isset($_GET['logout'])) {
    unset($_SESSION['token']);
}

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['token'] = $client->getAccessToken();
    header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
}

if (isset($_SESSION['token'])) {
    $client->setAccessToken($_SESSION['token']);
}

if ($client->getAccessToken()) {
	$message = 'oAuth token created';
	$button = '';
    $_SESSION['token'] = $client->getAccessToken();

    // write the token to mongo
    $config = new Config();
    $config->setAuthToken($_SESSION['token']);
    $config->save();
} else {
    $authUrl = $client->createAuthUrl();
    $message = 'Connect an account to Google in order to authorise Calendar requests for all staff.';
    $button = '<a class="btn btn-primary" href="'.$authUrl.'">Connect Account</a>';
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>WhosIn</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/whosin.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">WhosIn</a>
        </div>
      </div>
    </div>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      	<div class="container">
	        <h1>Configure Main Google Account</h1>
	        <p><?php echo $message ?></p>
	        <p><?php echo $button ?></p>
		</div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery-2.0.3.js"></script>
    <script src="assets/js/bootstrap.file-input.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>