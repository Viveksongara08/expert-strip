<?php

class ExpertStrip
{

    function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'expert_strip_style_script']);
        add_shortcode('strip_button', [$this, 'strip_button_shortcode']);

        add_action("wp_ajax_strip_payment_action", [$this, "strip_payment_action"]);
        add_action("wp_ajax_nopriv_strip_payment_action", [$this, "strip_payment_action"]);
    }


    function expert_strip_style_script()
    {

        wp_register_style('bootstrap-css', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css', 'all');
        wp_register_script('jqueryjs', 'https://code.jquery.com/jquery-3.3.1.min.js', 'all');

        wp_register_script('popper-js', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', 'all');
        wp_register_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js', 'all');
        wp_register_script('checkout-js', 'https://checkout.stripe.com/checkout.js', 'all');

        wp_register_script("main-js", STRIP_RNR_PATH . '/js/main.js', array('jquery'));

        wp_localize_script('main-js', 'strAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
        wp_enqueue_style('bootstrap-css');
        wp_enqueue_script('jqueryjs');

        wp_enqueue_script('popper-js');
        wp_enqueue_script('bootstrap-js');
        wp_enqueue_script('checkout-js');
        wp_enqueue_script('jquery');
        wp_enqueue_script('main-js');
    }


    function strip_button_shortcode($attr)
    {

        ob_start();
        $this->ShowButton($attr);
        return ob_get_clean();
    }



    function ShowButton($attr)
    {
        //print_r($attr);
        if (!empty($attr)) {
            $name = $attr["expertname"];
            $description = $attr["description"];
            $currencycode = $attr["currencycode"];
            $price = $attr["price"];
            $key = get_option('strip_privatekey');
            // $key  ='pk_test_5f6jfFP2ZV5U9TXQYG0vtqFJ00eFVWNoRX';
            if (!empty($attr["currencycode"]) and !empty($attr["price"])) {
                echo " <button data-name='$name' data-description='$description' data-currency='$currencycode' data-price='$price'  data-key='$key'    class='btn btn-primary btn-block wp_str_cls'>Pay  $currencycode $price </button>";
            }
        }
    }

    function strip_payment_action()
    {   
        if ($_POST['tokenId']) {
            $amount =  sanitize_text_field(trim($_POST["amount"]));
            $name =  sanitize_text_field(trim($_POST["name"]));
            $code =  sanitize_text_field(trim($_POST["code"]));
            $description =  sanitize_text_field(trim($_POST["description"]));
            require_once('vendor/autoload.php');

            //stripe secret key or revoke key
            //  $stripeSecret = 'sk_test_j5k0976GOLSOtiRzbDLpKqat00og5iM3cY';
            $stripeSecret = get_option('strip_secretkey');

            // See your keys here: https://dashboard.stripe.com/account/apikeys
            \Stripe\Stripe::setApiKey($stripeSecret);

            // Get the payment token ID submitted by the form:
            $token = $_POST['tokenId'];

            // Charge the user's card:
            $charge = \Stripe\Charge::create(array(
                "amount" => $amount,
                "currency" => $code,
                "description" => $name,
                "source" => $token,
            ));

           
            if($charge->amount_refunded == 0 && empty($charge->failure_code) && $charge->paid == 1 && $charge->captured == 1){

            // after successfull payment, you can store payment related information into your database
            $currencycode = $charge->currency;
            $amount = $charge->amount;
            $balance_transaction = $charge->balance_transaction;
            $id = $charge->id;
            $seller_message = $charge->outcome->seller_message;
            $email = $charge->billing_details->name;
            //$email = $charge->billing_details->name;
            

            $expert_content_post = "
            <p>Name :  $name</p>
            <p>Description :  $description</p>
            <p>Email :  $email</p>
            <p>Amount  :  $currencycode $amount</p>
            <p>Transaction :  $balance_transaction</p>
            <p>Id :  $id</p>           
            ";


            $post_arguments = array(
                'post_author' => get_current_user_id(),
                'post_type'     =>'expertstrippayments',
                'post_title' => $email,
                'post_content' => $expert_content_post,
                'post_status'   => 'publish'               
               
            );
            $insert = wp_insert_post($post_arguments, $wp_error = false);
            
            $this->Exper_strip_custom_mail($email,$expert_content_post);

            $data = array('success' => true, 'data' => $seller_message);
            echo json_encode($data);
        }else{

            $data = array('success' => false, 'data' => 'Payment faild.');
            echo json_encode($data);

        }
        }
        die();
    }

    function Exper_strip_custom_mail($to,$message){
        $subject="Payment completed.";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $message, $headers);
       

    }
}


class ExpertStripSetting
{

    public function expert_strip_action_links($links)
    {
        $expert_login_settings_link = '<a href="' . admin_url('admin.php?page=expert-strip-setting') . '">' . translate('Settings') . '</a>';
        array_unshift($links, $expert_login_settings_link);
        return $links;
    }

    public function __construct()
    {

        add_filter('plugin_action_links_' .STRIP_RNR_BASE, array(__CLASS__, 'expert_strip_action_links'));
        add_action('admin_menu', 'expert_strip_page_setting');
    }
}
$expertStrip = new ExpertStrip();
$expertStripSetting = new ExpertStripSetting();
