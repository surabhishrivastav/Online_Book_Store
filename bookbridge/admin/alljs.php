<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= $baseUrl ?>/admin/lib/chart/chart.min.js"></script>
<script src="<?= $baseUrl ?>/admin/lib/easing/easing.min.js"></script>
<script src="<?= $baseUrl ?>/admin/lib/waypoints/waypoints.min.js"></script>
<script src="<?= $baseUrl ?>/admin/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="<?= $baseUrl ?>/admin/lib/tempusdominus/js/moment.min.js"></script>
<script src="<?= $baseUrl ?>/admin/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="<?= $baseUrl ?>/admin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<script src="<?= $baseUrl ?>/admin/js/main.js"></script>

<script>
  $(document).ready(function() {
    $(".update_button").click(function() {
      let url = $(this).attr("data-url");
      let title = $(this).attr("data-title");
      let content = $(this).attr("data-content");
      $("#updateModalTitle").html(title);
      $("#updateModalContent").html("<p>" + content + "</p>");
      $("#deleteModalConfirmBtn").attr("href", url);
      $("#updateModal").modal("show");
    });

    $(document).on('change', '.image_change', function() {
      var outDivId = $(this).data("outdiv");
      var outputDiv = $("." + outDivId);

      if (this.files && this.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          outputDiv.empty();
          outputDiv.append('<img class="rounded" src="' + e.target.result + '" style="max-width: 50px; max-height: 50px;" />');
        }

        reader.readAsDataURL(this.files[0]);
      }
    });
    $(".logout").click(function () {
      event.preventDefault();
      let baseUrl = $("#baseUrlDiv").attr("data-url");
      $.ajax({
        type: "POST",
        url: baseUrl+"/includes/functions.php",
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
</script>