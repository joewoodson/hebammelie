<?php
/**
 * Template Name: Homepage Template
 */
?>

<?php while (have_posts()) : the_post(); ?>
  <section class="container">
    <div class="row">
      <div class="col-md-8">
        <?php get_template_part('templates/content', 'page'); ?>
      </div>
      <div class="col-md-4 text-center">
        <img class="img-responsive img-thumbnail headshot" src="<?php echo get_template_directory_uri(); ?>/dist/images/headshot-min.jpg" alt="amelie headshot">
      </div>
    </div>
  </section>
  <?php get_template_part('templates/services'); ?>
  <?php get_template_part('templates/news'); ?>
  <?php get_template_part('templates/testimonials'); ?>
<?php endwhile; ?>
