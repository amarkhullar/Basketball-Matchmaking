<?php

require_once 'core/init.php';
// instantiates the core class

if(Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}

$user = new User(); // current user

if(!$user->isLoggedIn()) {
	header("Location: login.php");
}

if(!$user->data()->teamid == 0) {
	header("Location: index.php");
}

$_SESSION['created'] = "";
$_SESSION['error_msg'] = "";

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'Name' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'teams'),
			'Location' => array(
				'required' => true)
			));

		// setting up the validation rules for the data we are using that needs to be validated, and instantiating the validation class so the function can be called that validates the data	

		if($validation->passed()) {

			$id = $user->data()->id;
			$role = $user->data()->role;

			$role = $role . "_id";

			$name = Input::get('Name');
			$day = Input::get('Day');
			$location = Input::get('Location');

			$sql = "INSERT INTO teams (name, pg_id, sg_id, sf_id, pf_id, c_id, score, preflocid) VALUES ('{$name}', 0, 0, 0, 0, 0, 0, '{$location}')";

			$update = "UPDATE teams SET {$role} = {$id} WHERE name = '{$name}'";

			DB::getInstance()->query($sql);
			DB::getInstance()->query($update);

			$findteamid = "SELECT id FROM teams WHERE role = {$id}";

			$findid = DB::getInstance()->query($findteamid);
			$teamid = $findid->first()->id;

			$updateusersteam = "UPDATE users SET teamid = {$teamid} WHERE id = {$id}";

			DB::getInstance()->query($updateusersteam);

			$_SESSION['created'] = "Team Created!";
		}else {
			foreach($validation->errors() as $error) {
				$_SESSION['error_msg'] = $_SESSION['error_msg']. $error . '<br>';
			}
		}
	}
}

$locationsql = "SELECT name FROM locations";

$locationnames = DB::getInstance()->query($locationsql);

for ($x = 0; $x <= 3; $x++) {
    $locationname[$x] = $locationnames->results()[$x]->name;
}
//allows a user to make their own team, and choose their teams preferred location
//The user is then placed in the team
?>

<html>
	
<head>
	<title>Create Team</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

	<center>

		<div class="col-md-4">
		</div>
		<div class="col-md-4 registerform">
			<h1>No Teams Available<br>Create New Team</h1><br>
			<form action="" method="post">
				<div class="row">
					<div class="form-group">
						<label for="Name">Name</label><br>
						<input class="form-control" type="text" name="Name" id="Name" autocomplete="off">
					</div>
				</div>

				<br>

				<div class="row">
					<div class="form-group">
						<label for="Day">Choose your preferred location</label><br>
						<select class="form-control" name="Location" id="Location">
							<option value="1"><?php echo $locationname[0]; ?></option>
							<option value="2"><?php echo $locationname[1]; ?></option>
							<option value="3"><?php echo $locationname[2]; ?></option>
							<option value="4"><?php echo $locationname[3]; ?></option>
						</select>
					</div>
				</div>

				<br>

				<div class="row">
					<div class="form-group">
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
						<button type="submit" class="btn btn-default">Create</button>
					</div>
				</div>

				<div class="row">
					<div class="form-group"><h4>
						<?php
							if($_SESSION['error_msg'] == "") {
									echo $_SESSION['created'];
								}else {
									echo $_SESSION['error_msg'];								
								}
						?>
					</h4></div>
				</div>

				<div class="row">
					<div class="form-group">
						<a href="index.php">Home</a>
					</div>
				</div>

		</form>

	</div>

	</center>
	</body>

	
</html>