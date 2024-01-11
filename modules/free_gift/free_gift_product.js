jQuery(document).ready(function () {
    console.log("Loading Free Gift Product JS script");

    create_event_listener();  
    
  });
  
  function create_event_listener() {
  
    //Click save settings button
    jQuery(".div_free_product_gift input[type='radio']").change(function() {
      console.log("Change radio");
        let id = jQuery(this).prop("id");
        let value = jQuery(this).val();

        jQuery('form.cart').find('input[name="radio_free_product_gift"]').remove();
        jQuery('form.cart').append('<input type="hidden" name="radio_free_product_gift" value="'+value+'">');
        // console.log(id);
        // console.log(value);
    });
  
  }