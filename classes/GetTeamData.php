<?php

class GetTeamData {

	private $id;
	private $pg_id;
	private $sg_id;
	private $pf_id;
	private $sf_id;
	private $c_id;

	public function __construct($teamid = null) {

		if($teamid > 0) {
			$sql = "SELECT * FROM teams WHERE id = " . $teamid;
			$teamdata = DB::getInstance()->query($sql);
			$this->id = $teamid;
			$this->pg_id = $teamdata->first()->pg_id;
			$this->sg_id = $teamdata->first()->sg_id;
			$this->pf_id = $teamdata->first()->pf_id;
			$this->sf_id = $teamdata->first()->sf_id;
			$this->c_id = $teamdata->first()->c_id;
		}
		
	}
// constructor, sets all of the team values that are needed to be stored
	public function ID() {
		return $this->id;
	}
// returns the id of the team
	public function PG() {
		if($this->pg_id > 0) {
			return $this->pg_id;
		}
	}
// returns the id of the point guard
	public function SG() {
		if($this->sg_id > 0) {
			return $this->sg_id;
		}
	}
// returns the id of the shooting guard
	public function PF() {
		if($this->pf_id > 0) {
			return $this->pf_id;
		}
	}
// returns the id of the power forward
	public function SF() {
		if($this->sf_id > 0) {
			return $this->sf_id;
		}
	}
// returns the id of the small forward
	public function C() {
		if($this->c_id > 0) {
			return $this->c_id;
		}
	}
// returns the id of the centre
}