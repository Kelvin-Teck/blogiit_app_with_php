<?php
require 'config/database.php';

if (isset($_POST['submit'])) {
    $author_id = $_SESSION['user-id'];
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];

    // set is_featured to 0 if unchecked...
    $is_featured = $is_featured == 1 ?: 0;

    // validate form data...
    if (!$title) {
        $_SESSION['add-post'] = "Enter Post title...";
    } elseif (!$body) {
        $_SESSION['add-post'] = "Enter Post body...";
    } elseif (!$category_id) {
        $_SESSION['add-post'] = "Select Post Category...";
    } elseif (!$thumbnail['name']) {
        $_SESSION['add-post'] = "Enter Post image...";
    } else {
        // Rename the thumbnail...
        $time = time();
        $thumbnail_name = $time . $thumbnail['name']; //to create a unique name...
        $thumbnail_tmp_name = $thumbnail['tmp_name'];
        $thumbnail_destination_path = '../images/' . $thumbnail_name;

        // make sure is an image...
        $allowed_files = ['jpg', 'jpeg', 'png'];
        $extension = explode('.', $thumbnail_name);
        $extension = end($extension);

        if (in_array($extension, $allowed_files)) {
            // make sure file size is not too big (2MB+)...
            if ($thumbnail['size'] < 10_000_000) {
                // upload thumbnail...
                move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
            } else {
                $_SESSION['add-post'] = "File size too big. Should be less than 2MB...";
            }
        } else {
            $_SESSION['add-post'] = "File should be a jpg , png or jpeg...";
        }

    }

    // if there is any problem redirect back to add-post page...
    if (isset($_SESSION['add-post'])) {
        $_SESSION['add-post-data'] = $_POST;
        header('location:' . ROOT_URL . 'admin/add-post.php');
        die();
    } else {
        // set is_featured of all other post but this post to 0 while this post is 1...
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0 ";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // Insert post into the database...
        $query = "INSERT INTO posts (title, body, thumbnail, category_id, author_id, is_featured) VALUES ('$title', '$body', '$thumbnail_name', '$category_id', '$author_id', '$is_featured') ";
        $result = mysqli_query($connection, $query);

        if (!mysqli_errno($connection)) {
            $_SESSION['add-post-success'] = "New Post added successfully...";
            header('location:' . ROOT_URL . 'admin/');
            die();
        }

    }
}

header('location:' . ROOT_URL . 'admin/add-post.php');
die();
