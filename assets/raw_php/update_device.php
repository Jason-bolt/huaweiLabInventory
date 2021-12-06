<?php
    session_start();

    include "../db/db.php";
    include "../functions/functions.php";

    if(!isset($_POST['update_device_submit'])){
        redirect_to('../../index.php');
    }

    if(!isset($_GET['admin'])){
        redirect_to('../../index.php');
    }

    $device_id = $_POST['device_id'];
    $device_name = mysql_prep(trim($_POST['device_name']));
    $device_description = mysql_prep(trim($_POST['device_description']));
    $device_type = $_POST['device_type'];
    $device_quantity = trim($_POST['device_quantity']);
    
    // Checking for valid values
    if ($device_name == '' || $device_description == '' || $device_quantity == ''){
        $_SESSION['update_device_message'] = "Fields cannot be left empty!";
        redirect_to('../../admin.php');
    }
    
    // Set date modified
    date_default_timezone_set("UTC");
    $date_modified = date('l jS \of F Y h:i:s A');

    // UPDATE device data in database
    $query = "UPDATE devices SET device_name = '{$device_name}', device_type = '{$device_type}',";
    $query .= " device_description = '{$device_description}', device_quantity = {$device_quantity},";
    $query .= " date_modified = '{$date_modified}' WHERE device_id = {$device_id}";
    $result = mysqli_query($connection, $query);
    query_check($result);

    if (!$result){
        $_SESSION['update_device_message'] = "Could not update device data... Please try again.";
        redirect_to('../../admin.php');
    }else{
        $_SESSION['update_device_message'] = "Device updated successfully!";
        redirect_to('../../admin.php');
    }

?>