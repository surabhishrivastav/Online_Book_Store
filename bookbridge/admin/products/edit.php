<?php
include_once ("../../connection.php");
if (!$_SESSION["adminData"]) {
  header("Location: " . $baseUrl . "/admin/login");
  die();
}

if (!isset($_GET["id"])) {
  header("Location: " . $baseUrl . "/admin/categories");
  die();
}
$message = "";
$message_class = ""; // alert-success / alert-danger / alert-warning
$edit_id = $_GET["id"];
$is_data_found = false;
$prod_name = "";
$category_id = "";
$generic_name = "";
$publisher = "";
$author = "";
$edition = "";
$language = "";
$short_description = "";
$long_description = "";
$no_of_pages = "";
$weight = "";
$country_of_origin = "";
$book_condition = "";
$for_purchase = "";
$for_rent = "";
$for_swapping = "";
$available_qty = "";
$mrp = "";
$selling_price = "";
$for_rent = "";
$get_data = mysqli_query($con, "SELECT * FROM product WHERE id='$edit_id'");
if (mysqli_num_rows($get_data) > 0) {
  $is_data_found = true;
  $prod_data = mysqli_fetch_assoc($get_data);
  $prod_name = $prod_data["name"];
  $category_id = $prod_data["category_id"];

  $generic_name = $prod_data["generic_name"];
  $publisher = $prod_data["publisher"];
  $author = $prod_data["author"];
  $edition = $prod_data["edition"];
  $language = $prod_data["language"];
  $short_description = $prod_data["short_description"];
  $long_description = $prod_data["long_description"];
  $no_of_pages = $prod_data["no_of_pages"];
  $weight = $prod_data["weight"];
  $country_of_origin = $prod_data["country_of_origin"];
  $book_condition = $prod_data["book_condition"];
  $for_purchase = $prod_data["for_purchase"];
  $for_rent = $prod_data["for_rent"];
  $for_swapping = $prod_data["for_swapping"];
  $available_qty = $prod_data["available_qty"];

  $mrp = $prod_data["mrp"];
  $selling_price = $prod_data["selling_price"];

  $rent_mrp = $prod_data["rent_mrp"];
  $rent_sp = $prod_data["rent_sp"];

  $swap_mrp = $prod_data["swap_mrp"];
  $swap_sp = $prod_data["swap_sp"];

} else {
  $message = "No product found";
  $message_class = "alert-danger";
}

