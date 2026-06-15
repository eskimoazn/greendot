<?php
defined( 'ABSPATH' ) || exit;

function lf_get_template_map(): array {
	return [
		'obsidian' => 't01-obsidian.css',
		'azure'    => 't02-azure.css',
		'crimson'  => 't03-crimson.css',
		'slate'    => 't04-slate.css',
		'verdant'  => 't05-verdant.css',
		'amber'    => 't06-amber.css',
		'midnight' => 't07-midnight.css',
		'chalk'    => 't08-chalk.css',
		'titanium' => 't09-titanium.css',
		'rosewood' => 't10-rosewood.css',
		'cobalt'   => 't11-cobalt.css',
		'onyx'     => 't12-onyx.css',
	];
}

function lf_get_template_labels(): array {
	return [
		'obsidian' => [ 'label' => 'Obsidian', 'mood' => 'Dark Luxury',        'palette' => 'Black · Gold · Cream' ],
		'azure'    => [ 'label' => 'Azure',    'mood' => 'Corporate Clean',     'palette' => 'White · Navy · Blue' ],
		'crimson'  => [ 'label' => 'Crimson',  'mood' => 'Bold Editorial',      'palette' => 'White · Crimson · Charcoal' ],
		'slate'    => [ 'label' => 'Slate',    'mood' => 'Ultra-Minimal',       'palette' => 'Gray · Charcoal · Terracotta' ],
		'verdant'  => [ 'label' => 'Verdant',  'mood' => 'Organic Authority',   'palette' => 'Forest Green · White · Brass' ],
		'amber'    => [ 'label' => 'Amber',    'mood' => 'Approachable Warm',   'palette' => 'Sand · Amber · Chocolate' ],
		'midnight' => [ 'label' => 'Midnight', 'mood' => 'Deep Prestige',       'palette' => 'Navy · Cyan · Silver' ],
		'chalk'    => [ 'label' => 'Chalk',    'mood' => 'Soft Editorial',      'palette' => 'Chalk · Soft Black · Sage' ],
		'titanium' => [ 'label' => 'Titanium', 'mood' => 'Modern Tech-Law',     'palette' => 'Silver · Black · Lime' ],
		'rosewood' => [ 'label' => 'Rosewood', 'mood' => 'Boutique Warmth',     'palette' => 'Dusty Rose · Rosewood · Blush' ],
		'cobalt'   => [ 'label' => 'Cobalt',   'mood' => 'Dynamic Energy',      'palette' => 'Cobalt · White · Orange' ],
		'onyx'     => [ 'label' => 'Onyx',     'mood' => 'Stark Power',         'palette' => 'Black · White · Blood Red' ],
	];
}

function lf_get_active_template(): string {
	$override = apply_filters( 'lf_page_template_override', null );
	if ( $override && array_key_exists( $override, lf_get_template_map() ) ) {
		return $override;
	}
	if ( isset( $_GET['lf_template'] ) && array_key_exists( sanitize_key( $_GET['lf_template'] ), lf_get_template_map() ) ) {
		return sanitize_key( $_GET['lf_template'] );
	}
	$saved = get_theme_mod( 'lf_active_template', 'obsidian' );
	return array_key_exists( $saved, lf_get_template_map() ) ? $saved : 'obsidian';
}

function lf_get_firm_data( string $key ): string {
	$post_id = get_the_ID();
	if ( $post_id ) {
		$val = get_post_meta( $post_id, 'lf_' . $key, true );
		if ( $val ) {
			return sanitize_text_field( (string) $val );
		}
	}
	return sanitize_text_field( (string) get_option( 'lf_firm_' . $key, '' ) );
}

function lf_get_practice_areas(): array {
	$q = new WP_Query( [
		'post_type'      => 'lf_practice_area',
		'posts_per_page' => 8,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	] );
	return $q->posts ?: [];
}

function lf_get_attorneys(): array {
	$q = new WP_Query( [
		'post_type'      => 'lf_attorney',
		'posts_per_page' => 6,
		'orderby'        => 'menu_order',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	] );
	return $q->posts ?: [];
}

