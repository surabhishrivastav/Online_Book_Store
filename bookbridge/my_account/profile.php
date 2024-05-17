<?php
include("../connection.php");
if(!isset($_SESSION["userLogin"])) {
  header("Location: " . $baseUrl);
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
        <span><a href="<?= $baseUrl ?>/my_account/profile">Profile</a></span>
      </div>
    </div>
  </div>
</div>
<?php
include("../include_pages/footer.php");
?>