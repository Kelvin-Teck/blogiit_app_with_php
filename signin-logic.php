<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    // get data from the form...
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$username_email){
        $_SESSION['signin'] = "Username or email required!!!";
    }elseif(!$password){
        $_SESSION['signin'] = "Password required!!!";
    }else{
        // fetch user from database...
        $fetch_user_query = "SELECT * FROM users WHERE username = '$username_email' OR email = '$username_email' ";
        $fetch_user_query_result = mysqli_query($connection, $fetch_user_query);

        if(mysqli_num_rows($fetch_user_query_result) == 1){
            $user_record = mysqli_fetch_assoc($fetch_user_query_result);
            $db_password = $user_record['password'];
            // Compared the inputed password with the one in the database...
            if(password_verify($password,$db_password)){
                // you can now have access...
                $_SESSION['user-id'] = $user_record['id'];
                // check if user is an admin...
                if($user_record['is_admin'] == 1){
                    $_SESSION['user_is_admin'] = true;
                }
                // log user in...
                header('location: '.ROOT_URL.'admin/');
            }else{
                $_SESSION['signin'] = "incorrect password!. Please input a valid password";
            }
        }else{
            $_SESSION['signin'] = "No User exists with this Username or Email";
        }
    }

    // if an error exist, redirect to signin page with login details...
    if(isset($_SESSION['signin'])){
        $_SESSION['signin-data'] = $_POST; 
        header('location: '.ROOT_URL.'signin.php');
        die();
    }
}else{
    header('location: '.ROOT_URL.'signin.php');
    die();
}