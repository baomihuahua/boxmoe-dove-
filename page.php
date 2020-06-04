<?php get_header(); ?>
<?php get_sidebar(); ?>
      <section class="section">
        <div class="container">
          <div class="section-head">
            <span>Page</span></div>
          <div class="row justify-content-center align-items-center">
            <div class="col-lg-12 col-md-12"><?php while (have_posts()) : the_post(); ?>
              <div class="post-single">
                <h3 class="entry-title"><?php the_title(); echo get_the_subtitle(); ?></h3>
                <div class="entry-content"><?php the_content(); ?></div>
				<?php wp_link_pages(array('before' => '<div class="fenye pagination justify-content-center">', 'after' => '</div>', 'next_or_number' => 'number',
'link_before' =>'<span>', 'link_after'=>'</span>')); ?>  
              </div><?php endwhile;  ?>
			  <?php comments_template('', true); ?>
            </div>
          </div>
      </section>
<?php get_footer(); ?>	  

