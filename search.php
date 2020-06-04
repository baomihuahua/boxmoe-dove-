<?php
/*
* Boxmoe.com template file.
*/
get_header(); ?>
<section class="section section-about" id="about">
        <div class="container">
          <div class="section-head">
            <span>search</span>
            <h4>搜索:[<?php echo htmlspecialchars($s); ?>]<?php echo __('关键词的结果', 'meowdata') ?><?php global $wp_query;echo ' 共' . $wp_query->found_posts . ' 篇文章';?></h4></div>
			<div class="row justify-content-center align-items-center">
<?php while ( have_posts() ) : the_post(); 
if( boxmoe_com( 'bloglistrow' )== 'col-1') {
echo'<div class="col-lg-12 col-md-12 post-boxmoe-standard">' ;	
get_template_part( 'component/blog-list' );
echo' </div>' ;	
 } else if (boxmoe_com( 'bloglistrow' )== 'col-2') { 
get_template_part( 'component/blog-list-row' );
 }  else{ echo'<div class="col-lg-12 col-md-12 post-boxmoe-standard">' ;	get_template_part( 'component/blog-list' );echo' </div>' ;
 } ;
endwhile; ?>
           <div class="col-lg-12 col-md-12">
             <?php bm_paging(); ?>
			 </div>
           </div>                     
        </div>
      </section>
<?php get_footer(); ?>


