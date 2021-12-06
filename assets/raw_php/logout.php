<?php

	session_start();

    if (isset($_SESSION['admin_id'])){
        unset ($_SESSION['admin_id']);
        unset ($_SESSION['admin_username']);
    }else{
        unset ($_SESSION['user_id']);
        unset ($_SESSION['username']);
    }

	header('Location: ../../login.php');

?>