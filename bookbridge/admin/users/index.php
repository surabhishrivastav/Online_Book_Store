<?php
include_once("../../connection.php");
if (!$_SESSION["adminData"]) {
  header("Location: " . $baseUrl . "/admin/login");
  die();
}

$message = "";
$message_class = ""; // alert-success / alert-danger / alert-warning
if (isset($_GET["block"])) {
  $user_id = $_GET["block"];
  $getData = mysqli_query($con, "SELECT * FROM `users` WHERE id='$user_id'");
  if (mysqli_num_rows($getData) > 0) {
    if (mysqli_query($con, "UPDATE `users` SET status='blocked' WHERE id='$user_id'")) {
      
      $message = "User blocked";
      $message_class = "alert-success";
    } else {
      $message = "Please try again later";
      $message_class = "alert-danger";
    }
  } else{
    $message = "User not found";
    $message_class = "alert-danger";
  }
}

if (isset($_GET["unblock"])) {
  $user_id = $_GET["unblock"];
  $getData = mysqli_query($con, "SELECT * FROM `users` WHERE id='$user_id'");
  if (mysqli_num_rows($getData) > 0) {
    if (mysqli_query($con, "UPDATE `users` SET status='active' WHERE id='$user_id'")) {
      $message = "User unblocked";
      $message_class = "alert-success";
    } else {
      $message = "Please try again later";
      $message_class = "alert-danger";
    }
  } else{
    $message = "User not found";
    $message_class = "alert-danger";
  }
}
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
    $cur_page = "users";
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
              <span><a href="<?= $baseUrl ?>/admin/users">Users</a></span>
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
          <div class="table-responsive mt-3">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">S.No</th>
                  <th scope="col">Image</th>
                  <th scope="col">Name</th>
                  <th scope="col">Email</th>
                  <th scope="col">Contact</th>
                  <th scope="col">Is Verified</th>
                  <th scope="col">Reg. On</th>
                  <th scope="col"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $i = 0;
                $get_data_query = "SELECT * FROM `users` WHERE `role`='user' AND (`status`='active' OR `status`='blocked') ORDER BY id DESC";
                $get_data_run = mysqli_query($con, $get_data_query);
                while ($data = mysqli_fetch_assoc($get_data_run)) {
                  $image_name = $data["pro_pic"];
                  $image_link = "";
                  $image_out = "";
                  if ($image_name != "") {
                    if (file_exists("../../images/pro_pic/" . $image_name)) {
                      $image_link = $baseUrl . "/images/pro_pic/" . $image_name;
                      $image_out = '
                        <a href="' . $image_link . '" target="_blank">
                          <img src="' . $image_link . '" height="50" width="50" class="rounded">
                        </a>';
                    }
                  }
                ?>
                  <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $image_out ?> </td>
                    <td><?= $data["name"] ?></td>
                    <td><?= $data["email"] ?></td>
                    <td><?= $data["contact_no"] ?></td>
                    <td><?= $data["is_verified"] ?></td>
                    <td><?= $data["reg_on"] ?></td>
                    <td>
                      <a href="<?= $baseUrl ?>/admin/users/document?id=<?= $data["id"] ?>" class="btn btn-sm btn-outline-success">
                        <i class="far fa-file-alt"></i> Documents
                      </a>
                      <?php
                        if($data["status"] === "blocked") {
                          ?>
                            <button type="button" class="btn btn-sm btn-outline-warning update_button" data-url="<?= $baseUrl ?>/admin/users?unblock=<?= $data["id"] ?>" data-id="<?= $data["id"] ?>" data-content="Are you sure you want to unblock this user ? (<?= $data["name"] ?>)" data-title="Unblock Confirmation"><i class="fas fa-check-square"></i></i> Unblock</button>
                          <?php
                        } else {
                          ?>
                            <button type="button" class="btn btn-sm btn-outline-danger update_button" data-url="<?= $baseUrl ?>/admin/users?block=<?= $data["id"] ?>" data-id="<?= $data["id"] ?>" data-content="Are you sure you want to block this user ? (<?= $data["name"] ?>)" data-title="Block Confirmation"><i class="fas fa-ban"></i> Block</button>
                          <?php
                        }
                      ?>
                      
                    </td>
                  </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <?php include("../footer.php") ?>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>

  <?php include("../alljs.php") ?>
</body>

</html>