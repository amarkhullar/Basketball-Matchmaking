<?php

require_once 'core/init.php';
// instantiates the core class

$style = "css/style.css";
$bootstrap = "css/bootstrap.css";
$icon = "css/Martin-Berube-Sport-Basketball.ico";

if(Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User(); // current user

$teamid = $user->data()->teamid;

$now = new DateTime('now');
$day = $now->format('d');
$month = $now->format('m');
$year = $now->format('y');

$weekno = date('W');

$weekyear = $weekno . $year;

if($user->isLoggedIn()) {
?>


<html>

<head>
	<title>Welcome</title>
	<link rel="stylesheet" type="text/css" href=<?php echo $bootstrap; ?>>
	<link rel="stylesheet" type="text/css" href=<?php echo $style; ?>>
	<link rel="shortcut icon" href=<?php echo $icon; ?>>
</head>

<body background="css/basketball.jpg">

	<div class="row">
		<div class="col-md-12">
			<h1><center>Welcome <a href="profile.php?user=<?php echo escape($user->data()->username); ?>"><?php echo escape($user->data()->name); ?></a></h1></center>
			<a href="logout.php"><h4><div class="indexlogoutheader">Log Out</h4></a></div>
		</div>
	</div>
		
	<div class="col-md-4">
	</div>
	<div class="col-md-4 loginform">
		
		<center>

			<?php

			if($teamid == 0) {

			?>

			<div class="row">
			<a href="findteam.php"><h1>Team Finder</a></h1>
			</div>

			<?php

			}

			?>

			<div class="row">
				<a href="scoreboard.php"><h1>Scoreboard</a></h1>
			</div>

			<div class="row">
				<a href="matchtimetable.php"><h1>Match Timetable</h1></a>
			</div>

			<?php
			if ($teamid > 0) {

				$sql = "SELECT name FROM teams WHERE id = {$teamid}";
				$teamname = DB::getInstance()->query($sql);
				$teamname = $teamname->first()->name;

			?>
			<div class="row">
				<a href="matchorganiser.php"><h1>Match Organiser</h1></a>
			</div>



			<div class="row">
				<h1><a href="matchhistory.php">Match History</a></h1>
			</div>

			<div class="row">
				<h1><a href="team.php?team=<?php echo escape($teamname); ?>">Your Team</a></h1>
			</div>

			<div class="row"><h3>
				<?php
				}
				$sql = "SELECT * FROM matches WHERE weekyear = {$weekyear} AND (team1 = {$teamid} OR team2 = {$teamid})";

				$teammatchthisweek = DB::getInstance()->query($sql);

				if($teammatchthisweek->count() > 0) {

					$team1id = $teammatchthisweek->first()->team1;
					$team2id = $teammatchthisweek->first()->team2;
					$matchdate = $teammatchthisweek->first()->weekyear;
					$matchlocationid = $teammatchthisweek->first()->locationid;

					$sql = "SELECT name FROM teams WHERE id = {$team1id} OR id = {$team2id}";
					$teamnames = DB::getInstance()->query($sql);
					if($teamnames->count() > 1) {
						$team1name = $teamnames->results()[0]->name;
						$team2name = $teamnames->results()[1]->name;
					}
					$locationsql = "SELECT name, address FROM locations WHERE id = {$matchlocationid}";
					$locations = DB::getInstance()->query($locationsql);
					$locationname = $locations->first()->name;
					$locationaddress = $locations->first()->address;
					echo "Match this week:" . '<br>';
					echo $team1name . ' VS ' . $team2name . '<br>';
					echo $locationname . '<br>';
					echo $locationaddress . '<br>';

					echo "Sunday @1 PM";
				}

				?>

			</div></h3>

		</center>
		
	</div>

</body>

</html>

<?php
} else {
	header("Location: login.php");
}
?>