<?php
include("../connection.php");
if(!isset($_SESSION["userLogin"])) {
  header("Location: " . $baseUrl);
}
$user_id = $_SESSION["userLogin"]["id"];
$get_order_query = mysqli_query($con, "SELECT `orders`.*, `product`.generic_name FROM `orders` INNER JOIN `product` ON `product`.id=`orders`.product_id WHERE `orders`.user_id='$user_id' ORDER BY `orders`.id DESC");
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
      </div>
    </div>
  </div>
  <div>
    <div class="p-5 bg-white">
      <table class="table table-bordered mt-3">
        <thead>
          <tr>
            <td>S.No</td>
            <td>Order Id</td>
            <td>Request Type</td>
            <td>Book</td>
            <td>Ordered On</td>
            <td>Status</td>
          </tr>
        </thead>
        <tbody>
          <?php
            $i = 0;
            while($orders = mysqli_fetch_assoc($get_order_query)) {
              $i++;
              ?>
              <tr>
                <td><?=$i ?></td>
                <td><a href="<?= $baseUrl ?>/order/detail?order=<?=$orders["order_id"] ?>"><?=$orders["order_id"] ?></a></td>
                <td><?=$orders["purchase_type"] ?></td>
                <td><?=$orders["generic_name"] ?></td>
                <td><?=$orders["added_on"] ?></td>
                <td><?=$orders["status"] ?></td>
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