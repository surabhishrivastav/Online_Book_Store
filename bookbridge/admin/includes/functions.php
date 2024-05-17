<?php
  session_start();
  include_once("../connection.php");
  if(isset($_POST["logout"])) {
    unset($_SESSION["adminData"]);
    echo "logout successfully";
  }

?>