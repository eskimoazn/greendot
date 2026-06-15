<?php
defined( 'ABSPATH' ) || exit;

/* [lf_showcase_switcher] — inline template picker grid */
add_shortcode( 'lf_showcase_switcher', function ( $atts ) {
	$atts   = shortcode_atts( [ 'columns' => '3' ], $atts );
	$labels = lf_get_template_labels();
	$active = lf_get_active_template();

	ob_start();
	echo '<div class="lf-showcase-inline" style="--cols:' . esc_attr( $atts['columns'] ) . ';grid-template-columns:repeat(' . esc_attr( $atts['columns'] ) . ',1fr);">';
	foreach ( $labels as $slug => $info ) {
		$url       = esc_url( add_query_arg( 'lf_template', $slug ) );
		$is_active = $slug === $active ? ' is-active' : '';
		printf(
			'<a href="%s" class="showcase-inline-card%s" data-template="%s">
				<div class="showcase-inline-card__swatch showcase-inline-card__swatch--%s"></div>
				<div class="showcase-inline-card__label">
					<strong>%s</strong>
					<em>%s</em>
				</div>
			</a>',
			$url,
			esc_attr( $is_active ),
			esc_attr( $slug ),
			esc_attr( $slug ),
			esc_html( $info['label'] ),
			esc_html( $info['mood'] )
		);
	}
	echo '</div>';
	return ob_get_clean();
} );

/* [lf_contact_form] — standalone contact form shortcode */
add_shortcode( 'lf_contact_form', function () {
	$practice_areas = [
		'Personal Injury', 'Criminal Defense', 'Family Law',
		'Estate Planning', 'Business Law', 'Real Estate Law',
		'Immigration Law', 'Employment Law', 'Other',
	];
	ob_start();
	include get_template_directory() . '/template-parts/contact.php';
	return ob_get_clean();
} );

/* Handle contact form POST */
add_action( 'admin_post_lf_contact_submit', 'lf_handle_contact_form' );
add_action( 'admin_post_nopriv_lf_contact_submit', 'lf_handle_contact_form' );

function lf_handle_contact_form(): void {
	if ( ! isset( $_POST['lf_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['lf_nonce'] ) ), 'lf_contact_nonce' ) ) {
		wp_die( esc_html__( 'Security check failed.', 'lawfirm-showcase' ) );
	}
	if ( ! empty( $_POST['lf_hp'] ) ) {
		wp_safe_redirect( wp_get_referer() ?: home_url() );
		exit;
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['lf_name']    ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['lf_email']        ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['lf_phone']   ?? '' ) );
	$subject = sanitize_text_field( wp_unslash( $_POST['lf_subject'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['lf_message'] ?? '' ) );

	if ( ! $name || ! is_email( $email ) || ! $message ) {
		wp_safe_redirect( add_query_arg( 'contact', 'error', wp_get_referer() ?: home_url() ) );
		exit;
	}

	$to      = get_option( 'lf_firm_email' ) ?: get_option( 'admin_email' );
	$subject_line = sprintf( 'New Contact: %s – %s', $subject ?: 'General', $name );
	$body    = '<p><strong>Name:</strong> ' . esc_html( $name ) . '</p>'
	         . '<p><strong>Email:</strong> ' . esc_html( $email ) . '</p>'
	         . '<p><strong>Phone:</strong> ' . esc_html( $phone ) . '</p>'
	         . '<p><strong>Practice Area:</strong> ' . esc_html( $subject ) . '</p>'
	         . '<p><strong>Message:</strong><br>' . nl2br( esc_html( $message ) ) . '</p>';
	$headers = [ 'Content-Type: text/html; charset=UTF-8', "Reply-To: {$name} <{$email}>" ];

	wp_mail( $to, $subject_line, $body, $headers );

	wp_safe_redirect( add_query_arg( 'contact', 'success', wp_get_referer() ?: home_url() ) );
	exit;
}
