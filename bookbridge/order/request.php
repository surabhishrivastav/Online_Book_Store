<?php
include("../connection.php");
if (!isset($_SESSION["userLogin"])) {
  header("Location: " . $baseUrl);
}
if (!isset($_GET["product"]) || !isset($_SESSION["userLogin"])) {
  header("Location: " . $baseUrl . "/shop");
  exit();
}
$user_data = $_SESSION["userLogin"];


if (!isset($_GET["product"])) {
  header("Location: " . $baseUrl . "/shop");
  exit();
}

$prod_id = $_GET["product"];
if (!isset($_GET["type"])) {
  header("Location: " . $baseUrl . "/detail?product=" . $prod_id);
  exit();
}
$allowed_types = array("rent", "swap", "sale");
if (!in_array($_GET["type"], $allowed_types)) {
  header("Location: " . $baseUrl . "/detail?product=" . $prod_id);
}

$get_data_query = "SELECT `product`.*, `category`.`name` AS category_name FROM `product` INNER JOIN `category` ON `product`.category_id=`category`.id WHERE `product`.id='$prod_id'";
$get_data_run = mysqli_query($con, $get_data_query);
if (mysqli_num_rows($get_data_run) == 0) {
  header("Location: " . $baseUrl . "/shop");
  exit();
}
$prod_data = mysqli_fetch_assoc($get_data_run);
$for_purchase = $prod_data["for_purchase"];
$for_rent = $prod_data["for_rent"];
$for_swapping = $prod_data["for_swapping"];
/* if ($for_purchase != "true") {
  header("Location: " . $baseUrl . "/detail?product=" . $prod_id);
  exit();
} */

function generateCustomOrderID($prefix = 'OD-', $segment1Length = 5, $separator = '-', $segment2Length = 5, $segment3Length = 5)
{
  $characters = '0123456789';
  $charactersLength = strlen($characters);
  $segment1 = '';
  $segment2 = '';
  $segment3 = '';
  for ($i = 0; $i < $segment1Length; $i++) {
    $segment1 .= $characters[rand(0, $charactersLength - 1)];
  }
  for ($i = 0; $i < $segment2Length; $i++) {
    $segment2 .= $characters[rand(0, $charactersLength - 1)];
  }
  for ($i = 0; $i < $segment3Length; $i++) {
    $segment3 .= $characters[rand(0, $charactersLength - 1)];
  }
  $orderID = $prefix . $segment1 . $separator . $segment2 . $separator . $segment3;
  return $orderID;
}

$req_type = "Buy";
$prod_mrp = $prod_data["mrp"];
$prod_sp = $prod_data["selling_price"];
if ($_GET["type"] == "swap") {
  $req_type = "Swap";
  $prod_mrp = $prod_data["swap_mrp"];
  $prod_sp = $prod_data["swap_sp"];
} else if ($_GET["type"] == "rent") {
  $req_type = "Rent";
  $prod_mrp = $prod_data["rent_mrp"];
  $prod_sp = $prod_data["rent_sp"];
}

$profile_verified = "false";
$user_id = $_SESSION["userLogin"]["id"];
$get_profile_data = mysqli_query($con, "SELECT * FROM `users` WHERE id='$user_id'");
$profile_data = mysqli_fetch_assoc($get_profile_data);
$profile_status = "<span class='text-danger'>Not Verified</span>";
if ($profile_data["is_verified"] == "true") {
  $profile_verified = "true";
  $profile_status = "<span class='text-success'>Verified</span>";
}

$take_request = false;
if ($req_type == "Buy") {
  $take_request = true;
} else if ($profile_verified == "true") {
  $take_request = true;
}

$message = "";
$message_class = "";

