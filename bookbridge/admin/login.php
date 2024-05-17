<?php
  include("../connection.php");
?>
<!DOCTYPE html>
<html lang="en">
<?php 
  $title = "BookBridge - Admin Login";
  
  include("head.php");
  $message = "";
  $message_class = ""; // alert-success / alert-danger / alert-warning
  if(isset($_POST["logIn"])) {
    if (isset($_POST["adminEmail"]) && isset($_POST["adminPass"])) {
      if($_POST["adminEmail"] != "" && $_POST["adminPass"] != "") {
        $email = $_POST["adminEmail"];
        $pass = $_POST["adminPass"];
        $query_login = "SELECT * FROM users WHERE email='$email' AND password='$pass' AND role='admin' AND status='active'";
        $query_run = mysqli_query($con, $query_login);
        if(mysqli_num_rows($query_run) > 0) {
          $userData = mysqli_fetch_assoc($query_run);
          $message = "Logged In Successfully";
          $message_class = "alert-success";
          $_SESSION["adminData"] = $userData;
          header("Location: index");
        } else {
          $message = "Email or password not valid";
          $message_class = "alert-danger";
        }
      } else {
        $message = "Please fill your credentials";
        $message_class = "alert-danger";
      }
    } else {
      $message = "Please fill your credentials";
      $message_class = "alert-danger";
    }
  }
?>

<body>
  <div class="container-xxl position-relative bg-white d-flex p-0">

    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
      <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
          <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <a href="#" class="">
                <h3 class="text-primary">Admin</h3>
              </a>
              <h3>Log In</h3>
            </div>
            <form method="POST">
              <?php 
                if($message != "") {
                  ?>
                  <div class="alert <?=$message_class ?>" role="alert">
                    <?=$message ?>
                  </div>
                  <?php
                }
              ?>
              <div class="form-floating mb-3">
                <input type="email" class="form-control" id="adminEmail" name="adminEmail" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
              </div>
              <div class="form-floating mb-4">
                <input type="password" class="form-control" id="adminPass" name="adminPass" placeholder="Password">
                <label for="floatingPassword">Password</label>
              </div>
              <button type="submit" name="logIn" class="btn btn-primary py-3 w-100 mb-4">Sign In</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php include("alljs.php") ?>
</body>

</html>