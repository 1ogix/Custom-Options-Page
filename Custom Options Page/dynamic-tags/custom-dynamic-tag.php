<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

// Create the dynamic tag for Mobile Phone
class Custom_Mobile_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'custom_mobile_tag';
    }

    public function get_title() {
        return 'Mobile Phone Number';
    }

    public function get_group() {
        return 'custom_options_group'; // Place it in the custom group
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ]; // Categorize it as a text-related dynamic tag
    }

    public function render() {
        $mobile_phone = get_option( 'custom_mobile_phone', '' );
        echo esc_html( $mobile_phone );
    }
}

// Create the dynamic tag for Email Address
class Custom_Email_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'custom_email_tag';
    }

    public function get_title() {
        return 'Email Address';
    }

    public function get_group() {
        return 'custom_options_group'; // Place it in the custom group
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ]; // Categorize it as a text-related dynamic tag
    }

    public function render() {
        $email_address = get_option( 'custom_email_address', '' );
        echo esc_html( $email_address );
    }
}