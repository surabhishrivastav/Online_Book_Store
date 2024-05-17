<?php
$userName = "";
$userPic = $baseUrl."/images/pro_pic/blank-user.png";
if(isset($_SESSION["userData"])) {
  if(isset($_SESSION["userData"]["name"])) {
    $userName = $_SESSION["userData"]["name"];
  }

  if(isset($_SESSION["userData"]["pro_pic"])) {
    if($_SESSION["userData"]["pro_pic"] != "") {
      $userPic = $baseUrl."/images/pro_pic/".$_SESSION["userData"]["pro_pic"];
    }
  }
}

if (!isset($cur_page)) {
  $cur_page = "dashboard";
}
?>
<div class="sidebar pe-4 pb-3">
  <nav class="navbar bg-light navbar-light">
    <a href="<?=$baseUrl ?>/admin/" class="navbar-brand mx-4 mb-3">
      <h3 class="text-primary"><i class="fas fa-book me-2"></i>BookBridge</h3>
    </a>
    <div class="d-flex align-items-center ms-4 mb-4">
      <div class="position-relative">
        <img class="rounded-circle" src="<?=$baseUrl ?>/admin/img/blank-user.png" alt="" style="width: 40px; height: 40px;">
        
      </div>
      <div class="ms-3">
        <h6 class="mb-0"><?=$userName ?></h6>
        <span>Admin</span>
      </div>
    </div>
    <div class="navbar-nav w-100">
      <a href="<?=$baseUrl ?>/admin/index" class="nav-item nav-link <?php if($cur_page == "dashboard") { echo "active"; } ?>">
        <i class="fas fa-th-large me-2"></i>Dashboard
      </a>
      <a href="<?=$baseUrl ?>/admin/categories" class="nav-item nav-link <?php if($cur_page == "category") { echo "active"; } ?>">
        <i class="fa fa-th me-2"></i>Categories
      </a>
      <a href="<?=$baseUrl ?>/admin/products" class="nav-item nav-link <?php if($cur_page == "product") { echo "active"; } ?>">
        <i class="fas fa-book me-2"></i>Books
      </a>
      <a href="<?=$baseUrl ?>/admin/users" class="nav-item nav-link <?php if($cur_page == "users") { echo "active"; } ?>">
        <i class="fas fa-users me-2"></i>Users
      </a>
      <a href="<?=$baseUrl ?>/admin/orders" class="nav-item nav-link <?php if($cur_page == "orders") { echo "active"; } ?>">
        <i class="fas fa-shopping-cart me-2"></i>Orders
      </a>
    </div>
  </nav>
</div>