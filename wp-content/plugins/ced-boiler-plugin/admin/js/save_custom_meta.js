(function( $ ) {
	'use strict';
    $('#save_meta').on('click',function(){
        let val=$("#ced_meta_brand").val();
        let id=$("#ced_meta_brand_id").val();
        $.ajax({
            url: ajax_save_meta.ajaxurl,
            type: 'POST',
            data:{
              action: 'save_meta_action',
              valueforfun:val,
              valueforpost:id
            },
            success: function( data ){
              console.log( data );
              $("#message").text(data);
            }
          });
    })
})( jQuery );

