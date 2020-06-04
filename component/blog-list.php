<?php
/**
*Boxmoe.com 
*/
?>        
 <div class="entry-blog <?php  echo bm_border() ?> wow zoomIn">                
				<div class="entry-blog-listing clearfix">
                  <div class="post-standard-view">
                    <div class="entry-blog-list-left">
                      <div class="featured-image">
                        <a <?php _post_target_blank() ?> href="<?php echo get_permalink() ?>" title="<?php echo get_the_title().get_the_subtitle(false).bm_connector().get_bloginfo('name')?>">
                          <img class="img-fluid" <?php echo _get_post_thumbnail() ?> alt="<?php echo get_the_title().get_the_subtitle(false).bm_connector().get_bloginfo('name')?>"></a>
                      </div>
                    </div>
                    <div class="entry-blog-list-right">
                      <div class="post-content">
                        <div class="post-header">
                          <span class="category-meta">
                           <?php $category = get_the_category();if($category[0]){ echo '<a href="'.get_category_link($category[0]->term_id ).'" title="查看《'.$category[0]->cat_name.'》下的所有文章 " rel="category tag" '. _post_target_blank().' ><i class="fa fa-sticky-note-o"></i>'.$category[0]->cat_name.'</a>'; };?>
                          </span>
                          <h3 class="entry-post-title">
                            <a href="<?php echo get_permalink() ?>" title="<?php echo get_the_title().get_the_subtitle(false).bm_connector().get_bloginfo('name')?>"><?php echo get_the_title().get_the_subtitle() ?></a>
							</h3>
                        </div>
                        <div class="post-meta-list">
                          <div class="post-meta author-box">
                            <div class="thw-autohr-bio-img">
                              <div class="thw-img-border">
                               <?php echo get_avatar(get_the_author_meta( 'user_email' ),60,'','',array('class'=>array('img-fluid'))); ?>
							   </div>
                            </div>
                            <div class="post-meta-info">
                              <div class="post-meta-info-block">
                                <span class="list-post-view">
                                  <i class="fa fa-calendar"></i>Post on <?php echo get_the_time('Y-m-d') ?></span>
                              </div>
                              <span class="post-author">
                                <i class="fa fa-user-o"></i>By <?php the_author(); ?></span>
                              <span class="list-post-view">
                                <i class="fa fa-street-view"></i><?php echo getPostViews(get_the_ID()) ?></span>
                              <span class="list-post-comment">
                                <i class="fa fa-comments-o"></i><?php echo get_comments_number('0', '1', '%') ?></span>
                            </div>
                          </div>
                        </div>
                        <div class="post-intro-text"><?php echo _get_excerpt() ?></div></div>
                    </div>
                  </div>
                </div>
              </div>