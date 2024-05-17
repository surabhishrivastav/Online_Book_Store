<script src="<?= $baseUrl ?>/lib/easing/easing.min.js"></script>
<script src="<?= $baseUrl ?>/lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Custom Javascript -->
<script src="<?= $baseUrl ?>/js/main.js?v=<?php echo rand(); ?>"></script>
<script src="<?= $baseUrl ?>/js/otherFunction.js?v=<?php echo rand(); ?>"></script>
<script>
  $(document).on('change', '.image_change', function() {
    var outDivId = $(this).data("outdiv");
    var outputDiv = $("." + outDivId);

    if (this.files && this.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        outputDiv.empty();
        outputDiv.append('<img class="rounded" src="' + e.target.result + '" style="max-width: 100px; max-height: 100px;" />');
      }

      reader.readAsDataURL(this.files[0]);
    }
  });
</script>

</body>

</html>