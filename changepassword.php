<?php

require_once 'core/init.php';

$user = new User();

if(!$user->isLoggedIn()) {
	Redirect::to('index.php');
}

$_SESSION['changepassworderrors'] = "";
if(Input::exists()) {
	if(Token::check(Input::get('token'))) {

		$validate = new Validate();
		$validation = $validate->check($_POST, array(
			'password_current' => array(
				'required' => true,
				'min' => 6),
			'password_new' => array(
				'required' => true,
				'min' => 6),
			'password_new_again' => array(
				'required' => true,
				'min' => 6,
				'matches' => 'password_new')
			));

		if($validation->passed()) {
			if(Hash::make(Input::get('password_current'), $user->data()->salt) !== $user->data()->password) {
				echo 'Your current password is wrong';
			} else {
				$salt = Hash::salt(32);
				$user->update(array(
					'password' => Hash::make(Input::get('password_new'), $salt),
					'salt' => $salt));

			Session::flash('home', 'Your password has been changed');
			Redirect::to('index.php');

			}


		} else {
			foreach($validation->errors() as $error) {
				$_SESSION['changepassworderrors'] = $_SESSION['changepassworderrors'] . $error . '<br>';
				
			}
		}
	}
}
//validates a users new password and changes it 
?>

<html>

<head>
	<title>Change password</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="shortcut icon" href="css/Martin-Berube-Sport-Basketball.ico">
</head>

<body background="css/basketball.jpg">

<div class="col-md-4">
</div>
	<div class="col-md-4 loginform">
		<h1><center>Change Password</h1></center>
		<h3><center>
		<br>
		<div class="row">

			<form action="" method="post">

				<div class="row">
					<div class="form-group">
						<input type="password" name="password_current" id="password_current" placeholder="Current Password" class="form-control">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<input type="password" name="password_new" id="password_new" placeholder="New Password" class="form-control">
					</div>
				</div>

				<div class="row">
					<div class="form-group">
						<input type="password" name="password_new_again" id="password_new_again" placeholder="New Password Again" class="form-control">
					</div>
				</div>
				<br>

				<input type="submit" value="Change" class="btn btn-default">
				<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
				<br>

				<?php

				echo $_SESSION['changepassworderrors'];

				?>
				<br>
			</form>
		</div>

		<div class="row">
			<a href="index.php">Home</a>
		</div>

	</center>
	</h3>
	</h1>
	</div>

</body>
</html>

