<?php
require 'config/database.php';

// fetch user image...
if(isset($_SESSION['user-id'])){
  $id = filter_var($_SESSION['user-id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $img_query = "SELECT avatar from users WHERE id = $id ";
  $result = mysqli_query($connection, $img_query);  
  $avatar = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blogit</title>
    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="https: //uxwing.com/pen-icon/" type="image/x-icon">
    <!-- CUSTOM STYLE SHEET -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css" />
    <!-- ICONCOUT CDN -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- GOOGLE FONT() -->
    
  </head>
  <body>
    <nav>
      <div class="container nav__container">
        <a href="<?= ROOT_URL ?>" class="nav__logo">Blog<span>it</span></a>
        <ul class="nav__items">
          <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
          <li><a href="<?= ROOT_URL ?>about.php">about</a></li>
          <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
          <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
          <?php if(isset($_SESSION['user-id'])) : ?>
          <li class="nav__profile">
            <div class="avatar">
              <img src="<?= ROOT_URL.'images/'.$avatar['avatar']?>" alt="" />
            </div>
            <ul>
              <li><a href="<?= ROOT_URL ?>admin/index.php">dashboard</a></li>
              <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
            </ul>
          </li>
          <?php else : ?>
          <li><a href="<?= ROOT_URL ?>signin.php">Signin</a></li>
          <?php endif; ?>
        </ul>

        <button id="open__nav-btn"><i class="uil uil-bars"></i></button>
        <button id="close__nav-btn"><i class="uil uil-multiply"></i></button>
      </div>
    </nav>
    <!-- =============== END OF NAV ============== -->
