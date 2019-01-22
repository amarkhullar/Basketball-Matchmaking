<?php

require_once 'core/init.php';

$now = new DateTime('now');
$month = $now->format('m');
$year = $now->format('Y');
$day = $now->format('d');


switch ($month) {
    case 1:
        $monthname = "January";
        break;
    case 2:
        $monthname = "February";
        break;
    case 3:
        $monthname = "March";
        break;
    case 4:
    	$monthname = "April";
    	break;
   	case 5:
   		$monthname = "May";
   		break;
   	case 6:
   		$monthname = "June";
   	case 7:
   		$monthname = "July";
   		break;
   	case 8:
   		$monthname = "August";
   		break;
   	case 9:
   		$monthname = "September";
   		break;
   	case 10:
   		$monthname = "October";
   		break;
   	case 11:
   		$monthname = "November";
   		break;
    case 12:
    	$monthname = "December";
    	break;
}

echo '<h2>' . $monthname . ' ' . $year . '</h2>';
echo Calendar::DrawCalendar($month,$year);

?>

<html>

<head>
	<title>Match Calendar</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>