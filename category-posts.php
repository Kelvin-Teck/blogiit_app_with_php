<?php
  include 'partials/header.php';

  // fetch category post via url
  if(isset($_GET['id'])){
    $category_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $category_title_query = "SELECT * FROM categories WHERE id=$category_id ";
    $category_title_result = mysqli_query($connection, $category_title_query);
    $category_title = mysqli_fetch_assoc($category_title_result);

    // get post via id in the url
    $post_based_on_category_query = "SELECT * FROM posts WHERE category_id=$category_id ORDER BY date_time DESC";
    $post_based_on_category_result = mysqli_query($connection, $post_based_on_category_query);
  }else{
    header('location:' .ROOT_URL. 'blog.php');
    die();
  }
?>


<header class="category__title">
    <h2><?= "{$category_title['title']}" ?></h2>
</header>
    
    <!-- =============== END OF CATEGORY TITLE ============== -->
    
<?php if(mysqli_num_rows($post_based_on_category_result) > 0) :?>
    <section class="posts">
        <div class="container posts__container">
          <?php while($post_based_on_category = mysqli_fetch_assoc($post_based_on_category_result)) :?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= "{$post_based_on_category['thumbnail']}" ?>" alt="">
                </div>
                <div class="post__info">
                  <h3 class="post__title"><?= "{$post_based_on_category['title']}" ?></h3>
                  <p class="post__body"><?= "{$post_based_on_category['body']}" ?></p>
                  <div class="post__author">
                     <?php
                        $author_id = filter_var($post_based_on_category['author_id'], FILTER_SANITIZE_NUMBER_INT);
                        $author_query = "SELECT * FROM users WHERE id = $author_id";
                        $author_result = mysqli_query($connection, $author_query);
                        $author = mysqli_fetch_assoc($author_result);
                      ?>
                      <div class="post__author-avatar">
                        <img src="./images/<?=$author['avatar']?>" alt="">
                      </div>
                      <div class="post__author-info">
                        <h5>By: <?="{$author['firstname']}"?> <?="{$author['lastname']}"?></h5>
                        <small><?=date('M d, Y - H:i A', strtotime($post_based_on_category['date_time']))?></small>
                      </div>
                  </div>
                </div>
            </article>
          <?php endwhile; ?>
        </div>
    </section>
      <!-- =============== END OF POSTS ============== -->
<?php else :?>
<div class="alert__message error  container">
  <p>No post found in this category...</p>
</div>
<?php endif ; ?>

      <section class="category__buttons">
        <div class="container category__buttons-container">
          <?php
            $every_category_query = "SELECT * FROM categories";
            $every_category_result = mysqli_query($connection, $every_category_query);
          ?>
          <?php while ($category = mysqli_fetch_assoc($every_category_result)): ?>
            <a href="<?=ROOT_URL?>category-posts.php?id=<?=$category['id']?>" class="category__button"><?="{$category['title']}"?></a>
          <?php endwhile?>
        </div>
      </section>
      <!-- =============== END OF CATEGORY ============== -->

<?php
  include 'partials/footer.php';
?>
