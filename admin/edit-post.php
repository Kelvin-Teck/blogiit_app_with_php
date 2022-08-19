<?php
include 'partials/header.php';
// fetch categories from database...
$query = "SELECT * FROM categories ";
$categories = mysqli_query($connection, $query);

if(isset($_GET['id'])){
    $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
    $query = "SELECT * FROM posts WHERE id = $id";
    $result = mysqli_query($connection, $query);
    $post = mysqli_fetch_assoc($result);
}else{
    header('location:' .ROOT_URL. 'admin/');
    die();
}

?>


<section class="form__section">
   
    <div class="container form__section-container">
        <h2>Edit Post</h2>
        <form action="<?= ROOT_URL ?>admin/edit-post-logic.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= "{$post['id']}"?>">
            <input type="hidden" name="previous_thumbnail_name" value="<?= "{$post['thumbnail']}"?>">
            <input type="text" name="title" value="<?= "{$post['title']}" ?>" placeholder="Title">
            <Select name="category">
                <?php while( $category = mysqli_fetch_assoc($categories)) :?>
                <option value="<?= "{$category['id']}" ?>"><?= "{$category['title']}" ?></option>
                <?php endwhile ; ?>
            </Select>
            <textarea name="body"  id="" rows="10" placeholder="Body"><?= "{$post['body']}" ?></textarea>
             <div class="form__control inline">
                <input type="checkbox" name="is_featured" value="1" id="is_featured" checked>
                <label for="is_featured">Featured</label>
            </div>
            <div class="form__control">
                <label for="thumbnail">Change Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail">
            </div>
            <button type="submit" name="submit" class="btn">Edit Post</button>
        </form>
    </div>
</section>

<?php
include '../partials/footer.php';
?>
