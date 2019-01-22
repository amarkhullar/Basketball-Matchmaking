<?php

class TeamInfo {

	public static function FindAvgSkill($currentteamid = -1) {
		if($currentteamid == -1) {
			header("index.php");
		}else {
			$sqlplayers = "SELECT pg_id, sg_id, sf_id, pf_id, c_id FROM teams WHERE id = {$currentteamid}";
			$players = DB::getInstance()->query($sqlplayers);

			if($players->count() > 0) {

			
				$teampg_id = $players->first()->pg_id;
				$teamsg_id = $players->first()->sg_id;
				$teamsf_id = $players->first()->sf_id;
				$teampf_id = $players->first()->pf_id;
				$teamc_id = $players->first()->c_id;

				$avg = 0;
				$count = 0;

				if($teampg_id > 0) {
					$findskillsql = "SELECT skill FROM users WHERE id = {$teampg_id}";
					$findskill = DB::getInstance()->query($findskillsql);
					$avg = $avg + $findskill->first()->skill;
					$count = $count + 1;
				}
				if($teamsg_id > 0) {
					$findskillsql = "SELECT skill FROM users WHERE id = {$teamsg_id}";
					$findskill = DB::getInstance()->query($findskillsql);
					$avg = $avg + $findskill->first()->skill;
					$count = $count + 1;
				}
				if($teamsf_id > 0) {
					$findskillsql = "SELECT skill FROM users WHERE id = {$teamsf_id}";
					$findskill = DB::getInstance()->query($findskillsql);
					$avg = $avg + $findskill->first()->skill;
					$count = $count + 1;
				}
				if($teampf_id > 0) {
					$findskillsql = "SELECT skill FROM users WHERE id = {$teampf_id}";
					$findskill = DB::getInstance()->query($findskillsql);
					$avg = $avg + $findskill->first()->skill;
					$count = $count + 1;
				}
				if($teamc_id > 0) {
					$findskillsql = "SELECT skill FROM users WHERE id = {$teamc_id}";
					$findskill = DB::getInstance()->query($findskillsql);
					$avg = $avg + $findskill->first()->skill;
					$count = $count + 1;
				}

				$avg = $avg / $count;
				return $avg;

			}
		}

	}
	//Finds the average skill of a team given the team's ID
	public static function FindNumPlayers($pg_id = 0, $sf_id = 0, $pf_id = 0, $sg_id = 0, $c_id = 0) {
			$numplayers = 0;
			if($pg_id > 0) {
				$numplayers = $numplayers + 1;
			}
			if($sf_id > 0) {
				$numplayers = $numplayers + 1;
			}
			if($pf_id > 0) {
				$numplayers = $numplayers + 1;
			}
			if($sg_id > 0) {
				$numplayers = $numplayers + 1;
			}
			if($c_id > 0) {
				$numplayers = $numplayers + 1;
			}

		return $numplayers;
	}
	//Finds the number of players in a team
	public static function FindScore($teamid = 0) {

		$sql = "SELECT winner FROM matches WHERE team1 = {$teamid} OR team2 = {$teamid}";
		$matches = DB::getInstance()->query($sql);

		$score = 0;

		$scoremultiplier = 3;

		foreach($matches->results() as $match) {

			$winner = $match->winner;

			if($winner == $teamid) {
				$score = $score + $scoremultiplier;
			}

		}

		return $score;

	}
	//Finds the score of a team given its ID
}

?>