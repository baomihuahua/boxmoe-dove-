<?php 
/*
 * Template Name: 友情链接模板
*/
get_header();
?>
 <section class="section">
        <div class="container">
          <div class="section-head">
            <span>Page</span></div>
          <div class="row justify-content-center align-items-center">
            <div class="col-lg-12 col-md-12">
			<?php while (have_posts()) : the_post(); ?>
              <div class="post-single">
                <h3 class="entry-title"><?php the_title(); ?></h3>
                <div class="entry-content">
				<?php the_content(); ?> 
				</div>
              </div>
			  <?php endwhile;  ?>
			  <?php echo get_link_items(); ?>
			  <?php comments_template('', true); ?>
            </div>
          </div>
      </section>

<?php  get_footer(); ?>