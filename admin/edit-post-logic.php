<?php
require 'config/database.php';

if(isset($_POST['submit'])){
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is_featured to 0 if it is unchecked...
    $is_featured = $is_featured == 1 ?  : 0;

    // Check and validate form input data...
    if(!$title){
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form input...";
    }elseif(!$body){
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form input...";
    }elseif(!$category_id){
        $_SESSION['edit-post'] = "Couldn't update post. Invalid form input...";
    }else{
        // delete existing thumbnail if new thumbnail was selected...
        if($thumbnail['name']){
            $previous_thumbnail_path = '../images/'. $previous_thumbnail_name;
            if($previous_thumbnail_path){
                unlink($previous_thumbnail_path);
            }

            // process the new thumbnail...
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name = $thumbnail['tmp_name'];
            $thumbnail_destination_path = '../images/'. $thumbnail_name;

            // Check validity of the file...
            $allowed_files = ['jpg', 'png', 'jpeg'];
            $extension = explode('.', $thumbnail_name);
            $extension = end($extension);

            if(in_array($extension, $allowed_files)){
                // check file size...
                if($thumbnail['size'] < 2_000_000){
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                }else{
                    $_SESSION['edit-post'] = "Couldn't update post. File size too large. File should be less than 2MB";
                }
            }else{
                $_SESSION['edit-post'] = "Couldn't update post. Invalid file format. File should be jpg, jpeg or png...";
            }
        }
    }

    if(isset($_SESSION['edit-post'])){
        header('location:'.ROOT_URL.'admin/');
        die();
    }else{
        // set is_featured of all other post but this post to 0 while this post is 1...
        if($is_featured == 1){
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0 " ;
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // set thumbnail to the new uploaded one, else keep the old one...
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title = '$title', body = '$body', thumbnail = '$thumbnail_to_insert', category_id = '$category_id', is_featured = $is_featured WHERE id = $id LIMIT 1 ";
        $result = mysqli_query($connection, $query);
    }
    
    if(!mysqli_errno($connection)){
        $_SESSION['edit-post-success'] = "Post updated successfully...";
    }

}

header('location:' .ROOT_URL. 'admin/');
die();