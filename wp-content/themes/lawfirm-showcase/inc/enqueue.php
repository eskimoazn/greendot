<?php
defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {
    $ver = LF_VERSION;

    // Google Fonts
    wp_enqueue_style(
        'lf-google-fonts',
        'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Cormorant:ital,wght@0,300;0,400;0,600;1,400&family=Inter:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600&family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Lora:ital,wght@0,400;0,600;1,400&family=Merriweather:ital,wght@0,300;0,400;0,700;1,300&family=Libre+Baskerville:ital,wght@0,400;0,700;1,400&family=Spectral:ital,wght@0,300;0,400;0,600;1,400&family=Source+Sans+3:wght@300;400;600&family=Nunito:wght@300;400;600;700&family=Lato:wght@300;400;700&family=Karla:wght@300;400;500;600&family=Work+Sans:wght@300;400;500;600&family=Barlow:wght@300;400;500;600&family=Barlow+Condensed:wght@400;600;700&family=Space+Grotesk:wght@300;400;500;700&family=IBM+Plex+Sans:ital,wght@0,300;0,400;0,600;1,400&family=Rajdhani:wght@400;500;600;700&family=Exo+2:ital,wght@0,300;0,400;0,600;1,400&family=Anton&family=Roboto+Condensed:wght@300;400;700&display=swap',
        [],
        null
    );

    // CSS Tokens (always first)
    wp_enqueue_style( 'lf-tokens', LF_URI . '/assets/css/tokens.css', [], $ver );

    // Base styles
    wp_enqueue_style( 'lf-base', LF_URI . '/assets/css/base.css', [ 'lf-tokens' ], $ver );

    // Animations
    wp_enqueue_style( 'lf-animations', LF_URI . '/assets/css/animations.css', [ 'lf-base' ], $ver );

    // Components
    wp_enqueue_style( 'lf-components', LF_URI . '/assets/css/components.css', [ 'lf-base' ], $ver );

    // Main theme style.css
    wp_enqueue_style( 'lf-style', get_stylesheet_uri(), [ 'lf-components' ], $ver );

    // Per-template CSS
    $active_template = lf_get_active_template();
    $template_map    = lf_get_template_map();
    if ( isset( $template_map[ $active_template ] ) ) {
        wp_enqueue_style(
            'lf-template-css',
            LF_URI . '/assets/css/templates/' . $template_map[ $active_template ],
            [ 'lf-tokens', 'lf-base' ],
            $ver
        );
    }

    // Showcase switcher CSS (always load for switcher functionality)
    wp_enqueue_style( 'lf-switcher', LF_URI . '/assets/css/showcase-switcher.css', [ 'lf-style' ], $ver );

    // Scripts
    wp_enqueue_script( 'lf-animations', LF_URI . '/assets/js/animations.js', [], $ver, true );
    wp_enqueue_script( 'lf-main', LF_URI . '/assets/js/main.js', [], $ver, true );
    wp_enqueue_script( 'lf-switcher-js', LF_URI . '/assets/js/showcase-switcher.js', [], $ver, true );

    // Localize for AJAX
    wp_localize_script( 'lf-main', 'lfData', [
        'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
        'adminPost' => admin_url( 'admin-post.php' ),
        'nonce'     => wp_create_nonce( 'lf_contact_nonce' ),
        'siteUrl'   => get_site_url(),
        'themeUri'  => LF_URI,
        'i18n'      => [
            'sending'  => __( 'Sending…', 'lawfirm-showcase' ),
            'sent'     => __( 'Message sent! We\'ll be in touch soon.', 'lawfirm-showcase' ),
            'error'    => __( 'Something went wrong. Please try again.', 'lawfirm-showcase' ),
            'required' => __( 'Please fill in all required fields.', 'lawfirm-showcase' ),
        ],
    ] );
} );

// Admin scripts
add_action( 'admin_enqueue_scripts', function ( $hook ) {
    if ( ! in_array( $hook, [ 'settings_page_lf-google-sheets', 'settings_page_lf-law-firm-data' ], true ) ) {
        return;
    }
    wp_enqueue_style( 'lf-admin', LF_URI . '/assets/css/tokens.css', [], LF_VERSION );
} );
