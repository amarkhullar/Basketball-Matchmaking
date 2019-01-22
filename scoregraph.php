<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	header("Location: index.php");
}

//Include the code
require_once 'phplot.php';

//Define the object
$plot = new PHPlot(500,400);

$sql = "SELECT * FROM teams";
$teams = DB::getInstance()->query($sql);

$example_data = array();

foreach($teams->results() as $team){
    /** getting data from each record from field Mass and storing it in $mass array **/

    $id = $team->id;
    $name = $team->name;
    $score = TeamInfo::FindScore($id);
    
    $example_data[] = array($name,$score);
   
}

$plot->SetDataValues($example_data);

//Set titles
$plot->SetTitle("Scoreboard");
$plot->SetXTitle("Name");
$plot->SetYTitle("Score");

//Turn off X axis ticks and labels because they get in the way:
$plot->SetXTickLabelPos('none');
$plot->SetXTickPos('none');

//Draw it
$plot->DrawGraph();

?>