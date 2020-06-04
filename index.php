<?php
/*
* Boxmoe.com template file.
*/
get_header(); ?>

      <section class="section section-about" id="about">
        <div class="container">
          <div class="section-head">
            <span><?php if(is_home()) {echo'Home';}else{echo'category';}  ?></span>
            <h2>New post</h2></div>
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