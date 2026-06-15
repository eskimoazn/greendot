<?php
/**
 * Template Name: Obsidian – Dark Luxury
 * Template Post Type: page
 */
defined( 'ABSPATH' ) || exit;

add_filter( 'lf_page_template_override', fn() => 'obsidian' );

get_header();
get_template_part( 'template-parts/hero' );
get_template_part( 'template-parts/about' );
get_template_part( 'template-parts/practice-areas' );
get_template_part( 'template-parts/attorneys' );
get_template_part( 'template-parts/stats' );
get_template_part( 'template-parts/testimonials' );
get_template_part( 'template-parts/contact' );
get_footer();
