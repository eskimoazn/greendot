<?php
defined( 'ABSPATH' ) || exit;

define( 'LF_VERSION', '1.0.0' );
define( 'LF_DIR', get_template_directory() );
define( 'LF_URI', get_template_directory_uri() );

/* ── Includes ── */
require_once LF_DIR . '/inc/enqueue.php';
require_once LF_DIR . '/inc/template-functions.php';
require_once LF_DIR . '/inc/customizer.php';
require_once LF_DIR . '/inc/shortcodes.php';
require_once LF_DIR . '/inc/google-sheets.php';

/* ── Theme Setup ── */
add_action( 'after_setup_theme', function () {
    add_theme_support( 'title-tag' );
    add_theme_support( 'custom-logo', [
        'height'      => 80,
        'width'       => 240,
        'flex-height' => true,
        'flex-width'  => true,
    ] );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );
    add_theme_support( 'custom-background' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );

    load_theme_textdomain( 'lawfirm-showcase', LF_DIR . '/languages' );

    register_nav_menus( [
        'primary' => __( 'Primary Navigation', 'lawfirm-showcase' ),
        'footer'  => __( 'Footer Navigation', 'lawfirm-showcase' ),
    ] );
} );

/* ── Custom Post Types ── */
add_action( 'init', function () {
    register_post_type( 'lf_attorney', [
        'labels'       => [
            'name'          => __( 'Attorneys', 'lawfirm-showcase' ),
            'singular_name' => __( 'Attorney', 'lawfirm-showcase' ),
            'add_new_item'  => __( 'Add New Attorney', 'lawfirm-showcase' ),
            'edit_item'     => __( 'Edit Attorney', 'lawfirm-showcase' ),
        ],
        'public'       => true,
        'has_archive'  => true,
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'menu_icon'    => 'dashicons-businessman',
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'attorneys' ],
    ] );

    register_post_type( 'lf_testimonial', [
        'labels'       => [
            'name'          => __( 'Testimonials', 'lawfirm-showcase' ),
            'singular_name' => __( 'Testimonial', 'lawfirm-showcase' ),
            'add_new_item'  => __( 'Add New Testimonial', 'lawfirm-showcase' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'supports'     => [ 'title', 'editor', 'custom-fields' ],
        'menu_icon'    => 'dashicons-format-quote',
        'show_in_rest' => true,
    ] );

    register_post_type( 'lf_practice_area', [
        'labels'       => [
            'name'          => __( 'Practice Areas', 'lawfirm-showcase' ),
            'singular_name' => __( 'Practice Area', 'lawfirm-showcase' ),
            'add_new_item'  => __( 'Add New Practice Area', 'lawfirm-showcase' ),
        ],
        'public'       => true,
        'has_archive'  => true,
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
        'menu_icon'    => 'dashicons-portfolio',
        'show_in_rest' => true,
        'rewrite'      => [ 'slug' => 'practice-areas' ],
    ] );

    /* ── Register Meta Fields ── */
    $attorney_meta = [ 'lf_title', 'lf_phone', 'lf_email', 'lf_bar_number', 'lf_linkedin', 'lf_education', 'lf_years_experience' ];
    foreach ( $attorney_meta as $key ) {
        register_post_meta( 'lf_attorney', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'auth_callback' => function () { return current_user_can( 'edit_posts' ); },
        ] );
    }

    $testimonial_meta = [ 'lf_client_name', 'lf_client_city', 'lf_rating', 'lf_practice_area' ];
    foreach ( $testimonial_meta as $key ) {
        register_post_meta( 'lf_testimonial', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'auth_callback' => function () { return current_user_can( 'edit_posts' ); },
        ] );
    }

    $practice_meta = [ 'lf_icon', 'lf_image', 'lf_short_desc' ];
    foreach ( $practice_meta as $key ) {
        register_post_meta( 'lf_practice_area', $key, [
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'auth_callback' => function () { return current_user_can( 'edit_posts' ); },
        ] );
    }
} );

/* ── Flush rewrite rules on activation ── */
add_action( 'after_switch_theme', function () {
    flush_rewrite_rules();
} );

/* ── Content width ── */
if ( ! isset( $content_width ) ) {
    $content_width = 1280;
}
