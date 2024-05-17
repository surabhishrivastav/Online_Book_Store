<?php
if(!isset($userName)) {
  $userName = "";
}

if(!isset($userPic)) {
  $userPic = $baseUrl."/images/pro_pic/blank-user.png";;
}
?>
<nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
  <a href="<?=$baseUrl ?>/admin/" class="navbar-brand d-flex d-lg-none me-4">
    <h2 class="text-primary mb-0"><i class="fas fa-book me-2"></i></h2>
  </a>
  <a href="#" class="sidebar-toggler flex-shrink-0">
    <i class="fa fa-bars"></i>
  </a>
  
  <div class="navbar-nav align-items-center ms-auto">
    
    <div class="nav-item dropdown">
      <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
        <img class="rounded-circle me-lg-2" src="<?=$userPic ?>" alt="" style="width: 40px; height: 40px;">
        <span class="d-none d-lg-inline-flex"><?=$userName ?></span>
      </a>
      <div class="dropdown-menu dropdown-menu-end bg-light border-0 rounded-0 rounded-bottom m-0">
        <a href="#" class="dropdown-item">My Profile</a>
        <a href="#" class="dropdown-item">Settings</a>
        <a href="#" class="dropdown-item logout">Log Out</a>
      </div>
    </div>
  </div>
</nav>
<span id="baseUrlDiv" data-url="<?=$baseUrl ?>/admin"></span>