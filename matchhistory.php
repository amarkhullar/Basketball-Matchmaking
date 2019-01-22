<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	header("Location: index.php");
}

?>

<html>

<head>
	<title>Match History</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

<div class="col-md-4">
</div>
	<center>
	<div class="col-md-4 registerform">
		<h1>Match History</h1>
		<h3><div class="row">

		<?php

		$teamid = $user->data()->teamid;

		$sql = "SELECT * FROM matches WHERE winner IS NOT NULL AND (team1 = {$teamid} OR team2 = {$teamid})";

		$matches = DB::getInstance()->query($sql);

		if($matches->count() == 0) {
			echo "You have not played any matches";
		}

		foreach($matches->results() as $match) {

			if($match->winner == $teamid) {
				$color = '<font color="green">';
			}else {
				$color = '<font color="red">';
			}

			$weekyear = $match->weekyear;
			$len = strlen((string)$weekyear);
			
			if($len > 3) {
				$week = substr($weekyear, 0, 2);
				$year = substr($weekyear, 2, 2);
			}else {
				$week = substr($weekyear, 0 , 1);
				$year = substr($weekyear, 1, 2);
			}

			$year = "20" . $year;
			
			$team1 = $match->team1;
			$team2 = $match->team2;

			$team1namesql = "SELECT name FROM teams WHERE id = {$team1}";
			$team2namesql = "SELECT name FROM teams WHERE id = {$team2}";

			$team1name = DB::getInstance()->query($team1namesql);
			$team2name = DB::getInstance()->query($team2namesql);

			$team1name = $team1name->first()->name;
			$team2name = $team2name->first()->name;

			$locationid = $match->locationid;
			$locationsql = "SELECT name FROM locations WHERE id = {$locationid}";
			$locationname = DB::getInstance()->query($locationsql);
			$locationname = $locationname->first()->name;

			echo $color . "Week: " . $week . " " . $year . " " . $team1name . " VS " . $team2name . " @ " . $locationname . '<br>';

		}

		?>

		</div>
		<br>
		<div class="row">
			<a href="index.php">Home</a>
		</div>

		</h3>
	</center>
	</div>
</body>

</html>