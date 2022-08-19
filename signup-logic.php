<?php
session_start();
require 'config/database.php';


// get form data when clicked...

if(isset($_POST['submit'])){
    $firstname = filter_var($_POST['firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $createpassword = filter_var($_POST['createpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['confirmpassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];

    // Input validation...
    if(!$firstname){
        $_SESSION['signup'] = "Please enter your First Name";
    }elseif(!$lastname){
        $_SESSION['signup'] = "Please enter your Last Name";
    }elseif(!$username){
        $_SESSION['signup'] = "Please enter a Username";
    }elseif(!$email){
        $_SESSION['signup'] = "Please enter a valid email address";
    }elseif(strlen($createpassword) < 8 || strlen($confirmpassword) < 8){
        $_SESSION['signup'] = "Password should be at least 8 Characters";
    }elseif(!$avatar['name']){
        $_SESSION['signup'] = "Please add an image";
    }else{
        // Check passwords match...
        if($createpassword !== $confirmpassword){
            $_SESSION['signup'] = "Passwords do not match";
        }else{
            // hash password for security...
            $hashed_password = password_hash($createpassword,PASSWORD_DEFAULT);
            
            // Check if username or email already exists...
            $user_email_check = "SELECT * from users WHERE username = '$username' OR email = '$email' ";
            $user_email_check_result = mysqli_query($connection,$user_email_check);

            // if it exists...
            if(mysqli_num_rows($user_email_check_result) > 0){
                $_SESSION['signup'] = "Username or email already exists";
            }else{ //if it doesn't exist...
                // Let's work on the image provided...

                // rename avatar and give it a unique name...
                $time  = time();
                $avatar_name = $time.$avatar['name'];
                $avatar_tmp_name = $avatar['tmp_name'];
                $avatar_destination_path = 'images/'.$avatar_name;

                // Check to see if file is an image...
                $allowed_files = ['png','jpg','jpeg'];
                $extension = explode('.',$avatar_name);
                $image_extension = end($extension);
                
                // Check if the image extension provided matches the array of allowed extensions...
                if(in_array($image_extension, $allowed_files)){
                    // manage image file size (< 1MB)...
                    if($avatar['size'] < 10000000){
                        // proceed to upload the image
                        move_uploaded_file($avatar_tmp_name,$avatar_destination_path);
                    }else{
                        $_SESSION['signup'] = "File size too large. File size should not be less than 1 MB";
                    }
                }else{
                    $_SESSION['signup'] = "File should be either a 'png', 'jpg' or a 'jpeg' ";
                }
            }
        }
    }
    
    // Redirect back to the signup page there is any problem...
    if(isset($_SESSION['signup'])){
        // display error message and formerly inputed data in the signup form page...
        $_SESSION['signup-data'] = $_POST;
        header('location: '. ROOT_URL . 'signup.php');
        die();
    }else{
        // Insert new user into the users table...
        $insert_new_user_query = "INSERT INTO users (firstname,lastname,username,email,password,avatar,is_admin) VALUES ('$firstname','$lastname','$username','$email','$hashed_password','$avatar_name',0)";
        $insert_new_user_query_result = mysqli_query($connection,$insert_new_user_query); 

        if(!mysqli_errno($connection)){
            $_SESSION['signup-success'] = "Registration successful. Please login to continue...";
            header('location: '. ROOT_URL . 'signin.php');
            die();
        }
    }
}else{
    // redirect if the button was not clicked...
    header('location: '. ROOT_URL . 'signup.php');
    die();
}