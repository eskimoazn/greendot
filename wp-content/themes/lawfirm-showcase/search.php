<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<div class="container" style="padding-top:calc(var(--nav-height) + var(--space-16));padding-bottom:var(--space-24);">
  <h1 style="font-family:var(--font-display);font-size:var(--font-size-3xl);margin-bottom:var(--space-6);">
    <?php printf( esc_html__( 'Results for: %s', 'lawfirm-showcase' ), '<em>' . esc_html( get_search_query() ) . '</em>' ); ?>
  </h1>
  <div style="margin-bottom:var(--space-10);"><?php get_search_form(); ?></div>
  <?php if ( have_posts() ) : ?>
    <div style="display:flex;flex-direction:column;gap:var(--space-8);">
      <?php while ( have_posts() ) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
          <h2 style="font-family:var(--font-display);font-size:var(--font-size-xl);margin-bottom:var(--space-2);">
            <a href="<?php the_permalink(); ?>" style="color:var(--color-text-primary);"><?php the_title(); ?></a>
          </h2>
          <p style="color:var(--color-text-secondary);"><?php the_excerpt(); ?></p>
        </article>
      <?php endwhile; ?>
    </div>
    <div style="margin-top:var(--space-12);"><?php the_posts_pagination(); ?></div>
  <?php else : ?>
    <p><?php esc_html_e( 'No results found. Try a different search term.', 'lawfirm-showcase' ); ?></p>
  <?php endif; ?>
</div>
<?php get_footer(); ?>
