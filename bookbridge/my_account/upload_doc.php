<?php
include("../connection.php");
if(!isset($_SESSION["userLogin"])) {
  header("Location: " . $baseUrl);
}
include("../include_pages/navbar.php");

$user_id = $_SESSION["userLogin"]["id"];
$message = "";
$message_class = "";
if (isset($_POST["upload_doc"])) {
  if (!empty($_POST["doc_nmbr"]) && !empty($_FILES["doc_image"]["name"]) && !empty($_POST["doc_type"])) {
    $file_name = "";

    if (is_uploaded_file($_FILES['doc_image']['tmp_name'])) {
      $unique_image_name = uniqid(date('Y-m-d-h-i-s') . '_');
      $temp_name = explode(".", $_FILES["doc_image"]["name"]);
      $extension = strtolower(end($temp_name));
      $allowed_extensions = array('jpg', 'jpeg', 'png', 'pdf');
      $file_name = $unique_image_name . '-user_document.' . $extension;
      $location = '../images/user_doc/' . $file_name;

      if (in_array($extension, $allowed_extensions) && $_FILES["doc_image"]["size"] > 0) {
        if (move_uploaded_file($_FILES["doc_image"]["tmp_name"], $location)) {
          $doc_number = mysqli_real_escape_string($con, $_POST["doc_nmbr"]);
          $doc_type = mysqli_real_escape_string($con, $_POST["doc_type"]);
          $current_date_time = date('Y-m-d H:i:s');

          $query = "INSERT INTO user_doc(`user_id`, `file_name`, `doc_number`, `doc_type`, `added_on`) VALUES('$user_id', '$file_name', '$doc_number', '$doc_type', '$current_date_time')";

          if (mysqli_query($con, $query)) {
            $message = "Document Uploaded";
            $message_class = "alert-success";
            echo '<script>window.location.href = "'.$baseUrl.'/my_account/documents";</script>';
            exit;
          } else {
            $message = "Error: " . mysqli_error($con);
            $message_class = "alert-danger";
          }
        } else {
          $message = "Error uploading file. Please try again.";
          $message_class = "alert-danger";
        }
      } else {
        $message = "Invalid file type or file size exceeds limit.";
        $message_class = "alert-danger";
      }
    } else {
      $message = "Error: Invalid file upload.";
      $message_class = "alert-danger";
    }
  } else {
    $message = "Please fill all required fields.";
    $message_class = "alert-danger";
  }
}

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
        <span><i class="fas fa-angle-right"></i></span>
        <span><a href="<?= $baseUrl ?>/my_account/upload_doc">Upload Documents</a></span>
      </div>
    </div>
  </div>
  <div class="pt-5">
    <?php
    if ($message != "") {
    ?>
      <div class="alert <?= $message_class ?>" role="alert">
        <?= $message ?>
      </div>
    <?php
    }
    ?>
    <form class="bg-white p-5" method="POST" enctype="multipart/form-data">
      <div class="row">
        <div class="col-sm-6 form-group">
          <label for="doc_type">Document Type</label>
          <select class="form-control rounded" id="doc_type" name="doc_type" required>
            <option value="">Select document type</option>
            <option value="Aadhar Card">Aadhar Card</option>
            <option value="Pan Card">Pan Card</option>
            <option value="Driving Licence">Driving Licence</option>
            <option value="Voter Id">Voter Id</option>

          </select>
        </div>
        <div class="col-sm-6 form-group">
          <label for="doc_nmbr">Document Number</label>
          <input type="text" class="form-control rounded" id="doc_nmbr" name="doc_nmbr" maxlength="50" placeholder="Document Number" required>
        </div>
        <div class="col-sm-6 form-group">
          <label for="doc_image">Document Image</label>
          <input type="file" class="form-control rounded image_change" id="doc_image" name="doc_image" data-outdiv="doc_out_div" placeholder="Document Image" required>
        </div>
        <div class="col-sm-6 form-group doc_out_div p-3">

        </div>
      </div>
      <div>
        <center><button type="submit" class="btn btn-success" name="upload_doc">Upload Document</button></center>
      </div>
    </form>
  </div>
</div>
<?php
include("../include_pages/footer.php");
?>