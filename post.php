<?php
  include 'partials/header.php';

  //get post using the id in the url
  if(isset($_GET['id'])){
    $post_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $single_post_query = "SELECT * FROM posts WHERE id=$post_id";
    $single_post_result = mysqli_query($connection, $single_post_query);
    $single_post = mysqli_fetch_assoc($single_post_result);
  } else{
    header('location:' .ROOT_URL. 'blog.php');
    die();
  }
?>


    <section class="singlepost">
      <div class="container singlepost__container">
        <h2><?= "{$single_post['title']}" ?></h2>
        <div class="post__author">
           <?php
              $author_id = filter_var($single_post['author_id'], FILTER_SANITIZE_NUMBER_INT);
              $author_query = "SELECT * FROM users WHERE id = $author_id";
              $author_result = mysqli_query($connection, $author_query);
              $author = mysqli_fetch_assoc($author_result);
            ?>
            <div class="post__author-avatar">
              <img src="./images/<?=$author['avatar'] ?>" alt="">
            </div>
            <div class="post__author-info">
              <h5>By: <?="{$author['firstname']}"?> <?="{$author['lastname']}"?></h5>
              <small><?=date('M d, Y - H:i A', strtotime($single_post['date_time']))?></small>
            </div>
        </div>
        <div class="singlepost__thumbnail">
            <img src="./images/<?= "{$single_post['thumbnail']}" ?>" alt="">
        </div>
        <p><?= "{$single_post['body']}" ?></p>
      </div>
    </section>
    <!-- =============== END OF SINGLE POST ============== -->

<?php
  include 'partials/footer.php';
?>
