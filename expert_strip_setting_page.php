<?php
global $wpdb, $PasswordHash, $current_user, $user_ID;
global $smof_data;
?>

<section id="ts-working-process" class="ts-working-process">


    <div class="container">

        <div class="row">

            <div class="col-md-12">
                <table class="wp-list-table widefat fixed striped table-view-list posts">
                    
                    <tr>
                        <td>Shortcode</td>
                        <td>[strip_button expertname="product name" description='Product description'  currencycode="USD"  price="120"  ]


</td>
                    </tr>


                </table>

            </div>

        </div>
        <?php
        $privatekey = get_option('strip_privatekey');
        $secretkey = get_option('strip_secretkey');

        ?>
        <div class="row">
            <div class="col-md-12">
                <?php print "<h1>Expert strip setting</h1>"; ?>
                <table class="wp-list-table widefat fixed striped table-view-list posts">
                    <tr>
                        <th>
                            <form name="<?php echo admin_url('admin.php'); ?>" method="post">
                                <input type="hidden" name="page" value="expert-strip-setting" />
                                <input value="<?php echo $privatekey; ?>" style="width:100%;padding: 10px;" name="privatekey" id="privatekey" placeholder="Private Key " />
                        </th>
                        <th></th>

                    </tr>
                    <tr>
                        <th>
                            <input value="<?php echo $secretkey; ?>" style="width:100%;padding: 10px;" name="secretkey" id="secretkey" placeholder="Secret key" />
                        </th>
                        <th>

                        </th>


                    </tr>
                    <tr>
                        <th><input style="  padding: 10px;" name="submit" type="submit" value="Save" />
                            </from>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <?php
                            if (isset($_REQUEST["submit"])) {
                                $privatekey =  sanitize_text_field(trim($_REQUEST["privatekey"]));
                                $secretkey =  sanitize_text_field(trim($_REQUEST["secretkey"]));

                                update_option('strip_privatekey', $privatekey);
                                update_option('strip_secretkey', $secretkey);

                                echo "Update";
                            }

                            ?>

                        </td>

                        </td>

                </table>
            </div>
</section>