if (isset($_POST["order"])) {
  if (isset($_POST["order_name"]) && isset($_POST["order_cont"]) && isset($_POST["order_address1"]) && isset($_POST["order_address2"]) && isset($_POST["order_city"]) && isset($_POST["order_area"]) && isset($_POST["order_pincode"])) {
    $order_name = $_POST["order_name"];
    $order_cont = $_POST["order_cont"];
    $order_address1 = $_POST["order_address1"];
    $order_address2 = $_POST["order_address2"];
    $order_city = $_POST["order_city"];
    $order_area = $_POST["order_area"];
    $order_landmark = "";
    if (isset($_POST["order_landmark"])) {
      $order_landmark = $_POST["order_landmark"];
    }
    $order_pincode = $_POST["order_pincode"];
    $order_id = generateCustomOrderID();
    $purchase_type = $_GET["type"];
    $query_in = "INSERT INTO `orders`(`order_id`, `user_id`, `product_id`, `purchase_type`, `mrp`, `selling_price`, `order_name`, `order_cont`, `order_address1`, `order_address2`, `order_area_id`, `order_landmark`, `order_pincode`, `added_on`, `updated_on`) VALUES('$order_id', '$user_id', '$prod_id', '$purchase_type', '$prod_mrp', '$prod_sp', '$order_name', '$order_cont', '$order_address1', '$order_address2', '$order_area', '$order_landmark', '$order_pincode', '$current_date_time', '$current_date_time')";
    if (mysqli_query($con, $query_in)) {
      $message = "Thank you !. <br> Your " . $req_type . " request for " . $prod_data["generic_name"] . " has been taken successfully.<br>You will be redirected to <a href='" . $baseUrl . "/my_account/orders'>your orders</a> in 5 seconds.";
      $message_class = "alert-success";
    } else {
      $message = "Error: " . mysqli_error($con);
      $message_class = "alert-danger";
    }
  } else {
    $message = "Please fill all required fields.";
    $message_class = "alert-danger";
  }
}


include("../include_pages/navbar.php");

?>
<div class="container-fluid">
  <div class="row px-xl-5">
    <div class="col-12">
      <nav class="breadcrumb bg-light mb-30">
        <a class="breadcrumb-item text-dark" href="<?= $baseUrl ?>">Home</a>
        <a class="breadcrumb-item text-dark" href="<?= $baseUrl ?>/shop">Books</a>
        <a class="breadcrumb-item text-dark" href="<?= $baseUrl ?>/detail?product=<?= $prod_id ?>">(<?= $prod_data["generic_name"] ?>)</a>
        <a class="breadcrumb-item active" href="<?= $baseUrl ?>/order/request?product=<?= $prod_id ?>"><?= $req_type ?> Request</a>
      </nav>
    </div>
  </div>
