<?php defined( 'ABSPATH' ) || exit;

$firm_name  = lf_get_firm_data( 'firm_name' ) ?: get_bloginfo( 'name' );
$tagline    = lf_get_firm_data( 'tagline' )   ?: get_bloginfo( 'description' );
$desc       = lf_get_firm_data( 'description' );
$template   = lf_get_active_template();
$images_uri = LF_URI . '/assets/images/';

$hero_image_map = [
	'obsidian' => 'courthouse.jpg',
	'azure'    => 'office-interior.jpg',
	'crimson'  => 'courthouse.jpg',
	'slate'    => 'marble-01.jpg',
	'verdant'  => 'office-interior.jpg',
	'amber'    => 'courthouse.jpg',
	'midnight' => 'office-interior.jpg',
	'chalk'    => 'marble-02.jpg',
	'titanium' => 'office-interior.jpg',
	'rosewood' => 'courthouse.jpg',
	'cobalt'   => 'office-interior.jpg',
	'onyx'     => 'courthouse.jpg',
];
$hero_image = $hero_image_map[ $template ] ?? 'courthouse.jpg';
?>
<section class="hero" id="home" aria-labelledby="hero-heading">

  <div class="hero__bg" aria-hidden="true" style="background-image: url('<?php echo esc_url( $images_uri . $hero_image ); ?>');"></div>
  <div class="hero__overlay" aria-hidden="true"></div>

  <div class="container hero__inner">

    <p class="eyebrow hero__eyebrow">
      <?php esc_html_e( 'Trusted Legal Counsel', 'lawfirm-showcase' ); ?>
    </p>

    <h1 id="hero-heading" class="hero__heading">
      <?php echo esc_html( $firm_name ); ?>
    </h1>

    <p class="hero__sub">
      <?php
      if ( $desc ) {
        echo esc_html( $desc );
      } elseif ( $tagline ) {
        echo esc_html( $tagline );
      } else {
        esc_html_e( 'Dedicated advocates fighting for your rights. Schedule a free consultation today.', 'lawfirm-showcase' );
      }
      ?>
    </p>

    <div class="hero__cta">
      <a href="#contact" class="btn btn--primary">
        <?php esc_html_e( 'Free Consultation', 'lawfirm-showcase' ); ?>
      </a>
      <a href="#practice-areas" class="btn btn--ghost">
        <?php esc_html_e( 'Our Practice', 'lawfirm-showcase' ); ?>
      </a>
    </div>

  </div>

  <div class="hero__scroll-indicator" aria-hidden="true">
    <span class="sr-only"><?php esc_html_e( 'Scroll down', 'lawfirm-showcase' ); ?></span>
  </div>

</section>
