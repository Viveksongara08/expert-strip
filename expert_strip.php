<?php

/**
 * Expert Strip plugin for use for strip payment
 * Take this as a base plugin and modify as per your need.
 *
 * @package Expert Strip
 * @author vivek songara
 * @license GPL-2.0+
 * @link http://expertwebinfotech.com
 * @copyright 2022 Vivek songara, LLC. All rights reserved.
 *
 *            @wordpress-plugin
 *            Plugin Name: Expert Strip
 *            Plugin URI: http://expertwebinfotech.com
 *            Description: This is a WordPress plugin for strip payment methods. 
 *            Version: 1.1
 *            Author: Vivek Songara
 *            Author URI: 
 *            Text Domain: Expert Strip
 *            Contributors: Vivek Songara
 *            License: GPL-2.0+
 *            License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */


if ( ! defined( 'ABSPATH' ) ) exit;
//************************************//

define( 'EXPERT_STRIP_VERSION', '0.1' );
define( 'METADATA_VERSION', '0.1' );

define('STRIP_RNR_BASE', plugin_basename(__FILE__));
define('STRIP_RNR_FUNCTIONS', plugin_dir_path(__FILE__)  . '/includes');
define('STRIP_RNR_PATH', plugins_url('',__FILE__) );


  
  function expert_strip_page_setting()
  {

    add_submenu_page(
        'edit.php?post_type=expertstrippayments', //$parent_slug
        'Strip setting',  //$page_title
        'Strip setting',        //$menu_title
        'manage_options',           //$capability
        'expert-strip-setting',//$menu_slug
        'expert_strip_page_setting_render'//$function
);


   
  }
  function expert_strip_page_setting_render()
  {
      global $title;
  
      print '<div class="wrap">';
      print "<h1>$title</h1>";
      include('expert_strip_setting_page.php');
      print '</div>';
  }

 

include_once('classes.php');
include_once(STRIP_RNR_FUNCTIONS.'/post_expert_strip.php');

