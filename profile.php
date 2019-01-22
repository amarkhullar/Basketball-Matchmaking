<?php

require_once 'core/init.php';

if(!$username = Input::get('user')) {
	Redirect::to('index.php');
} else {
	$user = new User($username);
	if(!$user->exists()) {
		Redirect::to(404);
	} else {
		$data = $user->data();
	}
}

$user = new User();
$data = $user->data();

?>

<html>

<head>
	<title><?php echo $data->name ?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

<div class="col-md-4">
</div>
	<div class="col-md-4 registerform">
		<h1><center>Profile</h1></center>
		<h3><center>
		<div class="row">
			Username: <?php echo escape($data->username); ?>
		</div><br>
		<div class="row">
			Full Name: <?php echo escape($data->name); ?>
		</div><br>
		<div class="row">
			Role: 
			<?php
			if($data->role == "pg") {
				echo "Point Guard";
			} elseif($data->role == "sg") {
				echo "Shooting Guard";
			} elseif($data->role == "sf") {
				echo "Small Forward";
			} elseif($data->role == "pf") {
				echo "Power Forward";
			} elseif($data->role == "c") {
				echo "Centre";
			}
			?>
		</div><br>
		<div class="row">
			Skill Level: <?php echo escape($data->skill); ?>
		</div><br>
		<div class="row">
			<?php
			$usersteamid = $data->teamid;
			if(!$usersteamid == 0) {
				$sql = "SELECT name FROM teams WHERE id = {$usersteamid}";
				$teamname = DB::getInstance()->query($sql);
				echo "Team: " . $teamname->first()->name;
				?><br><br><?php
			}
			?>
		</div>
		<div class="row">
			Date Joined: <?php echo escape($data->joined); ?>
		</div><br>
		<div class="row">
			<a href="changepassword.php">Change Password?</a>
		</div>
		<br>
		<div class="row">
			<a href="index.php">Home</a>
		</div>
	</div>
	</div>
	</center>
</body>
</html>