<?php
include("../connection.php");
if(!isset($_SESSION["userLogin"])) {
  header("Location: " . $baseUrl);
}
$user_id = $_SESSION["userLogin"]["id"];
if (!isset($_GET["order"])) {
  header("Location: " . $baseUrl . "/order");
  exit();
}
$order_id = $_GET["order"];
$get_order_query = mysqli_query($con, "SELECT `orders`.*, `area`.name AS area_name FROM `orders` INNER JOIN `area` ON `area`.id=`orders`.order_area_id WHERE `orders`.user_id='$user_id' AND `orders`.order_id='$order_id'");
$orderData = mysqli_fetch_assoc($get_order_query);
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
    if (file_exists("../images/product/" . $image_name)) {
      $image_link = $baseUrl . "/images/product/" . $image_name;
    }
  }
}
$order_status = $orderData["status"];
if($order_status == "cancelled") {
  $order_status = '<span class="text-danger">Cancelled</span>';
}
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
        <span><a href="<?= $baseUrl ?>/order">Orders</a></span>
        <span><i class="fas fa-angle-right"></i></span>
        <span><a href="<?= $baseUrl ?>/detail?order=<?= $order_id ?>">(<?= $order_id ?>) Detail</a></span>
      </div>
    </div>
  </div>
  <div class="mb-5">
    <div class="p-5 bg-white">
      <div class="row">
        <div class="col-sm-6">
          Order Id: <?= $order_id ?>
        </div>
        <div class="col-sm-6">
          Order Status: <?= $order_status ?>
        </div>
        <div class="col-sm-6">
          Order Type: <?= $orderData["purchase_type"] ?>
        </div>
        <?php
          if($orderData["status"] == "cancelled") {
            ?>
            <div class="col-sm-6">
              Cancellation Reason: <?=$orderData["cancellation_reason"] ?>
            </div>
            <?php
          }
        ?>
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
          <a href="<?= $baseUrl ?>/detail?product=<?=$order_prod_id ?>"><img src="<?=$image_link ?>" style="height:100px;width:100px"></a>
        </div>
        <div class="col-sm-6">
          Name: <a href="<?= $baseUrl ?>/detail?product=<?=$order_prod_id ?>"><?=$prod_data["generic_name"] ?></a>
        </div>
        <div class="col-sm-6">
          Edition: <?=$prod_data["edition"] ?>
        </div>
        <div class="col-sm-6">
          Language: <?=$prod_data["language"] ?>
        </div>
        <div class="col-sm-6">
          No. Of Pages: <?=$prod_data["no_of_pages"] ?>
        </div>
        <div class="col-sm-6">
          Weight: <?=$prod_data["weight"] ?>
        </div>
        <div class="col-sm-6">
          Price: <?=$orderData["selling_price"] ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include("../include_pages/footer.php");
?>