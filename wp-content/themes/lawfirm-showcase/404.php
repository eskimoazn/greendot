<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<div class="container" style="padding-top:calc(var(--nav-height) + var(--space-24));padding-bottom:var(--space-24);text-align:center;min-height:70vh;display:flex;flex-direction:column;align-items:center;justify-content:center;">
  <div style="font-family:var(--font-display);font-size:clamp(6rem,20vw,14rem);font-weight:700;line-height:1;color:var(--color-accent-1);opacity:0.25;">404</div>
  <h1 style="font-family:var(--font-display);font-size:var(--font-size-3xl);margin-bottom:var(--space-4);"><?php esc_html_e( 'Page Not Found', 'lawfirm-showcase' ); ?></h1>
  <p style="color:var(--color-text-secondary);max-width:48ch;margin-bottom:var(--space-10);"><?php esc_html_e( 'The page you\'re looking for may have moved or no longer exists. Let us help you find what you need.', 'lawfirm-showcase' ); ?></p>
  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Return Home', 'lawfirm-showcase' ); ?></a>
</div>
<?php get_footer(); ?>
