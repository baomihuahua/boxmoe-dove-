<?php
/**
 *blog-list.
 *boxmoe.com 
 *
 */
?>                          <div class="col-md-4 wow zoomIn">						
                            <a <?php _post_target_blank() ?> href="<?php echo get_permalink() ?>" title="<?php echo get_the_title().get_the_subtitle(false).bm_connector().get_bloginfo('name')?>" class="blog-list d-block mb-5">
							<div class="blog-list--img">							
							<img class="img-fluid" <?php echo _get_post_thumbnail() ?> alt="<?php echo get_the_title().get_the_subtitle(false).bm_connector().get_bloginfo('name')?>">
							<div class="blog-list--details d-flex justify-content-center align-items-center">
							<div class="blog-list--details-in">
							<p class="blog-date text-white"><i class="fa fa-calendar"></i> Post on <?php echo get_the_time('Y-m-d') ?></p>
							<span class="blog-cat"><i class="fa fa-user-o"></i> By <?php the_author(); ?></span>
							<span class="blog-cat"><i class="fa fa-comments-o"></i> <?php echo get_comments_number('0', '1', '%') ?></span>	
							</div>								
							</div>							
							</div>							
							<div class="blog-list--desc mt-4">								
							<h3><?php echo get_the_title().get_the_subtitle() ?></h3>
							</div>
							</a>
							</div>