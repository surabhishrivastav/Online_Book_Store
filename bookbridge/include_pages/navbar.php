<?php
include("head.php");
$regmessage = "";
$regmessage_class = ""; // alert-success / alert-danger / alert-warning

if(isset($_POST["signup"])) {
  if(isset($_POST["user_name"]) && isset($_POST["email_id"]) && isset($_POST["regpassword"]) && isset($_POST["cnfpassword"])) {
    if($_POST["user_name"] != "" && $_POST["email_id"] != "" && $_POST["regpassword"] != "" && $_POST["cnfpassword"] != "") {
      if($_POST["regpassword"] === $_POST["cnfpassword"]) {
        $email_id = $_POST["email_id"];
        $checkAlready = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$email_id'");
        if(mysqli_num_rows($checkAlready) == 0) {
          $name = $_POST["user_name"];
          $password = $_POST["regpassword"];
          $query_in = "INSERT INTO `users`(`name`, `email`, `password`, `reg_on`) VALUES('$name', '$email_id', '$password', '$current_date_time')";
          if(mysqli_query($con, $query_in)) {
            $user_id = mysqli_insert_id($con);
            $userLogin["id"] = $user_id;
            $userLogin["name"] = $name;
            $userLogin["email"] = $email_id;
            $userLogin["contact_no"] = "";
            $userLogin["pro_pic"] = "";
            $userLogin["is_verified"] = "false";
            $_SESSION["userLogin"] = $userLogin;
            $regmessage = "Registered Successfully";
            $regmessage_class = "alert-success";
            header("Location: index");
          }
        } else {
          $regmessage = "You are already registered, please try logging in";
          $regmessage_class = "alert-danger";
        }
      } else {
        $regmessage = "Passwords not matched";
        $regmessage_class = "alert-danger";
      }
    } else {
      $regmessage = "Please fill all fields";
      $regmessage_class = "alert-danger";
    }
  } else {
    $regmessage = "Please fill all fields";
    $regmessage_class = "alert-danger";
  }
}

$logmessage = "";
$logmessage_class = ""; // alert-success / alert-danger / alert-warning
if(isset($_POST["signin"])) {
  if(isset($_POST["logemail_id"]) && isset($_POST["logpassword"])) {
    if($_POST["logemail_id"] != "" && $_POST["logpassword"] != "") {
      $email_id = $_POST["logemail_id"];
      $password = $_POST["logpassword"];
      $getUser = mysqli_query($con, "SELECT * FROM `users` WHERE `email`='$email_id' AND role='user'");
      if(mysqli_num_rows($getUser) > 0) {
        $userData = mysqli_fetch_assoc($getUser);
        if($password == $userData["password"]) {
          
          $_SESSION["userLogin"] = $userData;
          $logmessage = "Logged Successfully";
          $logmessage_class = "alert-success";
          header("Location: index");
        } else {
          $logmessage = "Wrong password";
          $logmessage_class = "alert-warning";
        }
      } else {
        $logmessage = "Email id not registered";
        $logmessage_class = "alert-danger";
      }
    } else {
      $logmessage = "Please fill all fields";
      $logmessage_class = "alert-danger";
    }
  } else {
    $logmessage = "Please fill all fields";
    $logmessage_class = "alert-danger";
  }
}
if(!isset($cur_page)) {
  $cur_page = "";
}
?>

