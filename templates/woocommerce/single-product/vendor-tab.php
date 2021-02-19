<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wpdb;
// include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

$vendor_description = do_shortcode( $vendor_description );
$vendor_description = call_user_func( '__', $vendor_description, 'yith-woocommerce-product-vendors' );

$vendor_name = call_user_func( '__', $vendor_name, 'yith-woocommerce-product-vendors' );
$vendor_user_id = get_the_author_meta('ID');
?>

<div class="wp-block-columns">
    <div class="wp-block-column" style="flex-basis:18%">
        <?php echo get_wp_user_avatar(get_the_author_meta('ID'), 200); ?>
    </div>

    <div class="wp-block-column" style="flex-basis:80%">
        <h2>
            <a href="<?php echo $vendor_url ?>">
                <?php echo $vendor_name; ?>

                <?php 
                // ambil data departemen dari plugin 
                // Profile Extra Fields (https://wordpress.org/plugins/profile-extra-fields/)
                if( is_plugin_active('profile-extra-fields/profile-extra-fields.php') )
                :
                    $sql = "
                        SELECT 
                            ud.user_value,
                            fv.value_name
                        FROM
                            ". $wpdb->base_prefix ."prflxtrflds_user_field_data AS ud
                        JOIN    
                            ". $wpdb->base_prefix ."prflxtrflds_field_values AS fv ON fv.value_id = ud.user_value
                        WHERE 
                            ud.user_id = $vendor_user_id AND 
                            ud.field_id = 1
                    ";
                    $user_department = $wpdb->get_row($sql);
                    if(!empty($user_department)):
                ?>
                
                -
                <?php echo $user_department->value_name; ?>

                <?php 
                    endif;
                endif;
                ?>
            </a>
        </h2>

        <div class="vendor-description">
            <?php echo wpautop( $vendor_description );  ?>
        </div>
    </div>
</div>