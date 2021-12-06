<?php
    session_start();

    include "../db/db.php";
    include "../functions/functions.php";

    if(!isset($_POST['request_device_submit'])){
        redirect_to('../../user.php');
    }

    $user_id = $_SESSION['user_id'];
    $device_id = mysql_prep($_POST['device_id']);
    $device_quantity = trim($_POST['device_quantity']);

    // Checking for valid values
    if ($device_quantity == '' || $device_quantity == 0){
        $_SESSION['request_device_message'] = "Device quantity can not be 0!";
        redirect_to('../../user.php');
    }

    // Setting request status
    $status = "Pending approval";

    // Insert device request into database
    $query = "INSERT INTO requests (user_id, device_id, request_quantity, request_status";
    $query .= ") VALUES ( '{$user_id}', '{$device_id}', {$device_quantity}, '{$status}')";
    $result = mysqli_query($connection, $query);
    query_check($result);

    if (!$result){
        $_SESSION['request_device_message'] = "Request could not be sent... Please try again.";
        redirect_to('../../user.php');
    }else{
        $_SESSION['request_device_message'] = "Request sent successfully!";
        redirect_to('../../user.php');
    }

?>