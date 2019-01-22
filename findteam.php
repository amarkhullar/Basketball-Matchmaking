<?php

require_once 'core/init.php';
// instantiates the core class

if(Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User(); // current user

if(!$user->isLoggedIn()) {
	header("Location: index.php");
}

?>

<html>

<head>
	<title>Find Team</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

<div class="col-md-4">
</div>
	<div class="col-md-4 registerform">
		<h1><center>Find Team</h1></center>
		<div class="row"><h3><center>


<?php

if($user->data()->teamid == 0) {

	$role = $user->data()->role;
 	$role = $role."_id";
 	$id = $user->data()->id;

 	$count = 0;
 	$avg = 0;

	$skill1 = $user->data()->skill - 1;
	$skill2 = $user->data()->skill + 1;
	$skill3 = $user->data()->skill - 2;
	$skill4 = $user->data()->skill + 2;
	$skill5 = $user->data()->skill - 3;
	$skill6 = $user->data()->skill + 3;

	$sql = "SELECT id FROM teams WHERE {$role} = 0";

	$availableteams1 = DB::getInstance()->query($sql);

	if($availableteams1->count() > 0) {

		$teamcount = $availableteams1->count();

		foreach($availableteams1->results() as $avail) {

			$currentteamid = $avail->id;

			$avg = TeamInfo::FindAvgSkill($currentteamid);

			if($avg >= $skill1 and $avg <= $skill2) {
				$first = $currentteamid;
			}elseif($avg >= $skill3 and $avg <= $skill4) {
				$second = $currentteamid;
			}elseif($avg >= $skill5 and $avg <= $skill6) {
				$third = $currentteamid;
			}
		}

		if(isset($first)) {
			
			$update1 = "UPDATE users SET teamid = {$first} WHERE id = {$id}";
			$update2 = "UPDATE teams SET {$role} = {$id} WHERE id = {$first}";
			DB::getInstance()->query($update1);
			DB::getInstance()->query($update2);
			echo 'You have been placed in a team';

		}elseif(isset($second)) {

			$update1 = "UPDATE users SET teamid = {$second} WHERE id = {$id}";
			$update2 = "UPDATE teams SET {$role} = {$id} WHERE id = {$second}";
			DB::getInstance()->query($update1);
			DB::getInstance()->query($update2);
			echo 'You have been placed in a team';

		}elseif(isset($third)) {

			$update1 = "UPDATE users SET teamid = {$third} WHERE id = {$id}";
			$update2 = "UPDATE teams SET {$role} = {$id} WHERE id = {$third}";
			DB::getInstance()->query($update1);
			DB::getInstance()->query($update2);
			echo 'You have been placed in a team';

		}

		if(!isset($first)) {
			if(!isset($second)) {
				if(!isset($third)) {
					header("Location: createteam.php");
				}
			}
		}

	} else {
		header("Location: createteam.php");
	}
}else {
	echo "You are already in a team";
}
//If a user is not already in a team, he is placed in a team of similar skill level to himself. If there are no teams available he can create his own
?>
		
		<br><br>
		<div class="row">
			<div class="form-group">
				<a href="index.php">Home</a>
			</div>
		</div>
	</center>
	</h3>
	</div>

</h1>
</div>
</body>
</html>