<?php

session_start();

include "../db/db.php";
include "../functions/functions.php";

if (!isset($_GET['request_id'])){
    redirect_to('../../admin.php');
}

$id = $_GET['request_id'];

$status = "Request declined";

// Query to update request table
$query = "UPDATE requests SET request_status = '{$status}' WHERE request_id = {$id}";
$result = mysqli_query($connection, $query);
if (!$result){
    $_SESSION['decline_request_message'] = "Something went wrong please try again!";
    redirect_to('../../admin.php#requests_button');
}else{
    $_SESSION['decline_request_message'] = "Request declined!";
    redirect_to('../../admin.php#requests_button');
}

?>