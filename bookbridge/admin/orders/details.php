<?php
include_once("../../connection.php");
if (!$_SESSION["adminData"]) {
  header("Location: " . $baseUrl . "/admin/login");
  die();
}

if (!isset($_GET["order"])) {
  header("Location: " . $baseUrl . "/admin/orders");
  die();
}
$adminId = $_SESSION["adminData"]["id"];
$order_id = $_GET["order"];
$message = "";
$message_class = ""; // alert-success / alert-danger / alert-warning
if (isset($_GET["update_status"])) {
  $order_id = $_GET["order"];
  $update_status = $_GET["update_status"];
  if (mysqli_query($con, "UPDATE orders SET status='$update_status' WHERE order_id='$order_id'")) {
    $message = "Order status updated";
    $message_class = "alert-success";
  } else {
    $message = "Please try again later";
    $message_class = "alert-danger";
  }
}

if(isset($_POST["update"])) {
  if(isset($_POST["cancel_reason"])) {
    $cancel_reason = $_POST["cancel_reason"];
    if($cancel_reason != "") {
      if (mysqli_query($con, "UPDATE orders SET `status`='cancelled', `updated_on`='$current_date_time', `cancelled_by`='$adminId', `cancellation_reason`='$cancel_reason' WHERE order_id='$order_id'")) {
        $message = "Order Cancelled";
        $message_class = "alert-success";
      } else {
        $message = "Please try again later";
        $message_class = "alert-danger";
      }
    } else {
      $message = "Please specify reason";
      $message_class = "alert-danger";
    }
  } else {
    $message = "Please specify reason";
    $message_class = "alert-danger";
  }
}

