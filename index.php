<?php
  include 'partials/header.php';

  // Fetch the featured Posts...
  $featured_query = "SELECT * FROM posts WHERE is_featured = 1";
  $featured_result = mysqli_query($connection, $featured_query);
  $featured = mysqli_fetch_assoc($featured_result);

  // Fetch 10 post from the database...
  $query = "SELECT * FROM posts ORDER BY date_time DESC LIMIT 9";
  $posts = mysqli_query($connection, $query); 

?>

<?php if(mysqli_num_rows($featured_result) == 1) : ?>
 
    <section class="featured">
        <div class="container featured__container">
            <div class="post__thumbnail">
                <img src="./images/<?= "{$featured['thumbnail']}" ?>" alt="">
            </div>
            <div class="post__info">
              <?php 
                $featured_category_id = filter_var($featured['category_id'], FILTER_SANITIZE_NUMBER_INT);
                $featured_category_query = "SELECT * FROM categories WHERE id = $featured_category_id";
                $featured_category_result = mysqli_query($connection, $featured_category_query);
                $featured_category = mysqli_fetch_assoc($featured_category_result);
                
              ?>
                <a href="<?= ROOT_URL ?>category-posts.php?id=<?= "{$featured_category['id']}" ?>" class="category__button"><?= "{$featured_category['title']}" ?></a>
                <h2 class="post__title">
                    <a href="<?= ROOT_URL ?>post.php?id=<?= "{$featured['id']}" ?>"><?= "{$featured['title']}" ?></a>
                </h2>
                <p class="post__body"><?= substr("{$featured['body']}",0,300 )?>...</p>
                <div class="post__author">
                <?php 
                  $featured_category_author_id = filter_var($featured['author_id'], FILTER_SANITIZE_NUMBER_INT);
                  $featured_category_author_query = "SELECT * FROM users WHERE id = $featured_category_author_id";
                  $featured_category_author_result = mysqli_query($connection, $featured_category_author_query);
                  $featured_category_author = mysqli_fetch_assoc($featured_category_author_result);
                ?>
                    <div class="post__author-avatar">
                        <img src="./images/<?= "{$featured_category_author['avatar']}" ?>" alt="">
                    </div>
                    <div class="post__author-info">
                        <h5>By: <?= "{$featured_category_author['firstname']}" ?> <?= "{$featured_category_author['lastname']}" ?></h5>
                        <small><?= date('M d, Y - H:i A', strtotime($featured['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif ;?>

    <!-- =============== END OF FEATURED POST ============== -->


<section class="posts <?= $featured ? '' : 'section__extra-margin' ?>" >
    <div class="container posts__container">
      <?php while ($post = mysqli_fetch_assoc($posts)): ?>
        <article class="post">
            <div class="post__thumbnail">
                <img src="./images/<?= $post['thumbnail'] ?>" alt="">
            </div>
            <div class="post__info">
              <?php
                  $category_id = $post['category_id'];
                  $category_query = "SELECT * FROM categories WHERE id=$category_id";
                  $category_result = mysqli_query($connection, $category_query);
                  $category = mysqli_fetch_assoc($category_result);
                ?>
              <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $post['category_id']?>" class="category__button"><?= $category['title']?></a>
              <h3 class="post__title"><a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= "{$post['title']}"?></a></h3>
              <p class="post__body"><?= substr("{$post['body']}",0,150 )?>...</p>
              <div class="post__author">
                  <?php
                    $author_id = filter_var($post['author_id'], FILTER_SANITIZE_NUMBER_INT);
                    $author_query = "SELECT * FROM users WHERE id = $author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author = mysqli_fetch_assoc($author_result);
                  ?>
                <div class="post__author-avatar">
                  <img src="./images/<?= $author['avatar']?>" alt="">
                </div>
                <div class="post__author-info">
                  <h5>By: <?= "{$author['firstname']}" ?> <?= "{$author['lastname']}" ?></h5>
                  <small><?= date('M d, Y - H:i A', strtotime($post['date_time'])) ?></small>
                </div>
              </div>
            </div>
        </article>
        <?php endwhile ;?>
    </div>
</section>
      <!-- =============== END OF POSTS ============== -->

<section class="category__buttons">
  <div class="container category__buttons-container">
    <?php
      $every_category_query = "SELECT * FROM categories";
      $every_category_result = mysqli_query($connection, $every_category_query);
    ?>
  <?php while($category = mysqli_fetch_assoc($every_category_result)) :?>
    <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id']?>" class="category__button"><?= "{$category['title']}"?></a>
  <?php endwhile?>
  </div>
</section>
<!-- =============== END OF CATEGORY ============== -->

<?php
include 'partials/footer.php';
?>