<!-- Navbar Start -->
<div id="baseUrlDiv" data-url="<?=$baseUrl ?>"></div>
<div class="container-fluid bg-dark ">
  <div class="row ">
    <div class="col-lg-2 d-none d-lg-block">
      <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
        <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
        <i class="fa fa-angle-down text-dark"></i>
      </a>
      <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
        <div class="navbar-nav w-100">
          <?php
          $get_category_query = "SELECT `id`,`name` FROM `category` WHERE `status`='active' ORDER BY `name` ASC";
          $get_category_run = mysqli_query($con, $get_category_query);
          if (mysqli_num_rows($get_category_run) > 0) {
            while ($categoryData = mysqli_fetch_assoc($get_category_run)) {
              $cat_name = $categoryData["name"];
              $cat_id = $categoryData["id"];
          ?>
              <a href="<?=$baseUrl ?>/shop?category=<?=$cat_id ?>" class="nav-item nav-link"><?= $cat_name ?></a>
          <?php
            }
          }
          ?>
        </div>
      </nav>
    </div>
    <div class="col-lg-10">
      <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-1 py-lg-0 px-0">
        <a href="<?=$baseUrl ?>" class="text-decoration-none d-block d-lg-none">
          <span class="h1 text-uppercase text-dark bg-light px-2">Book</span>
          <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Brigde</span>
        </a>
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
          <div class="navbar-nav mr-auto py-0">
            <a href="<?=$baseUrl ?>" class="nav-item nav-link <?php if($cur_page == "home") { echo "active"; } ?>">Home</a>
            <a href="<?=$baseUrl ?>/shop" class="nav-item nav-link <?php if($cur_page == "shop") { echo "active"; } ?>">Shop</a>
            <span class="d-block d-lg-none"><button type="button" class="btn btn-sm text-white" data-toggle="modal" data-target="#loginModal">
            <i class="far fa-user"></i> Login</button></span>
            <?php
            if (isset($_SESSION["userLogin"])) {
            ?>
            <div class="d-block d-lg-none">
              <a class="nav-link" href="<?=$baseUrl ?>/my_account">My account</a>
              <a class="nav-link" href="<?=$baseUrl ?>/my_account/profile">Profile</a>
              <a class="nav-link" href="<?=$baseUrl ?>/my_account/documents">My Documents</a>
              <a class="nav-link" href="<?=$baseUrl ?>/order">Orders</a>
              <a class="nav-link" href="<?=$baseUrl ?>/my_account/my_books">My Books</a>
            </div>
            <?php }
            ?>
          </div>
          <a href="<?=$baseUrl ?>" class="text-decoration-none d-none d-lg-block mr-5">
            <span class="h1 text-uppercase text-dark bg-light px-2">Book</span>
            <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Brigde</span>
            <span><button type="button" class="btn btn-sm text-dark" data-toggle="modal" data-target="#loginModal">
            <i class="far fa-user"></i>
          </button></span>
          </a>
          <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
            <!-- <a href="" class="btn px-0">
              <i class="fas fa-heart text-primary"></i>
              <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
            </a>
            <a href="" class="btn px-0 ml-3">
              <i class="fas fa-shopping-cart text-primary"></i>
              <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
            </a> -->
            <span class="ml-5"></span>
            <?php
            if (isset($_SESSION["userLogin"])) {
            ?>
              <div class="btn-group">
                <button type="button" class="btn btn-sm text-secondary dropdown-toggle" data-toggle="dropdown">
                  <i class="far fa-user"></i> <?=$_SESSION["userLogin"]["name"] ?>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="<?=$baseUrl ?>/my_account">My account</a>
                  <a class="dropdown-item" href="<?=$baseUrl ?>/my_account/profile">Profile</a>
                  <a class="dropdown-item" href="<?=$baseUrl ?>/my_account/documents">My Documents</a>
                  <a class="dropdown-item" href="<?=$baseUrl ?>/order">Orders</a>
                  <a class="dropdown-item" href="<?=$baseUrl ?>/my_account/my_books">My Books</a>
                  <button class="dropdown-item logout" type="button">Sign out</button>
                </div>
              </div>
            <?php
            } else {
            ?>
              <button type="button" class="btn btn-sm text-secondary" data-toggle="modal" data-target="#loginModal">
                <i class="far fa-user"></i> Login
              </button>
            <?php
            }
            ?>
          </div>
        </div>
      </nav>
    </div>
  </div>
</div>
<!-- Navbar End -->

