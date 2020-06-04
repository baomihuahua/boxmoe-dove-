<?php get_header(); ?>
<?php get_sidebar(); ?>
<section class="section">
        <div class="container">
          <div class="section-head">
            <span>Single</span></div>
          <div class="row justify-content-center align-items-center">
            <div class="col-lg-12 col-md-12"><?php while (have_posts()) : the_post(); ?><?php setPostViews(get_the_ID()); ?>
              <div class="post-single">
                <h3 class="entry-title"><?php the_title(); echo get_the_subtitle(); ?></h3>
                <div class="entry-header">
                  <div class="post-meta author-box">
                    <div class="thw-autohr-bio-img">
                      <div class="avatarbox">
                        <?php echo get_avatar(get_the_author_meta( 'user_email' ),60,'','',array('class'=>array('img-fluid'))); ?></div>
                      <div class="post-meta-info">
                        <div class="post-meta-info-block">
                          <span class="list-post-date">
                            <i class="fa fa-clock-o"></i>Post on <?php echo get_the_time('Y-m-d'); ?></span>
                        </div>
                        <span class="list-post-author">
                          <i class="fa fa-user-o"></i>By <?php the_author(); ?></span>
                        <span class="list-post-view">
                          <i class="fa fa-eye"></i>浏览(<?php echo getPostViews(get_the_ID()); ?>)</span>
                        <span class="list-post-comment">
                          <i class="fa fa-comments-o"></i>评论(<?php echo get_comments_number('0', '1', '%') ?>)</span>
						  <?php edit_post_link('['.__('编辑仅作者可见', 'boxemoe').']'); ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="entry-content">
                  <?php the_content(); ?>
                </div>
				<?php wp_link_pages(array('before' => '<div class="fenye pagination justify-content-center">', 'after' => '</div>', 'next_or_number' => 'number',
'link_before' =>'<span>', 'link_after'=>'</span>')); ?>  
                <div class="post-footer clearfix mt20">
                  <div class="post-tags">
                    <div class="article-categories">
                      <?php the_tags('','',''); ?>
					  </div>
                  </div>
                </div>
              </div>
			  <?php endwhile;  ?>
              <div class="another-posts thw-sept">
                <div class="row no-gutters">
                  <div class="col-12 col-md-6">
                    <div class="another-post_block prev-post"><?php $previous_post = get_previous_post();if (!empty( $previous_post )){ ?>
                      <div class="post-mini-img text-left"><a href="<?php echo get_permalink( $previous_post->ID ); ?>">
					  <img <?php echo _get_post_thumbnail($previous_post->ID) ?> ></a></div>
                      <div class="post-title">
                        <p><i class="fa fa-angle-left"></i> Previous post</p><a href="<?php echo get_permalink( $previous_post->ID ); ?>"><?php echo $previous_post->post_title; ?></a>
                      </div><?php }else{ ?> <div class="post-mini-img text-left">
					  <img src="<?php echo randpic() ?>" alt="post image" ></div>
                      <div class="post-title">
                        <p><i class="fa fa-angle-left"></i> Previous post</p><a>已经是最后一篇文章了哦！</a>
                      </div><?php }?>
                    </div>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="another-post_block text-right next-post">
                      <?php $next_post = get_next_post();if (!empty( $next_post )){ ?>
                      <div class="post-title">
                        <p>Next post <i class="fa fa-angle-right"></i></p><a href="<?php echo get_permalink( $next_post->ID ); ?>"><?php echo $next_post->post_title; ?></a>
                      </div>
                      <div class="post-mini-img text-right"><a href="<?php echo get_permalink( $next_post->ID ); ?>"><img <?php echo _get_post_thumbnail($next_post->ID) ?>></a></div>
<?php }else{ ?>       <div class="post-title">
                        <p>Next post <i class="fa fa-angle-right"></i></p><a>已经是最新一篇文章了哦！</a>
                      </div>
                      <div class="post-mini-img text-right"><img src="<?php echo randpic() ?>" alt="post image"></div><?php }?>
                    </div>
                </div>
              </div>	 
            </div>
            <?php comments_template('', true); ?>            
            </div>
          </div>
        </div>
				
<?php if( boxmoe_com('post_related_s') ) {?> 	
		<div class=" container mt80">
                    <div class="row">
                    <div class="col-lg-12">	
                    <h3 class="title-normal text-center">相关推荐</h3>	 </div>							
<?php if( boxmoe_com('post_related_s') ) md_posts_related( boxmoe_com('related_title'), boxmoe_com('post_related_n'), (boxmoe_com('post_related_model') ? boxmoe_com('post_related_model') : 'thumb') ) ?>
	</div>
                    </div>		
			<?php }	?>
					
      </section>
<?php get_footer(); ?>