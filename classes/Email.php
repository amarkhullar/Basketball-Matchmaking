<?php

class Email {

	public static function BookMatchEmail($team1id = 0, $team2id = 0, $team1name = 0, $team2name = 0, $locationname = 0) {

		$msg = "Sunday 1 PM: " . $team1name . " VS " . $team2name . " @ " . $locationname;
		$msg = wordwrap($msg,70);

		$sql = "SELECT pg_id, sg_id, sf_id, pf_id, c_id FROM teams WHERE id = {$team1id}";
		$team1players = DB::getInstance()->query($sql);

		$team1pg = $team1players->first()->pg_id;
		$team1sg = $team1players->first()->sg_id;
		$team1sf = $team1players->first()->sf_id;
		$team1pf = $team1players->first()->pf_id;
		$team1c = $team1players->first()->c_id;

		$sql = "SELECT pg_id, sg_id, sf_id, pf_id, c_id FROM teams WHERE id = {$team2id}";
		$team2players = DB::getInstance()->query($sql);

		$team2pg = $team2players->first()->pg_id;
		$team2sg = $team2players->first()->sg_id;
		$team2sf = $team2players->first()->sf_id;
		$team2pf = $team2players->first()->pf_id;
		$team2c = $team2players->first()->c_id;

		$sql = "SELECT email FROM users WHERE id IN ({$team1pg}, {$team1sg}, {$team1sf}, {$team1pf}, {$team1c}, {$team2pg}, {$team2sg}, {$team2sf}, {$team2pf}, {$team2c}";
		$emailaddresses = DB::getInstance()->query($sql);

		foreach($emailaddresses->results() as $emailaddress) {
			$emailaddress = ' . $emailaddress . ';
			mail($emailaddress, "Match Booking", $msg);
		}
	}
	// sends an email to all players in a team with their match details
}