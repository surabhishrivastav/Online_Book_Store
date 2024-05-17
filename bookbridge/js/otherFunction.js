$(document).ready(function () {
  $(".toggle_pass_visiblity").click(function () {
    let fieldClass = $(this).attr("data-fieldClass");
    let isvisible = $(this).html();
    if (isvisible === '<i class="far fa-eye"></i>') {
      $("." + fieldClass).attr("type", "text");
      $(this).html('<i class="fas fa-eye-slash"></i>');
    } else {
      $("." + fieldClass).attr("type", "password");
      $(this).html('<i class="far fa-eye"></i>');
    }
  });

  $(".logout").click(function () {
    let baseUrl = $("#baseUrlDiv").attr("data-url");
    $.ajax({
      type: "POST",
      url: baseUrl+"/include_pages/functions.php",
      data: {
        logout: "logout"
      },
      success: function (out) {
        console.log(out);
        location.reload();
      }
    });
  });
});