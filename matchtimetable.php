<?php

require_once 'core/init.php';

$user = new User();

$teamid = $user->data()->teamid;

$now = new DateTime('now');
$day = $now->format('d');
$month = $now->format('m');
$year = $now->format('y');

$weekno = date('W');

$weekyear = $weekno . $year;
// getting all the relevant times and dates of today, that will be used

?>

<html>

<head>
	<title>Match Timetable</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

  <div class="row">
    <div class="col-md-12">
      <h1><center>Matches: Week <?php echo $weekno; ?></h1></center>
    </div>
  </div>
    
  <div class="col-md-4">
  </div>
  <div class="col-md-4 loginform">
    
    <center><h3>

      <div class="row">

      <?php

      $sql = "SELECT * FROM matches WHERE weekyear = {$weekyear}";

      $matches = DB::getInstance()->query($sql);

      // getting all matches for this week
      if($matches->count() > 0) {

        foreach($matches->results() as $match) {

          $matchid = $match->id;

          $matchwinner = $match->winner;

          $cancel = '';
          $winner = '';

          $finished = '';

          $team1id = $match->team1;
          $team2id = $match->team2;

          $team1sql = "SELECT name FROM teams WHERE id = {$team1id}";
          $team1 = DB::getInstance()->query($team1sql);
          $team1name = $team1->first()->name;

          $team2sql = "SELECT name FROM teams WHERE id = {$team2id}";
          $team2  = DB::getInstance()->query($team2sql);
          $team2name = $team2->first()->name;

          if(!$matchwinner > 0) {

            if($team1id == $teamid) {
              $cancel = '<a href="cancel.php?match=' . $matchid . '">Cancel</a>';
              $winner = '<a href="winner.php?match=' . $matchid . '">Winner</a>';
            }elseif($team2id == $teamid) {
              $cancel = '<a href="cancel.php?match=' . $matchid . '">Cancel</a>';
              $winner = '<a href="winner.php?match=' . $matchid . '">Winner</a>';
            }

          }else {
            $finished = '(Finished)';
          }

          $locationid = $match->locationid;

          $sql = "SELECT name FROM locations WHERE id = {$locationid}";
          $location = DB::getInstance()->query($sql);
          $locationname = $location->first()->name;

          echo $team1name . " VS " . $team2name . " @ " . '<a href="location.php?location=' . $locationid . '">' . $locationname . '</a>' . " " . $cancel . " " . $winner . $finished . '<br>';
        }

      }

?>

    </div>
<br>
    <div class="row">
      <a href="index.php">Home</a>
    </div>
        