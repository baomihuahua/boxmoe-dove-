      <footer class="footer section">        
	  <div class="container">          
	  <hr class="hr-icon">  
<?php echo boxmoe_com('footer_seo') ;?>	  
	  <p class="copyright text-center">	  
	  &copy; <a href="<?php echo home_url();?>" target="_blank" title="<?php echo get_bloginfo( 'name' );?>"><?php echo get_bloginfo( 'name' );?></a> <?php echo date('Y'); ?> | Theme by
          <a href="https://www.boxmoe.com" target="_blank">Boxmoe</a>  <?php echo boxmoe_com('footer_info') ;?>
		  <?php if(boxmoe_com('boxmoedataquery') ){?><br>本页花费了<?php timer_stop(3); ?>秒进行了<?php echo get_num_queries(); ?> 次数据查询.<?php } ?>
		<?php if(boxmoe_com('trackcode') ){?> <span <?php if(boxmoe_com('trackcodehidden'))echo 'style="display:none;"'?>><br><?php echo boxmoe_com('trackcode'); ?></span><?php } ?>  
		  </p>
		  
	  </div>      
	  </footer>    
	  </div> <?php if (boxmoe_com('lolijump') ): ?>   
	  <div id="lolijump" data-toggle="tooltip" data-original-title="点我电脑会爆炸，不信试试看">
      <img src="<?php echo boxmoe_load_style(); ?>/assets/images/top/<?php echo boxmoe_com('lolijumpsister'); ?>.gif">
	  </div><?php endif; ?>
	  <div id="search"> 
	  <span class="close">X</span>
	  <form role="search" id="searchform" method="get" action="<?php echo home_url( '/' ) ?>">
	  <input type="search" name="s" value="<?php echo htmlspecialchars($s) ?>" placeholder="输入搜索关键词..."/>
	  </form>
      </div>
	  <script src="<?php echo boxmoe_load_style(); ?>/assets/js/vendor.js"></script>
	  <script src="<?php echo boxmoe_load_style(); ?>/assets/js/boxmoe.js"></script>
	  <script src="<?php echo get_template_directory_uri(); ?>/assets/js/comments.js"></script>	  
	  <?php wp_footer();?>
	</body>
	</html>

