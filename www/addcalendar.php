<?php
require_once dirname(__FILE__) . '/../GoogleClientApi/src/Google_Client.php';
require_once dirname(__FILE__) . '/../GoogleClientApi/src/contrib/Google_CalendarService.php';
require_once dirname(__FILE__) . '/../config/development.php';
require_once dirname(__FILE__) . '/../classes/calendarsclass.php';

session_start();

if (is_array($_POST)) {
	// create calendars object and save the details for the connecting user
	$calendars = new Calendars();

	$calendars->setEmail($_POST["inputEmail"]);
	$calendars->setFirstName($_POST["inputFirstName"]);
	$calendars->setLastName($_POST["inputLastName"]);
	$calendars->save();

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
	        <h1>Hello, there!</h1>
	        <p>Connect your calendar to WhosIn so we know when you're in or out of the office.</p>
			<form class="form-horizontal" role="form" method="post" action="/www/addcalendar.php">
			  <div class="form-group">
			    <label for="inputEmail1" class="col-lg-2 control-label">Email</label>
			    <div class="col-lg-4">
			      <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="inputFirstName" class="col-lg-2 control-label">First name</label>
			    <div class="col-lg-4">
			      <input type="input" class="form-control" id="inputFirstName" name="inputFirstName" placeholder="First name">
			    </div>
			  </div>
			  <div class="form-group">
			    <label for="inputLastName" class="col-lg-2 control-label">Last name</label>
			    <div class="col-lg-4">
			      <input type="input" class="form-control" id="inputLastName" name="inputLastName" placeholder="Last name">
			    </div>
			  </div>
			  <div class="form-group">
			    <div class="col-lg-offset-2 col-lg-10">
			      <button type="submit" class="btn btn-primary">Connect</button>
			    </div>
			  </div>
			</form>      
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