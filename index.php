<?php
include 'classes/DB.php';

function isLoggedIn()
{
	if (isset($_COOKIE['SNID'])) {
		if (DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))) {
			$user_id = DB::query('SELECT user_id FROM login_tokens WHERE token=:token', array(':token'=>sha1($_COOKIE['SNID'])))[0]['user_id'];

			if (isset($_COOKIE['SNID_'])) {
				return $user_id;
			} else {
				$cstrong = True;
				$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
				DB::query('INSERT INTO login_tokens VALUES (\'\', :token, :user_id)', array(':token'=>sha1($token), ':user_id'=>$user_id));
				DB::query('DELETE FROM login_tokens WHERE token=:token', array(':token'=>sha1('token')));

				setcookie("SNID", $token, time() + 60 * 60 * 24 * 7, '/', NULL, NULL, TRUE);
				setcookie("SNID_", '1', time() + 60 * 60 * 24 * 3, '/', NULL, NULL, TRUE) // cookie expires after three days

			}
			
		}
	}

	return false;
}

if (isLoggedIn()) {
	echo "Logged In";
	echo isLoggedIn();
} else {
	echo "Not logged In";
}
?>