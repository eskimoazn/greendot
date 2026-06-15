<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<div class="container" style="padding-top:calc(var(--nav-height) + var(--space-16));padding-bottom:var(--space-24);">
  <h1 style="font-family:var(--font-display);font-size:var(--font-size-4xl);margin-bottom:var(--space-10);"><?php the_archive_title(); ?></h1>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:var(--space-8);">
    <?php while ( have_posts() ) : the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class( 'practice-card' ); ?>>
        <div class="practice-card__body">
          <h2 class="practice-card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p class="practice-card__desc"><?php the_excerpt(); ?></p>
          <a class="practice-card__link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Read More', 'lawfirm-showcase' ); ?></a>
        </div>
      </article>
    <?php endwhile; ?>
  </div>
  <div style="margin-top:var(--space-12);"><?php the_posts_pagination(); ?></div>
</div>
<?php get_footer(); ?>
