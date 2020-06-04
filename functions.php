<?php
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/module/options/' );
require_once dirname( __FILE__ ) . '/module/options/options-framework.php';
$optionsfile = locate_template( 'options.php' );
load_template( $optionsfile );
require_once get_stylesheet_directory() . '/module/fun-panel.php';
require_once get_stylesheet_directory() . '/module/fun-global.php';
require_once get_stylesheet_directory() . '/module/fun-bootstrap.php';  
require_once get_stylesheet_directory() . '/module/fun-comments.php'; 
require_once get_stylesheet_directory() . '/module/fun-article.php'; 
require_once get_stylesheet_directory() . '/module/fun-opzui.php'; 
require_once get_stylesheet_directory() . '/module/fun-seo.php'; 
require_once get_stylesheet_directory() . '/module/fun-user.php'; 
require_once get_stylesheet_directory() . '/module/fun-mail.php'; 
require_once get_stylesheet_directory() . '/module/fun-admin.php';
if( boxmoe_com('no_categoty') )require_once get_stylesheet_directory() . '/module/fun-no-category.php';
