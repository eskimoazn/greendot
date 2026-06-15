<?php defined( 'ABSPATH' ) || exit;

$firm_name = lf_get_firm_data( 'firm_name' ) ?: get_bloginfo( 'name' );
$desc      = lf_get_firm_data( 'description' );
$images_uri = LF_URI . '/assets/images/';
?>
<section class="about" id="about">
  <div class="container about__inner">

    <div class="about__text" data-animate="fade-right">
      <p class="eyebrow"><?php esc_html_e( 'Our Story', 'lawfirm-showcase' ); ?></p>
      <h2 class="section-title">
        <?php
        printf(
          /* translators: %s: firm name */
          esc_html__( 'Fighting for Justice Since Day One', 'lawfirm-showcase' ),
          esc_html( $firm_name )
        );
        ?>
      </h2>
      <p>
        <?php
        if ( $desc ) {
          echo wp_kses_post( $desc );
        } else {
          esc_html_e( 'At our firm, we believe every client deserves exceptional legal representation regardless of the complexity of their case. Our experienced attorneys combine decades of courtroom success with genuine compassion for our clients\' situations.', 'lawfirm-showcase' );
        }
        ?>
      </p>
      <blockquote class="about__quote">
        <?php esc_html_e( 'We don\'t just practice law — we fight for the outcome you deserve.', 'lawfirm-showcase' ); ?>
      </blockquote>

      <div class="about__pillars" data-stagger>
        <div class="about__pillar" data-animate="fade-up">
          <div class="about__pillar-icon" aria-hidden="true">⚖</div>
          <div class="about__pillar-label"><?php esc_html_e( 'Integrity', 'lawfirm-showcase' ); ?></div>
        </div>
        <div class="about__pillar" data-animate="fade-up">
          <div class="about__pillar-icon" aria-hidden="true">🏆</div>
          <div class="about__pillar-label"><?php esc_html_e( 'Results', 'lawfirm-showcase' ); ?></div>
        </div>
        <div class="about__pillar" data-animate="fade-up">
          <div class="about__pillar-icon" aria-hidden="true">🤝</div>
          <div class="about__pillar-label"><?php esc_html_e( 'Experience', 'lawfirm-showcase' ); ?></div>
        </div>
      </div>
    </div>

    <div class="about__visual" data-animate="fade-left">
      <img
        src="<?php echo esc_url( $images_uri . 'office-interior.jpg' ); ?>"
        alt="<?php echo esc_attr( sprintf( __( '%s law office', 'lawfirm-showcase' ), $firm_name ) ); ?>"
        loading="lazy"
        width="600"
        height="750"
      >
      <div class="about__accent-box" aria-hidden="true">
        <div class="about__accent-number">25+</div>
        <div class="about__accent-label"><?php esc_html_e( 'Years of Excellence', 'lawfirm-showcase' ); ?></div>
      </div>
    </div>

  </div>
</section>
