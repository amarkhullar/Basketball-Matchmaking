<?php

require_once 'core/init.php';

$_SESSION['error_msg'] = "";

if(Input::exists()) {
	if(Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'Username' => array('required' => true),
			'Password' => array('required' => true)
			));
// sets validation rules
		if($validation->passed()) {
			$user = new User();
// if validation passes it sets a new user, creating a session for the user
			$remember = (Input::get('remember') === 'on') ? true : false;

			$login = $user->login(Input::get('Username'), Input::get('Password'), $remember);
			if($login) {
				Redirect::to('index.php');
			} else {
				$_SESSION['error_msg'] = $_SESSION['error_msg'] . "Sorry, logging in failed" . '<br>';
			}
		} else {
			foreach($validation->errors() as $error) {
				$_SESSION['error_msg'] = $_SESSION['error_msg'] . $error . '<br>';
			}
		}
	}
}

?>

<html>

<head>
	<title>Log In</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

		<center>
			
			<div class="col-md-4">
			</div>
			<div class="col-md-4 loginform">
				<h1>Log In</h1><br><br>
				<form method="post" action="">

					<div class="row">
						<div class="form-group">
							<input type="text" placeholder="Username" name="Username" id="Username" autocomplete="off" class="form-control">
						</div>
					</div>

					<div class="row">
						<div class="form-group">
							<input type="password" placeholder="Password" name="Password" id="Password" autocomplete="off" class="form-control">
						</div>
					</div>

					<div class="row">
						<label for="remember">
						<input type="checkbox" name="remember" id="remember">Remember Me
						</label>
					</div>

					<br><br>

					<input type="hidden" name="token" value ="<?php echo Token::generate(); ?>">
					<div class="row">
						<button type="submit" class="btn btn-default">Log In</button>
					</div>

				</form>

				<a href="register.php">Register here</a>

				<br>
				<div class="row"><h4>
					<?php
						echo $_SESSION['error_msg'];
					?>
				</h5></div>
				<br>

			</div>
		</div>

	</center>
</body>

</html>