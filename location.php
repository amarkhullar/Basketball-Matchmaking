<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	header("Location: login.php");
}

$locationid = Input::get('location');

$sql = "SELECT * FROM locations WHERE id = {$locationid}";
$locationdata = DB::getInstance()->query($sql);
//displays data about a location
?>

<html>

<head>
	<title><?php echo $locationdata->first()->name; ?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

  <div class="row">
    <div class="col-md-12">
      <h1><center><?php echo $locationdata->first()->name; ?></h1></center>
    </div>
  </div>
    
  <div class="col-md-4">
  </div>
  <div class="col-md-4 loginform">
    
    <center><h3>

      <div class="row">
        <?php echo $locationdata->first()->address; ?>
      </div>
      <br>

      <img src="css/<?php echo escape($locationdata->first()->id); ?>.jpg" style="width:304px;height:228px;">
      
      <br><br>
      <div class="row">
        <a href="index.php">Home</a>
      </div>

