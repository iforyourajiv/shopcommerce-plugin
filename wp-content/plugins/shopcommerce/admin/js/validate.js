//Validating  meta Box value of Product Page
(function ($) {
  "use strict";
  $(document).on("click", "#publish", function (event) {
    event.preventDefault();
    var discountvalue = $("#ced_input_meta_discount").val();
    var regularvalue = $("#ced_input_meta_regular_price").val();
    var inventory = $("#ced_input_meta_inventory").val();


    if(parseInt(inventory)<0){
      var check='negative';
    }

    if( parseFloat(discountvalue) < 0 || parseFloat(regularvalue) < 0 ){
    var priceField='negative'

    }


    if (
      discountvalue == "" ||
      discountvalue == null ||
      regularvalue == "" ||
      regularvalue == null ||
      priceField == 'negative'
    ) {
      $("#massage").html(
        "Invalid Input both Field Should be Filled and Value should not be Negative Number,Product Not Updated"
      );
    } else if (parseFloat(discountvalue) >= parseFloat(regularvalue)) {
      console.log("Greater");
      $("#massage").html(
        "Discount Price is Greater The Regular Price ,Product Not Updated"
      );
    } else if (inventory == "" || inventory == null || check=='negative') {
      $("#massageinventory").html("Inventory is Empty or Invalid Input ,<br>Product Not Updated");
    } else {
      $("#massageinventory").html(" ");
      $("#massage").html("");
      $("#post").submit();
    }
  });
})(jQuery);
