<?php

session_start();

include "../db/db.php";
include "../functions/functions.php";

if (!isset($_GET['dt_id'])){
    redirect_to('../../admin.php');
}

$dt_id = $_GET['dt_id'];
$device_id = $_GET['device_id'];

$number_taken = $_GET['numTaken'];
$dt_quantity = $_GET['quantity'];

$current_number = $number_taken - $dt_quantity;


// Set date returned
date_default_timezone_set("UTC");
$date_returned = date('l jS \of F Y h:i:s A');

// Query to update request table
$query = "UPDATE devices_taken SET dt_date_returned = '{$date_returned}' WHERE dt_id = {$dt_id}";
$result = mysqli_query($connection, $query);
if (!$result){
    $_SESSION['device_returned_message'] = "Something went wrong please try again!";
    redirect_to('../../admin.php#people_with_devices');
}else{
    // Update devices table
    $sql = "UPDATE devices SET number_taken = {$current_number} WHERE device_id = {$device_id}";
    mysqli_query($connection, $sql);
    $_SESSION['device_returned_message'] = "Device has been returned!";
    redirect_to('../../admin.php#people_with_devices');
}

?>