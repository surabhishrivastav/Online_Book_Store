<?php
include_once("../../connection.php");
if (!$_SESSION["adminData"]) {
  header("Location: ".$baseUrl."/admin/login");
  die();
}

if(!isset($_GET["id"])) {
  header("Location: ".$baseUrl."/admin/users");
  die();
}
$message = "";
$message_class = ""; // alert-success / alert-danger / alert-warning
$user_id = $_GET["id"];

if(isset($_GET["verified"])) {
  $doc_id = $_GET["verified"];
  mysqli_query($con, "UPDATE user_doc SET is_verified='true' WHERE id='$doc_id'");
  $message = "Document marked verified";
  $message_class = "alert-success";
  
  echo '<script>window.location.href = "'.$baseUrl.'/admin/users/document?id='.$user_id.'";</script>';
}

if(isset($_GET["notverified"])) {
  $doc_id = $_GET["notverified"];
  mysqli_query($con, "UPDATE user_doc SET is_verified='false' WHERE id='$doc_id'");
  mysqli_query($con, "UPDATE users SET is_verified='false' WHERE id='$user_id'");
  $message = "Document marked not verified";
  $message_class = "alert-danger";
  echo '<script>window.location.href = "'.$baseUrl.'/admin/users/document?id='.$user_id.'";</script>';
}

if(isset($_GET["userVerified"])) {
  if($_GET["userVerified"] == "true" || $_GET["userVerified"] == "false") {
    $userVerified = $_GET["userVerified"];
    mysqli_query($con, "UPDATE users SET is_verified='$userVerified' WHERE id='$user_id'");

    $message = "User marked not verified";
    $message_class = "alert-danger";
    if($userVerified == "true") {
      $message = "User marked verified";
      $message_class = "alert-success";
    }
    echo '<script>window.location.href = "'.$baseUrl.'/admin/users/document?id='.$user_id.'";</script>';
  }
}

$is_user_found = false;
$user_name = "";
$user_image = "";
$is_userVerified = "false";
$get_data = mysqli_query($con, "SELECT * FROM `users` WHERE id='$user_id'");
if(mysqli_num_rows($get_data) > 0) {
  $is_user_found= true;
  $data = mysqli_fetch_assoc($get_data);
  $user_name = $data["name"];
  $user_image = $data["pro_pic"];
  $is_userVerified = $data["is_verified"];
} else {
  $message = "No user found";
  $message_class = "alert-danger";
}


$not_verified_count = 0;
$not_verified_doc_query = mysqli_query($con, "SELECT * FROM user_doc WHERE `user_id`='$user_id' AND is_verified='false'");
$not_verified_count = mysqli_num_rows($not_verified_doc_query);

$get_documents = mysqli_query($con, "SELECT * FROM `user_doc` WHERE `user_id`='$user_id' AND `status`='active'");
$all_doc_count = mysqli_num_rows($get_documents);

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
              <span><a href="<?=$baseUrl ?>/admin">Dashboard</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span><a href="<?= $baseUrl ?>/admin/users">Users</a></span>
              <span><i class="fas fa-angle-right"></i></span>
              <span>
                <a href="<?=$baseUrl ?>/admin/users/document?id=<?=$user_id ?>">
                  Documents <?php if($user_name !="" ) { ?> (<?=$user_name ?>) <?php } ?>
                </a>
              </span>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <?php
                if ($message != "") {
                  ?>
                    <div class="alert <?= $message_class ?>" role="alert">
                      <?= $message ?>
                    </div>
                  <?php
                }
              ?>
              <?php
              if($is_user_found) { ?>
                <div class="bg-light rounded h-100 p-4">
                  <h6 class="mb-4">User Documents</h6> 
                  <?php 
                  if($all_doc_count > 0 && $not_verified_count == 0) { 
                    if($is_userVerified == 'true') {
                      ?>
                        <a class="btn btn-danger btn-sm" href="?id=<?=$user_id ?>&userVerified=false">Mark User Not Verified</a> 
                      <?php
                    } else {
                      ?>
                        <a class="btn btn-success btn-sm" href="?id=<?=$user_id ?>&userVerified=true">Mark User Verified</a> 
                      <?php
                    }
                    
                  }
                  ?>
                  <div class="table-responsive mt-3">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">S.No</th>
                          <th scope="col">Document</th>
                          <th scope="col">Document<br>Number</th>
                          <th scope="col">Document<br>Type</th>
                          
                          <th scope="col">Is Verified</th>
                          <th scope="col">Added On</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          
                          if(mysqli_num_rows($get_documents) > 0) {
                            $i = 0;
                            while($docs = mysqli_fetch_assoc($get_documents)) {
                              $i++;
                              $image_name = $docs["file_name"];
                              $image_link = "Not Found";
                              if ($image_name != "") {
                                if (file_exists("../../images/user_doc/" . $image_name)) {
                                  $image_link = $baseUrl . "/images/user_doc/" . $image_name;
                                }
                              }
                              ?>
                              <tr>
                                <td><?=$i ?></td>
                                <td>
                                  <?php
                                    if($image_link != "Not Found") {
                                      ?>
                                        <a href="<?=$image_link ?>" target="_blank">
                                          <img src="<?=$image_link ?>" style="height:50px;width:50px" />
                                        </a>
                                      <?php
                                    } else {
                                      ?>
                                      Not Found
                                      <?php
                                    }
                                  ?>
                                </td>
                                <td><?=$docs["doc_number"] ?></td>
                                <td><?=$docs["doc_type"] ?></td>
                                <td>
                                  <?php
                                    if($docs["is_verified"] == "true") {
                                      ?>
                                      <span class="text-success">Verified</span>
                                      <a class="btn btn-danger btn-sm" href="?id=<?=$user_id ?>&notverified=<?=$docs["id"] ?>">Mark Not Verified</a>
                                      <?php
                                    } else {
                                      ?>
                                      <span class="text-danger">Not Verified</span>
                                      <a class="btn btn-success btn-sm" href="?id=<?=$user_id ?>&verified=<?=$docs["id"] ?>">Mark Verified</a>
                                      <?php
                                    }
                                  ?>
                                </td>
                                <td><?=$docs["added_on"] ?></td>
                                <td></td>
                              </tr>
                              <?php
                            }
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              <?php } ?>
            </div>
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