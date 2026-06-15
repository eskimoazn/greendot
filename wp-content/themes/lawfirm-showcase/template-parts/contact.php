<?php defined( 'ABSPATH' ) || exit;

$phone   = lf_get_firm_data( 'phone' );
$email   = lf_get_firm_data( 'email' );
$address = lf_get_firm_data( 'address' );
$city    = lf_get_firm_data( 'city' );
$state   = lf_get_firm_data( 'state' );
$zip     = lf_get_firm_data( 'zip' );

$practice_areas = [
	'Personal Injury', 'Criminal Defense', 'Family Law',
	'Estate Planning', 'Business Law', 'Real Estate Law',
	'Immigration Law', 'Employment Law', 'Other',
];
?>
<section class="contact" id="contact">
  <div class="container contact__inner">

    <div class="contact__form" data-animate="fade-right">
      <p class="eyebrow"><?php esc_html_e( 'Get In Touch', 'lawfirm-showcase' ); ?></p>
      <h2 class="section-title"><?php esc_html_e( 'Free Case Evaluation', 'lawfirm-showcase' ); ?></h2>
      <p style="margin-bottom:var(--space-8);color:var(--color-text-secondary);">
        <?php esc_html_e( 'Tell us about your situation and we\'ll get back to you within 24 hours.', 'lawfirm-showcase' ); ?>
      </p>

      <form class="lf-contact-form" id="lf-contact-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
        <?php wp_nonce_field( 'lf_contact_nonce', 'lf_nonce' ); ?>
        <input type="hidden" name="action" value="lf_contact_submit">

        <div class="lf-hp" aria-hidden="true">
          <label for="lf_hp_field">Leave blank</label>
          <input type="text" id="lf_hp_field" name="lf_hp" tabindex="-1" autocomplete="off">
        </div>

        <div class="form-row form-row--2col">
          <div class="form-group">
            <label class="form-label" for="lf_name"><?php esc_html_e( 'Full Name', 'lawfirm-showcase' ); ?> <span aria-hidden="true">*</span></label>
            <input class="form-input" type="text" id="lf_name" name="lf_name" required autocomplete="name" placeholder="Jane Smith">
          </div>
          <div class="form-group">
            <label class="form-label" for="lf_phone"><?php esc_html_e( 'Phone Number', 'lawfirm-showcase' ); ?></label>
            <input class="form-input" type="tel" id="lf_phone" name="lf_phone" autocomplete="tel" placeholder="(555) 000-0000">
          </div>
        </div>

        <div class="form-row form-row--2col">
          <div class="form-group">
            <label class="form-label" for="lf_email"><?php esc_html_e( 'Email Address', 'lawfirm-showcase' ); ?> <span aria-hidden="true">*</span></label>
            <input class="form-input" type="email" id="lf_email" name="lf_email" required autocomplete="email" placeholder="jane@example.com">
          </div>
          <div class="form-group">
            <label class="form-label" for="lf_subject"><?php esc_html_e( 'Practice Area', 'lawfirm-showcase' ); ?></label>
            <select class="form-select" id="lf_subject" name="lf_subject">
              <option value=""><?php esc_html_e( 'Select…', 'lawfirm-showcase' ); ?></option>
              <?php foreach ( $practice_areas as $area ) : ?>
                <option value="<?php echo esc_attr( $area ); ?>"><?php echo esc_html( $area ); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label" for="lf_message"><?php esc_html_e( 'Your Message', 'lawfirm-showcase' ); ?> <span aria-hidden="true">*</span></label>
          <textarea class="form-textarea" id="lf_message" name="lf_message" rows="5" required placeholder="<?php esc_attr_e( 'Briefly describe your legal matter…', 'lawfirm-showcase' ); ?>"></textarea>
        </div>

        <div class="form-group form-group--submit">
          <button class="btn btn--primary form-submit" type="submit">
            <span class="form-submit__text"><?php esc_html_e( 'Send Message', 'lawfirm-showcase' ); ?></span>
            <span class="form-submit__loading" hidden><?php esc_html_e( 'Sending…', 'lawfirm-showcase' ); ?></span>
          </button>
        </div>

        <div class="form-response" role="status" aria-live="polite" hidden></div>
      </form>
    </div>

    <div class="contact__info" data-animate="fade-left">
      <p class="eyebrow"><?php esc_html_e( 'Our Office', 'lawfirm-showcase' ); ?></p>
      <h2 class="section-title"><?php esc_html_e( 'Reach Out Directly', 'lawfirm-showcase' ); ?></h2>

      <address class="footer__address">
        <?php if ( $address ) : ?>
          <div class="contact__info-item">
            <span aria-hidden="true">📍</span>
            <span>
              <?php echo esc_html( $address ); ?><br>
              <?php if ( $city ) echo esc_html( $city . ', ' . $state . ' ' . $zip ); ?>
            </span>
          </div>
        <?php endif; ?>
        <?php if ( $phone ) : ?>
          <div class="contact__info-item">
            <span aria-hidden="true">📞</span>
            <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
          </div>
        <?php endif; ?>
        <?php if ( $email ) : ?>
          <div class="contact__info-item">
            <span aria-hidden="true">✉</span>
            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
          </div>
        <?php endif; ?>
        <div class="contact__info-item">
          <span aria-hidden="true">🕐</span>
          <span><?php esc_html_e( 'Mon–Fri: 9am–6pm · 24/7 Emergency Line', 'lawfirm-showcase' ); ?></span>
        </div>
      </address>

      <div class="contact__map" aria-label="<?php esc_attr_e( 'Office location map', 'lawfirm-showcase' ); ?>">
        <?php esc_html_e( 'Map Embed', 'lawfirm-showcase' ); ?>
      </div>
    </div>

  </div>
</section>
