<?php
//使用默认编辑器
if( boxmoe_com('gutenbergoff') )  {
add_filter('use_block_editor_for_post', '__return_false');
remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' ); // 禁止前端加载样式文件
}

################# 主题优化 ################# 


    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'start_post_rel_link', 10, 0);
    remove_action('wp_head', 'wp_generator');
    remove_action( 'admin_print_scripts' ,	'print_emoji_detection_script');
    remove_action( 'admin_print_styles'  ,	'print_emoji_styles');
    remove_action( 'wp_head'             ,	'print_emoji_detection_script',	7);
    remove_action( 'wp_print_styles'     ,	'print_emoji_styles');
    remove_filter( 'the_content_feed'    ,	'wp_staticize_emoji');
    remove_filter( 'comment_text_rss'    ,	'wp_staticize_emoji');
    remove_filter( 'wp_mail'             ,	'wp_staticize_emoji_for_email');
    add_theme_support( 'post-formats', array( 'aside' ) );
    remove_action('rest_api_init', 'wp_oembed_register_route');
	remove_filter('rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4);
	remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
	remove_filter('oembed_response_data', 'get_oembed_response_data_rich', 10, 4);
	remove_action('wp_head', 'wp_oembed_add_discovery_links');
	remove_action('wp_head', 'wp_oembed_add_host_js');
	remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
	remove_action('wp_head', 'print_emoji_detection_script', 7, 1);
    remove_action('wp_head', 'feed_links', 2, 1);
    remove_action('wp_head', 'parent_post_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
    remove_action('wp_head', 'rel_canonical', 10, 0);
	add_filter( 'emoji_svg_url', '__return_false' );



if(boxmoe_com('remove_dns_refresh')){
function remove_dns_prefetch( $hints, $relation_type ) {
if ( 'dns-prefetch' === $relation_type ) {
return array_diff( wp_dependencies_unique_hosts(), $hints );
}
return $hints;
}
add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );
}

//禁用文章自动保存
if(boxmoe_com('autosaveop')){
add_action('wp_print_scripts','disable_autosave');
function disable_autosave(){
wp_deregister_script('autosave');
}
 }
 
//禁用文章修订版本
if(boxmoe_com('revisions_to_keepop')){
add_filter( 'wp_revisions_to_keep', 'specs_wp_revisions_to_keep', 10, 2 );
function specs_wp_revisions_to_keep( $num, $post ) {
return 0;
}
}


//隐藏管理条
function hide_admin_bar($flag) {
	return false;}
add_filter('show_admin_bar', 'hide_admin_bar');

// no self Pingback
add_action('pre_ping', '_noself_ping');
function _noself_ping(&$links) {
	$home = get_option('home');
	foreach ($links as $l => $link) {
		if (0 === strpos($link, $home)) {
			unset($links[$l]);
		}
	}
}

//禁止加载WP自带的jquery.js
 if ( !is_admin() ) { // 后台不禁止
 function my_init_method() {
 wp_enqueue_scripts( 'jquery' ); // 取消原有的 jquery 定义
 }
 add_action('init', 'my_init_method');
 }

//移除后台谷歌字体
function remove_open_sans() {
    wp_deregister_style( 'open-sans' );
    wp_register_style( 'open-sans', false );
    wp_enqueue_style('open-sans','');
}
add_action( 'init', 'remove_open_sans' );


//移除没有用的元素
add_filter('nav_menu_css_class', 'my_css_attributes_filter', 100, 1);
add_filter('nav_menu_item_id', 'my_css_attributes_filter', 100, 1);
add_filter('page_css_class', 'my_css_attributes_filter', 100, 1);
function my_css_attributes_filter($var) {
    return is_array($var) ? array() : '';
}
//Gravatar头像加速
function boxmoe_getavatar_host(){
	$gravatarUrl = 'gravatar.loli.net';
	switch (boxmoe_com('gravatar_url')){
		case 'cn':
			$gravatarUrl = 'cn.gravatar.com';
			break;
		case 'ssl':
			$gravatarUrl = 'secure.gravatar.com';
			break;			
		case 'lolinet':
			$gravatarUrl = 'gravatar.loli.net';
			break;
		case 'v2excom':
			$gravatarUrl = 'cdn.v2ex.com';
			break;
		case 'qiniu':
			$gravatarUrl = 'dn-qiniu-avatar.qbox.me';
			break;	
        case 'geekzu':
			$gravatarUrl = 'fdn.geekzu.org';
			break;			
		default:
			$gravatarUrl = 'gravatar.loli.net';
	}
	return $gravatarUrl;
}
//编辑器
if( boxmoe_com('gutenbergoff') )  {
if ( version_compare( get_bloginfo('version'), '5.0', '>=' ) ) {
    add_filter('use_block_editor_for_post', '__return_false'); // 切换回之前的编辑器
    remove_action( 'wp_enqueue_scripts', 'wp_common_block_scripts_and_styles' ); // 禁止前端加载样式文件
}else{
    // 4.9.8 < WP < 5.0 插件形式集成Gutenberg古腾堡编辑器
    add_filter('gutenberg_can_edit_post_type', '__return_false');
}
}


//替换头像链接 Gravatar host  
function boxmoe_get_avatar($avatar) {
	$avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com","secure.gravatar.com"), boxmoe_getavatar_host(), $avatar);
return $avatar;
}
add_filter( 'get_avatar', 'boxmoe_get_avatar', 10, 3 );


//添加HTML编辑器按钮
function my_quicktags(){
	wp_enqueue_script(
		'my_quicktags',
		boxmoe_load_style().'/assets/js/quicktags.js',
		array('quicktags')
	);
}
add_action('admin_print_scripts', 'my_quicktags');


//修复 WordPress 找回密码提示“抱歉，该key似乎无效”
function reset_password_message( $message, $key ) {
 if ( strpos($_POST['user_login'], '@') ) {
 $user_data = get_user_by('email', trim($_POST['user_login']));
 } else {
 $login = trim($_POST['user_login']);
 $user_data = get_user_by('login', $login);
 }
 $user_login = $user_data->user_login;
 $msg = __('有人要求重设如下帐号的密码：'). "\r\n\r\n";
 $msg .= network_site_url() . "\r\n\r\n";
 $msg .= sprintf(__('用户名：%s'), $user_login) . "\r\n\r\n";
 $msg .= __('若这不是您本人要求的，请忽略本邮件，一切如常。') . "\r\n\r\n";
 $msg .= __('要重置您的密码，请打开下面的链接：'). "\r\n\r\n";
 $msg .= network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') ;
 return $msg;
}
add_filter('retrieve_password_message', 'reset_password_message', null, 2);

// 自适应图片
function boxmoe_remove_width_height($content){
  preg_match_all('/<[img|IMG].*?src=[\'|"](.*?(?:[\.gif|\.jpg|\.png\.bmp]))[\'|"].*?[\/]?>/', $content, $images);
  if(!empty($images)) {
    foreach($images[0] as $index => $value){
      $new_img = preg_replace('/(width|height)="\d*"\s/', "", $images[0][$index]);
      $content = str_replace($images[0][$index], $new_img, $content);
    }
  }
  return $content;
}
add_filter('the_content', 'boxmoe_remove_width_height', 99);




?>