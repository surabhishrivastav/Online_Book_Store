<?php
include_once("../../connection.php");
if (!$_SESSION["adminData"]) {
  header("Location: " . $baseUrl . "/admin/login");
  die();
}

$message = "";
$message_class = ""; // alert-success / alert-danger / alert-warning
if (isset($_GET["delete"])) {
  $del_id = $_GET["delete"];
  $getData = mysqli_query($con, "SELECT * FROM `product` WHERE id='$del_id'");
  if (mysqli_num_rows($getData) > 0) {
    $getImage_query = "SELECT * FROM `product_images` WHERE `product_id`='$del_id'";
    $getImage = mysqli_query($con, $getImage_query);
    if(mysqli_num_rows($getImage) > 0) {
      while($imageData = mysqli_fetch_assoc($getImage)){
        $image_name = $imageData["image_name"];
        if ($image_name != "") {
          if (file_exists("../../images/product/" . $image_name)) {
            unlink("../../images/product/" . $image_name);
          }
        }
      }
      mysqli_query($con, "DELETE FROM `product_images` WHERE `product_id`='$del_id'");
    }
    if (mysqli_query($con, "DELETE FROM product WHERE id='$del_id'")) {
      
      $message = "Product deleted ";
      $message_class = "alert-success";
    } else {
      //$message = "Please try again later ".mysqli_error($con);
      $message = "Please try again later ";
      $message_class = "alert-danger";
    }
  } else {
    $message = "Please try again later";
    $message_class = "alert-danger";
  }
}

if(isset($_GET["mark_active"])) {
  $prod_id = $_GET["mark_active"];
  if(mysqli_query($con, "UPDATE product SET status='active' WHERE id='$prod_id'")) {
    $message = "Product marked active.";
    $message_class = "alert-success";
  } else {
    $message = "Please try again later";
    $message_class = "alert-danger";
  }
}

if(isset($_GET["mark_pending"])) {
  $prod_id = $_GET["mark_pending"];
  if(mysqli_query($con, "UPDATE product SET status='pending' WHERE id='$prod_id'")) {
    $message = "Product marked In-Active.";
    $message_class = "alert-success";
  } else {
    $message = "Please try again later";
    $message_class = "alert-danger";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("../head.php") ?>

<body>
  <div class="container-xxl position-relative bg-white d-flex p-0">

    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
      <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <?php
    $cur_page = "product";
    include("../sidebar.php")
    ?>

    <div class="content">
      <?php include("../navbar.php") ?>
      <div style="min-height: 75vh;">
        <div class="container-fluid pt-4 px-4">
          <div>
            <div class="mb-3">
              <span><a href="<?= $baseUrl ?>/admin/">Dashboard</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span><a href="<?= $baseUrl ?>/admin/products">Books</a></span>
            </div>
          </div>
          <div class="">
            <a href="add" class="btn btn-primary">Add Book</a>
          </div>
          <?php
          if ($message != "") {
          ?>
            <div class="row mt-2">
              <div class="alert <?= $message_class ?>" role="alert">
                <?= $message ?>
              </div>
            <div>
          <?php
          }
          ?>
          <div class="table-responsive mt-3">
            <table class="table">
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
                $i = 0;
                $get_data_query = "SELECT `product`.*, `category`.`name` AS category_name FROM `product` INNER JOIN `category` ON `product`.category_id=`category`.id ORDER BY `product`.id DESC";
                $get_data_run = mysqli_query($con, $get_data_query);
                while ($data = mysqli_fetch_assoc($get_data_run)) {
                  $prod_id = $data["id"];
                  $image_out = "";
                  $getImage_query = "SELECT * FROM `product_images` WHERE `product_id`='$prod_id' AND `status`='active' ORDER BY id ASC LIMIT 1";
                  $getImage = mysqli_query($con, $getImage_query);
                  if(mysqli_num_rows($getImage) > 0) {
                    $imageData = mysqli_fetch_assoc($getImage);
                    $image_name = $imageData["image_name"];
                    $image_link = "";
                    
                    if ($image_name != "") {
                      if (file_exists("../../images/product/" . $image_name)) {
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
                    <td><?= ++$i ?></td>
                    <td><?= $image_out ?> </td>
                    <td><?= $data["generic_name"] ?></td>
                    <td><?= $data["category_name"] ?></td>
                    <td><?= $data["author"] ?></td>
                    <td><?= $data["available_qty"] ?></td>
                    <td><?= $data["added_on"] ?></td>
                    <td><?= $data["updated_on"] ?></td>
                    <td>
                      <?= $data["status"] ?>
                      <?php
                      if($data["status"] == "pending") {
                        ?>
                        <a class="btn btn-success btn-sm" href="?mark_active=<?=$data["id"] ?>" style="padding:2px;">Mark Active</a>
                        <?php
                      } else {
                        ?>
                        <a class="btn btn-danger btn-sm" href="?mark_pending=<?=$data["id"] ?>" style="padding:2px;">Mark In-Active</a>
                        <?php
                      }
                      ?>
                    </td>
                    <td>
                      <a href="<?= $baseUrl ?>/admin/products/edit?id=<?= $data["id"] ?>" class="btn btn-sm btn-outline-success"><i class="far fa-edit"></i> Edit</a>
                      <button type="button" class="btn btn-sm btn-outline-danger update_button" data-url="<?= $baseUrl ?>/admin/products?delete=<?= $data["id"] ?>" data-id="<?= $data["id"] ?>" data-content="Are you sure you want to delete this product ? (<?= $data["name"] ?>)" data-title="Delete Confirmation"><i class="fas fa-trash-alt"></i> Delete</button>
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php include("../footer.php") ?>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>

  <?php include("../alljs.php") ?>
</body>

</html>