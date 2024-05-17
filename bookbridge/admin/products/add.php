<?php
include_once ("../../connection.php");
if (!$_SESSION["adminData"]) {
  header("Location: " . $baseUrl . "/admin/login");
  die();
}

$message = "";
$message_class = ""; // alert-success / alert-danger / alert-warning
if (isset($_POST["submit"])) {
  if (isset($_POST["name"]) && isset($_POST["generic_name"]) && isset($_POST["language"]) && isset($_POST["author"]) && isset($_POST["publisher"]) && isset($_POST["available_qty"]) && isset($_POST["short_description"]) && isset($_POST["long_description"]) && isset($_POST["category"])) {
    if ($_POST["name"] != "" && $_POST["generic_name"] != "" && $_POST["language"] != "" && $_POST["author"] != "" && $_POST["publisher"] != "" && $_POST["available_qty"] != "" && $_POST["short_description"] != "" && $_POST["long_description"] != "" && $_POST["category"] != "") {
      $name = $_POST["name"];
      $generic_name = $_POST["generic_name"];
      $language = $_POST["language"];
      $author = $_POST["author"];
      $publisher = $_POST["publisher"];
      $edition = $_POST["edition"];
      $no_of_pages = $_POST["no_of_pages"];
      $weight = $_POST["weight"];
      $country_of_origin = $_POST["country_of_origin"];
      $available_qty = $_POST["available_qty"];
      $book_condition = $_POST["book_condition"];
      $category_id = $_POST["category"];

      $mrp = $_POST["mrp"];
      $selling_price = $_POST["selling_price"];

      $rent_mrp = $_POST["rent_mrp"];
      $rent_sp = $_POST["rent_sp"];

      $swap_mrp = $_POST["swap_mrp"];
      $swap_sp = $_POST["swap_sp"];

      $for_purchase = "false";
      if ($_POST["for_purchase"] != "") {
        $for_purchase = "true";
      }
      $for_rent = "false";
      if ($_POST["for_rent"] != "") {
        $for_rent = "true";
      }
      $for_swapping = "false";
      if ($_POST["for_swapping"] != "") {
        $for_swapping = "true";
      }
      $short_description = mysqli_real_escape_string($con, $_POST["short_description"]);
      $long_description = mysqli_real_escape_string($con, $_POST["long_description"]);
      $image = "";

      $check_already_exist_query = "SELECT id FROM `product` WHERE `name`='$name' AND `generic_name`='$generic_name' AND `status`='active'";
      $check_already_exist_run = mysqli_query($con, $check_already_exist_query);
      if (mysqli_num_rows($check_already_exist_run) == 0) {


        $query_in = "INSERT INTO product(`category_id`, `name`, `generic_name`, `publisher`, `author`, `edition`, `language`, `short_description`, `long_description`, `no_of_pages`, `weight`, `country_of_origin`, `book_condition`, `for_purchase`, `for_rent`, `for_swapping`, `available_qty`, `mrp`, `selling_price`, `rent_mrp`, `rent_sp`, `swap_mrp`, `swap_sp`, `added_on`, `added_by`, `updated_on`, `updated_by`, `status`) VALUES('$category_id' ,'$name', '$generic_name', '$publisher', '$author', '$edition', '$language', '$short_description', '$long_description', '$no_of_pages', '$weight', '$country_of_origin', '$book_condition', '$for_purchase', '$for_rent', '$for_swapping', '$available_qty', '$mrp', '$selling_price', '$rent_mrp', '$rent_sp', '$swap_mrp', '$swap_sp', '$current_date_time', 'admin', '$current_date_time', 'admin', 'active')";
        if (mysqli_query($con, $query_in)) {
          $product_id = mysqli_insert_id($con);
          $image_count = $_POST["image_count"];
          if ($image_count > 0) {
            $i = 1;
            $unique_image_name = uniqid(date('Y-m-d-h-i-s') . '_');
            $add_query = "";

            while ($i <= $image_count) {
              if (isset($_FILES["book_image" . $i])) {
                if (is_uploaded_file($_FILES["book_image" . $i]['tmp_name'])) {

                  $temp_name = explode(".", $_FILES["book_image" . $i]["name"]);
                  $extension = end($temp_name);
                  $image = $unique_image_name . $i . '-book.' . $extension;
                  $location = '../../images/product/' . $image;
                  move_uploaded_file($_FILES["book_image" . $i]["tmp_name"], $location);
                  if ($add_query != "") {
                    $add_query .= " ,";
                  }
                  $add_query .= " ('$image', '$product_id', '$current_date_time')";
                }
              }
              $i++;
            }
            if ($add_query != "") {
              $query_product_image .= "INSERT INTO `product_images`(`image_name`, `product_id`, `added_on`) VALUES" . $add_query;
              mysqli_query($con, $query_product_image);
            }
          }
          $message = "Product Added";
          $message_class = "alert-success";
          header("Location: " . $baseUrl . "/admin/products");
        } else {
          //echo $query_in;
          $message = "Please try again later";
          $message_class = "alert-danger";
        }
      } else {
        $message = "This product already exixts";
        $message_class = "alert-danger";
      }
    } else {
      $message = "Please fill all fields";
      $message_class = "alert-danger";
    }
  } else {
    $message = "Please fill all fields";
    $message_class = "alert-danger";
  }
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
              <span><a href="<?= $baseUrl ?>/admin/products">Books</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span><a href="<?= $baseUrl ?>/admin/products/add">Add Book</a></span>
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
              <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Add New Book</h6>
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
                              <option value="<?= $categoryData["id"] ?>"><?= $categoryData["name"] ?></option>
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
                        <input type="text" class="form-control" name="name" placeholder="Book title" required>
                        <label for="name">Book title</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="generic_name" placeholder="Generic name">
                        <label for="generic_name">Generic name</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <select class="form-control" name="language">
                          <option value="Hindi">Hindi</option>
                          <option value="English">English</option>
                        </select>
                        <label for="language">Language</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="author" placeholder="Author" required>
                        <label for="name">Author</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="publisher" placeholder="Publisher" required>
                        <label for="publisher">Publisher</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <select class="form-control" name="edition">
                          <option value="first edition">1</option>
                          <option value="second edition">2</option>
                          <option value="third edition">3</option>
                          <option value="fourth edition">4</option>
                          <option value="fifth edition">5</option>
                          <option value="sixth edition">6</option>
                          <option value="seventh edition">7</option>
                          <option value="eightth edition">8</option>
                        </select>
                        <label for="edition">Edition</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="no_of_pages" placeholder="244" min="1" required>
                        <label for="no_of_pages">Number of pages</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="weight" placeholder="0.5" min="0.1" step="any"
                          required>
                        <label for="weight">Weight (KG)</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="country_of_origin"
                          placeholder="India / United Kingdom" required>
                        <label for="country_of_origin">Country of origin</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <select class="form-control" name="book_condition">
                          <option value="New">New</option>
                          <option value="Old">Old</option>
                        </select>
                        <label for="book_condition">Book Condition</label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating mb-3">
                        <input type="number" class="form-control" name="available_qty" placeholder="Available quantity"
                          min="1" value="1" required>
                        <label for="available_qty">Available Quantity</label>
                      </div>
                    </div>
                    
                    <div class="col-sm-12 row p-4">
                      <div class="form-check col">
                        <input type="checkbox" class="form-check-input sale_type" data-type="saleinp" name="for_purchase" value="true">
                        <label for="for_purchase" class="form-check-label">For sell ?</label>
                      </div>
                      <div class="col">
                        <input type="number" class="form-control saleinp" name="mrp" placeholder="Purchase MRP" min="0"
                          value="0" readonly>
                        <label for="mrp">Purchase MRP</label>
                      </div>
                      <div class="col">
                        <input type="number" class="form-control saleinp" name="selling_price" placeholder="Purchase Selling Price" min="0"
                          value="0" readonly>
                        <label for="selling_price">Purchase Selling Price</label>
                      </div>
                    </div>
                    <div class="col-sm-12 row p-4">
                      <div class="form-check col">
                        <input type="checkbox" class="form-check-input sale_type" data-type="rentinp" name="for_rent" value="true">
                        <label for="for_rent" class="form-check-label">For rent ?</label>
                      </div>
                      <div class="col">
                        <input type="number" class="form-control rentinp" name="rent_mrp" placeholder="Rent MRP" min="0"
                          value="0" readonly>
                        <label for="rent_mrp">Rent MRP / Day</label>
                      </div>
                      <div class="col">
                        <input type="number" class="form-control rentinp" name="rent_sp" placeholder="Purchase Selling Price" min="0"
                          value="0" readonly>
                        <label for="rent_sp">Rent Selling Price / Day</label>
                      </div>
                    </div>
                    <div class="col-sm-12 row p-4">
                      <div class="form-check col">
                        <input type="checkbox" class="form-check-input sale_type" data-type="swapinp" name="for_swapping" value="true">
                        <label for="for_swapping" class="form-check-label">For swapping ?</label>
                      </div>
                      <div class="col">
                        <input type="number" class="form-control swapinp" name="swap_mrp" placeholder="Swap MRP" min="0"
                          value="0" readonly>
                        <label for="swap_mrp">Swap MRP</label>
                      </div>
                      <div class="col">
                        <input type="number" class="form-control swapinp" name="swap_sp" placeholder="Swap Selling Price" min="0"
                          value="0" readonly>
                        <label for="swap_sp">Swap Selling Price</label>
                      </div>
                    </div>
                    
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <textarea class="form-control" name="short_description" maxlength="950" rows="3"
                          required></textarea>
                        <label for="short_description">Short description (max 950)</label>
                      </div>
                    </div>
                    <div class="col-sm-12">
                      <div class="mb-3">
                        <textarea class="form-control" name="long_description" id="summernote"
                          maxlength="4950"></textarea>
                        <label for="long_description">Long description (max 4950)</label>
                      </div>
                    </div>
                    <div>
                      <div class="row">
                        <div class="col-10"></div>
                        <div class="col-2">
                          <button type="button" class="btn btn-sm btn-outline-primary" id="add_image_div">Add More
                            Image</button>
                          <input type="hidden" value="1" id="image_count" name="image_count" />
                        </div>
                      </div>
                      <div class="image_divs">
                        <div class="row book_image_div1 mb-3">
                          <div class="col-sm-8">
                            <div class="form-floating mb-3">
                              <input type="file" class="form-control image_change" data-outDiv="book_image1_out"
                                name="book_image1" id="book_image1" accept="image/*" placeholder="Image" required>
                              <label for="book_image1"> Image 1</label>
                            </div>
                          </div>
                          <div class="col-sm-3 book_image1_out">

                          </div>
                        </div>
                      </div>
                      <div class="row d-none delete_btn_div">
                        <div class="col-10"></div>
                        <div class="col-2">
                          <button type="button" class="btn btn-sm btn-outline-danger"
                            id="remove_image_div">Delete</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <br />
                  <center><button type="submit" class="btn btn-success" name="submit">Add Book</button></center>
                </form>
              </div>
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

      $(".sale_type").change(function () {
        const curType = $(this).attr("data-type");
        if(curType != "") {
          if ($(this).is(':checked')) {
            $("."+curType).removeAttr("readonly");
            $("."+curType).attr("required", true);
          } else {
            $("."+curType).removeAttr("required");
            $("."+curType).attr("readonly", true);
          }
        }
      });

    });
  </script>
</body>

</html>