<?php
    session_start();

    include "../db/db.php";
    include "../functions/functions.php";

    if(!isset($_GET['add_person_submit'])){
        redirect_to('../../index.php');
    }

    $person_name = mysql_prep(trim($_GET['person_name']));
    $device_id = $_GET['device_id'];
    $device_count = mysql_prep(trim($_GET['device_count']));
    $password = mysql_prep(trim($_GET['add_person_password']));
  
    
    // Checking for valid values
    if ($peron_name == '' || $password == ''){
        $_SESSION['add_person_message'] = "Fields cannot be left empty!";
        redirect_to('../../index.php');
    }
    
    // Confirm admin issued this
    $admin = get_admin();
    $check = password_check($password, $admin['admin_password']);
    if (!$check){
        $_SESSION['add_person_message'] = "Password is incorrect!";
        redirect_to('../../index.php');
    }
    
    // Set date modified
    date_default_timezone_set("UTC");
    $date_modified = date('l jS \of F Y h:i:s A');

    // UPDATE device data in database
    $query = "INSERT INTO persons (person_name, device_id, device_count, date_given)";
    $query .= "VALUES ('{$person_name}', {$device_id}, {$device_count}, '{$date_modified}')";
    $result = mysqli_query($connection, $query);
    query_check($result);

    if (!$result){
        $_SESSION['add_person_message'] = "Could not add person data... Please try again.";
        redirect_to('../../index.php');
    }else{
        $_SESSION['add_person_message'] = "Device updated successfully!";
        redirect_to('../../index.php');
    }

?>