<?php
    
    function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}
    
    function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}
    
    function find_user_by_username($username) {
        global $db;
        
        $safe_username = mysqli_real_escape_string($db, $username);
        
        $query  = "SELECT * ";
        $query .= "FROM users ";
        $query .= "WHERE username = '$safe_username' ";
        $query .= "LIMIT 1;";
        $result = mysqli_query($db, $query);
        confirm_query($result);
        if ($user = mysqli_fetch_assoc($result)) {
            return $user;
        } else {
            return null;
        }
    }
    
    function find_all_user_lists($user_id) {
        global $db;
        
        $safe_user_id = mysqli_real_escape_string($db, $user_id);
        
        $query  = "SELECT * ";
        $query .= "FROM lists ";
        $query .= "WHERE user_id = '{$safe_user_id}';";
        $result = mysqli_query($db, $query);
        confirm_query($result);
        return $result;
    }
    
    function attempt_login($username, $password) {
        $user = find_user_by_username($username);
        if ($user) {
            if (password_verify($password, $user["password"])) {
                return $user;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
?>