<?php defined( 'ABSPATH' ) || exit;

$testimonials = lf_get_testimonials();

$sample_testimonials = [
	[
		'quote'    => 'The team at this firm went above and beyond for my case. They were available every step of the way and secured an outcome I never thought possible.',
		'name'     => 'Sarah T.',
		'city'     => 'Miami, FL',
		'area'     => 'Personal Injury',
		'rating'   => 5,
	],
	[
		'quote'    => 'Professional, knowledgeable, and genuinely caring. My family law matter was handled with sensitivity and sharp legal expertise. Highly recommend.',
		'name'     => 'Michael R.',
		'city'     => 'Atlanta, GA',
		'area'     => 'Family Law',
		'rating'   => 5,
	],
	[
		'quote'    => 'They took my call on a Friday evening and had a strategy ready by Monday. That level of dedication is rare and I\'m grateful for everything they did.',
		'name'     => 'Linda K.',
		'city'     => 'Dallas, TX',
		'area'     => 'Criminal Defense',
		'rating'   => 5,
	],
	[
		'quote'    => 'Our business faced a serious legal challenge and this firm turned it around completely. Strategic, efficient, and excellent communicators throughout.',
		'name'     => 'David M.',
		'city'     => 'Chicago, IL',
		'area'     => 'Business Law',
		'rating'   => 5,
	],
];
?>
<section class="testimonials" id="testimonials">
  <div class="container">

    <div class="section-header section-header--centered" data-animate="fade-up">
      <p class="eyebrow"><?php esc_html_e( 'Client Stories', 'lawfirm-showcase' ); ?></p>
      <h2 class="section-title"><?php esc_html_e( 'What Our Clients Say', 'lawfirm-showcase' ); ?></h2>
    </div>

    <div class="testimonials__track" data-stagger>
      <?php if ( $testimonials ) : ?>
        <?php foreach ( $testimonials as $i => $t ) : ?>
          <?php
          $delay  = $i * 100;
          $client = get_post_meta( $t->ID, 'lf_client_name', true ) ?: $t->post_title;
          $city   = get_post_meta( $t->ID, 'lf_client_city', true );
          $rating = (int) get_post_meta( $t->ID, 'lf_rating', true ) ?: 5;
          $area   = get_post_meta( $t->ID, 'lf_practice_area', true );
          ?>
          <div class="testimonial-card" data-animate="fade-up" style="--stagger-delay:<?php echo esc_attr( $delay ); ?>ms">
            <div class="testimonial-card__mark" aria-hidden="true">&ldquo;</div>
            <p class="testimonial-card__quote"><?php echo wp_kses_post( $t->post_content ); ?></p>
            <div class="testimonial-card__author">
              <div>
                <?php echo wp_kses_post( lf_stars( $rating ) ); ?>
                <div class="testimonial-card__name"><?php echo esc_html( $client ); ?></div>
                <div class="testimonial-card__meta"><?php echo esc_html( trim( $city . ( $area ? ' · ' . $area : '' ) ) ); ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <?php foreach ( $sample_testimonials as $i => $t ) : ?>
          <?php $delay = $i * 100; ?>
          <div class="testimonial-card" data-animate="fade-up" style="--stagger-delay:<?php echo esc_attr( $delay ); ?>ms">
            <div class="testimonial-card__mark" aria-hidden="true">&ldquo;</div>
            <p class="testimonial-card__quote"><?php echo esc_html( $t['quote'] ); ?></p>
            <div class="testimonial-card__author">
              <div>
                <?php echo wp_kses_post( lf_stars( $t['rating'] ) ); ?>
                <div class="testimonial-card__name"><?php echo esc_html( $t['name'] ); ?></div>
                <div class="testimonial-card__meta"><?php echo esc_html( $t['city'] . ' · ' . $t['area'] ); ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>

  </div>
</section>
