<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 */
function optionsframework_option_name() {
	// Change this to use your theme slug
	return 'options-framework-theme';
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'theme-textdomain'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	// Test data
	$test_array = array(
		'3' => __( '一行3个文章', 'theme-textdomain' ),
		'2' => __( '一行2个文章', 'theme-textdomain' )
	);

	// Multicheck Array
	$multicheck_array = array(
		'one' => __( 'French Toast', 'theme-textdomain' ),
		'two' => __( 'Pancake', 'theme-textdomain' ),
		'three' => __( 'Omelette', 'theme-textdomain' ),
		'four' => __( 'Crepe', 'theme-textdomain' ),
		'five' => __( 'Waffle', 'theme-textdomain' )
	);

	// Multicheck Defaults
	$multicheck_defaults = array(
		'one' => '1',
		'five' => '1'
	);

	// Background Defaults
	$background_defaults = array(
		'color' => '',
		'image' => '',
		'repeat' => 'repeat',
		'position' => 'top center',
		'attachment'=>'scroll' );

	// Typography Defaults
	$typography_defaults = array(
		'size' => '15px',
		'face' => 'georgia',
		'style' => 'bold',
		'color' => '#bada55' );

	// Typography Options
	$typography_options = array(
		'sizes' => array( '6','12','14','16','20' ),
		'faces' => array( 'Helvetica Neue' => 'Helvetica Neue','Arial' => 'Arial' ),
		'styles' => array( 'normal' => 'Normal','bold' => 'Bold' ),
		'color' => false
	);

	// Pull all the categories into an array
	$options_categories = array();
	$options_categories_obj = get_categories();
	foreach ($options_categories_obj as $category) {
		$options_categories[$category->cat_ID] = $category->cat_name;
	}

	// Pull all tags into an array
	$options_tags = array();
	$options_tags_obj = get_tags();
	foreach ( $options_tags_obj as $tag ) {
		$options_tags[$tag->term_id] = $tag->name;
	}


	// Pull all the pages into an array
	$options_pages = array();
	$options_pages_obj = get_pages( 'sort_column=post_parent,menu_order' );
	$options_pages[''] = 'Select a page:';
	foreach ($options_pages_obj as $page) {
		$options_pages[$page->ID] = $page->post_title;
	}

	// If using image radio buttons, define a directory path
	$imagepath =  get_template_directory_uri() . '/assets/images/';
	$options = array();
	$style= get_template_directory_uri();
	$webhome= get_option('home');
//==============================================================================
	$options[] = array(
		'name' => __( '全局设置', 'boxmoe-com' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __('导航LOGO下自定义网址', 'boxmoe-com'),
		'id' => 'blog_site',
		'std' => 'www.boxmoe.com',
		'settings' => array(
			'rows' => 1
		),
		'type' => 'textarea');
	$options[] = array(
		'name' => __( 'LOGO设置', 'boxmoe-com' ),
		'id' => 'logosrc',
		'desc' => __(' ', 'boxmoe-com'),
		'std' => $imagepath.'banner/1.jpg',
		'type' => 'upload');
	$options[] = array(
		'name' => __( 'Favicon地址', 'boxmoe-com' ),
		'id' => 'favicon_src',
		'std' => $imagepath.'favicon.ico',
		'type' => 'upload');	
	$options[] = array(
		'name' => __('使用外链加载前端资源CSS JS', 'boxmoe-com'),
		'id' => 'style_src_onoff',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启后将外部链接填写在下方才能生效', 'boxmoe-com'),);		
	$options[] = array(
		'desc' => __( '将主题中“assets”文件上传到七牛 OSS之类加速前端加载，链接结尾不带/', 'boxmoe-com' ),
		'id' => 'style_src',
		'std' => '',
		'settings' => array('rows' => 2),
		'class' => 'hidden',
		'type' => 'textarea');	
	$gravatar_array = array(
	    'lolinet' => __('萝莉服务器（荐）', 'boxmoe-com'),
		'qiniu' => __('七牛服务器（荐）', 'boxmoe-com'),
		'geekzu' => __('极客服务器（荐）', 'boxmoe-com'),
		'v2excom' => __('v2ex服务器', 'boxmoe-com'),
		'cn' => __('官方CN服务器', 'boxmoe-com'),
		'ssl' => __('官方SSL服务器', 'boxmoe-com'),		
	);
	$options[] = array(
		'name' => __('Gravatar头像加速服务器', 'boxmoe-com'),
		'desc' => __('通过镜像服务器可对gravatar头像进行加速', 'boxmoe-com'),
		'id' => 'gravatar_url',
		'std' => 'lolinet',
		'type' => 'select',
		'class' => 'mini', //mini, tiny, small
		'options' => $gravatar_array);	
	$options[] = array(
		'name' => __('分类去除category', 'boxmoe-com'),
		'id' => 'no_categoty',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启  （需要开启伪静态/固定链接需要保存一次 wordpress的设置 → 固定链接）', 'boxmoe-com'),);	
    $options[] = array(
		'name' => __('导航搜索功能开启', 'boxmoe-com'),
		'id' => 'sousuo',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'boxmoe-com')); 
	$options[] = array(
		'name' => __('网页右侧小萝莉开关，附带back to top 回到顶部功能', 'boxmoe-com'),
		'id' => 'lolijump',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'boxmoe-com')); 
	$options[] = array(
		'name' => __('选择前端小萝莉展现形象', 'boxmoe-com'),
		'id' => 'lolijumpsister',
		'type' => "radio",
		'std' => 'lolisister1',
		'class' => 'hidden',
		'options' => array(
			'lolisister1' => __(' 萝莉姐姐 ', 'boxmoe-com'),
			'lolisister2' => __(' 萝莉妹妹', 'boxmoe-com'),
			'meow' => __(' 喵小娘', 'boxmoe-com'),
			'bear' => __(' 熊宝宝', 'boxmoe-com')
		));		
	$options[] = array(
		'name' => __('开启自定义CSS', 'boxmoe-com'),
		'id' => 'diystyles',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启 （启用后在主题目录/assets/css/diystyle.css 里添加自己的CSS前端会生效）', 'boxmoe-com'));	

	$options[] = array(
		'name' => __('网站底部导航链接', 'boxmoe-com'),
		'id' => 'footer_seo',
		'std' => '<ul class="nav nav-footer justify-content-center mt10"><li class="nav-item"><a href="'.site_url('/sitemap.xml').'" class="nav-link" target="_blank">'.__('网站地图', 'boxmoe-com').'</a></li></ul>'."\n",
		'desc' => __('网站地图可自行使用sitemap插件自动生成', 'boxmoe-com'),
		'settings' => array('rows' => 3),
		'type' => 'textarea');
	$options[] = array(
		'name' => __('网站底部版权后自定义信息', 'boxmoe-com'),
		'id' => 'footer_info',
		'std' => '| 本站使用Wordpress创作'."\n",
		'settings' => array('rows' => 3),
		'type' => 'textarea');	
	$options[] = array(
		'name' => __('底部显示页面执行时间', 'boxmoe-com'),
		'id' => 'boxmoedataquery',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启 （默认关闭，开启后底部显示页面执行时间）', 'boxmoe-com'));			
	$options[] = array(
		'name' => __('统计代码隐藏', 'boxmoe-com'),
		'id' => 'trackcodehidden',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启 （默认显示，开启后底部统计代码隐藏不显示，但不影响统计）', 'boxmoe-com'));		
    $options[] = array(
		'name' => __('统计代码', 'boxmoe-com'),
		'desc' => __('底部第三方流量数据统计代码,默认主题隐藏统计代码，具体查看前端源码', 'boxmoe-com'),
		'id' => 'trackcode',
		'std' => '统计代码',
		'settings' => array('rows' => 3),
		'type' => 'textarea');		
		
//==============================================================================
	$options[] = array(
		'name' => __( 'Banner设置', 'boxmoe-com' ),
		'type' => 'heading'
	);
	$options[] = array(
		'name' => __('页面Banner背景图', 'boxmoe-com'),
		'id' => 'banner_url',
		'std' => $imagepath.'banner/1.jpg',
		'type' => 'upload');    
    $options[] = array(
		'name' => __('Banner随机背景图（开启后上方↑图片失效）', 'boxmoe-com'),
		'id' => 'banner_rand',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('（开启后在主题boxmoe/assets/images/banner/下加入图片即可）', 'boxmoe-com'),);	 
	$options[] = array(
		'name' => __('Banner随机图片数量', 'boxmoe-com'),
		'id' => 'banner_rand_n',
		'std' => 12,
		'class' => 'mini',
		'desc' => __('图片命名为1.jpg ...x.jpg ，x=1-你上面设置的数量，格式JPG ', 'boxmoe-com'),
		'class' => 'hidden',
		'type' => 'text');
//==============================================================================
	$options[] = array(
		'name' => __('文章设置', 'boxmoe-com'),
		'type' => 'heading');
	$options[] = array(
		'name' => "文章列表布局模式",
		'id' => "bloglistrow",
		'std' => "2c-l-fixed",
		'type' => "images",
		'options' => array(
			'col-1' => $imagepath . 'col-1.png',
			'col-2' => $imagepath . 'col-2.png'
		)
	);
    //$options[] = array(
	//	'name' => __( '瀑布流列表一行排列数量（下版出先记着）', 'theme-textdomain' ),
	//	'id' => 'example_radio',
	//	'std' => 'one',
	//	'type' => 'radio',
	//	'options' => $test_array
	//);
	$options[] = array(
		'name' => __('文章列表边框和阴影切换', 'boxmoe-com'),
		'id' => 'blog_border',
		'std' => "border1",
		'type' => "radio",
		'options' => array(
			'border1' => __('边框形式', 'boxmoe-com'),
			'border2' => __('阴影形式', 'boxmoe-com')
		));	
	$options[] = array(
		'name' => __('文章随机缩略图数量', 'boxmoe-com'),
		'id' => 'thumbnail_rand_n',
		'std' => 5,
		'class' => 'mini',
		'desc' => __('图片放在在主题boxmoe/assets/images/rand/N.jpg，N=1-你设置的数量 ', 'boxmoe-com'),
		'type' => 'text');	
    $options[] = array(
		'name' => __('新窗口打开文章', 'boxmoe-com'),
		'id' => 'target_blank',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启 （开启后文章链接都是新窗口打开）', 'boxmoe-com'));	
	$options[] = array(
		'name' => __('文章列表分页模式', 'boxmoe-com'),
		'id' => 'paging_type',
		'std' => "multi",
		'type' => "radio",
		'options' => array(
			'next' => __(' « 和 »', 'boxmoe-com'),
			'multi' => __('页码  1 2 3 ', 'boxmoe-com')
		));
	$options[] = array(
		'name' => __('相关文章', 'boxmoe-com'),
		'id' => 'post_related_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'boxmoe-com'));
    $options[] = array(
		'name' => __('相关文章显示方式', 'boxmoe-com'),
		'id' => 'post_related_model',
		'type' => "radio",
		'std' => 'thumb',
		'options' => array(
			'thumb' => __(' 图文模式 ', 'boxmoe-com'),
			'text' => __(' 文字链模式 ', 'boxmoe-com')
		));
	$options[] = array(
		'name' => __('相关文章-显示文章数量', 'boxmoe-com'),
		'id' => 'post_related_n',
		'std' => 3,
		'class' => 'mini',
		'desc' => __('建议使用3 6 9 12这样排版', 'boxmoe-com'),
		'type' => 'text');		
		/** 
	$options[] = array(
		'name' => __('开启文章内容页作者信息框', 'boxmoe-com'),
		'id' => 'open_author_info',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'boxmoe-com'));	
	$options[] = array(
		'name' => __('文章作者信息', 'boxmoe-com'),
		'desc' => __('位于文章内容标签下方', 'boxmoe-com'),
		'id' => 'authorinfo',
		'settings' => array(
		'rows' => 3),
		'class' => 'hidden',
		'std' => '文章作者信息文章作者信息文章作者信息文章作者信息文章作者信息文章作者信息文章作者信息文章作者信息文章作者信息...',
		'type' => 'textarea');		
		*/
		
//==============================================================================	
    $options[] = array(
		'name' => __('SEO设置', 'boxmoe-com'),
		'type' => 'heading');

    $options[] = array(
		'name' => __( '全站标题连接符', 'boxmoe-com' ),
		'desc' => __( '“-”或“_”一般设置就不要去修改它，会影响SEO', 'boxmoe-com' ),
		'id' => 'connector',
		'std' => boxmoe_com('connector') ? boxmoe_com('connector') : '-',
		'class' => 'mini',
		'type' => 'text');

	$options[] = array(
		'name' => __('百度文章发布主动推送', 'boxmoe-com'),
		'id' => 'baidutuisong',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'boxmoe-com')); 
	 
	$options[] = array(
		'name' => __( '百度文章发布主动推送key', 'boxmoe-com' ),
		'id' => 'baidutuisongkey',
		'std' =>'',
		'type' => 'text',
		'class' => 'hidden',
		'desc' => __('如果推送成功则在文章新增自定义栏目Baidusubmit，值为1', 'boxmoe-com'),
	);	 
	 
	$options[] = array(
		'name' => __('首页关键字(keywords)', 'boxmoe-com'),
		'id' => 'keywords',
		'std' => 'WordPress',
		'desc' => __('用英文逗号隔开', 'boxmoe-com'),
		'settings' => array(
			'rows' => 3
		),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('首页描述(description)', 'boxmoe-com'),
		'id' => 'description',
		'std' => '又是一个博客',
		'desc' => __('网站描述', 'boxmoe-com'),
		'settings' => array(
		'rows' => 3),
		'type' => 'textarea');

	$options[] = array(
		'name' => __('分类关键字', 'boxmoe-com'),
		'id' => 'cat_keyworks_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'boxmoe-com').__(' 开启后分类的关键字将自动获取分类中的“图像描述”中的一部分，请用“::::::”6个英文冒号隔开关键字和描述，比如：<br>关键字1,关键字2<br>::::::<br>描述描述描述描述描述描述描述', 'boxmoe-com'));

	$options[] = array(
		'name' => __('网站自动添加关键字和描述', 'boxmoe-com'),
		'id' => 'site_keywords_description_s',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启', 'boxmoe-com').__('（开启后所有页面将自动使用主题配置的关键字和描述）', 'boxmoe-com'));

	$options[] = array(
		'name' => __('文章关键字和描述自定义', 'boxmoe-com'),
		'id' => 'post_keywords_description_s',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'boxmoe-com').__('（开启后你需要在编辑文章的时候书写关键字和描述，如果为空，将自动使用主题配置的关键字和描述；开启这个必须开启上面的“网站自动添加关键字和描述”开关）', 'boxmoe-com'));
//==============================================================================	
	$options[] = array(
		'name' => __('评论设置', 'boxmoe-com'),
		'type' => 'heading'); 
	$options[] = array(
		'name' => __('禁用纯英文 日语评论内容！屏蔽一些垃圾评论', 'boxmoe-com'),
		'id' => 'false_enjp_comment',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'boxmoe-com'),);	
		
	$options[] = array(
			'name' => __('评论:管理员标志命名', 'boxmoe-com'),
			'id' => 'comnanes',
			'std' => '博主',
			'class' => 'mini',
			'desc' => __('管理员发表回复评论的标志', 'boxmoe-com'),
			'type' => 'text');
    $options[] = array(
			'name' => __('评论:注册会员标志命名', 'boxmoe-com'),
			'id' => 'comnanesu',
			'std' => '会员',
			'class' => 'mini',
			'desc' => __('注册会员发表回复评论的标志', 'boxmoe-com'),
			'type' => 'text');
	$options[] = array(
			'name' => __('评论:游客标志命名', 'boxmoe-com'),
			'id' => 'comnaness',
			'std' => '游客',
			'class' => 'mini',
			'desc' => __('管理员发表回复评论的标志', 'boxmoe-com'),
			'type' => 'text');		
	//$options[] = array(
	//	'name' => __('评论者网址开启go跳转模式', 'boxmoe-com'),
	//	'id' => 'comnanesgo',
	//	'type' => "checkbox",
	//	'std' => false,
	//	'desc' => __('开启（其实没必要，已经加了nofollow不影响权重）', 'boxmoe-com'));		
	$options[] = array(
		'name' => __('站内链接GO跳转到评论者网站', 'boxmoe-com'),
		'id' => 'comnanesgo_url',
		'std' => $webhome.'/go?url=',
		'desc' => __( '需要在【页面】新建一个GO链接的页面', 'boxmoe-com' ),
		'class' => 'hidden',
		'settings' => array('rows' => 1),
		'type' => 'textarea');			
//==============================================================================
	$options[] = array(
		'name' => __('会员设置', 'boxmoe-com'),
		'type' => 'heading');
	$options[] = array(
		'name' => __('开启导航会员注册链接', 'boxmoe-com'),
		'id' => 'sign_f',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启 【需要配合erphpdown插件】', 'boxmoe-com')
	);		
    $options[] = array(
		'name' => __('注册会员支持中文', 'boxmoe-com'),
		'id' => 'sign_zhcn',
		'type' => "checkbox",
		'std' => false,
		'class' => 'hidden',
		'desc' => __('开启', 'boxmoe-com')
	);	
	$options[] = array(
		'name' => __( '会员登录页面', 'boxmoe-com' ),
		'desc' => __( '选择前端会员登录页面，新建一个页面选择会员登录模板', 'boxmoe-com' ),
		'id' => 'users_login',
		'type' => 'text',
		'class' => 'hidden',
		'std' => $webhome
	);
	$options[] = array(
		'name' => __( '会员注册页面', 'boxmoe-com' ),
		'desc' => __( '选择前端会员注册页面，新建一个页面选择会员注册模板', 'boxmoe-com' ),
		'id' => 'users_reg',
		'type' => 'text',
		'class' => 'hidden',
		'std' => $webhome
	);
	$options[] = array(
		'name' => __( '会员中心页面', 'boxmoe-com' ),
		'desc' => __( '选择前端会员中心页面，新建一个页面选择会员中心模板【需要配合erphpdown插件】', 'boxmoe-com' ),
		'id' => 'users_page',
		'type' => 'text',
		'class' => 'hidden',
		'std' => $webhome
	);
	
	
    $options[] = array(
		'name' => __( '注册成功后会员跳转页面', 'boxmoe-com' ),
		'id' => 'regto',
		'std' => $webhome,
		'class' => 'hidden',
		'type' => 'text'
	);	
    $options[] = array(
		'name' => __( '登录成功后会员跳转页面', 'boxmoe-com' ),
		'id' => 'loginto',
		'std' => $webhome,
		'class' => 'hidden',
		'type' => 'text'
	);	

		
//==============================================================================	
	$options[] = array(
		'name' => __('社交设置', 'boxmoe-com'),
		'type' => 'heading');				
    $options[] = array(
		'name' => __('文章打赏二维码（先记着下版出）'),
		'desc' => __('直接上传图片，留空不展现。', 'boxmoe-com'),
		'id' => 'boxmoe_dayegivemesomemoney',
		'std' => $imagepath.'dayegivemesomemoney.jpg',
		'type' => 'upload');
	$options[] = array(
		'name' => __('QQ联系'),
		'desc' => __('直接输入QQ号，留空不展现', 'boxmoe-com'),
		'id' => 'boxmoe_qq',
		'std' => '10000',
		'type' => 'text');	
	$options[] = array(
		'name' => __('微信二维码'),
		'desc' => __('直接上传图片，留空不展现。', 'boxmoe-com'),
		'id' => 'boxmoe_wechat',
		'std' => $imagepath.'mgwechat.jpg',
		'type' => 'upload');		
    $options[] = array(
		'name' => __('Email邮箱'),
		'desc' => __('直接输入邮箱，留空不展现。', 'boxmoe-com'),
		'id' => 'boxmoe_mail',
		'type' => 'text');	
	$options[] = array(
		'name' => __('Github'),
		'desc' => __('直接输入链接，留空不展现', 'boxmoe-com'),
		'id' => 'boxmoe_github',
		'std' => 'https://www.boxmoe.com',
		'type' => 'text');
    $options[] = array(
		'name' => __('微博'),
		'desc' => __('直接输入链接，留空不展现', 'boxmoe-com'),
		'id' => 'boxmoe_weibo',
		'std' => 'https://www.boxmoe.com',
		'type' => 'text');
	 	
    /* 
	 * 友链设置
	 * ====================================================================================================
	 */	
    $options[] = array(
		'name' => __('友链设置', 'boxmoe-com'), 
		'type' => 'heading');	 
    
    	$options[] = array(
		'name' => __('全站底部开启友链', 'boxmoe-com'),
		'id' => 'indexlinks',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'boxmoe-com'),);
	$options[] = array(
		'name' => __('首页友情链接申请地址'),
		'desc' => __('填写自己站点的友情链接申请地址（留空则不会链接过去）', 'boxmoe-com'),
		'id' => 'yqlinks',
		'std' => 'https://boxmoe.com',
		'type' => 'text');	
	$options[] = array(
		'name' => __('友情链接标题命名'),
		'desc' => __('自己想怎么取就怎么取', 'boxmoe-com'),
		'id' => 'yqlinksname',
		'std' => '友情链接',
		'type' => 'text');
	$options[] = array(
		'name' => __('自定义友情链接', 'boxmoe-com'),
		'id' => 'diylinks_open',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启（开启后wp的友情链接失效，只显示下方输入的自定义链接）', 'boxmoe-com'),);
	$options[] = array(
		'name' => __('自定义友情链接', 'boxmoe-com'),
		'id' => 'diylinks_con',
		'std' => '<li><i class="fa fa-link"></i><a href="https://www.boxmoe.com/" target="_blank">盒子萌</a></li>',
		'desc' => __('模板在上面了，复制粘贴一行一个自己改就好了', 'boxmoe-com'),
		'settings' => array('rows' => 3),
		'type' => 'textarea');	

	/* 
	 * SMTP发件
	 * ====================================================================================================
	 */
	$options[] = array(
		'name' => __('SMTP设置', 'boxmoe-com'),
		'type' => 'heading');	 
	$options[] = array(
		'name' => __('开启SMTP发件功能', 'boxmoe-com'),
		'id' => 'smtpmail',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('勾选开启 （开启后下面也要设置好才生效）', 'boxmoe-com'),);	
	$options[] = array(
		'name' => __( '发件人', 'boxmoe-com' ),
		'id' => 'fromnames',
		'std' => '盒子萌',
		'class' => 'mini',
		'type' => 'text'
	);		
	$options[] = array(
		'name' => __( 'SMTP服务器', 'boxmoe-com' ),
		'id' => 'smtphost',
		'std' => 'smtp.boxmoe.com',
		'class' => 'mini',
		'type' => 'text'
	);
    $options[] = array(
		'name' => __( '加密SSL，如果留空下方端口填写25', 'boxmoe-com' ),
		'id' => 'smtpsecure',
		'std' => 'ssl',
		'class' => 'mini',
		'type' => 'text'
	);		
    $options[] = array(
		'name' => __( 'SMTP端口(SSL一般为465，普通为25)', 'boxmoe-com' ),
		'id' => 'smtpprot',
		'std' => '465',
		'class' => 'mini',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( '邮箱账户', 'boxmoe-com' ),
		'id' => 'smtpusername',
		'std' => 'sys@boxmoe.com',
		'class' => 'mini',
		'type' => 'text'
	);	
	$options[] = array(
		'name' => __( '邮箱密码', 'boxmoe-com' ),
		'id' => 'smtppassword',
		'std' => 'boxmoe',
		'class' => 'mini',
		'type' => 'text'
	);

	/* 
	 * 优化性能
	 * ====================================================================================================
	 */	
	$options[] = array(
		'name' => __('优化设置', 'boxmoe-com'),
		'type' => 'heading');
	$options[] = array(
		'name' => __('关闭古腾堡移除前端加载样式', 'boxmoe-com'),
		'id' => 'gutenbergoff',
		'type' => "checkbox",
		'std' => true,
		'desc' => __('开启 （5.0版本后使用，可关闭新编辑器和前端样式）', 'boxmoe-com'));		 	
	$options[] = array(
		'name' => __('Wordpress头部优化', 'boxmoe-com'),
		'id' => 'wpheaderop',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启 （移除feed WordPress版本号等等没用东西）', 'boxmoe-com'),);	
	$options[] = array(
		'name' => __('移除头部emoji表情的 dns-refresh 功能', 'boxmoe-com'),
		'id' => 'remove_dns_refresh',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'boxmoe-com'),);	
	$options[] = array( 
		'name' => __('禁用文章自动保存', 'boxmoe-com'),
		'id' => 'autosaveop',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'boxmoe-com'),);
	$options[] = array(
		'name' => __('禁用文章修订版本', 'boxmoe-com'),
		'id' => 'revisions_to_keepop',
		'type' => "checkbox",
		'std' => false,
		'desc' => __('开启', 'boxmoe-com'),);
	//$options[] = array(
	//	'name' => __('关闭插件自动检测更新', 'boxmoe-com'),
	//	'id' => 'off_plugins',
	//	'type' => "checkbox",
	//	'std' => false,
	//	'desc' => __('开启', 'boxmoe-com'),);	
	//$options[] = array(
	//	'name' => __('关闭程序自动检测更新', 'boxmoe-com'),
	//	'id' => 'off_core',
	//	'type' => "checkbox",
	//	'std' => false,
	//	'desc' => __('开启', 'boxmoe-com'),);	


	return $options;
}