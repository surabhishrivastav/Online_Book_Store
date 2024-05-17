<?php
  include_once("../connection.php");
  if(isset($_POST["logout"])) {
    unset($_SESSION["userLogin"]);
    echo "logout successfully";
  }

  if(isset($_POST["curCity"])) {
    $output = array();
    $output["is_error"] = true;
    $output["message"] = "No area found";
    $output["data"] = '<option value="">No area found</option>'; 
    $cityId = $_POST["curCity"];
    $get_area_query = mysqli_query($con, "SELECT * FROM `area` WHERE city_id='$cityId' ORDER BY `name` ASC");
    if(mysqli_num_rows($get_area_query) > 0) {
      $output["is_error"] = false;
      $output["message"] = "Area found";
      $output["data"] = '<option value="">Select Area</option>';
      while ($area = mysqli_fetch_assoc($get_area_query)) {
        $output["data"] .= '<option value="'.$area["id"].'">'.$area["name"].'</option>'; 
      }
    }
    echo json_encode($output);
  }

?>