<?php
    session_start();

    include "../db/db.php";
    include "../functions/functions.php";

    if(!isset($_GET['device_id'])){
        redirect_to('../../admin.php');
    }

    $device_id = $_GET['device_id'];

    // DELETE device data from database
    $query = "DELETE FROM devices WHERE device_id = {$device_id}";
    $result = mysqli_query($connection, $query);
    query_check($result);

    if (!$result){
        $_SESSION['delete_device_message'] = "Could not delete request... Please try again.";
        redirect_to('../../admin.php');
    }else{
        // delete device details from request table
        $query = "DELETE FROM requests WHERE device_id = {$device_id}";
        $result = mysqli_query($connection, $query);
        
        // delete device details from device taken table
        $query = "DELETE FROM devices_taken WHERE device_id = {$device_id}";
        $result = mysqli_query($connection, $query);


        $_SESSION['delete_device_message'] = "Request deleted successfully!";
        redirect_to('../../admin.php');
    }

?>