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
  $getData = mysqli_query($con, "SELECT * FROM category WHERE id='$del_id'");
  if (mysqli_num_rows($getData) > 0) {
    $cat_data = mysqli_fetch_assoc($getData);
    $cat_image = $cat_data["image"];
    
    if (mysqli_query($con, "DELETE FROM category WHERE id='$del_id'")) {
      if ($cat_image != "") {
        if (file_exists("../../images/category/" . $cat_image)) {
          unlink("../../images/category/" . $cat_image);
        }
      }
      $message = "Category deleted";
      $message_class = "alert-success";
    }
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
    $cur_page = "category";
    include("../sidebar.php")
    ?>

    <div class="content">
      <?php include("../navbar.php") ?>
      <div style="min-height: 75vh;">
        <div class="container-fluid pt-4 px-4">
          <div>
            <div class="mb-3">
              <span><a href="index">Dashboard</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span><a href="<?= $baseUrl ?>/admin/categories">Categories</a></span>
            </div>
          </div>
          <div class="">
            <a href="add" class="btn btn-primary">Add Category</a>
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
                  <th scope="col">Added On</th>
                  <th scope="col">Updated On</th>
                  <th scope="col">Status</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                $get_category_query = "SELECT * FROM category ORDER BY id DESC";
                $get_category_run = mysqli_query($con, $get_category_query);
                while ($category = mysqli_fetch_assoc($get_category_run)) {
                  $image_name = $category["image"];
                  $image_link = "";
                  $image_out = "";
                  if ($image_name != "") {
                    if (file_exists("../../images/category/" . $image_name)) {
                      $image_link = $baseUrl . "/images/category/" . $image_name;
                      $image_out = '
                        <a href="' . $image_link . '" target="_blank">
                          <img src="' . $image_link . '" height="50" width="50" class="rounded">
                        </a>';
                    }
                  }
                ?>
                  <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $image_out ?> </td>
                    <td><?= $category["name"] ?></td>
                    <td><?= $category["added_on"] ?></td>
                    <td><?= $category["updated_on"] ?></td>
                    <td><?= $category["status"] ?></td>
                    <td>
                      <a href="<?= $baseUrl ?>/admin/categories/edit?id=<?= $category["id"] ?>" class="btn btn-sm btn-outline-success"><i class="far fa-edit"></i> Edit</a>
                      <button type="button" class="btn btn-sm btn-outline-danger update_button" data-url="<?= $baseUrl ?>/admin/categories?delete=<?= $category["id"] ?>" data-id="<?= $category["id"] ?>" data-content="Are you sure you want to delete this category ? (<?= $category["name"] ?>)" data-title="Delete Confirmation"><i class="fas fa-trash-alt"></i> Delete</button>
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