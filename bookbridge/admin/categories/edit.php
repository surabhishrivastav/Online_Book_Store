<?php
include_once("../../connection.php");
if (!$_SESSION["adminData"]) {
  header("Location: ".$baseUrl."/admin/login");
  die();
}

if(!isset($_GET["id"])) {
  header("Location: ".$baseUrl."/admin/categories");
  die();
}
$message = "";
$message_class = ""; // alert-success / alert-danger / alert-warning
$category_id = $_GET["id"];
$is_category_found = false;
$category_name = "";
$category_image = "";
$get_category = mysqli_query($con, "SELECT * FROM category WHERE id='$category_id'");
if(mysqli_num_rows($get_category) > 0) {
  $is_category_found= true;
  $category_data = mysqli_fetch_assoc($get_category);
  $category_name = $category_data["name"];
  $category_image = $category_data["image"];
} else {
  $message = "No category found";
  $message_class = "alert-danger";
}

if (isset($_POST["submit"])) {
  if (isset($_POST["name"])) {
    if($_POST["name"] != "") {
      $name = $_POST["name"];
      $image = $category_image;

      $check_already_exist_query = "SELECT id FROM category WHERE name='$name' AND id<>'$category_id'";
      $check_already_exist_run = mysqli_query($con, $check_already_exist_query);
      if(mysqli_num_rows($check_already_exist_run) == 0) {
        if (isset($_FILES["cat_image"])) {
          if (is_uploaded_file($_FILES['cat_image']['tmp_name'])) {
            $unique_image_name = uniqid(date('Y-m-d-h-i-s') . '_');
            $temp_name = explode(".", $_FILES["cat_image"]["name"]);
            $extension = end($temp_name);
            $image = $unique_image_name . '-category.' . $extension;
            $location = '../../images/category/' . $image;
            move_uploaded_file($_FILES["cat_image"]["tmp_name"], $location);
          }
        }

        $query_up = "UPDATE category SET `name`='$name', `image`='$image', `updated_on`='$current_date_time' WHERE id='$category_id'";
        if(mysqli_query($con, $query_up)) {
          $message = "Category updated";
          $message_class = "alert-success";
          header("Location: ".$baseUrl."/admin/categories");
        } else {
          $message = "Please try again later";
          $message_class = "alert-danger";
        }
      } else {
        $message = "This category already exixts";
        $message_class = "alert-danger";
      }
    } else {
      $message = "Please fill category name";
      $message_class = "alert-danger";
    }
  } else {
    $message = "Please fill category name";
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
    $cur_page = "category";
    include("../sidebar.php")
    ?>

    <div class="content">
      <?php include("../navbar.php") ?>
      <div style="min-height: 75vh;">
        <div class="container-fluid pt-4 px-4">
          <div>
            <div class="mb-3">
              <span><a href="<?=$baseUrl ?>/admin">Dashboard</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span><a href="<?=$baseUrl ?>/admin/categories">Categories</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span>
                <a href="<?=$baseUrl ?>/admin/categories/edit?id=<?=$category_id ?>">
                  Edit <?php if($category_name !="" ) { ?> (<?=$category_name ?>) <?php } ?>
                </a>
              </span>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <?php
                if ($message != "") {
                  ?>
                    <div class="alert <?= $message_class ?>" role="alert">
                      <?= $message ?>
                    </div>
                  <?php
                }
              ?>
              <?php
              if($is_category_found) { ?>
                <div class="bg-light rounded h-100 p-4">
                  <h6 class="mb-4">Edit Category</h6>
                  <form method="POST" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" name="name" placeholder="Category Name" value="<?=$category_name ?>">
                      <label for="name">Category Name</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="file" class="form-control" name="cat_image" accept="image/*" placeholder="Image">
                      <label for="cat_image">Category Image</label>
                    </div>
                    <button type="submit" class="btn btn-success" name="submit">Update</button>
                  </form>
                </div>
              <?php } ?>
            </div>
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