if (isset($_POST["submit"])) {
  /* if (isset($_POST["name"])) {
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
  } */
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include ("../head.php") ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">

<body>
  <div class="container-xxl position-relative bg-white d-flex p-0">

    <div id="spinner"
      class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
      <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <?php
    $cur_page = "product";
    include ("../sidebar.php")
      ?>

    <div class="content">
      <?php include ("../navbar.php") ?>
      <div style="min-height: 75vh;">
        <div class="container-fluid pt-4 px-4">
          <div>
            <div class="mb-3">
              <span><a href="<?= $baseUrl ?>/admin">Dashboard</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span><a href="<?= $baseUrl ?>/admin/products">Categories</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span>
                <a href="<?= $baseUrl ?>/admin/products/edit?id=<?= $edit_id ?>">
                  Edit <?php if ($generic_name != "") { ?> (<?= $generic_name ?>) <?php } ?>
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
              if ($is_data_found) { ?>
                <div class="bg-light rounded h-100 p-4">
                  <h6 class="mb-4">Edit Product</h6>
                  <form method="POST" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <?php
                          $get_category_query = "SELECT `id`,`name` FROM `category` WHERE `status`='active' ORDER BY `name` ASC";
                          $get_category_run = mysqli_query($con, $get_category_query);
                          if (mysqli_num_rows($get_category_run) > 0) {
                            ?>
                            <select class="form-control" name="category" required>
                              <option value="">Select Category</option>
                              <?php
                              while ($categoryData = mysqli_fetch_assoc($get_category_run)) {
                                ?>
                                <option value="<?= $categoryData["id"] ?>" <?php if ($category_id === $categoryData["id"]) {
                                    echo "selected";
                                  } ?>><?= $categoryData["name"] ?></option>
                                <?php
                              }
                              ?>
                            </select>
                            <label for="category">Category</label>
                            <?php
                          }
                          ?>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="name" placeholder="Book title"
                            value="<?= $prod_name ?>" required>
                          <label for="name">Book title</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="generic_name" value="<?= $generic_name ?>"
                            placeholder="Generic name">
                          <label for="generic_name">Generic name</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <select class="form-control" name="language">
                            <option value="Hindi" <?php if ($language == "Hindi") {
                              echo "selected";
                            } ?>>Hindi</option>
                            <option value="English" <?php if ($language == "Engish") {
                              echo "selected";
                            } ?>>English</option>
                          </select>
                          <label for="language">Language</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="author" value="<?= $author ?>"
                            placeholder="Author" required>
                          <label for="name">Author</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="publisher" value="<?= $publisher ?>"
                            placeholder="Publisher" required>
                          <label for="publisher">Publisher</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <select class="form-control" name="edition">
                            <option value="first edition" <?php if ($edition == "first edition") {
                              echo "selected";
                            } ?>>1
                            </option>
                            <option value="second edition" <?php if ($edition == "second edition") {
                              echo "selected";
                            } ?>>2
                            </option>
                            <option value="third edition" <?php if ($edition == "third edition") {
                              echo "selected";
                            } ?>>3
                            </option>
                            <option value="fourth edition" <?php if ($edition == "fourth edition") {
                              echo "selected";
                            } ?>>4
                            </option>
                            <option value="fifth edition" <?php if ($edition == "fifth edition") {
                              echo "selected";
                            } ?>>5
                            </option>
                            <option value="sixth edition" <?php if ($edition == "sixth edition") {
                              echo "selected";
                            } ?>>6
                            </option>
                            <option value="seventh edition" <?php if ($edition == "seventh edition") {
                              echo "selected";
                            } ?>>
                              7</option>
                            <option value="eightth edition" <?php if ($edition == "eightth edition") {
                              echo "selected";
                            } ?>>
                              8</option>
                          </select>
                          <label for="edition">Edition</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <input type="number" class="form-control" name="no_of_pages" placeholder="244" min="1"
                            value="<?= $no_of_pages ?>" required>
                          <label for="no_of_pages">Number of pages</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <input type="number" class="form-control" name="weight" placeholder="0.5" min="0.1" step="any"
                            value="<?= $weight ?>" required>
                          <label for="weight">Weight (KG)</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" name="country_of_origin"
                            placeholder="India / United Kingdom" value="<?= $country_of_origin ?>" required>
                          <label for="country_of_origin">Country of origin</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <select class="form-control" name="book_condition">
                            <option value="New" <?php if ($book_condition == "New") {
                              echo "selected";
                            } ?>>New</option>
                            <option value="Old" <?php if ($book_condition == "Old") {
                              echo "selected";
                            } ?>>Old</option>
                          </select>
                          <label for="book_condition">Book Condition</label>
                        </div>
                      </div>
                      <div class="col-sm-6">
                        <div class="form-floating mb-3">
                          <input type="number" class="form-control" name="available_qty" placeholder="Available quantity"
                            min="1" value="1" value="<?= $available_qty ?>" required>
                          <label for="available_qty">Available Quantity</label>
                        </div>
                      </div>


                      <div class="col-sm-12 row p-4">
                        <div class="form-check col">
                          <input type="checkbox" class="form-check-input sale_type" data-type="saleinp"
                            name="for_purchase" value="true" <?php if ($for_purchase == "true") {
                              echo "checked";
                            } ?>>
                          <label for="for_purchase" class="form-check-label">For sell ?</label>
                        </div>
                        <div class="col">
                          <input type="number" class="form-control saleinp" name="mrp" placeholder="Purchase MRP" min="0"
                            value="<?= $mrp ?>">
                          <label for="mrp">Purchase MRP</label>
                        </div>
                        <div class="col">
                          <input type="number" class="form-control saleinp" name="selling_price"
                            placeholder="Purchase Selling Price" min="0" value="<?= $selling_price ?>">
                          <label for="selling_price">Purchase Selling Price</label>
                        </div>
                      </div>
                      <div class="col-sm-12 row p-4">
                        <div class="form-check col">
                          <input type="checkbox" class="form-check-input sale_type" data-type="rentinp" name="for_rent"
                            value="true" <?php if ($for_rent == "true") {
                              echo "checked";
                            } ?>>
                          <label for="for_rent" class="form-check-label">For rent ?</label>
                        </div>
                        <div class="col">
                          <input type="number" class="form-control rentinp" name="rent_mrp" placeholder="Rent MRP" min="0" value="<?= $rent_mrp ?>">
                          <label for="rent_mrp">Rent MRP / Day</label>
                        </div>
                        <div class="col">
                          <input type="number" class="form-control rentinp" name="rent_sp"
                            placeholder="Purchase Selling Price" min="0" value="<?= $rent_sp ?>">
                          <label for="rent_sp">Rent Selling Price / Day</label>
                        </div>
                      </div>
                      <div class="col-sm-12 row p-4">
                        <div class="form-check col">
                          <input type="checkbox" class="form-check-input sale_type" data-type="swapinp"
                            name="for_swapping" value="true" <?php if ($for_swapping == "true") {
                              echo "checked";
                            } ?>>
                          <label for="for_swapping" class="form-check-label">For swapping ?</label>
                        </div>
                        <div class="col">
                          <input type="number" class="form-control swapinp" name="swap_mrp" placeholder="Swap MRP" min="0"
                            value="<?= $swap_mrp ?>">
                          <label for="swap_mrp">Swap MRP</label>
                        </div>
                        <div class="col">
                          <input type="number" class="form-control swapinp" name="swap_sp"
                            placeholder="Swap Selling Price" min="0" value="<?= $swap_sp ?>">
                          <label for="swap_sp">Swap Selling Price</label>
                        </div>
                      </div>

                      <div class="col-sm-12">
                        <div class="mb-3">
                          <textarea class="form-control" name="short_description" maxlength="950" rows="3"
                            required><?= $short_description ?></textarea>
                          <label for="short_description">Short description (max 950)</label>
                        </div>
                      </div>
                      <div class="col-sm-12">
                        <div class="mb-3">
                          <textarea class="form-control" name="long_description" id="summernote"
                            maxlength="4950"><?= $long_description ?></textarea>
                          <label for="long_description">Long description (max 4950)</label>
                        </div>
                      </div>

                    </div>
                    <br />
                    <center><button type="submit" class="btn btn-success" name="submit">Update Book</button></center>
                  </form>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <?php include ("../footer.php") ?>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>
  <?php include ("../alljs.php") ?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#summernote').summernote();
      $("#add_image_div").click(function () {
        $("#add_image_div").attr("disabled", true);
        var image_count = $("#image_count").val();
        image_count++;
        var image_div = '<div class="row book_image_div' + image_count + ' mb-3">';
        image_div += ' <div class="col-sm-8">';
        image_div += '   <div class="form-floating mb-3">';
        image_div += '     <input type="file" class="form-control image_change" name="book_image' + image_count + '" id="book_image' + image_count + '" accept="image/*" data-outDiv="book_image' + image_count + '_out" placeholder="Image">';
        image_div += '     <label for="book_image' + image_count + '"> Image ' + image_count + '</label>';
        image_div += '   </div>';
        image_div += ' </div>';
        image_div += ' <div class="col-sm-3 book_image' + image_count + '_out"></div>';
        image_div += '</div>';

        $(".image_divs").append(image_div);
        $("#image_count").val(image_count);
        if (image_count > 1) {
          $(".delete_btn_div").removeClass("d-none");
        }
        $("#add_image_div").removeAttr("disabled");
      });

      $("#remove_image_div").click(function () {
        $("#remove_image_div").attr("disabled", true);
        var image_count = $("#image_count").val();
        if (image_count > 1) {
          $(".book_image_div" + image_count).remove();
          image_count--;
          if (image_count <= 1) {
            $(".delete_btn_div").addClass("d-none");
          }
          $("#image_count").val(image_count);
        }
        $("#remove_image_div").removeAttr("disabled");
      });
    });
  </script>
</body>

</html>