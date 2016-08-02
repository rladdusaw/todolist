<?php

    $errors = array();
    
    function value_exists($value) {
        return isset($value) && $value !== '';
    }

    function field_value_exists($form_fields) {
        global $errors;
        
        foreach ($form_fields as $field) {
            $value = trim($_POST[$field]);
            if (!value_exists($value)) {
                $errors[$field] = 'Please enter a value for ' . ucfirst($field);
            }
        }
    }
    
    function passwords_match($password_fields) {
        global $errors;
        
        $password1 = trim($_POST['password1']);
        $password2 = trim($_POST['password2']);
        if ($password1 === '' || $password2 === '') {
            if ($password1 !== $password2) {
                $errors['password1'] = "Passwords must match";
                $errors['password2'] = "Passwords must match";
            }
        }
    }
    
    function username_is_unique($username) {
        global $db;
        global $errors;
        
        $query  = "SELECT * ";
        $query .= "FROM users ";
        $query .= "WHERE username = '$username';";
        $result = mysqli_query($db, $query);
        if ($result->num_rows !== 0) {
            $errors['username'] = 'Selected username is not available';
        }
        mysqli_free_result($result);
    }
    
?>