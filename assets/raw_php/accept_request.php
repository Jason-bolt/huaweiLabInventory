<?php

session_start();

include "../db/db.php";
include "../functions/functions.php";

if (!isset($_GET['request_id'])){
    redirect_to('../../admin.php');
}

$id = $_GET['request_id'];

$request = get_specific_user_device_requests($id);
$user_id = $request['user_id'];
$device_id = $request['device_id'];
$request_quantity = $request['request_quantity'];

$device = get_device_by_id($device_id);

$number_taken = $device['number_taken'];

// Add requested quantity to number taken
$current_number = $request_quantity + $number_taken;
// Check to ensure current number does not exceed totla number available
if ($current_number > $device['device_quantity']){
    $_SESSION['accept_request_message'] = "Can not accept because request quantity is more than the available quantity!";
    redirect_to('../../admin.php#requests_button');
}

// Set date modified
date_default_timezone_set("UTC");
$date_taken = date('l jS \of F Y h:i:s A');

$date_returned = "Not returned";

// Query to delete request from request table
$query = "DELETE FROM requests WHERE request_id = {$id}";
$deleted = mysqli_query($connection, $query);
if (!$deleted){
    $_SESSION['accept_request_message'] = "Something went wrong please try again!";
    redirect_to('../../admin.php#requests_button');
}else{
    // Query to add device to devices taken table
    $query = "INSERT INTO devices_taken (user_id, device_id, dt_quantity, dt_date_taken, dt_date_returned)";
    $query .= " VALUES ({$user_id}, {$device_id}, {$request_quantity}, '{$date_taken}', '{$date_returned}')";
    $result = mysqli_query($connection, $query);
    echo $result;
    if (!$result){
        $_SESSION['accept_request_message'] = "Something went wrong please try again!";
        redirect_to('../../admin.php#requests_button');
    }else{
        // Update device table
        $sql = "UPDATE devices SET number_taken = {$current_number} WHERE device_id = {$device_id}";
        mysqli_query($connection, $sql);
        // Confirmation message
        $_SESSION['accept_request_message'] = "Request accepted successfully!";
        redirect_to('../../admin.php#requests_button');
    }
}

?>