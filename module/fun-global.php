<?php
//载入前端资源
function boxmoe_load_style(){
if( boxmoe_com('style_src_onoff') ) {
$styleurlload = boxmoe_com('style_src')	;
}else{
$styleurlload = get_template_directory_uri() ;
}
return $styleurlload;
}



function boxmoe_enqueue_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );
    wp_enqueue_style('themes-style',boxmoe_load_style() . '/assets/css/themes.min.css',[], $theme_version);
	wp_enqueue_style('style-css',boxmoe_load_style() . '/assets/css/style.css',[], $theme_version);
}
add_action( 'wp_enqueue_scripts', 'boxmoe_enqueue_scripts' );


// 注册导航
if (function_exists('register_nav_menus')){
    register_nav_menus( array(
    'nav' => __('顶部主导航', 'boxmoe-com'),
    ));
}

function bm_nav_menu($location='nav',$dropdowns='dropdown'){
    echo ''.str_replace("</ul></div>", "", preg_replace("/<div[^>]*><ul[^>]*>/", "", wp_nav_menu(array('theme_location' => $location,'fallback_cb'       => 'WP_Bootstrap_Navwalker::fallback','menu_class' => $dropdowns,'walker' => new wp_bootstrap_navwalker(),'echo' => false)) )).''; 
}

//搜索结果排除所有页面
function search_filter_page($query) {
    if ($query->is_search) {
        $query->set('post_type', 'post');
    }
    return $query;
}
add_filter('pre_get_posts','search_filter_page');


// 开启友情链接
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

// 开启友情链接
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

//logo地址
function bm_logo() {
if( boxmoe_com('logosrc') ) {
$src = '<img src="'.boxmoe_com('logosrc').'" alt="'. get_bloginfo('name') .'" class="img-fluid mx-auto d-block shadow-sm rounded-full">';	
}else{
$src = '';
}    
return  $src;
}


//banner参数
function bm_banner() {
if( boxmoe_com('banner_rand') ) {
$banner_no = boxmoe_com('banner_rand_n');
$temp_no = mt_rand(1,$banner_no);	
echo 'style="background-image: url(\''.boxmoe_load_style().'/assets/images/banner/'.$temp_no.'.jpg\');" ';	
}else{
echo  'style="background-image: url(\''.boxmoe_com('banner_url').'\');"';	 
}		
}


//防止代码转义
function meow_prettify_esc_html($content){
    $regex = '/(<pre\s+[^>]*?class\s*?=\s*?[",\'].*?prettyprint.*?[",\'].*?>)(.*?)(<\/pre>)/sim';
    return preg_replace_callback($regex, 'meow_prettify_esc_callback', $content);}
function meow_prettify_esc_callback($matches){
    $tag_open = $matches[1];
    $content = $matches[2];
    $tag_close = $matches[3];
    $content = esc_html($content);
    return $tag_open . $content . $tag_close;}
add_filter('the_content', 'meow_prettify_esc_html', 2);
add_filter('comment_text', 'meow_prettify_esc_html', 2);
//强制兼容
function meow_prettify_replace($text){
	$replace = array( '<pre>' => '<pre class="prettyprint linenums" >' );
	$text = str_replace(array_keys($replace), $replace, $text);
	return $text;}
add_filter('the_content', 'meow_prettify_replace');