</div>
<div class="container pt-2" style="min-height: 83vh;">
  <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
      <span class="sr-only">Loading...</span>
    </div>
  </div>

  <div class="bg-white p-5">
    <div>Your request to <?= $req_type ?> <b><?= $prod_data["generic_name"] ?></b></div>
    <div>Price : <del class="text-muted">₹ <?= $prod_mrp ?></del> <span class="ml-2"> ₹ <?= $prod_sp ?></span></div>
    <h5 class="pt-3">Address Detail</h5>
    <?php
    if ($message != "") {
    ?>
      <div class="alert <?= $message_class ?>" role="alert">
        <?= $message ?>
      </div>
      <?php
    }
    if ($message_class != "alert-success") {
      if ($take_request) {
      ?>
        <form class="bg-white p-4" method="POST" enctype="multipart/form-data">
          <div class="row">
            <?php
            if ($req_type == "Swap") {
              $get_my_products_query = "SELECT `product`.*, `category`.`name` AS category_name FROM `product` INNER JOIN `category` ON `product`.category_id=`category`.id WHERE `product`.added_by_id='$user_id' ORDER BY `product`.id DESC";
              $get_my_products_run = mysqli_query($con, $get_my_products_query);
              if(mysqli_num_rows($get_my_products_run) > 0) {
                  
                ?>
                  <div class="col-sm-12">
                    <select class="form-control" name="swap_product_id" >
                      <option value="">Select your book to swap</option>
                      <?php
                      while($my_books = mysqli_fetch_assoc($get_my_products_run)) {
                        $cur_prod_id = $my_books["id"];
                        $getImage_query = "SELECT * FROM `product_images` WHERE `product_id`='$cur_prod_id' AND `status`='active' ORDER BY id ASC LIMIT 1";
                        $getImage = mysqli_query($con, $getImage_query);
                        if(mysqli_num_rows($getImage) > 0) {
                          $imageData = mysqli_fetch_assoc($getImage);
                          $image_name = $imageData["image_name"];
                          $image_link = "";
                          
                          if ($image_name != "") {
                            if (file_exists("../images/product/" . $image_name)) {
                              $image_link = $baseUrl . "/images/product/" . $image_name;
                            }
                          }
                        }
                        ?>
                        <option value="<?=$my_books["id"] ?>">
                          <img src="<?=$image_link ?>" style="height: 20px;width:20px;" /><?=$my_books["generic_name"] ?>
                        </option>
                        <?php
                      }
                      ?>
                    </select>
                  </div>
                <?php
              }
            }
            ?>

            <div class="col-sm-6 form-group">
              <label for="order_name">Name <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded" id="order_name" name="order_name" maxlength="150" placeholder="Name" value="<?= $user_data["name"] ?>" required>
            </div>
            <div class="col-sm-6 form-group">
              <label for="order_cont">Contact Number <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded" id="order_cont" name="order_cont" maxlength="10" placeholder="Contact Number" value="<?= $user_data["contact_no"] ?>" required>
            </div>
            <div class="col-sm-6 form-group">
              <label for="order_address1">Address Line 1 <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded" id="order_address1" name="order_address1" maxlength="200" placeholder="Address Line 1" required>
            </div>
            <div class="col-sm-6 form-group">
              <label for="order_address2">Address Line 2 <span class="text-danger">*</span></label>
              <input type="text" class="form-control rounded" id="order_address2" name="order_address2" maxlength="200" placeholder="Address Line 2" required>
            </div>
            <div class="col-sm-6 form-group">
              <label for="order_city">City <span class="text-danger">*</span></label>
              <select class="form-control rounded" id="order_city" name="order_city">
                <option value="">Select City</option>
                <?php
                $get_city_query = mysqli_query($con, "SELECT * FROM `city` WHERE `status`='active' ORDER BY `name` ASC");
                while ($city = mysqli_fetch_assoc($get_city_query)) {
                ?>
                  <option value="<?= $city["id"] ?>"><?= $city["name"] ?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="col-sm-6 form-group">
              <label for="order_area">Area <span class="text-danger">*</span></label>
              <select class="form-control rounded" id="order_area" name="order_area">
                <option value="">Select Area</option>
              </select>
            </div>
            <div class="col-sm-6 form-group">
              <label for="order_landmark">Landmark <span class="text-muted">(optional)</span></label>
              <input type="text" class="form-control rounded" id="order_landmark" name="order_landmark" maxlength="200" placeholder="Landmark">
            </div>
            <div class="col-sm-6 form-group">
              <label for="order_pincode">Pincode <span class="text-danger">*</span></label>
              <input type="number" class="form-control rounded" id="order_pincode" name="order_pincode" min="100000" max="999999" placeholder="Area Pincode" required>
            </div>
          </div>
          <div class="mt-3">
            <center><button class="btn btn-success" type="submit" name="order">Confirm Order</button></center>
          </div>
        </form>
      <?php
      } else {
      ?>
        <p class="text-danger">Your profile needs to be verified to make this request</p>
    <?php
      }
    }
    ?>
  </div>
</div>
<?php
include("../include_pages/footer.php");
if ($message_class == "alert-success") {
?>
  <script>
    $(document).ready(function() {
      let baseUrl = $("#baseUrlDiv").attr("data-url");
      setTimeout(function() {
        window.location.href = baseUrl + '/order';
      }, 5000);
    });
  </script>
<?php
}
?>
<script>
  $(document).ready(function() {
    let baseUrl = $("#baseUrlDiv").attr("data-url");
    $("#order_city").change(function() {
      let curCity = $(this).val();
      if (curCity != "") {
        $.ajax({
          type: "POST",
          url: baseUrl + "/include_pages/functions.php",
          data: {
            curCity: curCity
          },
          cache: false,
          dataType: "json",
          success: function(out) {
            console.log(out);
            $("#order_area").html(out["data"]);
          }
        });
      }
    });
  });
</script>