function lf_get_testimonials(): array {
	$q = new WP_Query( [
		'post_type'      => 'lf_testimonial',
		'posts_per_page' => 6,
		'orderby'        => 'rand',
		'no_found_rows'  => true,
	] );
	return $q->posts ?: [];
}

function lf_practice_area_defaults(): array {
	return [
		[ 'title' => 'Personal Injury',  'icon' => '⚖', 'image' => 'personal-injury.jpg',  'desc' => 'Fighting for maximum compensation for accident victims and their families.' ],
		[ 'title' => 'Criminal Defense', 'icon' => '🛡', 'image' => 'criminal-defense.jpg', 'desc' => 'Aggressive defense strategies protecting your rights at every stage.' ],
		[ 'title' => 'Family Law',        'icon' => '🏠', 'image' => 'family-law.jpg',       'desc' => 'Compassionate counsel through divorce, custody, and family matters.' ],
		[ 'title' => 'Estate Planning',   'icon' => '📜', 'image' => 'estate-planning.jpg',  'desc' => 'Securing your legacy with wills, trusts, and comprehensive estate plans.' ],
		[ 'title' => 'Business Law',      'icon' => '🏢', 'image' => 'corporate-law.jpg',    'desc' => 'Strategic legal guidance for businesses at every stage of growth.' ],
		[ 'title' => 'Real Estate Law',   'icon' => '🔑', 'image' => 'real-estate.jpg',      'desc' => 'Expert representation for buyers, sellers, and developers in all transactions.' ],
		[ 'title' => 'Immigration Law',   'icon' => '🌐', 'image' => 'immigration.jpg',      'desc' => 'Navigating complex immigration processes to achieve your American dream.' ],
		[ 'title' => 'Employment Law',    'icon' => '💼', 'image' => 'employment.jpg',       'desc' => 'Protecting worker rights and resolving workplace disputes effectively.' ],
	];
}

function lf_get_stats(): array {
	return [
		[ 'number' => '25+',    'label' => 'Years of Experience' ],
		[ 'number' => '5,000+', 'label' => 'Cases Won' ],
		[ 'number' => '98%',    'label' => 'Client Satisfaction' ],
		[ 'number' => '$500M+', 'label' => 'Recovered for Clients' ],
	];
}

function lf_fallback_menu(): void {
	echo '<ul class="nav-menu">';
	echo '<li><a href="#about">About</a></li>';
	echo '<li><a href="#practice-areas">Practice Areas</a></li>';
	echo '<li><a href="#attorneys">Our Team</a></li>';
	echo '<li><a href="#testimonials">Results</a></li>';
	echo '<li><a href="#contact">Contact</a></li>';
	echo '</ul>';
}

function lf_render_switcher_cards(): string {
	$labels = lf_get_template_labels();
	$active = lf_get_active_template();
	$html   = '';
	foreach ( $labels as $slug => $info ) {
		$is_active = $slug === $active ? ' is-active' : '';
		$html     .= sprintf(
			'<button class="switcher-card%s" data-template="%s" type="button" aria-label="Preview %s template">
				<div class="switcher-card__swatch switcher-card__swatch--%s" aria-hidden="true"></div>
				<div class="switcher-card__info">
					<strong class="switcher-card__name">%s</strong>
					<span class="switcher-card__mood">%s</span>
					<span class="switcher-card__palette">%s</span>
				</div>
			</button>',
			esc_attr( $is_active ),
			esc_attr( $slug ),
			esc_attr( $info['label'] ),
			esc_attr( $slug ),
			esc_html( $info['label'] ),
			esc_html( $info['mood'] ),
			esc_html( $info['palette'] )
		);
	}
	return $html;
}

function lf_stars( int $count = 5 ): string {
	$out = '<span class="star-rating" aria-label="' . esc_attr( $count . ' out of 5 stars' ) . '">';
	for ( $i = 0; $i < 5; $i++ ) {
		$out .= '<span class="star' . ( $i < $count ? ' star--full' : '' ) . '" aria-hidden="true">★</span>';
	}
	return $out . '</span>';
}