<?php
if (!isset($_SESSION["userLogin"])) {
?>
  <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="">
          <div class="modal-body">
            <?php
              if ($logmessage != "") {
                ?>
                  <div class="alert <?= $logmessage_class ?>" role="alert">
                    <?= $logmessage ?>
                  </div>
                <?php
              }
            ?>
            <div class="form-group">
              <label for="logemail_id">Email address</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="emailid_addon">
                    <i class="fas fa-envelope"></i>
                  </span>
                </div>
                <input type="email" class="form-control" name="logemail_id" placeholder="example@example.com" id="logemail_id" aria-describedby="emailid_addon" <?php if(isset($_POST["logemail_id"])) { echo 'value="'.$_POST["logemail_id"].'"'; } ?> required>
              </div>
            </div>
            <div class="form-group">
              <label for="logpassword">Password</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text toggle_pass_visiblity" id="password_addon" data-fieldClass="loginpassword_field">
                    <i class="far fa-eye"></i>
                  </span>
                </div>
                <input type="password" class="form-control loginpassword_field" name="logpassword" placeholder="john@77547" aria-describedby="password_addon" <?php if(isset($_POST["logpassword"])) { echo 'value="'.$_POST["logpassword"].'"'; } ?> required>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button type="button" class="btn btn-primary col-3" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">Signup</button>
            <div class="d-flex justify-content-end col-8 pl-0 pr-0">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary" name="signin">Login</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalModalLabel">Register</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form method="POST" action="">
          <div class="modal-body">
            <?php
              if ($regmessage != "") {
                ?>
                  <div class="alert <?= $regmessage_class ?>" role="alert">
                    <?= $regmessage ?>
                  </div>
                <?php
              }
            ?>
            <div class="form-group">
              <label for="user_name">Name</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="user_name_addon">
                    <i class="fas fa-user"></i>
                  </span>
                </div>
                <input type="text" class="form-control" name="user_name" placeholder="John" id="user_name" <?php if(isset($_POST["user_name"])) { echo 'value="'.$_POST["user_name"].'"'; } ?> aria-describedby="user_name_addon" required>
              </div>
            </div>
            <div class="form-group">
              <label for="email_id">Email address</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text" id="emailid_addon">
                    <i class="fas fa-envelope"></i>
                  </span>
                </div>
                <input type="email" class="form-control" name="email_id" placeholder="example@example.com" id="email_id" aria-describedby="emailid_addon" <?php if(isset($_POST["email_id"])) { echo 'value="'.$_POST["email_id"].'"'; } ?> required>
              </div>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text toggle_pass_visiblity" id="regpassword" data-fieldClass="regpassword_field">
                    <i class="far fa-eye"></i>
                  </span>
                </div>
                <input type="password" class="form-control regpassword_field" name="regpassword" placeholder="john@77547" aria-describedby="regpassword" <?php if(isset($_POST["regpassword"])) { echo 'value="'.$_POST["regpassword"].'"'; } ?> required>
              </div>
            </div>
            <div class="form-group">
              <label for="cnfpassword">Confirm password</label>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text toggle_pass_visiblity" id="cnfpassword_addon" data-fieldClass="cnfpassword_field">
                    <i class="far fa-eye"></i>
                  </span>
                </div>
                <input type="password" class="form-control cnfpassword_field" name="cnfpassword" placeholder="john@77547" aria-describedby="cnfpassword_addon" <?php if(isset($_POST["cnfpassword"])) { echo 'value="'.$_POST["cnfpassword"].'"'; } ?> required>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="signup">Signup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
<?php
  if(isset($_POST["signup"])) {
    ?>
    <script>
      $(document).ready(function(){
        $("#registerModal").modal("show");
      });
    </script>
    <?php
  }

  if(isset($_POST["signin"])) {
    ?>
    <script>
      $(document).ready(function(){
        $("#loginModal").modal("show");
      });
    </script>
    <?php
  }
}
?>