<?php
defined('ABSPATH') or die('This file can not be loaded directly.');
/*global $comment_ids; $comment_ids = array();
// global $loguser;
foreach ( $comments as $comment ) {
	if (get_comment_type() == "comment") {
		$comment_ids[get_comment_id()] = ++$comment_i;
	}
} */
if ( !comments_open() ) return;
date_default_timezone_set('PRC');
$closeTimer = (strtotime(date('Y-m-d G:i:s'))-strtotime(get_the_time('Y-m-d G:i:s')))/86400;
?>
<div id="comments" class="comments-area thw-sept"><?php if ( have_comments() ){?>
  <h3 class="comments-heading text-center">
  <?php $comments_number = get_comments_number();
	if ( 0 == ! $comments_number ) {
		if ( 1 === $comments_number ) {
			_x( 'One comment', 'comments title', 'boxmoe' );
		} else {
		printf(_nx('<span><i class="fa fa-comments"></i> 文章有（%1$s）条网友点评</span>','<span><i class="fa fa-comments"></i> 文章有（%1$s）条网友点评</span>',$comments_number,'comments title','boxmoe'),number_format_i18n( $comments_number ));
				}}?> </h3>
  <ul class="comments-list">
  
									<?php
										wp_list_comments( 'type=comment&callback=boxmoe_comments_list&end-callback=boxmoe_end_comment' );
                                        wp_list_comments( 'type=pings&callback=boxmoe_comments_list&end-callback=boxmoe_end_comment' );
									?> 
									</ul>
<div class="pagenav text-center"><?php paginate_comments_links('prev_next=0');?></div>
<?php } else {?><h3 class="comments-heading text-center"><span><i class="fa fa-comments"></i> 暂无评论</span></h3><?php } ?>
</div>
<?php if ( ! comments_open() && get_comments_number() ) { ?>
<h5 class="title-normal  thw-sept text-center"><?php esc_html_e( '评论已关闭！' , 'meowdata' ); ?></h5>
<?php } else {?>								
<div id="respond_com"></div>
<div id="respond">
<h5 class="title-normal text-center" id="respond_com"><i class="fa fa-commenting"></i> 发表评论 <a id="cancel-comment-reply-link" href="javascript:;"  class="btn btn-sm btn-warning" style="display:none;"><?php echo __('取消回复', 'mogu') ?></a> </h5> 
<form id="commentform" name="commentform" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php" method="post">
<div class="row justify-content-center mb10">
<div class="col-md-3">
</div></div>                       
<?php if ( is_user_logged_in() ) { ?>
<div class="row justify-content-center mb10">
<div class="col-md-12">
<div class="alert alert-success">
您已登录:<?php echo $user_identity; ?>，<a href="<?php echo wp_logout_url(get_permalink()); ?>" id="toggle-comment-author-info">[ 退出登录 &raquo; ]</a></div>
</div></div>	<?php }?>									
<?php if ( ! $user_ID  && '' != $comment_author ) : ?>
<div class="row justify-content-center mb10">
<div class="col-md-12">
<div class="alert alert-success">
<?php printf(__('你好，%s，'), $comment_author); ?><a href="javascript:toggleCommentAuthorInfo();" id="toggle-comment-author-info">[ 切换评论身份 ]</a>
<script type="text/javascript" charset="utf-8">
						//<![CDATA[
                        function toggleCommentAuthorInfo() {
							jQuery('#comment-author-info').slideToggle('slow', function(){
								if ( jQuery('#comment-author-info').css('display') == 'none' ) {
								var changeMsg = "[ 切换评论身份 ]";	
								jQuery('#toggle-comment-author-info').html(changeMsg);
								} else {
								var closeMsg = "[ 收起来 ]";	
								jQuery('#toggle-comment-author-info').html(closeMsg);
								}
							});
						}
						
						//]]>
					</script>
</div></div></div>
 <?php endif; ?> 
 <?php if ( ! $user_ID ): ?>	
                                          <div class="row" id="comment-author-info">
                                                <div class="col-md-4">
                                                <div class="form-group comment-form-group">
												<div class="input-group input-group-alternative mb-4">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-user-circle"></i></span></div>
												<input type="text" name="author" id="author" class="form-control" value="<?php echo $comment_author; ?>" placeholder="<?php echo __('昵称 *', 'meowdata') ?>" tabindex="1">
                                                </div>
                                                </div>
												</div>
                                          <div class="col-md-4">
                                                <div class="form-group comment-form-group">
												<div class="input-group input-group-alternative mb-4">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-envelope"></i></span></div>
												<input type="email" name="email" id="email" class="form-control" value="<?php echo $comment_author_email; ?>" placeholder="<?php echo __('邮箱 *', 'meowdata') ?>"  tabindex="2" />
                                                </div>
                                                </div>
												</div>
                                          <div class="col-md-4">
                                                <div class="form-group comment-form-group">
												<div class="input-group input-group-alternative mb-4">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-link"></i></span></div>
												<input type="text" name="url" id="url" class="form-control" value="<?php echo $comment_author_url; ?>" placeholder="<?php echo __('网址', 'meowdata') ?>" size="22" tabindex="3" />	
                                                </div>
                                                </div>
												</div>
										   </div>
										   <?php endif; ?> 

 
                                          <div class="row">
                                          <div class="col-md-12">
                                          <div class="media align-items-center">
										  <?php if ( is_user_logged_in() ) {  $current_user = wp_get_current_user();?>
										  <?php echo get_avatar( $current_user->user_email, 70,'','',array('class'=>array('avatar-lg rounded-circle mb-4'))); ?> 
										  <?php } else if ( ! $user_ID ){?>
										  <?php echo get_avatar( $comment_author_email, 70,'','',array('class'=>array('avatar-lg rounded-circle mb-4'))); ?> 
										  <?php }?>
										  <div class="media-body">										 
												<textarea class="form-control  form-control-alternative" rows="3" name="comment" id="comment" tabindex="4" placeholder="你可以在这里输入评论内容..."></textarea>
                                                </div>
                                          </div>
										  </div>
                                    </div>
                                    <div class="clearfix text-center">
									<div class="comt-tips"><?php comment_id_fields(); do_action('comment_form', $post->ID); ?></div>
                                          <button class="btn btn-1 btn-outline-success mt20" name="submit" type="submit" id="submit" tabindex="5">发送评论</button> 
                                    </div>									
                                    </form>									
				
</div>	

<?php } ?>							