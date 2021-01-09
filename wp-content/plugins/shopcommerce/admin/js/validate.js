//Validating  meta Box value of Product Page
(function ($) {
  "use strict";
  $(document).on("click", "#publish", function (event) {
    event.preventDefault();
    var discountvalue = $("#ced_input_meta_discount").val();
    var regularvalue = $("#ced_input_meta_regular_price").val();
    var inventory = $("#ced_input_meta_inventory").val();

    if (
      discountvalue == "" ||
      discountvalue == null ||
      regularvalue == "" ||
      regularvalue == null
    ) {
      $("#massage").html(
        "Invalid Input both Field Should be Filled,Product Not Updated"
      );
    } else if (parseFloat(discountvalue) >= parseFloat(regularvalue)) {
      console.log("Greater");
      $("#massage").html(
        "Discount Price is Greater The Regular Price ,Product Not Updated"
      );
    } else if (inventory == "" || inventory == null) {
      $("#massageinventory").html("Inventory is Empty ,Product Not Updated");
    } else {
      $("#massageinventory").html(" ");
      $("#massage").html("");
      $("#post").submit();
    }
  });
})(jQuery);
