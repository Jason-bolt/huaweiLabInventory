<?php

	session_start();
	include('../db/db.php');
	include('../functions/functions.php');

	if (!isset($_POST['login_submit'])) {
		// Probably a GET request
		redirect_to('../../login.php');
	}else{
		// POST request
		$username = mysql_prep(trim($_POST['username']));
		$password = (trim($_POST['password']));

		if (trim($username) == '' || trim($password) == '') {
			$_SESSION['login_notice'] = "Fields can not be left blank!";
            redirect_to('../../login.php');
		}

        // Check if an admin is trying to log in
        if ($username == 'admin'){
            $admin = attempt_admin_login($username, $password);

            if ($admin) {
                // print_r($admin);
                $_SESSION['admin_id'] = $admin['admin_id'];
                $_SESSION['admin_username'] = $user['admin_username'];
                redirect_to('../../admin.php');	
            }else{
                $_SESSION['login_notice'] = "Invalid username or password!";
                redirect_to('../../login.php');
            }
        }

        // If not an admin, then a user
		$user = attempt_user_login($username, $password);

		if ($user) {
			$_SESSION['user_id'] = $user['user_id'];
			$_SESSION['username'] = $user['username'];
			redirect_to('../../user.php');	
		}else{
			$_SESSION['login_notice'] = "Invalid username or password!";
			redirect_to('../../login.php');
		}
		
	}

?>