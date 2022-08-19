<?php
require 'config/database.php';

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $select_query = "SELECT * FROM categories WHERE id = $id ";
    $select_result = mysqli_query($connection,$select_query);
    if(mysqli_num_rows($select_result) == 1){
        $category  = mysqli_fetch_assoc($select_result);
        $title = $category['title'];
    }

    // change this deleted category id and change it to the id of the uncategoized one...
    $update_query = "UPDATE posts SET category_id = 7 WHERE category_id = $id ";
    $upate_result = mysqli_query($connection, $update_query);

    if(!mysqli_errno($connection)){
        // delete the category...
        $query = "DELETE FROM categories WHERE id = $id LIMIT 1";
        $result = mysqli_query($connection, $query);

        if(mysqli_errno($connection)){
            $_SESSION['delete-category'] = "Couldn't delete category";
        }else{
            $_SESSION['delete-category-success'] = "Category $title has been deleted successfully...";
        }

    }

}

header('location: ' . ROOT_URL .'admin/manage-categories.php');
die();