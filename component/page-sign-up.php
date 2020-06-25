<?php
/*Template Name: Boxmoe注册模板*/
	
//如果用户已经登陆那么跳转到首页
if (is_user_logged_in()){
  wp_safe_redirect( get_option('home') );
  exit;
}
	
//获取注册页面提交时候的表单数据

if( !empty($_POST['csyor_reg']) ) {
  $error = '';
  $redirect_to =  boxmoe_com('users_page');
  $sanitized_user_login = sanitize_user( $_POST['user_login'] );
  $user_website = sanitize_user( $_POST['website'] );
  $user_nickname = sanitize_user( $_POST['nickname'] );
  $user_email = apply_filters( 'user_registration_email', $_POST['user_email'] );
  $comment_aaa      	  = ( isset($_POST['aaa']) ) ? trim($_POST['aaa']) : '0';
  $comment_bbb          = ( isset($_POST['bbb']) ) ? trim($_POST['bbb']) : '0';
  $comment_subab        = ( isset($_POST['subab']) ) ? trim($_POST['subab']) : '0';
	
  // 验证邮箱
  if ( $user_email == '' ) {
    $error .= '错误：请填写电子邮件地址。';
  } elseif ( ! is_email( $user_email ) ) {
    $error .= '错误：电子邮件地址不正确。';
    $user_email = '';
  } elseif ( email_exists( $user_email ) ) {
    $error .= '错误：该电子邮件地址已经被注册，请换一个。';
  }
	
  // 验证用户名
  elseif ( $sanitized_user_login == '' ) {
    $error .= '错误：请输入登陆账号。';
  } elseif ( !preg_match("/^[a-zA-Z0-9_]{4,16}$/",$sanitized_user_login) ) {
    $error .= '错误：登陆账号只能包含字母、数字、下划线，长度4到16位。';
    $sanitized_user_login = '';
  } elseif ( username_exists( $sanitized_user_login ) ) {
    $error .= '错误：该用户名已被注册，请再选择一个。';
  }
	
  //验证密码
  elseif(strlen($_POST['user_pass']) < 6){
    $error .= '错误：密码长度至少6位。';
  }elseif($_POST['user_pass'] != $_POST['user_pass2']){
    $error .= '错误：两次输入的密码必须一致。';
  }elseif(((int)$comment_subab)!=(((int)$comment_aaa)+((int)$comment_bbb))){
    $error .= '错误：请输入正确的计算结果。';	
  }
	
  if($error == '') {
    //验证全部通过进入注册信息添加
    $display_name = empty($user_nickname)?$sanitized_user_login:$user_nickname;
    $user_pass = $_POST['user_pass'];
    $user_id = wp_insert_user( array ( 
      'user_login' => $sanitized_user_login, 
      'user_pass' => $user_pass , 
      'nickname' => $user_nickname,
      'display_name' => $display_name, 
      'user_email' => $user_email, 
      'user_url' => $user_website) ) ;
		
    //意外情况判断，添加失败
    if ( ! $user_id ) {
      $error .= sprintf( '错误：无法完成您的注册请求... 请联系<a href=\"mailto:%s\">管理员</a>！</p>', get_option( 'admin_email' ) );
    }else if (!is_user_logged_in()) {
      //注册成功发送邮件通知用户
	  $from = get_option('admin_email');
	  $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
      $subject = '您在 [' . get_option("blogname") . '] 的注册已经成功';
	  $msg = '<table style="width:50%;height:100%;margin:auto;"><tbody><tr><td style="background:#fafafa url()">
<div style="border-radius: 10px 10px 10px 10px;font-size:13px;color: #555555;width:100%;font-family:"Century Gothic","Trebuchet MS","Hiragino Sans GB",微软雅黑,"Microsoft Yahei",Tahoma,Helvetica,Arial,"SimSun",sans-serif;margin:50px auto;border:1px solid #eee;max-width:100%;background: #ffffff repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);">
<div style="width:100%;background:#49BDAD;color:#ffffff;border-radius: 10px 10px 0 0;background-image: -moz-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));background-image: -webkit-linear-gradient(0deg, rgb(67, 198, 184), rgb(255, 209, 244));height: 66px;">
<p style="font-size:15px;word-break:break-all;padding: 23px 32px;margin:0;background-color: hsla(0,0%,100%,.4);border-radius: 10px 10px 0 0;">您在<a style="text-decoration:none;color: #ffffff;" href="' . home_url(). '" rel="noopener" target="_blank"> [' . get_option('blogname') . '] </a> 的会员注册信息！</p>
</div><div style="margin:40px 30px"><p>恭喜注册成功，请保存好您的会员信息</p><p style="background: #fafafa repeating-linear-gradient(-45deg,#fff,#fff 1.125rem,transparent 1.125rem,transparent 2.25rem);box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);margin:20px 0px;padding:15px;border-radius:5px;font-size:14px;color:#555555;">
用户名: '.$sanitized_user_login.' <br>
邮  箱: '.$user_email.' <br>
密  码: '. $_POST['user_pass'] . '</p>
<p>此邮件由 <a style="text-decoration:none; color:#12addb" href="' . home_url(). '" rel="noopener" target="_blank"> ' . get_option('blogname') . ' </a> 系统自动发送，请勿直接回复！</p>
</div></div></td></tr></tbody></table>';
			//发送邮件
			wp_mail( $user_email, $subject, $msg, $headers );
      $user = get_userdatabylogin($sanitized_user_login);
      $user_id = $user->ID;
			
      // 自动登录
      wp_set_current_user($user_id, $user_login);
      wp_set_auth_cookie($user_id);
      do_action('wp_login', $user_login);
	 // 登录后调整页面		
      wp_safe_redirect( $redirect_to );
    }
  }
}	
?>
<?php
if (!is_user_logged_in()) { get_header(); ?>
      <section class="section section-about" id="about">
        <div class="container">
          <div class="section-head">
            <span>registered</span>
           </div>
 <?php if (have_posts()) : while (have_posts()) : the_post(); ?>			
<div class="container">
<div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="card border-0">
            <div class="card-header bg-transparent">
              <div class="text-muted text-center mt10"><h3>会员注册</h3></div>
            </div>
            <div class="card-body px-lg-5 py-lg-5">
			<?php if(!empty($error)) {echo '<div class="text-center mb-4 text-danger"><small>'.$error.'</small></div>';}?>			
       <form name="registerform" method="post" action="#">
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <input class="form-control" placeholder="用户名（*必填）" name="user_login" id="user_login" tabIndex="2" value="<?php if(!empty($sanitized_user_login)) echo $sanitized_user_login; ?>" required type="text">
                  </div>
                </div>
				<div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                    </div>
                    <input class="form-control" placeholder="输入密码（*必填）" tabindex="3" id="user_pwd1" name="user_pass"  required type="password">
                  </div>
                </div>
				<div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-asterisk"></i></span>
                    </div>
                    <input class="form-control" placeholder="重复输入密码（*必填）" tabindex="4" id="user_pwd2" name="user_pass2"  required type="password">
                  </div>
                </div>
                <div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-envelope-o"></i></span>
                    </div>
                    <input class="form-control" placeholder="Email（*必填）" name="user_email" id="user_email" tabIndex="1" value="<?php if(!empty($user_email)) echo $user_email; ?>" required type="email">
                  </div>
                </div>
				<div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-address-book-o"></i></span>
                    </div>
                    <input class="form-control" placeholder="昵称" tabindex="5" id="nickname" name="nickname" type="text">
                  </div>
                </div>
				<div class="form-group">
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-globe"></i></span>
                    </div>
                    <input class="form-control" placeholder="网址" tabindex="6" id="website" name="website" type="text">
                  </div>
                </div>
                <div class="form-group">
				<label class="form-control-label" >验证问题：<?php $aaa=rand(1,9); $bbb=rand(1,9); ?>
							<?php echo $aaa; ?>+<?php echo $bbb; ?>=
							<input name="aaa" value="<?php echo $aaa; ?>" type="hidden" />
							<input name="bbb" value="<?php echo $bbb; ?>" type="hidden" />
							</label>
                  <div class="input-group input-group-merge input-group-alternative mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-key"></i></span>
                    </div>
                    <input class="form-control" placeholder="验证码（*必填）"  name="subab" id="subab" tabindex="8" required type="text">
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" name="wp-submit"  id="wp-submit"  tabindex="7" class="btn btn-success">提交注册</button>
				  <input type="hidden" name="csyor_reg" value="ok" />
				  <input type="hidden" name="redirect_to" value="<?php echo $redirect_to; ?>"/>
                </div>
              </form>
            </div>
          </div>
        </div>
		</div>
		<div class="row justify-content-center">
		 <div class="col-lg-6 col-md-8">
            <a href="<?php echo boxmoe_com('users_login') ?>" class="btn btn-sm btn-success btn-block">
             会员登录</a>
		</div> 

      </div>
	  </div> 
     			
		<?php endwhile; else: ?><?php endif; ?>	
			
 </div>
      </section>
<?php } get_footer(); ?>