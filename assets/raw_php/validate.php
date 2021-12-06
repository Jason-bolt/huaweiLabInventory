<?php
    session_start();

    include "../db/db.php";
    include "../functions/functions.php";

    // Probably a GET request
    if(!isset($_POST['validate_submit'])){
        redirect_to('../../index.php');
    }

    $password = $_POST['password'];
    
    if ($password == ''){
        $_SESSION['validate_message'] = "Password field cannot be left empty!";
        redirect_to('../../index.php');
    }

    $admin = get_admin();

    $check = password_check($password, $admin['admin_password']);

    if (!$check){
        $_SESSION['validate_message'] = "Wrong Password!";
        redirect_to('../../index.php');
    }else{
        $_SESSION['validated'] = "True";
        redirect_to('../../add_device.php');
    }


?>