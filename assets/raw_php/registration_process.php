<?php

	session_start();
	include('../db/db.php');
	include('../functions/functions.php');

	if (isset($_POST['register_submit'])) {
		// Form submitted

		// Variables
		$lastName = mysql_prep(trim($_POST['lastName']));
		$otherName = mysql_prep(trim($_POST['otherName']));
		$indexNumber = mysql_prep(trim($_POST['indexNumber']));
		$username = mysql_prep(trim($_POST['username']));
		$password = $_POST['password'];
		$confirm_password = $_POST['confirm_password'];

		if ($lastName == '' || $otherName == '' || $indexNumber == '' || $username == '' || $password == '' || $confirm_password == '') {
			$_SESSION['register_message'] = "Fields with * are required!";
			redirect_to('../../register.php');
		}

		if (strlen($password) < 6) {
			$_SESSION['register_message'] = "Pasword is too short, must be more than 6 characters!";
			redirect_to('../../register.php');
		}	

		if ($password != $confirm_password) {
			$_SESSION['register_message'] = "Passwords do not match!";
			redirect_to('../../register.php');
		}

		// Hashing the password
		$hashed_password = password_encrypt($password);

		// Checking if user already exists
		$user_exists =  get_user_by_username($username);
		if ($user_exists) {
			$_SESSION['register_message'] = "User already exists!";
			redirect_to('../../register.php');
		}

		// Database query to uplaod info except image
		$query = "INSERT INTO users (";
		$query .= "last_name, other_names, index_number, username, password";
		$query .= ") VALUES (";
		$query .= "'{$lastName}', '{$otherName}', '{$indexNumber}', '{$username}', '{$hashed_password}')";
		$result = mysqli_query($connection, $query);

        // Confirm result
        if (!$result){
            $_SESSION['register_message'] = "Registration failed, please try again!";
			redirect_to('../../register.php');
        }else{
            $_SESSION['login_notice'] = "Registration successful!";
            redirect_to('../../login.php');
        }
	}else{
		// Probably the GET request
		redirect_to('../../register.php');
	}

?>