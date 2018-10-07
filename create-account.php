<?php
include 'classes/DB.php';


if (isset($_POST['createaccount'])) 
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];

		if (!DB::query('SELECT username FROM users WHERE username=:username', array(':username'=>$username))) {
				
				if (strlen($username) >= 3 && strlen($username) <= 32) {

					if (preg_match('/[a-zA-Z0-9_]+/', $username)) {

						if (strlen($password) >= 6 && strlen($password) <= 60) {

						if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
							DB::query('INSERT INTO users VALUES (\'\', :username, :password, :email)', array(':username'=>$username, ':password'=>password_hash($password, PASSWORD_BCRYPT),  ':email'=>$email));
							echo "success";
						}else {
							echo "invaild email";
						}

					} else {
						echo "invalid password!";
					}

						
					} else {
						echo "invaild username";
					}
					
					
					} else {
						echo "invaild username";
					}
		} else {
			echo 'User already exists!';
		}
		
	}

?>

<h1>Register</h1>
<form action="create-account.php" method="post">
	<input type="text" name="username" value="" placeholder="Enter Username"> <p />
	<input type="password" name="password" value="" placeholder="Enter Password"> <p />
	<input type="email" name="email" value="" placeholder="Enter Email"> <p />
	<input type="submit" name="createaccount" value="Create Account"> <p />
</form>