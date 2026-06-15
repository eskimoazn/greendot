<?php defined( 'ABSPATH' ) || exit;
$stats = lf_get_stats();
?>
<section class="stats" aria-label="<?php esc_attr_e( 'Firm statistics', 'lawfirm-showcase' ); ?>">
  <div class="container">
    <div class="stats__row" data-stagger>
      <?php foreach ( $stats as $i => $stat ) : ?>
        <div class="stat-item" data-animate="fade-up" style="--stagger-delay:<?php echo esc_attr( $i * 100 ); ?>ms">
          <div class="stat-item__number" data-count-to="<?php echo esc_attr( $stat['number'] ); ?>">
            <?php echo esc_html( $stat['number'] ); ?>
          </div>
          <div class="stat-item__label"><?php echo esc_html( $stat['label'] ); ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
