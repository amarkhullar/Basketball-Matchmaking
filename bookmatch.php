<?php

require_once 'core/init.php';

$user = new User();

$now = new DateTime('now');
$day = $now->format('d');
$month = $now->format('m');
$year = $now->format('y');

$weekno = date('W');

$weekyear = $weekno . $year;

if(!$user->isLoggedIn()) {
	header("Location: index.php");
}

$teamid = $user->data()->teamid;

if($teamid == 0){
	echo "You are not in a team, you cannot book a match";
}else {

	$sql = "SELECT * FROM teams WHERE id = {$teamid}";
	$userteam = DB::getInstance()->query($sql);

	$userteamname = $userteam->first()->name;

	$pg_id = $userteam->first()->pg_id;
	$sf_id = $userteam->first()->sf_id;
	$pf_id = $userteam->first()->pf_id;
	$sg_id = $userteam->first()->sg_id;
	$c_id = $userteam->first()->c_id;

	$teamplayers = 0;
	$teamplayers = TeamInfo::FindNumPlayers($pg_id, $sf_id, $pf_id, $sg_id, $c_id);

	$teamprefloc = $userteam->first()->preflocid;

	$avg = TeamInfo::FindAvgSkill($teamid);

	$skill1 = $avg - 1;
	$skill2 = $avg + 1;
	$skill3 = $avg - 2;
	$skill4 = $avg + 2;
	$skill5 = $avg - 3;
	$skill6 = $avg + 3;

	$sql = "SELECT * FROM teams WHERE id <> {$teamid}";

	$teams = DB::getInstance()->query($sql);

	foreach($teams->results() as $team) {

		$currentteamid = $team->id;
		$currentteamprefloc = $team->preflocid;

		$currentpg_id = $team->pg_id;
		$currentsf_id = $team->sf_id;
		$currentpf_id = $team->pf_id;
		$currentsg_id = $team->sg_id;
		$currentc_id = $team->c_id;

		$teamsavg = TeamInfo::FindAvgSkill($currentteamid);

		$sql = "SELECT * FROM matches WHERE weekyear = {$weekyear}";
		$alreadymatch = DB::getInstance()->query($sql);

		$alreadymatchthisweek = False;

		foreach($alreadymatch->results() as $match) {

          $team1id = $match->team1;
          $team2id = $match->team2;

          if($team1id == $teamid) {
          	$alreadymatchthisweek = True;
          }elseif($team2id == $teamid) {
          	$alreadymatchthisweek = True;
          }

        }

		$numplayers = 0;
		$numplayers = TeamInfo::FindNumPlayers($currentpg_id, $currentsf_id, $currentpf_id, $currentsg_id, $currentc_id);
		
		if($avg >= $skill1 AND $avg <= $skill2 AND $currentteamprefloc == $teamprefloc AND $numplayers == $teamplayers and $alreadymatchthisweek == False) {
			$first = $currentteamid;
			$firstname = $team->name;
			$firstprefloc = $currentteamprefloc;
		}elseif($avg >= $skill3 and $avg <= $skill4 and $currentteamprefloc == $teamprefloc and $numplayers == $teamplayers and $alreadymatchthisweek == False) {
			$second = $currentteamid;
			$secondname = $team->name;
			$secondprefloc = $currentteamprefloc;
		}elseif($avg >= $skill5 and $avg <= $skill6 and $currentteamprefloc == $teamprefloc and $numplayers == $teamplayers and $alreadymatchthisweek == False) {
			$third = $currentteamid;
			$thirdname = $team->name;
			$thirdprefloc = $currentteamprefloc;
		}elseif($avg >= $skill1 and $avg <= $skill2 and $numplayers == $teamplayers and $alreadymatchthisweek == False) {
			$fourth = $currentteamid;
			$fourthname = $team->name;
			$fourthprefloc = $currentteamprefloc;
		}elseif($avg >= $skill3 and $avg <= $skill4 and $numplayers == $teamplayers and $alreadymatchthisweek == False) {
			$fifth = $currentteamid;
			$fifthname = $team->name;
			$fifthprefloc = $currentteamprefloc;
		}elseif($avg >= $skill5 and $avg <= $skill6 and $numplayers == $teamplayers and $alreadymatchthisweek == False) {
			$sixth = $currentteamid;
			$sixthname = $team->name;
			$sixthprefloc = $currentteamprefloc;
		}

	}

	?>

<html>

<head>
	<title>Book Match</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

	<div class="row">
		<div class="col-md-12">
			<h1><center>Match Booking</h1></center>
		</div>
	</div>
		
	<div class="col-md-4">
	</div>
	<div class="col-md-4 loginform">
		
		<center><h3>

			<div class="row">

			<?php

			if(isset($first)) {
				
				$bookmatchsql = "INSERT INTO matches (team1, team2, weekyear, locationid) VALUES ({$teamid}, {$first}, {$weekyear}, {$firstprefloc})";
				$locationsql = "SELECT name, address FROM locations WHERE id = {$firstprefloc}";
				DB::getInstance()->query($bookmatchsql);
				$location = DB::getInstance()->query($locationsql);
				$locationname = $location->first()->name;
				$locationaddress = $location->first()->address;

				echo 'You have planned a match with: ' . $firstname;
				echo 'Sunday, Week: ' . $weekno;
				echo 'Location: ' . $locationname;
				echo 'Address: ' . $locationaddress;

				//Email::BookMatchEmail($teamid, $first, $userteamname, $firstname, $locationname);

			}elseif(isset($second)) {

				$bookmatchsql = "INSERT INTO matches (team1, team2, weekyear, locationid) VALUES ({$teamid}, {$second}, {$weekyear}, {$secondprefloc})";
				$locationsql = "SELECT name, address FROM locations WHERE id = {$secondprefloc}";
				DB::getInstance()->query($bookmatch);
				$location = DB::getInstance()->query($locationnamesql);
				$locationname = $location->first()->name;
				$locationaddress = $location->first()->address;

				echo 'You have planned a match with: ' . $secondname;
				echo 'Sunday, Week: ' . $weekno;
				echo 'Location: ' . $locationname;
				echo 'Address: ' . $locationaddress;

				//Email::BookMatchEmail($teamid, $second, $userteamname, $secondname, $locationname);

			}elseif(isset($third)) {

				$bookmatchsql = "INSERT INTO matches (team1, team2, weekyear, locationid) VALUES ({$teamid}, {$third}, {$weekyear}, {$thirdprefloc})";
				$locationsql = "SELECT name, address FROM locations WHERE id = {$thirdprefloc}";
				DB::getInstance()->query($bookmatch);
				$location = DB::getInstance()->query($locationnamesql);
				$locationname = $location->first()->name;
				$locationaddress = $location->first()->address;

				echo 'You have planned a match with: ' . $thirdname;
				echo 'Sunday, Week: ' . $weekno;
				echo 'Location: ' . $locationname;
				echo 'Address: ' . $locationaddress;

				//Email::BookMatchEmail($teamid, $third, $userteamname, $thirdname, $locationname);

			}elseif(isset($fourth)) {

				$bookmatchsql = "INSERT INTO matches (team1, team2, weekyear, locationid) VALUES ({$teamid}, {$fourth}, {$weekyear}, {$fourthprefloc})";
				$locationsql = "SELECT name, address FROM locations WHERE id = {$fourthprefloc}";
				DB::getInstance()->query($bookmatchsql);
				$location = DB::getInstance()->query($locationsql);
				$locationname = $location->first()->name;
				$locationaddress = $location->first()->address;

				echo 'You have planned a match with: ' . $fourthname;
				echo 'Sunday, Week: ' . $weekno;
				echo 'Location: ' . $locationname;
				echo 'Address: ' . $locationaddress;

				//Email::BookMatchEmail($teamid, $fourth, $userteamname, $fourthname, $locationname);

			}elseif(isset($fifth)) {

				$bookmatchsql = "INSERT INTO matches (team1, team2, weekyear, locationid) VALUES ({$teamid}, {$fifth}, {$weekyear}, {$fifthprefloc})";
				$locationsql = "SELECT name, address FROM locations WHERE id = {$fifthprefloc}";
				DB::getInstance()->query($bookmatch);
				$location = DB::getInstance()->query($locationnamesql);
				$locationname = $location->first()->name;
				$locationaddress = $location->first()->address;

				echo 'You have planned a match with: ' . $fifthname;
				echo 'Sunday, Week: ' . $weekno;
				echo 'Location: ' . $locationname;
				echo 'Address: ' . $locationaddress;

				//Email::BookMatchEmail($teamid, $fifth, $userteamname, $fifthname, $locationname);

			}elseif(isset($sixth)) {

				$bookmatchsql = "INSERT INTO matches (team1, team2, weekyear, locationid) VALUES ({$teamid}, {$sixth}, {$weekyear}, {$sixthprefloc})";
				$locationsql = "SELECT name, address FROM locations WHERE id = {$sixthprefloc}";
				DB::getInstance()->query($bookmatch);
				$location = DB::getInstance()->query($locationnamesql);
				$locationname = $location->first()->name;
				$locationaddress = $location->first()->address;

				echo 'You have planned a match with: ' . $sixthname;
				echo 'Sunday, Week: ' . $weekno;
				echo 'Location: ' . $locationname;
				echo 'Address: ' . $locationaddress;

				//Email::BookMatchEmail($teamid, $sixth, $userteamname, $sixthname, $locationname);

			}else {

				if(!$alreadymatchthisweek == false) {
					echo "You already have a match booked this week";
				}else {
					echo 'No matches available';
				}


			}
			}
			// if the user is not already in a team, and if the user hasnt already got a match booked this week, he can book a match. This finds all teams in a similar skill range, and picks the closest skill gap as possible for the match. It also chooses a team with the same preferred location as the user's team
			?>

			</div><br>

			<div class="row">
				<a href="index.php">Home</a>
			</div>

		</h3></center>

	</div>

</body>

</html>