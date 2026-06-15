<?php
defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {

	/* Law Firm Design section */
	$wp_customize->add_section( 'lf_design', [
		'title'       => __( 'Law Firm Design', 'lawfirm-showcase' ),
		'description' => __( 'Switch templates and override accent colors.', 'lawfirm-showcase' ),
		'priority'    => 30,
	] );

	$wp_customize->add_setting( 'lf_active_template', [
		'default'           => 'obsidian',
		'sanitize_callback' => 'sanitize_key',
		'transport'         => 'refresh',
	] );
	$wp_customize->add_control( 'lf_active_template', [
		'label'   => __( 'Active Template', 'lawfirm-showcase' ),
		'section' => 'lf_design',
		'type'    => 'select',
		'choices' => [
			'obsidian' => 'Obsidian – Dark Luxury',
			'azure'    => 'Azure – Corporate Clean',
			'crimson'  => 'Crimson – Bold Editorial',
			'slate'    => 'Slate – Ultra-Minimal',
			'verdant'  => 'Verdant – Organic Authority',
			'amber'    => 'Amber – Approachable Warm',
			'midnight' => 'Midnight – Deep Prestige',
			'chalk'    => 'Chalk – Soft Editorial',
			'titanium' => 'Titanium – Modern Tech-Law',
			'rosewood' => 'Rosewood – Boutique Warmth',
			'cobalt'   => 'Cobalt – Dynamic Energy',
			'onyx'     => 'Onyx – Stark Power',
		],
	] );

	foreach ( [
		'1' => __( 'Primary Accent Color', 'lawfirm-showcase' ),
		'2' => __( 'Secondary Accent Color', 'lawfirm-showcase' ),
		'3' => __( 'Tertiary Accent Color', 'lawfirm-showcase' ),
	] as $n => $label ) {
		$wp_customize->add_setting( "lf_color_override_{$n}", [
			'default'           => '',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		] );
		$wp_customize->add_control(
			new WP_Customize_Color_Control( $wp_customize, "lf_color_override_{$n}", [
				'label'       => $label,
				'section'     => 'lf_design',
				'description' => __( 'Leave blank to use template default.', 'lawfirm-showcase' ),
			] )
		);
	}

	/* Law Firm Info section */
	$wp_customize->add_section( 'lf_firm_info', [
		'title'    => __( 'Law Firm Info', 'lawfirm-showcase' ),
		'priority' => 31,
	] );

	$info_fields = [
		'lf_firm_firm_name'    => __( 'Firm Name', 'lawfirm-showcase' ),
		'lf_firm_tagline'      => __( 'Firm Tagline', 'lawfirm-showcase' ),
		'lf_firm_phone'        => __( 'Phone Number', 'lawfirm-showcase' ),
		'lf_firm_email'        => __( 'Email Address', 'lawfirm-showcase' ),
		'lf_firm_address'      => __( 'Street Address', 'lawfirm-showcase' ),
		'lf_firm_city'         => __( 'City', 'lawfirm-showcase' ),
		'lf_firm_state'        => __( 'State', 'lawfirm-showcase' ),
		'lf_firm_zip'          => __( 'ZIP Code', 'lawfirm-showcase' ),
	];

	foreach ( $info_fields as $key => $label ) {
		$wp_customize->add_setting( $key, [
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
			'type'              => 'option',
		] );
		$wp_customize->add_control( $key, [
			'label'   => $label,
			'section' => 'lf_firm_info',
			'type'    => 'text',
		] );
	}
} );

/* Output color overrides as inline CSS */
add_action( 'wp_head', function () {
	$vars = [];
	for ( $i = 1; $i <= 3; $i++ ) {
		$color = get_theme_mod( "lf_color_override_{$i}" );
		if ( $color && preg_match( '/^#[0-9a-fA-F]{3,6}$/', $color ) ) {
			$vars[] = "--color-accent-{$i}:{$color};";
		}
	}
	if ( $vars ) {
		echo '<style id="lf-color-overrides">:root,[data-template]{' . implode( '', $vars ) . '}</style>' . "\n";
	}
}, 20 );
