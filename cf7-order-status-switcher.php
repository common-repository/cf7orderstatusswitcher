<?php
/**
 * Plugin Name: CF7OrderStatusSwitcher
 * Description: Select a CF7 form to be displayed on WooCommerce order details pages, and change the order status after form submission.
 * Version: 1.0
 * Author: eliodata
 * Author URI: https://eliodata.com
 */

defined( 'ABSPATH' ) || exit;

// Add settings page
add_action( 'admin_menu', 'cf7oss_plugin_add_admin_menu' );
add_action( 'admin_init', 'cf7oss_plugin_settings_init' );

function cf7oss_plugin_add_admin_menu() {
    add_submenu_page('woocommerce', 'CF7OrderStatusSwitcher Settings', 'CF7OrderStatusSwitcher', 'manage_options', 'cf7oss_plugin_settings', 'cf7oss_plugin_options_page');
}

function cf7oss_plugin_settings_init() {
    register_setting( 'cf7oss_plugin_options', 'cf7oss_plugin_options' );

    add_settings_section(
        'cf7oss_plugin_options_section',
        'Plugin Options',
        'cf7oss_plugin_options_section_callback',
        'cf7oss_plugin_options'
    );

    add_settings_field(
        'cf7oss_plugin_actions',
        'Order Actions',
        'cf7oss_plugin_actions_callback',
        'cf7oss_plugin_options',
        'cf7oss_plugin_options_section'
    );
}

function cf7oss_plugin_options_section_callback() {
    echo '<p>Select the order status and the form ID to display on the order details page.</p>';
}

function cf7oss_plugin_actions_callback() {
    $options = get_option( 'cf7oss_plugin_options' );
    $actions = isset( $options['actions'] ) ? $options['actions'] : array();
    $index = isset( $options['index'] ) ? $options['index'] : 0;

    ?>
    <table class="form-table cf7oss-plugin-actions">
        <tr>
            <th>Order Status</th>
            <th>Form ID</th>
            <th>New Order Status</th>
            <th>&nbsp;</th>
        </tr>
        <?php foreach ( $actions as $key => $action ) : ?>
            <?php if ( ! empty( $action['status'] ) && ! empty( $action['form_id'] ) && ! empty( $action['new_status'] ) ) : ?>
            <tr class="cf7oss-plugin-action">
                <td><input type="text" name="cf7oss_plugin_options[actions][<?php echo esc_attr( $key ); ?>][status]" value="<?php echo esc_attr( $action['status'] ); ?>" /></td>
                <td><input type="text" name="cf7oss_plugin_options[actions][<?php echo esc_attr( $key ); ?>][form_id]" value="<?php echo esc_attr( $action['form_id'] ); ?>" /></td>
                <td><input type="text" name="cf7oss_plugin_options[actions][<?php echo esc_attr( $key ); ?>][new_status]" value="<?php echo esc_attr( $action['new_status'] ); ?>" /></td>
                <td><button type="button" class="button cf7oss-plugin-remove-action">&times;</button></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
    <input type="hidden" name="cf7oss_plugin_options[index]" value="<?php echo esc_attr( $index + 1 ); ?>" />
    <button type="button" class="button cf7oss-plugin-add-action">Add new action</button>
<?php
}

function cf7oss_plugin_options_page() {
?>

<div class="wrap">
<h2>CF7OrderStatusSwitcher Settings</h2>
<form action="options.php" method="post">
<?php
         settings_fields( 'cf7oss_plugin_options' );
         do_settings_sections( 'cf7oss_plugin_options' );
         submit_button();
         ?>
</form>
</div>
<script>
    jQuery(document).ready(function($) {
    $('.cf7oss-plugin-add-action').click(function(e) {
        e.preventDefault();
        var index = $('.cf7oss-plugin-action').length;
        var $newAction = $('<tr class="cf7oss-plugin-action"><td><input type="text" name="cf7oss_plugin_options[actions][' + index + '][status]" value="" /></td><td><input type="text" name="cf7oss_plugin_options[actions][' + index + '][form_id]" value="" /></td><td><input type="text" name="cf7oss_plugin_options[actions][' + index + '][new_status]" value="" /></td><td><button type="button" class="button cf7oss-plugin-remove-action">&times;</button></td></tr>');
        $('.cf7oss-plugin-actions').append($newAction);
    });
$(document).on('click', '.cf7oss-plugin-remove-action', function(e) {
    e.preventDefault();
    $(this).closest('.cf7oss-plugin-action').remove();
});
});
</script>

<?php
}

// Add styles and scripts
add_action( 'wp_enqueue_scripts', 'cf7oss_plugin_enqueue_scripts' );
function cf7oss_plugin_enqueue_scripts() {
    if (is_account_page()) {
        wp_enqueue_style('cf7oss-plugin-style', plugin_dir_url(__FILE__) . 'css/cf7oss-plugin.css', array(), '1.0');
        wp_enqueue_script('cf7oss-plugin-script', plugin_dir_url(__FILE__) . 'js/cf7oss-plugin.js', array('jquery'), '1.0', true);
    }
}

// Display Contact Form 7 form on the order details page based on the order status
add_action('woocommerce_view_order', 'cf7oss_plugin_replace_button_view_order', 10);
function cf7oss_plugin_replace_button_view_order($order_id)
{
    $options = get_option('cf7oss_plugin_options');
    $actions = isset($options['actions']) ? $options['actions'] : array();
    $order = wc_get_order($order_id);
    if (!$order) {
        return;
    }

    foreach ($actions as $action) {
        $status = isset($action['status']) ? $action['status'] : '';
        $form_id = isset($action['form_id']) ? $action['form_id'] : '';
        $new_status = isset($action['new_status']) ? $action['new_status'] : '';

        if ($order->has_status($status)) {
            echo do_shortcode("[contact-form-7 id='" . esc_attr( $form_id ) . "']");
            ?>
        <script>
            document.addEventListener('wpcf7mailsent', function (event) {
                var order_id = '<?php echo esc_js( $order_id ); ?>';
                var new_status = '<?php echo esc_js( $new_status ); ?>';
                jQuery.post('<?php echo esc_url( admin_url('admin-ajax.php') ); ?>', {
                    action: 'cf7oss_update_order_status',
                    order_id: order_id,
                    new_status: new_status
                }, function () {
                    location.reload();
                });
            }, false);
</script>
<?php
return; // stop loop if order status match found
}
}
}

// Update order status
add_action( 'wp_ajax_cf7oss_update_order_status', 'cf7oss_update_order_status' );
add_action( 'wp_ajax_nopriv_cf7oss_update_order_status', 'cf7oss_update_order_status' );
function cf7oss_update_order_status() {
if ( isset( $_POST['order_id'], $_POST['new_status'] ) ) {
$order_id = absint( $_POST['order_id'] );
$new_status = sanitize_text_field( $_POST['new_status'] );
$order = wc_get_order( $order_id );
if ( $order ) {
$order->update_status( $new_status );
}
}
wp_die();
}
