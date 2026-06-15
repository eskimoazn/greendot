<?php
defined( 'ABSPATH' ) || exit;
get_header();
?>
<div class="container" style="padding-top:calc(var(--nav-height) + var(--space-16));padding-bottom:var(--space-24);">
  <?php while ( have_posts() ) : the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      <h1 style="font-family:var(--font-display);font-size:var(--font-size-4xl);margin-bottom:var(--space-6);"><?php the_title(); ?></h1>
      <div class="entry-content" style="max-width:72ch;"><?php the_content(); ?></div>
    </article>
  <?php endwhile; ?>
</div>
<?php get_footer(); ?>
