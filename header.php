<!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo bm_title(); ?></title>
<?php if (boxmoe_com('favicon_src') ): ?>    <link rel="shortcut icon" href="<?php echo boxmoe_com('favicon_src')?>" /><?php endif; ?> 	
    <?php wp_head(); ?>
	<?php if (boxmoe_com('diystyles') ): ?>    <link rel="stylesheet" href="<?php echo boxmoe_load_style(); ?>/assets/css/diystyle.css"><?php endif; ?>
  </head> 
  <body data-spy="scroll" data-target=".navbar">
    <div id="loading" class="loading">
    <div id="begin"></div>
  </div>
    <aside class="aside">
      <div class="nav-wrapper">
        <div class="navbar-toggler">
          <svg class="ham hamRotate ham1" viewBox="0 0 100 100" width="60">
            <path class="line top" d="m 30,33 h 40 c 0,0 9.044436,-0.654587 9.044436,-8.508902 0,-7.854315 -8.024349,-11.958003 -14.89975,-10.85914 -6.875401,1.098863 -13.637059,4.171617 -13.637059,16.368042 v 40" />
            <path class="line middle" d="m 30,50 h 40" />
            <path class="line bottom" d="m 30,67 h 40 c 12.796276,0 15.357889,-11.717785 15.357889,-26.851538 0,-15.133752 -4.786586,-27.274118 -16.667516,-27.274118 -11.88093,0 -18.499247,6.994427 -18.435284,17.125656 l 0.252538,40" /></svg>
		</div>
        <nav class="navbar text-center align-items-center justify-content-center">
          <div class="collapse navbar-collapse show" id="navbarCollapse">
            <div class="about-avatar mb-5">
              <a href="<?php echo home_url(); ?>">
                <?php echo bm_logo() ;?></a>
              <div class="about-avatar-details mt-4">
                <h1><?php bloginfo( 'webname' ); ?></h1>
				<?php if (boxmoe_com('blog_site') ){echo'<p class="badge">'.boxmoe_com('blog_site').'</p>';}else{echo'<p class="badge">Wordpress</p>';} ?>                 
				</div>
            </div>
            <ul class="navbar-nav mx-auto">
              <?php bm_nav_menu() ;?>
			  <?php if( boxmoe_com('sousuo') ) { echo '<li class="nav-item "><a href="#search" class="nav-link"><i class="fa fa-search"></i>搜索</a></li>';} ?>  
            </ul>
			<?php if( boxmoe_com('sign_f') ) { ?>
			<?php if ( is_user_logged_in() ) {?>
			<ul class="list-group userlogin mb20"  id="longining" >
			<li class="checklist-entry list-group-item flex-column align-items-start px-4">       
			<div class="checklist-item checklist-item-success">
			    <div class="checklist-info">
 			       <h5 class="checklist-title mb-0">Hello！欢迎回来!</h5>
			        <small><a href="<?php echo boxmoe_com('users_page') ?>"><i class="fa fa-user-circle-o"></i>会员中心</a><a href="<?php echo wp_logout_url( home_url() ); ?>"><i class="fa fa-sign-out"></i>注销登录</a></small>
 			   </div>
 			<div>
 			   </div>
			</div>
    </li>
		</ul><?php } else {?>	
			<div class="admin-login" id="longinreg">
              <div class="ruike_user-wrapper">
                <span class="ruike_user-loader">
                  <a href="<?php echo boxmoe_com('users_login') ?>" class="signin-loader z-bor">登录</a>
                  <b class="middle-text">
                    <span class="middle-inner">or</span></b>
                </span>
                <span class="ruike_user-loader">
                  <a href="<?php echo boxmoe_com('users_reg') ?>" class="signup-loader l-bor">注册</a></span>
              </div>
              <i class="up-new"></i>
            </div>
			<?php } ?>	<?php } ?>	
          </div>
          <div class="aside-footer">
            <ul class="list-unstyled list-inline wow bounceInUp animated">
			<?php if(boxmoe_com('boxmoe_qq')){?>
              <li class="list-inline-item">
                <a target="_blank" href="https://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo boxmoe_com('boxmoe_qq');?>&amp;site=qq&amp;menu=yes">
                  <i class="fa fa-qq"></i>
                </a>
              </li>
			  <?php } ?><?php if(boxmoe_com('boxmoe_wechat')){?>
              <li class="list-inline-item">
                <a  href="index.html#">
                  <i class="fa fa-weixin"></i>
                  </i>
                </a>
              </li>
			  <?php } ?><?php if(boxmoe_com('boxmoe_weibo')){?>
              <li class="list-inline-item">
                <a target="_blank" href="<?php echo boxmoe_com('boxmoe_weibo');?>">
                  <i class="fa fa-weibo"></i>
                </a>
              </li>
			   <?php } ?><?php if(boxmoe_com('boxmoe_github')){?>
              <li class="list-inline-item">
                <a target="_blank" href="<?php echo boxmoe_com('boxmoe_github');?>">
                  <i class="fa fa-github"></i>
                </a>
              </li>
			  <?php } ?>
			  <?php if(boxmoe_com('boxmoe_mail')){?>
			  <li class="list-inline-item">
                <a target="_blank" href="//mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=<?php echo boxmoe_com('boxmoe_mail');?>">
                  <i class="fa fa-envelope-o"></i>
                </a>
              </li>
			  <?php } ?>
            </ul>
          </div>
        </nav>
      </div>
      </aside>

    <div class="page-overlay">
      <span class="overlay-1"></span>
      <span class="overlay-2"></span>
    </div>
    <div class="page-wrapper" id="global" >
      <section class="section-home " id="home">
        <div class="glass" <?php bm_banner();?>"></div></section>