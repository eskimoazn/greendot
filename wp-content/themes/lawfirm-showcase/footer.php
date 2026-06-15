<?php defined( 'ABSPATH' ) || exit; ?>
</main><!-- #main -->

<footer id="colophon" class="site-footer" role="contentinfo">
  <div class="container footer__inner">

    <div class="footer__brand">
      <div class="footer__firm-name">
        <?php echo esc_html( lf_get_firm_data( 'firm_name' ) ?: get_bloginfo( 'name' ) ); ?>
      </div>
      <p class="footer__tagline">
        <?php echo esc_html( lf_get_firm_data( 'tagline' ) ?: get_bloginfo( 'description' ) ); ?>
      </p>
      <div class="footer__social">
        <?php if ( $fb = lf_get_firm_data( 'facebook' ) ) : ?>
          <a href="<?php echo esc_url( $fb ); ?>" class="social-link" aria-label="Facebook" rel="noopener noreferrer" target="_blank">
            <svg aria-hidden="true" viewBox="0 0 24 24" width="20" height="20"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
          </a>
        <?php endif; ?>
        <?php if ( $ig = lf_get_firm_data( 'instagram' ) ) : ?>
          <a href="<?php echo esc_url( $ig ); ?>" class="social-link" aria-label="Instagram" rel="noopener noreferrer" target="_blank">
            <svg aria-hidden="true" viewBox="0 0 24 24" width="20" height="20"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
          </a>
        <?php endif; ?>
        <?php if ( $li = lf_get_firm_data( 'linkedin' ) ) : ?>
          <a href="<?php echo esc_url( $li ); ?>" class="social-link" aria-label="LinkedIn" rel="noopener noreferrer" target="_blank">
            <svg aria-hidden="true" viewBox="0 0 24 24" width="20" height="20"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
          </a>
        <?php endif; ?>
      </div>
    </div>

    <div class="footer__nav">
      <div class="footer__col">
        <h4 class="footer__heading"><?php esc_html_e( 'Practice Areas', 'lawfirm-showcase' ); ?></h4>
        <?php
        wp_nav_menu( [
          'theme_location' => 'footer',
          'menu_class'     => 'footer-menu',
          'fallback_cb'    => false,
          'depth'          => 1,
        ] );
        ?>
      </div>
      <div class="footer__col">
        <h4 class="footer__heading"><?php esc_html_e( 'Contact', 'lawfirm-showcase' ); ?></h4>
        <address class="footer__address">
          <?php if ( $addr = lf_get_firm_data( 'address' ) ) : ?>
            <span><?php echo esc_html( $addr ); ?></span>
          <?php endif; ?>
          <?php if ( $city = lf_get_firm_data( 'city' ) ) : ?>
            <span><?php echo esc_html( $city . ', ' . lf_get_firm_data( 'state' ) . ' ' . lf_get_firm_data( 'zip' ) ); ?></span>
          <?php endif; ?>
          <?php if ( $phone = lf_get_firm_data( 'phone' ) ) : ?>
            <a href="tel:<?php echo esc_attr( preg_replace( '/\D/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a>
          <?php endif; ?>
          <?php if ( $email = lf_get_firm_data( 'email' ) ) : ?>
            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
          <?php endif; ?>
        </address>
      </div>
    </div>

  </div><!-- .footer__inner -->

  <div class="footer__bar">
    <div class="container footer__bar-inner">
      <p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( lf_get_firm_data( 'firm_name' ) ?: get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'lawfirm-showcase' ); ?></p>
      <p class="footer__disclaimer"><?php esc_html_e( 'This website is for informational purposes only. Attorney advertising.', 'lawfirm-showcase' ); ?></p>
    </div>
  </div>
</footer>

</div><!-- #page -->

<?php /* Template Switcher Panel */ ?>
<div id="showcase-switcher" class="showcase-switcher" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Choose a Design Style', 'lawfirm-showcase' ); ?>" aria-hidden="true">
  <button class="showcase-switcher__close" aria-label="<?php esc_attr_e( 'Close template switcher', 'lawfirm-showcase' ); ?>">&times;</button>
  <div class="showcase-switcher__header">
    <h2 class="showcase-switcher__title"><?php esc_html_e( 'Choose a Design Style', 'lawfirm-showcase' ); ?></h2>
    <p class="showcase-switcher__sub"><?php esc_html_e( '12 unique concepts — click any to preview instantly', 'lawfirm-showcase' ); ?></p>
  </div>
  <div class="showcase-switcher__grid" id="switcher-grid">
    <?php echo lf_render_switcher_cards(); ?>
  </div>
</div>

<button id="switcher-trigger" class="showcase-trigger" aria-label="<?php esc_attr_e( 'Open template switcher', 'lawfirm-showcase' ); ?>" aria-controls="showcase-switcher" aria-expanded="false">
  <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
  <span><?php esc_html_e( 'Styles', 'lawfirm-showcase' ); ?></span>
</button>

<?php wp_footer(); ?>
</body>
</html>
