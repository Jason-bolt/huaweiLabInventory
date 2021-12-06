<?php

function redirect_to($website){
	header("Location: " . $website);
	exit;
}

function query_check($query){
	if (!$query) {
		die("Database query failed");
	}
}

function mysql_prep($string){
	global $connection;
	$escaped_string = mysqli_real_escape_string($connection, $string);
	return $escaped_string;
}


// PASSWORD FUNCTIONS
function password_encrypt($password){
	$hash_format = "$2y$10$"; // Tells PHP to use Blowfish with "cost" of 10
	$salt_length = 23; // Blowfish salts should be 22-characters or more
	$salt = generate_salt($salt_length);
	$format_and_salt = $hash_format . $salt;
	$hash = crypt($password, $format_and_salt);
	return $hash;
}

function generate_salt($length){
	// Not 100% unique or random
	// MD5 returns 32 characters
	$unique_random_string = md5(uniqid(mt_rand(), true));
	// Valid characters for salt are [a-zA-Z0-9./]
	$base64_string = base64_encode($unique_random_string);
	// But not '+' which is valid in base64 encoding
	$modified_base64_string = str_replace('+', '.', $base64_string);
	// Truncate to the correct length
	$salt = substr($modified_base64_string, 0, $length);
	return $salt;
}

function password_check($password, $existing_hash){
	// Existing hash contains format and salt to start
	$hash = crypt($password, $existing_hash);
	if ($hash === $existing_hash) {
		return true;
	}else{
		return false;
	}
}

function admin_logged_in(){
	return isset($_SESSION["admin_id"]);
}

function attempt_admin_login($username, $password){
	$admin = get_admin_by_username($username);
	if ($admin) {
		// Found admin, now check passord
		if (password_check($password, $admin["admin_password"])) {
			// Password matches
			return $admin;
		}else{
			// Password was not match
			return false;
		}
	}else{
		// admin not found
		return false;
	}
}

function user_logged_in(){
	return isset($_SESSION["user_id"]);
}

function attempt_user_login($username, $password){
	$user = get_user_by_username($username);
	if ($user) {
		// Found user, now check passord
		if (password_check($password, $user["password"])) {
			// Password matches
			return $user;
		}else{
			// Password was not match
			return false;
		}
	}else{
		// user not found
		return false;
	}
}

function get_admin_by_username($username){
	global $connection;
	$safe_username = mysql_prep($username);
	$query = "SELECT * from admins WHERE admin_username = '{$safe_username}' LIMIT 1";
	$admins = mysqli_query($connection, $query);
	query_check($admins);
	if ($admin = mysqli_fetch_assoc($admins)){
		return $admin;
	}
}

function get_user_by_username($username){
	global $connection;
	$safe_username = mysql_prep($username);
	$query = "SELECT * from users WHERE username = '{$safe_username}' LIMIT 1";
	$users = mysqli_query($connection, $query);
	query_check($users);
	if ($user = mysqli_fetch_assoc($users)){
		return $user;
	}
}

function get_all_devices(){
	global $connection;
	$query = "SELECT * from devices ORDER BY device_name ASC";
	$devices = mysqli_query($connection, $query);
	query_check($devices);
	return $devices;
}

function get_all_sensors(){
	global $connection;
	$query = "SELECT * from devices WHERE device_type = 'sensor' ORDER BY device_name ASC";
	$devices = mysqli_query($connection, $query);
	query_check($devices);
	return $devices;
}

function get_all_actuators(){
	global $connection;
	$query = "SELECT * from devices WHERE device_type = 'actuator' ORDER BY device_name ASC";
	$devices = mysqli_query($connection, $query);
	query_check($devices);
	return $devices;
}

function get_all_microcontrollers(){
	global $connection;
	$query = "SELECT * from devices WHERE device_type = 'microcontroller' ORDER BY device_name ASC";
	$devices = mysqli_query($connection, $query);
	query_check($devices);
	return $devices;
}

function get_all_others(){
	global $connection;
	$query = "SELECT * from devices WHERE device_type = 'other' ORDER BY device_name ASC";
	$devices = mysqli_query($connection, $query);
	query_check($devices);
	return $devices;
}

function get_all_persons(){
	global $connection;
	$query = "SELECT * from persons ORDER BY date_given ASC";
	$persons = mysqli_query($connection, $query);
	query_check($persons);
	return $persons;
}

function get_device_by_name($device_name){
	global $connection;
	$checked_device_name = mysql_prep($device_name);
	$query = "SELECT * from devices WHERE device_name = '{$checked_device_name}' LIMIT 1";
	$result = mysqli_query($connection, $query);
	query_check($result);
	if ($device = mysqli_fetch_assoc($result)) {
		return $device;
	}else{
		return null;
	}
}

function get_device_by_id($device_id){
	global $connection;
	$query = "SELECT * from devices WHERE device_id = {$device_id} LIMIT 1";
	$result = mysqli_query($connection, $query);
	query_check($result);
	if ($device = mysqli_fetch_assoc($result)) {
		return $device;
	}else{
		return null;
	}
}

function get_user_device_requests($user_id){
	global $connection;
	$query = "SELECT * FROM requests INNER JOIN users INNER JOIN devices WHERE";
	$query .= " requests.user_id = $user_id AND requests.device_id = devices.device_id";
	$results = mysqli_query($connection, $query);
	query_check($results);
	return $results;
}

function get_all_user_device_requests(){
	global $connection;
	$query = "SELECT * FROM requests INNER JOIN users INNER JOIN devices WHERE";
	$query .= " requests.user_id = users.user_id AND requests.device_id = devices.device_id AND requests.request_status = 'Pending approval'";
	$results = mysqli_query($connection, $query);
	query_check($results);
	return $results;
}

function get_specific_user_device_requests($request_id){
	global $connection;
	$query = "SELECT * FROM requests WHERE request_id = {$request_id} LIMIT 1";
	$results = mysqli_query($connection, $query);
	query_check($results);
	if ($result = mysqli_fetch_assoc($results)) {
		return $result;
	}else{
		return null;
	}
}

function get_all_users_with_devices(){
	global $connection;
	$query = "SELECT * FROM devices_taken INNER JOIN users INNER JOIN devices WHERE";
	$query .= " devices_taken.user_id = users.user_id AND devices_taken.device_id = devices.device_id";
	$query .= " AND devices_taken.dt_date_returned = 'Not returned'";
	$results = mysqli_query($connection, $query);
	query_check($results);
	return $results;
}

function get_device_taken_history(){
	global $connection;
	$query = "SELECT * FROM devices_taken INNER JOIN users INNER JOIN devices WHERE";
	$query .= " devices_taken.user_id = users.user_id AND devices_taken.device_id = devices.device_id";
	$results = mysqli_query($connection, $query);
	query_check($results);
	return $results;
}

function get_device_history(){
	global $connection;
	$query = "SELECT * FROM device_history";
	$results = mysqli_query($connection, $query);
	query_check($results);
	return $results;
}

?>