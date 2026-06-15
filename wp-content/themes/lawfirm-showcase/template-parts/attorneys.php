<?php defined( 'ABSPATH' ) || exit;

$attorneys = lf_get_attorneys();

$sample_attorneys = [
	[ 'name' => 'Alexandra Monroe', 'title' => 'Founding Partner', 'bar' => 'Bar No. 12345', 'phone' => '(555) 100-2000' ],
	[ 'name' => 'James R. Thornton', 'title' => 'Senior Partner',  'bar' => 'Bar No. 23456', 'phone' => '(555) 100-2001' ],
	[ 'name' => 'Priya Kapoor',     'title' => 'Associate Attorney', 'bar' => 'Bar No. 34567', 'phone' => '(555) 100-2002' ],
];
?>
<section class="attorneys" id="attorneys">
  <div class="container">

    <div class="section-header section-header--centered" data-animate="fade-up">
      <p class="eyebrow"><?php esc_html_e( 'Our Legal Team', 'lawfirm-showcase' ); ?></p>
      <h2 class="section-title"><?php esc_html_e( 'Meet Your Attorneys', 'lawfirm-showcase' ); ?></h2>
      <p class="section-subtitle"><?php esc_html_e( 'Experienced advocates committed to achieving the best possible outcome for every client.', 'lawfirm-showcase' ); ?></p>
    </div>

    <div class="attorneys__grid" data-stagger>
      <?php if ( $attorneys ) : ?>
        <?php foreach ( $attorneys as $i => $attorney ) : ?>
          <?php
          $delay = $i * 100;
          $thumb = get_the_post_thumbnail_url( $attorney->ID, 'medium' );
          $title = get_post_meta( $attorney->ID, 'lf_title', true );
          $phone = get_post_meta( $attorney->ID, 'lf_phone', true );
          $bar   = get_post_meta( $attorney->ID, 'lf_bar_number', true );
          $li    = get_post_meta( $attorney->ID, 'lf_linkedin', true );
          ?>
          <div class="attorney-card" data-animate="fade-up" style="--stagger-delay:<?php echo esc_attr( $delay ); ?>ms">
            <div class="attorney-card__photo">
              <?php if ( $thumb ) : ?>
                <img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo esc_attr( $attorney->post_title ); ?>" loading="lazy" width="160" height="160">
              <?php endif; ?>
            </div>
            <h3 class="attorney-card__name"><?php echo esc_html( $attorney->post_title ); ?></h3>
            <?php if ( $title ) : ?>
              <div class="attorney-card__title"><?php echo esc_html( $title ); ?></div>
            <?php endif; ?>
            <?php if ( $bar ) : ?>
              <div class="attorney-card__bar"><?php echo esc_html( $bar ); ?></div>
            <?php endif; ?>
            <div class="attorney-card__contact">
              <?php if ( $phone ) : ?>
                <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
              <?php endif; ?>
              <?php if ( $li ) : ?>
                <a href="<?php echo esc_url( $li ); ?>" target="_blank" rel="noopener noreferrer">LinkedIn</a>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <?php foreach ( $sample_attorneys as $i => $attorney ) : ?>
          <?php $delay = $i * 100; ?>
          <div class="attorney-card" data-animate="fade-up" style="--stagger-delay:<?php echo esc_attr( $delay ); ?>ms">
            <div class="attorney-card__photo" style="display:flex;align-items:center;justify-content:center;font-size:3rem;">👤</div>
            <h3 class="attorney-card__name"><?php echo esc_html( $attorney['name'] ); ?></h3>
            <div class="attorney-card__title"><?php echo esc_html( $attorney['title'] ); ?></div>
            <div class="attorney-card__bar"><?php echo esc_html( $attorney['bar'] ); ?></div>
            <div class="attorney-card__contact">
              <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $attorney['phone'] ) ); ?>"><?php echo esc_html( $attorney['phone'] ); ?></a>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</section>
