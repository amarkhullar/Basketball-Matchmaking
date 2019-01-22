<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	header("Location: login.php");
}

$teamid = $user->data()->teamid;

$getteamname = Input::get('team');


$teamdata = new GetTeamData($teamid);

$teamidfromget = $teamdata->ID();

if(!($teamid == $teamidfromget)) {
	header("Location: index.php");
} elseif($teamdata->ID() == 0) {
	header("Location: index.php");
}

?>

<html>

<head>
	<title><?php echo $getteamname; ?></title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

<div class="col-md-4">
</div>

	<div class="col-md-4 registerform">

		<h1><center><?php echo $getteamname; ?></h1></center>
		<h3><center>

		<div class="row">
			Score: <?php echo TeamInfo::FindScore($teamid); ?>
		</div><br>

		<?php

		if(null !==($teamdata->PG())) {
			$pg_id = $teamdata->PG();
			if($pg_id > 0) {
				$pgsql = "SELECT name, email FROM users WHERE id = '".$pg_id."'";
				$pg = DB::getInstance()->query($pgsql);
			?>
			<div class="row">
				Point Guard Name: <?php echo ($pg->first()->name); ?>
			</div>
			<div class="row">
				Point Guard Email: <?php echo ($pg->first()->email); ?>
			</div><br>
		
		<?php

			}
		}


		if(null !==($teamdata->SG())) { 
			$sg_id = $teamdata->SG();
			if($sg_id > 0) {
				$sgsql = "SELECT name, email FROM users WHERE id = '".$sg_id."'";
				$sg = DB::getInstance()->query($sgsql);

			?>
			<div class="row">
				Shooting Guard Name: <?php echo ($sg->first()->name); ?>
			</div>
			<div class="row">
				Shooting Guard Email: <?php echo escape($sg->first()->email); ?>
			</div><br>

		<?php
			}
		}


		if(null !==($teamdata->SF())) { 
			$sf_id = $teamdata->SF();
			if($sf_id > 0) {
				$sfsql = "SELECT name, email FROM users WHERE id = '".$sf_id."'";
				$sf = DB::getInstance()->query($sfsql);
		?>

			<div class="row">
				Small Forward Name: <?php echo ($sf->first()->name); ?>
			</div>
			<div class="row">
				Small Forward Email: <?php echo escape($sf->first()->email); ?>
			</div><br>

		<?php
			}
		}

		if(null !==($teamdata->PF())) { 
			$pf_id = $teamdata->PF();
			if($pf_id > 0) {
				$pfsql = "SELECT name, email FROM users WHERE id = '".$pf_id."'";
				$pf = DB::getInstance()->query($pfsql);
		?>

			<div class="row">
				Power Forward Name: <?php echo ($pf->first()->name); ?>
			</div>
			<div class="row">
				Power Forward Email: <?php echo escape($pf->first()->email); ?>
			</div><br>

		<?php
			}
		}

		if(null !==($teamdata->C())) { 
			$c_id = $teamdata->C();
			if($c_id > 0) {
				$csql = "SELECT name, email FROM users WHERE id = '".$c_id."'";
				$c = DB::getInstance()->query($csql);
		?>

			<div class="row">
				Centre Name: <?php echo ($c->first()->name); ?>
			</div>
			<div class="row">
				Centre Email: <?php echo escape($c->first()->email); ?>
			</div><br>
			
		<?php
			}
		}
		?>

		<div class="row">
			<a href="index.php">Home</a>
		</div>

	</div>
	</div>
	</center>
</body>
</html>