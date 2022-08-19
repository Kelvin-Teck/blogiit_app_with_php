<?php
  include 'partials/header.php';

  // Fetch the featured Posts...
  $featured_query = "SELECT * FROM posts WHERE is_featured = 1";
  $featured_result = mysqli_query($connection, $featured_query);
  $featured = mysqli_fetch_assoc($featured_result);
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
                        <small><?= date('M d, Y - H:i', strtotime($featured['date_time'])) ?></small>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- =============== END OF FEATURED POST ============== -->
<?php endif ;?>
    <section class="posts">
        <div class="container posts__container">
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./image/jae-bano-Xbf_4e7YDII-unsplash.jpg" alt="">
                </div>
                <div class="post__info">
                  <a href="category-posts.html" class="category__button">Nature</a>
                  <h3 class="post__title"><a href="./post.html">Lorem ipsum dolor sit amet consectetur adipisicing elit. Sit.</a></h3>
                  <p class="post__body">Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis, quos debitis amet porro vero dolorem odio adipisci quasi magni animi.</p>
                  <div class="post__author">
                    <div class="post__author-avatar">
                      <img src="./image/becca-tapert--A_Sx8GrRWg-unsplash.jpg" alt="">
                    </div>
                    <div class="post__author-info">
                      <h5>By: Jane Doe</h5>
                      <small>June 30, 2022 - 10:11</small>
                    </div>
                  </div>
                </div>
            </article>
        </div>
    </section>
      <!-- =============== END OF POSTS ============== -->

      <section class="category__buttons">
        <div class="container category__buttons-container">
          <a href="" class="category__button">Art</a>
          <a href="" class="category__button">Wild Life</a>
          <a href="" class="category__button">Travel</a>
          <a href="" class="category__button">Science and Technology</a>
          <a href="" class="category__button">Food</a>
          <a href="" class="category__button">Music</a>
        </div>
      </section>
      <!-- =============== END OF CATEGORY ============== -->

<?php
include 'partials/footer.php';
?>