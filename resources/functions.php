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
    
    function logged_in() {
        return isset($_SESSION['user_id']);
    }
    
    function confirm_logged_in() {
        if (!isset($_SESSION['user_id'])) {
            $page = basename($_SERVER['PHP_SELF']);
            if ($page === 'register.php' || $page === 'profile.php' || $page === 'index.php') {
                redirect_to("login.php");
            } else {
                redirect_to("../login.php");
            }
        }
    }
    
    function find_user_by_username($username) {
        global $db;
        
        $query  = "SELECT * ";
        $query .= "FROM users ";
        $query .= "WHERE username = '$username' ";
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
        
        $query  = "SELECT * ";
        $query .= "FROM lists ";
        $query .= "WHERE user_id = '{$user_id}';";
        $result = mysqli_query($db, $query);
        confirm_query($result);
        return $result;
    }
    
    function find_all_list_items($list_id) {
        global $db;
        
        $query  = "SELECT * ";
        $query .= "FROM items ";
        $query .= "WHERE list_id = '{$list_id}';";
        $result = mysqli_query($db, $query);
        confirm_query($result);
        return $result;
    }
    
    function get_list_name($list_id) {
        global $db;
        
        $query  = "SELECT name ";
        $query .= "FROM lists ";
        $query .= "WHERE id = '{$list_id}' ";
        $query .= "LIMIT 1;";
        $list_name = mysqli_query($db, $query);
        confirm_query($list_name);
        return $list_name;
    }
    
    function get_item_note($list_id, $item_id) {
        global $db;
        
        $query  = "SELECT note ";
        $query .= "FROM items ";
        $query .= "WHERE id = '{$item_id}' AND list_id = '{$list_id}' ";
        $query .= "LIMIT 1;";
        $item_note = mysqli_query($db, $query);
        confirm_query($item_note);
        return $item_note;
    }
    
    function create_new_list_item($note, $list_id) {
        global $db;
        
        $query  = "INSERT INTO items (";
        $query .= "note, list_id";
        $query .= ") VALUES (";
        $query .= "'{$note}', '{$list_id}'";
        $query .= ");";
        $create_item = mysqli_query($db, $query);
        confirm_query($create_item);
        return $create_item;
    }
    
    function create_new_list($name, $user_id) {
        global $db;
        
        $query  = "INSERT INTO lists (";
        $query .= "user_id, name";
        $query .= ") VALUES (";
        $query .= "'{$user_id}', '{$name}'";
        $query .= ");";
        $create_list = mysqli_query($db, $query);
        confirm_query($create_list);
        return $create_list;
    }
    
    function update_list_item($list_id, $item_id, $new_note) {
        global $db;
        
        $query  = "UPDATE items ";
        $query .= "SET note='{$new_note}' ";
        $query .= "WHERE id = '{$item_id}' AND list_id = '{$list_id}';";
        $updated_item = mysqli_query($db, $query);
        confirm_query($updated_item);
        return $updated_item;
    }
    
    function delete_list() {
        
    }
    
    function delete_list_item($user_id, $list_id, $item_id) {
    global $db;
        
        $query  = "DELETE items ";
        $query .= "FROM items ";
        $query .= "INNER JOIN lists ";
        $query .= "ON items.list_id=lists.id ";
        $query .= "WHERE lists.user_id='{$user_id}' ";
        $query .= "AND items.list_id='{$list_id}' ";
        $query .= "AND items.id='{$item_id}';";
        $result = mysqli_query($db, $query);
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