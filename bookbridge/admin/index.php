<?php
include_once("../connection.php");
if (!$_SESSION["adminData"]) {
  header("Location: ".$baseUrl."/admin/login");
  die();
}
$users_count = 0;
$user_count_query = mysqli_query($con, "SELECT COUNT(*) AS user_count FROM users");
$user_count_row = mysqli_fetch_assoc($user_count_query);
$users_count = $user_count_row["user_count"];

$order_count = 0;
$order_count_query = mysqli_query($con, "SELECT COUNT(*) AS order_count FROM orders");
$order_count_row = mysqli_fetch_assoc($order_count_query);
$order_count = $order_count_row["order_count"];

$book_purchase_count = 0;
$book_purchase_count_query = mysqli_query($con, "SELECT COUNT(*) AS book_purchase_count FROM product WHERE for_purchase='true'");
$book_purchase_count_row = mysqli_fetch_assoc($book_purchase_count_query);
$book_purchase_count = $book_purchase_count_row["book_purchase_count"];

$book_rent_count = 0;
$book_rent_count_query = mysqli_query($con, "SELECT COUNT(*) AS book_rent_count FROM product WHERE for_rent='true'");
$book_rent_count_row = mysqli_fetch_assoc($book_rent_count_query);
$book_rent_count = $book_rent_count_row["book_rent_count"];

$book_swap_count = 0;
$book_swap_count_query = mysqli_query($con, "SELECT COUNT(*) AS book_swap_count FROM product WHERE for_swapping='true'");
$book_swap_count_row = mysqli_fetch_assoc($book_swap_count_query);
$book_swap_count = $book_swap_count_row["book_swap_count"];
?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php") ?>

<body>
  <div class="container-xxl position-relative bg-white d-flex p-0">

    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
      <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <?php 
      $cur_page = "dashboard";
      include("sidebar.php")
    ?>

    <div class="content">
      <?php include("navbar.php") ?>
      <div style="min-height: 75vh;">
        <div class="container-fluid pt-4 px-4">
          <div class="row mb-3">
            <span><a href="index">Dashboard</a></span>
          </div>
          <div class="row g-4">
            <div class="col-sm-6 col-xl-3 urlDiv" data-curUrl="<?=$baseUrl ?>/admin/orders">
              <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                
                <i class="fas fa-store fa-3x text-primary"></i>
                <div class="ms-3">
                  <p class="mb-2">Total Orders</p>
                  <h6 class="mb-0"><?=$order_count ?></h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3 urlDiv" data-curUrl="<?=$baseUrl ?>/admin/users">
              <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-users fa-3x text-primary"></i>
                <div class="ms-3">
                  <p class="mb-2">Registered Users</p>
                  <h6 class="mb-0"><?=$users_count ?></h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-book fa-3x text-success"></i>
                <div class="ms-3">
                  <p class="mb-2">Books For Sale</p>
                  <h6 class="mb-0"><?=$book_purchase_count ?></h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-book fa-3x text-primary"></i>
                <div class="ms-3">
                  <p class="mb-2">Books For Rent</p>
                  <h6 class="mb-0"><?=$book_rent_count ?></h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-book fa-3x text-info"></i>
                <div class="ms-3">
                  <p class="mb-2">Books For Swap</p>
                  <h6 class="mb-0"><?=$book_swap_count ?></h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-book fa-3x text-success"></i>
                <div class="ms-3">
                  <p class="mb-2">Sale Request</p>
                  <h6 class="mb-0">0</h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-book fa-3x text-primary"></i>
                <div class="ms-3">
                  <p class="mb-2">Rent Request</p>
                  <h6 class="mb-0">0</h6>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-xl-3">
              <div class="bg-light rounded d-flex align-items-center justify-content-between p-4">
                <i class="fas fa-book fa-3x text-info"></i>
                <div class="ms-3">
                  <p class="mb-2">Swap Request</p>
                  <h6 class="mb-0">0</h6>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php include("footer.php") ?>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>
  <?php include("alljs.php") ?>
</body>
<script>
  $(document).ready(function() {
    $(".urlDiv").click(function() {
      var curUrl = $(this).attr("data-curUrl");
      if(curUrl != "") {
        window.location.href = curUrl;
      }
    });
  });
</script>
</html>