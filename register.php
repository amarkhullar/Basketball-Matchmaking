<?php

require_once 'core/init.php';
// inherits core class

$_SESSION['error_msg'] = "";

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {
		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'Username' => array(
				'required' => true,
				'min' => 2,
				'max' => 20,
				'unique' => 'users'),
			'Email' => array(
				'required' => true),
			'Password' => array(
				'required' => true,
				'min' => 6),
			'Password-again' => array(
				'required' => true,
				'matches' => 'Password'),
			'Name' =>array(
				'required' => true,
				'min' => 2,
				'max' => 50),
			'Role' =>array(
				'required' => true),
			'Skill' =>array(
				'required' => true,
				'minvalue' => 1,
				'maxvalue' => 10)
		));
		// setting up the validation rules for the data we are using that needs to be validated, and instantiating the validation class so the function can be called that validates the data
		if($validation->passed()) {

			$user = new User();
			$salt = Hash::salt(32);

			try {

				$user->create(array (
					'username' => Input::get('Username'),
					'email' => Input::get('Email'),
					'password' => Hash::make(Input::get('Password'), $salt),
					'salt' => $salt,
					'name' => Input::get('Name'),
					'joined' => date('Y-m-d H:i:s'),
					'role' => Input::get('Role'),
					'skill' => Input::get('Skill'),
					'teamid' => 0
					));

				Session::flash('login', 'You have been registered and can now log in.');
				Redirect::to('login.php');

			} catch(Exception $e) {
				die($e->getMessage());
			}
		} else {
			foreach($validation->errors() as $error) {
				$_SESSION['error_msg'] = $_SESSION['error_msg']. $error . '<br>';
			}
		}
	}
}

?>

<html>
	
<head>
	<title>Register</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

	<center>

		<div class="col-md-4">
		</div>
		<div class="col-md-4 registerform">
			<h1>Register</h1><br>
			<form action="" method="post">

				<div class="row">
					<div class="form-group">
						<label for="username">Username</label><br>
						<input class="form-control" type="text" name="Username" id="Username" value="<?php echo escape(Input::get('Username')); ?>" autocomplete="off">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="email">Email</label><br>
						<input class="form-control" type="email" name="Email" id="Email" value="<?php echo escape(Input::get('Email')); ?>" autocomplete="off">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="password">Choose a password</label><br>
						<input class="form-control" type="password" name="Password" id="Password">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="password_again">Enter your password again</label><br>
						<input class="form-control" type="password" name="Password-again" id="Password-again">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="name">Enter your name</label><br>
						<input class="form-control" type="text" name="Name" id="Name" value="<?php echo escape(Input::get('Name')); ?>">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="role">Choose your role</label><br>
						<select class="form-control" name="Role" id="Role">
							<option value="pg">Point Guard</option>
							<option value="sg">Shooting Guard</option>
							<option value="sf">Small Forward</option>
							<option value="pf">Power Forward</option>
							<option value="c">Center</option>
						</select>
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<label for="skill">Enter skill level (1-10)</label><br>
						<input class="form-control" type="text" name="Skill" id="Skill">
					</div>
				</div>

				<br>

				<div class="row">
					<div class="form-group">
						<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
						<button type="submit" class="btn btn-default">Register</button>
					</div>
				</div>

				<div class="row">
					<div class="form-group"><h4>
						<?php
							echo $_SESSION['error_msg'];
						?>
					</h4></div>
				</div>

				<div class="row">
					<div class="form-group">
						<a href="login.php">Log In</a>
					</div>
				</div>

		</form>

	</div>

	</center>
	</body>
	
</html>

<!-- Basic HTML form code -->

