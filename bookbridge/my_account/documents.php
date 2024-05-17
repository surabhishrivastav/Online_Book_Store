<?php
include("../connection.php");
if(!isset($_SESSION["userLogin"])) {
  header("Location: " . $baseUrl);
}
include("../include_pages/navbar.php");
$user_id = $_SESSION["userLogin"]["id"];
$user_doc_get_query = mysqli_query($con, "SELECT * FROM user_doc WHERE user_id='$user_id'");
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
        <span><a href="<?= $baseUrl ?>/my_account/documents">My Documents</a></span>
      </div>
    </div>
  </div>
  <div class="p-3 bg-white">
    <center><a class="btn btn-primary" href="<?=$baseUrl ?>/my_account/upload_doc">Upload Document</a></center>
    <?php
      if(mysqli_num_rows($user_doc_get_query) > 0) {
        ?>
        <table class="table table-bordered mt-3">
          <thead>
            <tr>
              <td>S.No</td>
              <td>Document</td>
              <td>Document Number</td>
              <td>Document Type</td>
              <td>Uploaded On</td>
              <td>Status</td>
            </tr>
          </thead>
          <tbody>
            <?php
              $i = 1;
              while($user_doc = mysqli_fetch_assoc($user_doc_get_query)) {
                $image_name = $user_doc["file_name"];
                $image_link = "Not Found";
                $doc_number = $user_doc["doc_number"];
                $doc_type = $user_doc["doc_type"];
                $is_verified = $user_doc["is_verified"];
                if ($image_name != "") {
                  if (file_exists("../images/user_doc/" . $image_name)) {
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
                  <td><?=$doc_number ?></td>
                  <td><?=$doc_type ?></td>
                  <td><?=$user_doc["added_on"] ?></td>
                  <td>
                    <?php
                    if($is_verified == "true") {
                      ?>
                      <span class="text-success">Verified</span>
                      <?php
                    } else {
                      ?>
                      <span class="text-danger">Not Verified</span>
                      <?php
                    }
                    ?>
                  </td>
                </tr>
                <?php
                $i++;
              }
            ?>
          </tbody>
        </table>
        <?php
      } else {
        ?>
        <h4>No documents uploaded by you</h4>
        <?php
      }
    ?>
  </div>
</div>
<?php
include("../include_pages/footer.php");
?>