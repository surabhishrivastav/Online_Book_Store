<?php
include("../connection.php");
if(!isset($_SESSION["userLogin"])) {
  header("Location: " . $baseUrl);
}
$user_id = $_SESSION["userLogin"]["id"];
$get_user_books_query = "SELECT product.*, `category`.`name` AS category_name FROM product INNER JOIN `category` ON `product`.category_id=`category`.id WHERE product.updated_by='user' AND product.updated_by_id='$user_id' ORDER BY product.id DESC";
$get_user_books_run = mysqli_query($con, $get_user_books_query);
include("../include_pages/navbar.php");
?>
<div class="container pt-5" style="min-height: 83vh;">
  <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>
  <div class="pl-5 pr-5 row">
    <div>
      <div class="mb-3">
        <span><a href="<?= $baseUrl ?>/">Home</a></span>
        <span><i class="fas fa-angle-right"></i></span>
        <span><a href="<?= $baseUrl ?>/my_account">My Account</a></span>
        <span><i class="fas fa-angle-right"></i></span>
        <span><a href="<?= $baseUrl ?>/my_account/my_books">My Books</a></span>
      </div>
    </div>
  </div>
  <div class="p-5 bg-white">
    <?php
    if($_SESSION["userLogin"]["is_verified"] == "true") {
      ?>
      <div><center><a href="<?= $baseUrl ?>/my_account/upload_book" type="button" class="btn btn-primary">Upload your book</a></center></div>
      <?php
    }
    ?>
    
    <div class="table-responsive mt-3">
      <table class="table table-bordered mt-3">
        <thead>
          <tr>
            <th scope="col">S.No</th>
            <th scope="col">Image</th>
            <th scope="col">Name</th>
            <th scope="col">Category</th>
            <th scope="col">Author</th>
            <th scope="col">Quantity</th>
            <th scope="col">Added On</th>
            <th scope="col">Updated On</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
          </tr>
        </thead>
        <tbody>
          <?php
          if(mysqli_num_rows($get_user_books_run) > 0) {
            $i = 0;
            while ($data = mysqli_fetch_assoc($get_user_books_run)) {
              $i++;
              $prod_id = $data["id"];
              $image_out = "";
              $getImage_query = "SELECT * FROM `product_images` WHERE `product_id`='$prod_id' AND `status`='active' ORDER BY id ASC LIMIT 1";
              $getImage = mysqli_query($con, $getImage_query);
              if(mysqli_num_rows($getImage) > 0) {
                $imageData = mysqli_fetch_assoc($getImage);
                $image_name = $imageData["image_name"];
                $image_link = "";
                
                if ($image_name != "") {
                  if (file_exists("../images/product/" . $image_name)) {
                    $image_link = $baseUrl . "/images/product/" . $image_name;
                    $image_out = '
                      <a href="' . $image_link . '" target="_blank">
                        <img src="' . $image_link . '" height="50" width="50" class="rounded">
                      </a>';
                  }
                }
              }
              ?>
              <tr>
                <td><?=$i ?></td>
                <td><?= $image_out ?> </td>
                <td><?= $data["generic_name"] ?></td>
                <td><?= $data["category_name"] ?></td>
                <td><?= $data["author"] ?></td>
                <td><?= $data["available_qty"] ?></td>
                <td><?= $data["added_on"] ?></td>
                <td><?= $data["updated_on"] ?></td>
                <td><?= $data["status"] ?></td>
                <td>
                  <button type="button" class="btn btn-sm btn-warning">Edit</button>
                </td>
              </tr>
              <?php
            }
          } else {
            ?>
            <tr>
              <td colspan="10">No books uploaded by you</td>
            </tr>
            <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php
include("../include_pages/footer.php");
?>