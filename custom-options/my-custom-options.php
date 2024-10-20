<?php
/*
Plugin Name: Custom Options
Description: A custom options page with Elementor integration.
Version: 1.1
Author: Alan Anthony Rubi
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Add the custom options page
function custom_options_page() {
    add_menu_page(
        'Custom Options', // Page title
        'Custom Options', // Menu title
        'manage_options', // Capability
        'custom-options', // Menu slug
        'custom_options_page_html', // Callback function
        'dashicons-database', // Icon
        20                    // Position
    );
}
add_action('admin_menu', 'custom_options_page');

// HTML content for the options page with better styling and shortcode display
function custom_options_page_html() {
    if ( !current_user_can( 'manage_options' ) ) {
        return;
    }

    // Save options if form is submitted
    if ( isset( $_POST['mobile_phone'] ) ) {
        update_option( 'custom_mobile_phone', sanitize_text_field( $_POST['mobile_phone'] ) );
    }
    if ( isset( $_POST['email_address'] ) ) {
        update_option( 'custom_email_address', sanitize_email( $_POST['email_address'] ) );
    }

    // Get the saved values
    $mobile_phone = get_option( 'custom_mobile_phone', '' );
    $email_address = get_option( 'custom_email_address', '' );

    ?>
    <div class="wrap">
        <h1>Custom Options</h1>
        <form method="post">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">
                        <label for="mobile_phone">Enter your mobile phone number:</label>
                    </th>
                    <td>
                        <input type="text" id="mobile_phone" name="mobile_phone" value="<?php echo esc_attr( $mobile_phone ); ?>" class="regular-text" />
                        <p class="description">Use this shortcode: <code>[custom_option_mobile]</code></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">
                        <label for="email_address">Enter your email address:</label>
                    </th>
                    <td>
                        <input type="email" id="email_address" name="email_address" value="<?php echo esc_attr( $email_address ); ?>" class="regular-text" />
                        <p class="description">Use this shortcode: <code>[custom_option_email]</code></p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" value="Save" class="button button-primary" />
            </p>
        </form>
    </div>
    <?php
}

// Register the custom group
function register_custom_options_group( $dynamic_tags ) {
    $dynamic_tags->register_group( 'custom_options_group', [
        'title' => 'Custom Option Page Group', // The title shown in Elementor UI
    ] );
}
add_action( 'elementor/dynamic_tags/register', 'register_custom_options_group' );

// Register the dynamic tag for both fields (mobile and email)
function register_new_dynamic_tags( $dynamic_tags_manager ) {
    if ( class_exists( '\Elementor\Core\DynamicTags\Tag' ) ) {
        require_once( __DIR__ . '/dynamic-tags/custom-dynamic-tag.php' );
        $dynamic_tags_manager->register( new \Custom_Mobile_Tag );
        $dynamic_tags_manager->register( new \Custom_Email_Tag );
        error_log( 'Custom Tags registered successfully' ); // Log this to check if registration happens
    } else {
        error_log( 'Elementor Core Dynamic Tag class not found!' );
    }
}
add_action( 'elementor/dynamic_tags/register', 'register_new_dynamic_tags' );

// Add shortcode for mobile phone
function custom_option_mobile_shortcode() {
    return esc_html( get_option( 'custom_mobile_phone', '' ) );
}
add_shortcode( 'custom_option_mobile', 'custom_option_mobile_shortcode' );

// Add shortcode for email address
function custom_option_email_shortcode() {
    return esc_html( get_option( 'custom_email_address', '' ) );
}
add_shortcode( 'custom_option_email', 'custom_option_email_shortcode' );