jQuery(document).ready(function () {
  jQuery(".wp_str_cls").on('click', (function () {

    var name = $(this).attr("data-name");
    var description = $(this).attr("data-description")
    var currency = $(this).attr("data-currency")
    var price = $(this).attr("data-price")
    var skey = $(this).attr("data-key")
    

    var handler = StripeCheckout.configure({
      key: skey, // your publisher key id
      locale: 'auto',
      token: function (token) {
        // You can access the token ID with `token.id`.
        // Get the token ID to your server-side code for use.
        console.log('Token Created!!');
        //console.log(token)
        $('#token_response').html(JSON.stringify(token));
 
        $.ajax({
          url: strAjax.ajaxurl,
          method: 'post',
          data: { action: "strip_payment_action" ,tokenId: token.id, amount: price, code: currency, description: description , name: name},
          dataType: "json",
          success: function( response ) {
            //console.log(response.data);
           //  $('#token_response').append( '<br />' + JSON.stringify(response.data));
            alert(response.data);
          }
        })
      }
    });
  
    handler.open({
      name: name,
      description: description,
      amount: price * 100
    });

  }));

  });