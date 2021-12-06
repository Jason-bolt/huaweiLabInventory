<?php
    session_start();

    include "../db/db.php";
    include "../functions/functions.php";

    if(!isset($_GET['request_id'])){
        redirect_to('../../user.php');
    }

    $request_id = $_GET['request_id'];

    // DELETE request data from database
    $query = "DELETE FROM requests WHERE request_id = {$request_id}";
    $result = mysqli_query($connection, $query);
    query_check($result);

    if (!$result){
        $_SESSION['delete_request_message'] = "Could not delete request... Please try again.";
        redirect_to('../../user.php');
    }else{
        $_SESSION['delete_request_message'] = "Request deleted successfully!";
        redirect_to('../../user.php');
    }

?>