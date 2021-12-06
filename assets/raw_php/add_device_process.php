<?php
    session_start();

    include "../db/db.php";
    include "../functions/functions.php";

    if(!isset($_POST['add_device_submit'])){
        redirect_to('../../index.php');
    }

    if(!isset($_GET['admin'])){
        redirect_to('../../index.php');
    }

    $device_name = mysql_prep(trim($_POST['device_name']));
    $device_description = mysql_prep(trim($_POST['device_description']));
    $device_type = $_POST['device_type'];
    $device_quantity = trim($_POST['device_quantity']);

    // Checking for valid values
    if ($device_name == '' || $device_description == '' || $device_quantity == ''){
        $_SESSION['add_device_message'] = "Fields cannot be left empty!";
        redirect_to('../../admin.php');
    }

    // Checking if device already exists
    $device = get_device_by_name($device_name);
    if ($device){
        $_SESSION['add_device_message'] = "Device already exists!";
        redirect_to('../../admin.php');
    }

    // Ensuring device quantity cannot be 0
    if ($device_quantity == 0){
        $_SESSION['add_device_message'] = "Device quantity cannot be 0!";
        redirect_to('../../admin.php');
    }

    // Set date modified
    date_default_timezone_set("UTC");
    $date_modified = date('l jS \of F Y h:i:s A');

    // Insert device data into database
    $query = "INSERT INTO devices (device_name, device_type, device_description,";
    $query .= " device_quantity, date_modified, number_taken) VALUES ( '{$device_name}', '{$device_type}',";
    $query .= " '{$device_description}', {$device_quantity}, '{$date_modified}', 0)";
    $result = mysqli_query($connection, $query);
    query_check($result);
    
    // Insert device data into history database
    $query = "INSERT INTO device_history (device_name, device_type, device_description,";
    $query .= " device_quantity) VALUES ( '{$device_name}', '{$device_type}',";
    $query .= " '{$device_description}', {$device_quantity})";
    mysqli_query($connection, $query);

    if (!$result){
        $_SESSION['add_device_message'] = "Device could not be added... Please try again.";
        redirect_to('../../admin.php');
    }else{
        $_SESSION['add_device_message'] = "Device added successfully!";
        redirect_to('../../admin.php');
    }

?>