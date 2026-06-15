<?php defined( 'ABSPATH' ) || exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php wp_head(); ?>
</head>
<body <?php body_class( 't-' . lf_get_active_template() ); ?> data-template="<?php echo esc_attr( lf_get_active_template() ); ?>">
<?php wp_body_open(); ?>
<div id="page" class="site">
<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'lawfirm-showcase' ); ?></a>

<header id="masthead" class="site-header" role="banner">
  <div class="container header__inner">

    <div class="site-branding">
      <?php if ( has_custom_logo() ) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-branding__name" rel="home">
          <?php echo esc_html( lf_get_firm_data( 'firm_name' ) ?: get_bloginfo( 'name' ) ); ?>
        </a>
      <?php endif; ?>
    </div>

    <nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Primary', 'lawfirm-showcase' ); ?>">
      <?php
      wp_nav_menu( [
        'theme_location' => 'primary',
        'menu_class'     => 'nav-menu',
        'fallback_cb'    => 'lf_fallback_menu',
        'depth'          => 1,
      ] );
      ?>
    </nav>

    <div class="header__cta">
      <a href="#contact" class="btn btn--primary header__btn">
        <?php esc_html_e( 'Free Consultation', 'lawfirm-showcase' ); ?>
      </a>
      <button class="nav-toggle" aria-controls="site-navigation" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle menu', 'lawfirm-showcase' ); ?>">
        <span class="nav-toggle__bar"></span>
        <span class="nav-toggle__bar"></span>
        <span class="nav-toggle__bar"></span>
      </button>
    </div>

  </div>
</header>

<main id="main" class="site-main" role="main">
