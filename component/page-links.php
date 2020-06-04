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
<style>  
    .clearfix{zoom:1;}.clearfix:after{content:‘.’;display:block;visibility:hidden;height:0;clear:both;}.readers-list{list-style:none;}.readers-list *{margin:0;padding:0;}.readers-list li{position:relative;float:left;margin-top:20px!important;padding:0 10px;}.readers-list li a{display:block;border:1px solid #eee;border-left:3px solid #FF002B;border-radius:7px;padding-left:15px;transition:all .3s;}.readers-list li:nth-of-type(6n+1) a{border-left-color:#FF002B;}.readers-list li:nth-of-type(6n+2) a{border-left-color:#FFA900;}.readers-list li:nth-of-type(6n+3) a{border-left-color:#00CC00;}.readers-list li:nth-of-type(6n+4) a{border-left-color:#00CCFF;}.readers-list li:nth-of-type(6n+5) a{border-left-color:#0089FA;}.readers-list li:nth-of-type(6n+6) a{border-left-color:#404040;}.readers-list li a div{padding:12px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;color:#ec947a;}.readers-list li a div:first-child{border-bottom:1px dashed #cb97a9;font-size:1.3em;color:#bd98bd;}.readers-list li a:hover{-webkit-transform:translateY(-6px);transform:translateY(-6px);box-shadow:0 26px 40px -24px rgba(0,0,0,0.3);}.link-title{position:relative;display:inline-block;margin:20px 0;font-size:15px;padding:0 30px 0 25px;height:45px;line-height:45px;border-radius:0 35px 35px 0;background:#a69bdf;color:#fff;}@media(min-width:768px){.readers-list li{width:33.3333333%;}}@media(max-width:767px){.readers-list li{width:100%;}}.readers-list img{width: 35px;height: 35px;margin-right: 10px;border: 1px solid #a59bdf;border-radius: 50%;}</style>