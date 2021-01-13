(function ($) {
  "use strict";
  $(document).ready(function () {
    $("#check-address").click(function () {
      if ($("#check-address").is(":checked")) {
        $("#zip_billing").val($("#zip").val());
        $("#flat_billing").val($("#flat").val());
        $("#street_billing").val($("#street").val());
        $("#landmark_billing").val($("#landmark").val());
        $("#town_billing").val($("#town").val());
        $("#state_billing").val($("#state").val());
      } else {
        //Clear on uncheck
        $("#zip_billing").val("");
        $("#flat_billing").val("");
        $("#street_billing").val("");
        $("#landmark_billing").val("");
        $("#town_billing").val("");
        $("#state_billing").val("");
      }
    });
  });
})(jQuery);
