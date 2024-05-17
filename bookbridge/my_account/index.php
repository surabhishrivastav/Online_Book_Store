<?php
include("../connection.php");
if(!isset($_SESSION["userLogin"])) {
  header("Location: " . $baseUrl);
}
include("../include_pages/navbar.php");
$profile_verified = "false";
$user_id = $_SESSION["userLogin"]["id"];
$get_profile_data = mysqli_query($con, "SELECT * FROM `users` WHERE id='$user_id'");
$profile_data = mysqli_fetch_assoc($get_profile_data);
$profile_status = "<span class='text-danger'>Not Verified</span>";
if($profile_data["is_verified"] == "true") {
  $profile_status = "<span class='text-success'>Verified</span>";
}

$order_count = 0;
$order_count_query = mysqli_query($con, "SELECT COUNT(*) AS order_count FROM orders WHERE user_id='$user_id'");
$order_count_row = mysqli_fetch_assoc($order_count_query);
$order_count = $order_count_row["order_count"];

$doc_submitted_count_query = mysqli_query($con, "SELECT COUNT(*) AS submitted_doc_count FROM user_doc WHERE user_id='$user_id'");
$doc_submitted_count_row = mysqli_fetch_assoc($doc_submitted_count_query);
$submitted_doc_count = $doc_submitted_count_row["submitted_doc_count"];

$doc_verified_count_query = mysqli_query($con, "SELECT COUNT(*) AS verified_doc_count FROM user_doc WHERE user_id='$user_id' AND is_verified='true'");
$doc_verified_count_row = mysqli_fetch_assoc($doc_verified_count_query);
$verified_doc_count = $doc_verified_count_row["verified_doc_count"];
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
      </div>
    </div>
  
  </div>
  <div class="pt-5">
    Profile Status <?=$profile_status ?>
    <div class="row pt-2">
      <div class="col-sm-4">
        <div class="card rounded">
          <div class="card-body">
            <h5 class="card-title">Orders</h5>
            <p class="card-text">Total orders by me : <b><?=$order_count ?></b></p>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card rounded">
          <div class="card-body">
            <h5 class="card-title">Documents</h5>
            <p class="card-text">
              <p>Documents Submitted : <b><?=$submitted_doc_count ?></b></p>
              <p>Documents Verified : <b><?=$verified_doc_count ?></b></p>
            </p>
          </div>
        </div>
      </div>
      <div class="col-sm-4">
        <div class="card rounded">
          <div class="card-body">
            <h5 class="card-title">My Books</h5>
            <p class="card-text">
              <p>Books Submited : <b>0</b></p>
              <p>Books Approved : <b>0</b></p>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include("../include_pages/footer.php");
?>