//列表翻页
if ( ! function_exists( 'bm_paging' ) ) :
function bm_paging() {
    $p = 3;
    if ( is_singular() ) return;
    global $wp_query, $paged;
    $max_page = $wp_query->max_num_pages;
    if ( $max_page == 1 ) return; 
    echo '<nav class="mt-5 d-flex justify-content-center" aria-label="Page navigation"><ul class="pagination">';
    if ( empty( $paged ) ) $paged = 1;
   if( boxmoe_com('paging_type') == 'multi' && $paged !== 1 ) p_link(0);
    // echo '<span class="pages">Page: ' . $paged . ' of ' . $max_page . ' </span> '; 
    if( boxmoe_com('paging_type') == 'next' ){echo '<li class="page-item">'; previous_posts_link(__('<span aria-hidden="true" class="next">«</span><span class="sr-only">Previous</span>', 'boxmoe-com')); echo '</li>';}

    if( boxmoe_com('paging_type') == 'multi' ){
        if ( $paged > $p + 1 ) p_link( 1, '<li class="page-item"><a class=\"page-link\">'.__('1', 'boxmoe-com').'</a></li>' );
        if ( $paged > $p + 2 ) echo "<li class=\"page-item\"><a class=\"page-link\">···</a></li>";
        for( $i = $paged - $p; $i <= $paged + $p; $i++ ) { 
            if ( $i > 0 && $i <= $max_page ) $i == $paged ? print "<li class=\"page-item active\"><a class=\"page-link\" href=\"#\">{$i}</a></li>" : p_link( $i );
        }
        if ( $paged < $max_page - $p - 1 ) echo "<li class=\"page-item\"><a class=\"page-link\"> ... </a></li>";
    }
    //if ( $paged < $max_page - $p ) p_link( $max_page, '&raquo;' );
   // echo '<li class="page-item">'; next_posts_link(__('Next', 'boxmoe-com')); echo '</li>';
   
    if( boxmoe_com('paging_type') == 'next' ){echo '<li class="page-item">'; next_posts_link(__('<span aria-hidden="true" class="next">»</span><span class="sr-only">Next</span>', 'boxmoe-com')); echo '</li>';}
    if( boxmoe_com('paging_type') == 'multi' && $paged < $max_page ) p_link($max_page, '', 1);

    echo '</ul></nav>';
}
function p_link( $i, $title = '', $w='' ) {
    if ( $title == '' ) $title = __('页', 'boxmoe-com')." {$i}";
    $itext = $i;
    if( $i == 0 ){
        $itext = __('首页', 'boxmoe-com');
    }
    if( $w ){
        $itext = __('尾页', 'boxmoe-com');
    }
    echo "<li class=\"page-item\"><a class=\"page-link\" href='", esc_html( get_pagenum_link( $i ) ), "'>{$itext}</a></li>";
}
endif;





function get_the_link_items($id = null){
	$bookmarks = get_bookmarks('orderby=date&category=' . $id);
	$output    = '';
    if (!empty($bookmarks)) {	
    foreach ($bookmarks as $bookmark) {
	if (!empty($bookmark->link_notes)) {
	$notes= $bookmark->link_notes;
	}else{
	$notes='这站长太懒了什么也没留下';
	}
	if (!empty($bookmark->link_image)){
	$linkimage=	'<img src="'. $bookmark->link_image .'" alt="' . $bookmark->link_name . '">';
	}else{
	$linkimage='<img src="'.get_template_directory_uri().'/assets/images/avatar.jpg" alt="' . $bookmark->link_name . '">';
	}
	$output .= '<li class="wow slideInUp"><a rel="'.$bookmark->link_rel.'" title="'.$bookmark->link_notes.'" target="_blank"  href="'.$bookmark->link_url.'"><div>'.$linkimage.''.$bookmark->link_name.'</div><div>'.$notes.'</div></a></li>';  	
	}
}
return $output;
}
function get_yqlinks_index(){
if (boxmoe_com('yqlinks')){
	$result='<a href="'.boxmoe_com('yqlinks').'" class="footeer_linkss" target="_blank" title="点击进入申请友情链接"><span>'.boxmoe_com('yqlinksname').'</span></a>'	;	
		}else {
			$result='<span>'.boxmoe_com('yqlinksname').'</span>';
			}
return $result;			
}
function get_the_link_items_index($id = null){
	$bookmarks = get_bookmarks('orderby=date&category=' . $id);
    $output    = '';
    if (!empty($bookmarks)) {
			
        $output .= '<section class="section"><div class="container"><div class="section-head ">' .get_yqlinks_index(). '   </div><div class="row"> <div class="col-md-12"> <ul class="footeer_links">';
        if (boxmoe_com('diylinks_open')){
			$output .= 	boxmoe_com('diylinks_con');
			}else {
		foreach ($bookmarks as $bookmark) {					
            $output .= '<li><i class="fa fa-link" ></i><a href="' . $bookmark->link_url . '"  target="_blank">' . $bookmark->link_name . '</a></li>';	
        }
		}
        $output .= '</ul></div></div></div> </section>';
    }
    return $output;
}

function get_link_items(){
	$bookmarks = get_bookmarks('orderby=date&category=' . $id);
    $linkcats = get_terms('link_category');
    if (!empty($linkcats)) {
        foreach ($linkcats as $linkcat) {
            $result .= '<div class="link-title wow rollIn">'.$linkcat->name.'</div>';
            $result .= '<ul class="readers-list clearfix">'.get_the_link_items($linkcat->term_id).'</ul>';
        }
    } else {
		$result .= '<div class="link-title wow rollIn">未分类</div>';
        $result = '<ul class="readers-list clearfix">'.get_the_link_items().'</ul>';
    }
    return $result;
}