$get_order_query = "SELECT `orders`.*, `area`.name AS area_name FROM `orders` INNER JOIN `area` ON `area`.id=`orders`.order_area_id WHERE `orders`.order_id='$order_id'";
$get_order_run = mysqli_query($con, $get_order_query);
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
    $cur_page = "orders";
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
              <span><a href="<?= $baseUrl ?>/admin/orders">Orders</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span><a href="<?= $baseUrl ?>/admin/orders/details?order=<?= $order_id ?>">(<?= $order_id ?>) Details</a></span>
            </div>
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
              <div class="mt-3">
                <?php
                if (mysqli_num_rows($get_order_run) > 0) {
                  $orderData = mysqli_fetch_assoc($get_order_run);
                  $orderStatus = $orderData["status"];
                  $order_prod_id = $orderData["product_id"];
                  $get_prod_query = mysqli_query($con, "SELECT `product`.*, `category`.`name` AS category_name FROM `product` INNER JOIN `category` ON `product`.category_id=`category`.id WHERE `product`.id='$order_prod_id'");
                  $prod_data = mysqli_fetch_assoc($get_prod_query);

                  $getImage_query = "SELECT * FROM `product_images` WHERE `product_id`='$order_prod_id' AND `status`='active' ORDER BY id ASC LIMIT 1";
                  $getImage = mysqli_query($con, $getImage_query);
                  if (mysqli_num_rows($getImage) > 0) {
                    $imageData = mysqli_fetch_assoc($getImage);
                    $image_name = $imageData["image_name"];
                    $image_link = "img/product-1.jpg";
                    if ($image_name != "") {
                      if (file_exists("../../images/product/" . $image_name)) {
                        $image_link = $baseUrl . "/images/product/" . $image_name;
                      }
                    }
                  }
                ?>
                  <div class="row">
                    <div class="col-sm-6">
                      Order Id: <?= $order_id ?>
                    </div>
                    <div class="col-sm-6">
                      Order Status: <?= $orderData["status"] ?>
                    </div>
                    <div class="col-sm-6">
                      Order Type: <?= $orderData["purchase_type"] ?>
                    </div>
                  </div>
                  <h6 class="mt-4">Address Detail:</h6>
                  <div class="row">
                    <div class="col-sm-6">
                      Name: <?= $orderData["order_name"] ?>
                    </div>
                    <div class="col-sm-6">
                      Contact: <?= $orderData["order_cont"] ?>
                    </div>
                    <div class="col-sm-6">
                      Address 1: <?= $orderData["order_address1"] ?>
                    </div>
                    <div class="col-sm-6">
                      Address 2: <?= $orderData["order_address2"] ?>
                    </div>
                    <div class="col-sm-6">
                      Area: <?= $orderData["area_name"] ?>
                    </div>
                    <div class="col-sm-6">
                      Landmark: <?= $orderData["order_landmark"] ?>
                    </div>
                  </div>
                  <h6 class="mt-4">Product Detail:</h6>
                  <div class="row">
                    <div class="col-sm-6">
                      <a href="<?= $baseUrl ?>/detail?product=<?= $order_prod_id ?>"><img src="<?= $image_link ?>" style="height:100px;width:100px"></a>
                    </div>
                    <div class="col-sm-6">
                      Name: <a href="<?= $baseUrl ?>/detail?product=<?= $order_prod_id ?>"><?= $prod_data["generic_name"] ?></a>
                    </div>
                    <div class="col-sm-6">
                      Edition: <?= $prod_data["edition"] ?>
                    </div>
                    <div class="col-sm-6">
                      Language: <?= $prod_data["language"] ?>
                    </div>
                    <div class="col-sm-6">
                      No. Of Pages: <?= $prod_data["no_of_pages"] ?>
                    </div>
                    <div class="col-sm-6">
                      Weight: <?= $prod_data["weight"] ?>
                    </div>
                    <div class="col-sm-6">
                      Price: <?= $orderData["selling_price"] ?>
                    </div>
                  </div>
                  <form method="POST">
                    <div class="row mt-3">
                      <div class="col-sm-6">
                        <label>Update Status : </label>
                        <select class="form-control update_status" name="update_status">
                          <option value="">Select New Status</option>
                          <option value="pending" <?php if ($orderStatus == "pending") {
                                                    echo "selected";
                                                  } ?>>Pending</option>
                          <option value="ordered" <?php if ($orderStatus == "ordered") {
                                                    echo "selected";
                                                  } ?>>Ordered</option>
                          <option value="processing" <?php if ($orderStatus == "processing") {
                                                        echo "selected";
                                                      } ?>>Processing</option>
                          <option value="cancelled" <?php if ($orderStatus == "cancelled") {
                                                      echo "selected";
                                                    } ?>>Cancelled</option>
                          <option value="delivered" <?php if ($orderStatus == "delivered") {
                                                      echo "selected";
                                                    } ?>>Delivered</option>
                        </select>
                      </div>

                      <div class="col-sm-6  mt-2 d-none cancel_reason_div">
                        <label>Cancellation Reason : </label>
                        <textarea class="form-control" name="cancel_reason" id="cancel_reason" placeholder="Cancel Reason" required></textarea>
                      </div>
                      <center><button type="submit" class="btn btn-sm btn-success mt-3 d-none cancel_reason_div" name="update">Update</button></center>
                    </div>
                  </form>
                <?php
                } else {
                ?>
                  <h6>Order not found</h6>
                <?php
                }
                ?>
              </div>
              </div>
            </div>
            <?php include("../footer.php") ?>
        </div>

        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
      </div>

      <?php include("../alljs.php") ?>
</body>
<script>
  $(document).ready(function() {
    let baseUrl = $("#baseUrlDiv").attr("data-url");
    $(".update_status").change(function() {
      event.preventDefault();
      var update_status = $(this).val();
      if (update_status != "cancelled") {
        var order_id = '<?= $order_id ?>';
        window.location.href = baseUrl + "/orders/details?order=" + order_id + "&update_status=" + update_status;
      } else {
        $(".cancel_reason_div").removeClass("d-none");
      }
    });
  });
</script>

</html>