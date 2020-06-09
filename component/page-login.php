<?php
/**
 * Template Name: Boxmoe登录模板
 *  防止刷新页面重复提交数据
 */
 if(!isset($_SESSION))
  session_start();
  
if( isset($_POST['md_token']) && ($_POST['md_token'] == $_SESSION['md_token'])) {
  $error = '';
  $secure_cookie = false;
  $user_name = sanitize_user( $_POST['log'] );
  $user_password = $_POST['pwd'];
  if ( empty($user_name) || ! validate_username( $user_name ) ) {
    $error .= '<strong>错误</strong>：请输入有效的用户名。<br />';
    $user_name = '';
  }
  
  if( empty($user_password) ) {
    $error .= '<strong>错误</strong>：请输入密码。<br />';
  }
  
  if($error == '') {
    // If the user wants ssl but the session is not ssl, force a secure cookie.
    if ( !empty($user_name) && !force_ssl_admin() ) {
      if ( $user = get_user_by('login', $user_name) ) {
        if ( get_user_option('use_ssl', $user->ID) ) {
          $secure_cookie = true;
          force_ssl_admin(true);
        }
      }
    }
	  

      $redirect_to = boxmoe_com('users_page');

	
    if ( !$secure_cookie && is_ssl() && force_ssl_login() && !force_ssl_admin() && ( 0 !== strpos($redirect_to, 'https') ) && ( 0 === strpos($redirect_to, 'http') ) )
      $secure_cookie = false;
	
    $creds = array();
    $creds['user_login'] = $user_name;
    $creds['user_password'] = $user_password;
    $creds['remember'] = !empty( $_POST['rememberme'] );
    $user = wp_signon( $creds, $secure_cookie );
    if ( is_wp_error($user) ) {
      $error .= $user->get_error_message();
    }
    else {
      unset($_SESSION['md_token']);
      wp_safe_redirect($redirect_to);
    }
  }

  unset($_SESSION['md_token']);
}

$rememberme = !empty( $_POST['rememberme'] );
  
$token = md5(uniqid(rand(), true));
$_SESSION['md_token'] = $token;
?>


<?php 
if (!is_user_logged_in()) { get_header();?>
      <section class="section section-about" id="about">
        <div class="container">
          <div class="section-head">
            <span>Login</span>
           </div>
      <div class="container">
        <div class="row justify-content-center">
         <div class="col-lg-6 col-md-8">
            <div class="card border-0">
			<div class="card-header bg-transparent">
              <div class="text-muted text-center mt10"><h3>会员登录</h3></div>
            </div>
              <div class="card-body">
                <div class="btn-wrapper text-center">
<?php if(!empty($error)) {
 echo '<div class="text-muted text-center  mb20"><span class="badge badge-pill badge-danger text-uppercase">'.$error.'</span></div>';
}?>
                </div>
                <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>" novalidate="novalidate">
                  <div class="form-group mb-3">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                      </div>
					  <input type="text" name="log" id="log" class="form-control" value="<?php if(!empty($user_name)) echo $user_name; ?>" placeholder="Email或用户名"  />
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group input-group-alternative">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-key"></i></span>
                      </div>
					  <input id="pwd" class="form-control" type="password" value="" name="pwd"  placeholder="Password"/>
                    </div>
                  </div>
                  <div class="custom-control custom-control-alternative custom-checkbox"> 
                    <input class="custom-control-input" name="rememberme" type="checkbox" id="rememberme" value="1" <?php checked( $rememberme ); ?>>
                    <label class="custom-control-label" for="rememberme">
                      <span>记住账户</span>
                    </label>
                  </div>
                  <div class="text-center"><input type="hidden" name="md_token" value="<?php echo $token; ?>" />
				  <input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>" />
                    <button type="submit" class="btn btn-success my-4">登录账户</button>
                  </div>
                </form>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-6">
                <a href="<?php echo site_url('/') ?>wp-login.php?action=lostpassword" class="btn btn-1 btn-sm btn-outline-warning">
                  <small>忘记密码?</small>
                </a>
              </div>
              <div class="col-6 text-right">
                <a href="<?php echo boxmoe_com('users_reg') ?>" class="btn btn-1 btn-sm btn-outline-warning">
                  <small>创建新帐户</small>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>


 </div>
      </section>
<?php get_footer(); } else {
echo "<script type='text/javascript'>window.location='".boxmoe_com('regto')."'</script>";
} ?>
