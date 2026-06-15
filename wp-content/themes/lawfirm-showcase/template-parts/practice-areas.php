<?php defined( 'ABSPATH' ) || exit;

$posts      = lf_get_practice_areas();
$defaults   = lf_practice_area_defaults();
$images_uri = LF_URI . '/assets/images/';
?>
<section class="practice-areas" id="practice-areas">
  <div class="container">

    <div class="section-header section-header--centered" data-animate="fade-up">
      <p class="eyebrow"><?php esc_html_e( 'How We Can Help', 'lawfirm-showcase' ); ?></p>
      <h2 class="section-title"><?php esc_html_e( 'Our Practice Areas', 'lawfirm-showcase' ); ?></h2>
      <p class="section-subtitle"><?php esc_html_e( 'Comprehensive legal representation across the areas that matter most to our clients.', 'lawfirm-showcase' ); ?></p>
    </div>

    <div class="practice-areas__grid" data-stagger>
      <?php if ( $posts ) : ?>
        <?php foreach ( $posts as $i => $post ) : ?>
          <?php
          $delay = $i * 80;
          $icon  = get_post_meta( $post->ID, 'lf_icon', true );
          $img   = get_post_meta( $post->ID, 'lf_image', true );
          $thumb = get_the_post_thumbnail_url( $post->ID, 'medium' );
          ?>
          <div class="practice-card" data-animate="fade-up" style="--stagger-delay:<?php echo esc_attr( $delay ); ?>ms">
            <?php if ( $thumb ) : ?>
              <div class="practice-card__img">
                <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $post->post_title ); ?>" loading="lazy" width="400" height="225">
              </div>
            <?php endif; ?>
            <?php if ( $icon ) : ?>
              <div class="practice-card__icon" aria-hidden="true"><?php echo esc_html( $icon ); ?></div>
            <?php endif; ?>
            <div class="practice-card__body">
              <h3 class="practice-card__title"><?php echo esc_html( $post->post_title ); ?></h3>
              <p class="practice-card__desc"><?php echo esc_html( get_the_excerpt( $post ) ); ?></p>
              <a class="practice-card__link" href="<?php echo esc_url( get_permalink( $post ) ); ?>">
                <?php esc_html_e( 'Learn More', 'lawfirm-showcase' ); ?>
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <?php foreach ( $defaults as $i => $area ) : ?>
          <?php $delay = $i * 80; ?>
          <div class="practice-card" data-animate="fade-up" style="--stagger-delay:<?php echo esc_attr( $delay ); ?>ms">
            <div class="practice-card__img">
              <img
                src="<?php echo esc_url( $images_uri . $area['image'] ); ?>"
                alt="<?php echo esc_attr( $area['title'] ); ?>"
                loading="lazy"
                width="400"
                height="225"
              >
            </div>
            <div class="practice-card__icon" aria-hidden="true"><?php echo esc_html( $area['icon'] ); ?></div>
            <div class="practice-card__body">
              <h3 class="practice-card__title"><?php echo esc_html( $area['title'] ); ?></h3>
              <p class="practice-card__desc"><?php echo esc_html( $area['desc'] ); ?></p>
              <span class="practice-card__link"><?php esc_html_e( 'Learn More', 'lawfirm-showcase' ); ?></span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</section>
