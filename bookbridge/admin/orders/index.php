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

$req_type = "";
if(isset($_GET["type"])) {
  $req_type = $_GET["type"];
}
$req_status = "";
if(isset($_GET["status"])) {
  $req_status = $_GET["status"];
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
    $cur_page = "orders";
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
              <span><a href="<?= $baseUrl ?>/admin/orders">Orders</a></span>
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
            <div class="row">
              <div class="col-sm-6">
                <label>Order Type </label>
                <select class="form-control dropdownChange" id="request_type">
                  <option value="">Select Order Type</option>
                  <option value="sale" <?php if($req_type == "sale") { echo "selected"; } ?>>Sale</option>
                  <option value="rent" <?php if($req_type == "rent") { echo "selected"; } ?>>Rent</option>
                  <option value="swap" <?php if($req_type == "swap") { echo "selected"; } ?>>Swap</option>
                </select>
              </div>
              <div class="col-sm-6">
                <label>Status </label>
                <select class="form-control dropdownChange" id="request_status">
                  <option value="">Select Status</option>
                  <option value="pending" <?php if($req_status == "pending") { echo "selected"; } ?>>Pending</option>
                  <option value="ordered" <?php if($req_status == "ordered") { echo "selected"; } ?>>Ordered</option>
                  <option value="processing" <?php if($req_status == "processing") { echo "selected"; } ?>>Processing</option>
                  <option value="cancelled" <?php if($req_status == "cancelled") { echo "selected"; } ?>>Cancelled</option>
                  <option value="delivered" <?php if($req_status == "delivered") { echo "selected"; } ?>>Delivered</option>
                </select>
              </div>
            </div>
            <div class="pt-4">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Order Id</th>
                    <th scope="col">Request Type</th>
                    <th scope="col">Book</th>
                    <th scope="col">Ordered On</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 0;
                  $get_order_query = "SELECT `orders`.*, `product`.generic_name FROM `orders` INNER JOIN `product` ON `product`.id=`orders`.product_id";
                  $where_condition = "";
                  if($req_type != "") {
                    $where_condition .= " WHERE `orders`.purchase_type='$req_type' ";
                  }
                  if($req_status != "") {
                    if($where_condition != "") {
                      $where_condition .= " AND `orders`.status='$req_status' ";
                    } else {
                      $where_condition .= " WHERE `orders`.status='$req_status' ";
                    }
                  }

                  $get_order_query .= $where_condition." ORDER BY `orders`.id DESC";
                  $get_order_run = mysqli_query($con, $get_order_query);
                  while ($data = mysqli_fetch_assoc($get_order_run)) {
                  ?>
                    <tr>
                      <td><?= ++$i ?></td>
                      <td><?= $data["order_id"] ?> </td>
                      <td><?= $data["purchase_type"] ?></td>
                      <td><?= $data["generic_name"] ?></td>
                      <td><?= $data["added_on"] ?></td>
                      <td><?= $data["status"] ?></td>
                      <td>
                        <a href="<?= $baseUrl ?>/admin/orders/details?order=<?= $data["order_id"] ?>" class="btn btn-sm btn-outline-success">
                          <i class="fas fa-info-circle"></i> Detail
                        </a>
                        <?php
                          /* if($data["status"] === "blocked") {
                            ?>
                              <button type="button" class="btn btn-sm btn-outline-warning update_button" data-url="<?= $baseUrl ?>/admin/users?unblock=<?= $data["id"] ?>" data-id="<?= $data["id"] ?>" data-content="Are you sure you want to unblock this user ? (<?= $data["name"] ?>)" data-title="Unblock Confirmation"><i class="fas fa-check-square"></i></i> Unblock</button>
                            <?php
                          } else {
                            ?>
                              <button type="button" class="btn btn-sm btn-outline-danger update_button" data-url="<?= $baseUrl ?>/admin/users?block=<?= $data["id"] ?>" data-id="<?= $data["id"] ?>" data-content="Are you sure you want to block this user ? (<?= $data["name"] ?>)" data-title="Block Confirmation"><i class="fas fa-ban"></i> Block</button>
                            <?php
                          } */
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
      </div>
      <?php include("../footer.php") ?>
    </div>

    <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
  </div>

  <?php include("../alljs.php") ?>
</body>
<script>
  $(document).ready(function() {
    let baseUrl = $("#baseUrlDiv").attr("data-url");
    $(".dropdownChange").change(function() {
      event.preventDefault();
      var type = $("#request_type").val();
      var status = $("#request_status").val();
      var urlQuery = "";
      if(type != "") {
        urlQuery = "?type="+type;
      }
      if(status != "") {
        if(urlQuery != "") {
          urlQuery += "&";
        } else {
          urlQuery = "?";
        }
        urlQuery += "status="+status;
      }

      if(urlQuery != "") {
        window.location.href = baseUrl+"/orders"+urlQuery;
      }
    });
  });
</script>
</html>