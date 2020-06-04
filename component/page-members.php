<?php 
/*
 * Template Name: Boxmoe会员中心
*/
get_header();?>
<?php if(!is_user_logged_in()){echo "<script>window.location.href='".wp_login_url()."';</script>";}?>
<?php if(is_user_logged_in() ) {
global $wpdb;
$user_info=wp_get_current_user();


function mobantu_paging($type,$paged,$max_page) {
	if ( $max_page <= 1 ) return; 
	if ( empty( $paged ) ) $paged = 1;
	
	echo '<nav aria-label="Page navigation" class="mt-5 d-flex justify-content-center" ><ul class="pagination mt20">';
	if($paged > 1){
		echo '<li class="page-item"><a href="?id='.$type.'&pp='.($paged-1).'" class="page-link"><i class="fa fa-angle-left"></i></a></li>';
	}
	if ( $paged > 2 ) echo "<li class='page-item'><span> ... </span></li>";
	for( $i = $paged - 1; $i <= $paged + 3; $i++ ) { 
		if ( $i > 0 && $i <= $max_page ) 
		{
			if($i == $paged) 
				print "<li class='active page-item'><a href='#' class='page-link'>{$i} <span class='sr-only'>(current)</span></a></li>";
			else
				print "<li class='page-item'><a href='?id=$type&pp={$i}' class='page-link'>{$i}</a></li>";
		}
	}
	if ( $paged < $max_page - 3 ) echo "<li class='page-item'><span> ... </span></li>";
	if($paged < $max_page){
		echo '<li class="page-item"><a href="?id='.$type.'&pp='.($paged+1).'" class="page-link"><i class="fa fa-angle-right"></i></a></li>';
	}
	echo '</ul>';
}


if($_POST)
{
	if($_POST['ice_alipay']){
		$fee=get_option("ice_ali_money_site");
		$fee=isset($fee) ?$fee :100;
		$userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$user_info->ID);
		if(!$userMoney)
		{
			$okMoney=0;
		}
		else 
		{
			$okMoney=$userMoney->ice_have_money - $userMoney->ice_get_money;
		
		}
		$ice_alipay = $wpdb->escape($_POST['ice_alipay']);
		$ice_name   = $wpdb->escape($_POST['ice_name']);
		$ice_money  = isset($_POST['ice_money']) && is_numeric($_POST['ice_money']) ?$_POST['ice_money'] :0;
		$ice_money = $wpdb->escape($ice_money);
		if($ice_money<get_option('ice_ali_money_limit'))
		{
			echo '<div class="alert"><p>提现金额至少得满'.get_option('ice_ali_money_limit').get_option('ice_name_alipay').'</p></div>';
		}
		elseif(empty($ice_name) || empty($ice_alipay))
		{
			echo '<div class="alert"><p>请输入支付宝帐号和姓名</p></div>';
		}
		elseif($ice_money > $okMoney)
		{
			echo '<div class="alert"><p>提现金额大于可提现金额'.$okMoney.'</p></div>';
		}
		else
		{
	
			$sql="insert into ".$wpdb->iceget."(ice_money,ice_user_id,ice_time,ice_success,ice_success_time,ice_note,ice_name,ice_alipay)values
				('".$ice_money."','".$user_info->ID."','".date("Y-m-d H:i:s")."',0,'".date("Y-m-d H:i:s")."','','$ice_name','$ice_alipay')";
			if($wpdb->query($sql))
			{
				addUserMoney($user_info->ID, '-'.$ice_money);
				echo '<div class="alert"><p>申请成功，等待管理员处理！</p></div>';
			}
			else
			{
				echo '<div class="alert"><p>系统错误，请稍后重试！</p></div>';
			}
		}
	}
	if($_POST['paytype']){
		$paytype=intval($_POST['paytype']);
		$doo = 1;
		
		if(isset($_POST['paytype']) && $paytype==1)
		{
			$url=constant("erphpdown")."payment/alipay.php?ice_money=".esc_sql($_POST['ice_money']);
		}
		elseif(isset($_POST['paytype']) && $paytype==5)
		{
			$url=constant("erphpdown")."payment/f2fpay.php?ice_money=".esc_sql($_POST['ice_money']);
		}
		elseif(isset($_POST['paytype']) && $paytype==4)
		{
			if(erphpdown_is_weixin() && get_option('ice_weixin_app')){
				$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.get_option('ice_weixin_appid').'&redirect_uri='.urlencode(constant("erphpdown")).'payment%2Fweixin.php%3Fice_money%3D'.esc_sql($_POST['ice_money']).'&response_type=code&scope=snsapi_base&state=STATE&connect_redirect=1#wechat_redirect';
			}else{
				$url=constant("erphpdown")."payment/weixin.php?ice_money=".esc_sql($_POST['ice_money']);
			}
		}
		elseif(isset($_POST['paytype']) && $paytype==7)
		{
			$url=constant("erphpdown")."payment/paypy.php?ice_money=".esc_sql($_POST['ice_money']);
		}
		elseif(isset($_POST['paytype']) && $paytype==8)
		{
			$url=constant("erphpdown")."payment/paypy.php?ice_money=".esc_sql($_POST['ice_money'])."&type=alipay";
		}
		elseif(isset($_POST['paytype']) && $paytype==2)
		{
			$url=constant("erphpdown")."payment/paypal.php?ice_money=".esc_sql($_POST['ice_money']);
		}
	    elseif(isset($_POST['paytype']) && $paytype==18)
		{
			$url=constant("erphpdown")."payment/xhpay3.php?ice_money=".esc_sql($_POST['ice_money'])."&type=2";
		}
		elseif(isset($_POST['paytype']) && $paytype==17)
		{
			$url=constant("erphpdown")."payment/xhpay3.php?ice_money=".esc_sql($_POST['ice_money'])."&type=1";
		}
	    elseif(isset($_POST['paytype']) && $paytype==13)
	    {
	        $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=1";
	    }elseif(isset($_POST['paytype']) && $paytype==14)
	    {
	        $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=3";
	    }elseif(isset($_POST['paytype']) && $paytype==15)
	    {
	        $url=constant("erphpdown")."payment/codepay.php?ice_money=".esc_sql($_POST['ice_money'])."&type=2";
	    }
		else{
			
		}
		if($doo) echo "<script>location.href='".$url."'</script>";
		exit;
	}
	if($_POST['userType']){
		$userType=isset($_POST['userType']) && is_numeric($_POST['userType']) ?intval($_POST['userType']) :0;
		if($userType >5 && $userType < 11){
			$okMoney=erphpGetUserOkMoney();
			$priceArr=array('6'=>'ciphp_day_price','7'=>'ciphp_month_price','8'=>'ciphp_quarter_price','9'=>'ciphp_year_price','10'=>'ciphp_life_price');
			$priceType=$priceArr[$userType];
			$price=get_option($priceType);
			if(empty($price) || $price<1){
				echo "<script>alert('此类型的会员价格错误，请稍候重试！');</script>";
			}elseif($okMoney < $price){
				echo "<script>alert('当前可用余额不足完成此次交易！');</script>";
			}
			elseif($okMoney >=$price){
				if(erphpSetUserMoneyXiaoFei($price)){
					if(userPayMemberSetData($userType)){
						addVipLog($price, $userType);
						$RefMoney=$wpdb->get_row("select * from ".$wpdb->users." where ID=".$user_info->ID);
						if($RefMoney->father_id > 0){
							addUserMoney($RefMoney->father_id,$price*get_option('ice_ali_money_ref')*0.01);
						}
					}else{
						echo "<script>alert('系统发生错误，请联系管理员！');</script>";
					}
				}else{
					echo "<script>alert('系统发生错误，请稍候重试！');</script>";
				}
			}else{
				echo "<script>alert('未定义的操作！');</script>";
			}
		}else{
			echo "<script>alert('会员类型错误！');</script>";
		}
	}
	
	if($_POST['action'] == 'card'){
		$cardnum = $wpdb->escape($_POST['epdcardnum']);
		$cardpass = $wpdb->escape($_POST['epdcardpass']);
		$result = checkDoCardResult($cardnum,$cardpass);
		if($result == '5'){
			echo "<script>alert('充值卡不存在！');</script>";
		}elseif($result == '0'){
			echo "<script>alert('充值卡已被使用！');</script>";
		}elseif($result == '2'){
			echo "<script>alert('充值卡密码错误！');</script>";
		}elseif($result == '1'){
			echo "<script>alert('充值成功！');</script>";
		}else{
			echo "<script>alert('系统错误，请稍后重试！');</script>";
		}
	}elseif($_POST['action'] == 'mycredto'){
		$epdmycrednum = $wpdb->escape($_POST['epdmycrednum']);
		if(is_numeric($epdmycrednum) && $epdmycrednum > 0 && get_option('erphp_mycred') == 'yes'){
			if(floatval(mycred_get_users_cred( $user_info->ID )) < floatval($epdmycrednum*get_option('erphp_to_mycred'))){
				$mycred_core = get_option('mycred_pref_core');
				echo "<script>alert('mycred剩余".$mycred_core['name']['plural']."不足！');</script>";
			}
			else
			{
				mycred_add( '兑换', $user_info->ID, '-'.$epdmycrednum*get_option('erphp_to_mycred'), '兑换扣除%plural%!', date("Y-m-d H:i:s") );
				$money = $epdmycrednum;
				if(addUserMoney($user_info->ID, $money))
				{
					$sql="INSERT INTO $wpdb->icemoney (ice_money,ice_num,ice_user_id,ice_time,ice_success,ice_note,ice_success_time,ice_alipay)
					VALUES ('$money','".date("y").mt_rand(10000000,99999999)."','".$user_info->ID."','".date("Y-m-d H:i:s")."',1,'4','".date("Y-m-d H:i:s")."','')";
					$wpdb->query($sql);
					echo "<script>alert('兑换成功！');</script>";
				}
				else
				{
					echo "<script>alert('兑换失败！');</script>";
				}
			}
		}
	}
	
}

//会员等级设定
                            $ciphp_year_price    = get_option('ciphp_year_price'); 
							$ciphp_quarter_price = get_option('ciphp_quarter_price');
							$ciphp_month_price  = get_option('ciphp_month_price');
							$ciphp_life_price  = get_option('ciphp_life_price');
							function boxmoe_vip() {
							$userTypeId=getUsreMemberType();								
                            if($userTypeId==7)
                            {
                                echo '包月会员&nbsp;&nbsp;&nbsp;<img src="'.boxmoe_load_style().'/assets/images/vip/v2.jpg">'; 
                            }
                            elseif ($userTypeId==8)
                            {
                                echo '包季会员&nbsp;&nbsp;&nbsp;<img src="'.boxmoe_load_style().'/assets/images/vip/v3.jpg">';
                            }
                            elseif ($userTypeId==9)
                            {
                                echo '包年会员&nbsp;&nbsp;&nbsp;<img src="'.boxmoe_load_style().'/assets/images/vip/v4.jpg">';
                            }
							elseif ($userTypeId==10)
                            {
                                echo '终身会员&nbsp;&nbsp;&nbsp;<img src="'.boxmoe_load_style().'/assets/images/vip/v5.jpg">';
                            }
                            else 
                            {
                                echo '普通会员&nbsp;&nbsp;&nbsp;<img src="'.boxmoe_load_style().'/assets/images/vip/v1.jpg">';
                            }
}
//积分设定
                    $user_Info   = wp_get_current_user();
					$userMoney=$wpdb->get_row("select * from ".$wpdb->iceinfo." where ice_user_id=".$user_Info->ID);
					if(!$userMoney)
					{
						$okMoney=0;
					}
					else 
					{
						$okMoney=$userMoney->ice_have_money - $userMoney->ice_get_money;
					}


?>
<?php if(function_exists( 'mobantu_erphp_menu' )  ) {?>
<section class="section boxmoeuser">
<div class="container-full">
<div class="card ">	
<div class="card-body">
<div class="row">
<div class="usernavs">
<ul class="usernav"> 
        <li <?php if($_GET["id"]=='info' || !isset($_GET["id"])){?>class="active"<?php }?> ><a href="?id=info"><span class="boxmoeusericon"><i class="fa fa-home"></i></span><span>个人信息</span></a></li>
		<li <?php if($_GET["id"]=='order'){?>class="active"<?php }?> ><a href="?id=order"><span class="boxmoeusericon"><i class="fa fa-database"></i></span><span>订单管理</span></a></li>
		<li <?php if($_GET["id"]=='vip'){?>class="active"<?php }?> ><a href="?id=vip"><span class="boxmoeusericon"><i class="fa fa-line-chart"></i></span><span>会员升级</span></a></li>
		<li <?php if($_GET["id"]=='addmoney'){?>class="active"<?php }?> ><a href="?id=addmoney"><span class="boxmoeusericon"><i class="fa fa-credit-card"></i></span><span><?php echo get_option('ice_name_alipay');?>充值</span></a></li>
		<li <?php if($_GET["id"]=='recharge'){?>class="active"<?php }?> ><a href="?id=recharge"><span class="boxmoeusericon"><i class="fa fa-won"></i></span><span>充值记录</span></a></li>
</ul>
</div>	

<?php if($_GET["id"]=='info' || !isset($_GET["id"])){/////会员信息?>
<div class="usercontainerinfo">
  <div class="container">
  <div class="card-header card-header-info text-center">
    会员信息<div id="result"></div>
  </div>
    <div class="row ml-auto mr-auto">
      <div class="col-md-5 ">
        <div class=" card-profile">
          <img src="<?php echo boxmoe_load_style(); ?>/assets/images/banner/8.jpg" alt="Image placeholder" class="card-img-top">
          <div class="row justify-content-center">
            <div class="col-lg-3 order-lg-2">
              <div class="card-profile-image">
                <a href="#">
				<?php echo get_avatar( $user_info->user_email, 100,'','',array('class'=>array('rounded-circle'))); ?> 
                </a>
              </div>
            </div>
          </div>
          <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
            <div class="d-flex justify-content-between">
              <a href="?id=addmoney" class="btn btn-sm btn-info  mr-4 ">充值<?php echo get_option('ice_name_alipay');?></a>
              <a href="?id=pass" class="btn btn-sm btn-default float-right">修改密码</a></div>
          </div>
          <div class="card-body pt-0">
            <div class="row">
              <div class="col">
                <div class="card-profile-stats d-flex justify-content-center">
                  <div>
                    <span class="heading"><?php echo $okMoney?></span>
                    <span class="description">余额</span></div>
                  <div>
                    <span class="heading"><?php echo intval($userMoney->ice_get_money)?></span>
                    <span class="description">消费</span></div>
                  <div>
                    <span class="heading"><?php global $user_ID;echo get_comments('count=true&user_id='.$user_ID);?></span>
                    <span class="description">评论</span></div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <span>登陆用户：</span><?php echo esc_attr($user_info->user_login ); ?></div>
              <div class="col-md-12">
                <span>会员等级：</span><?php boxmoe_vip()?></div>
				<div class="col-md-12">
                <span>到期时间：</span><?php $userTypeId=getUsreMemberType(); if($userTypeId>0 && $userTypeId<10){echo getUsreMemberTypeEndTime() ;}else{echo '当前未购买会员服务';}?></div>
              <div class="col-md-12">
                <span>注册时间：</span><?php echo esc_attr( $user_info->user_registered ) ?></div>
              <div class="col-md-12">
                <span>最近登录：</span><?php echo esc_attr( $user_info->last_login ) ?></div></div>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <form action="" method="post" class="mb20 mt20">
          <div class="row">
            <div class="col-md-9">
              <div class="form-group">
                <label class="control-label ">帐户邮箱：</label>
                <input type="text" class="form-control" id="mm_mail" name="mm_mail" value="<?php echo esc_attr( $current_user->user_email ) ?>"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-9">
              <div class="form-group">
                <label class="control-label">会员昵称：</label>
                <input type="text" class="form-control" id="mm_name" name="mm_name" value="<?php echo esc_attr( $current_user->nickname ) ?>"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-9">
              <div class="form-group">
                <label class="control-label">会员网站：</label>
                <input type="text" class="form-control" id="mm_url" name="mm_url" value="<?php echo esc_attr( $current_user->user_url ) ?>"></div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label class="control-label">会员简介：</label>
                <textarea rows="4" class="form-control forminput" id="mm_desc" name="mm_desc"><?php echo esc_html( $current_user->description ); ?></textarea>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12 text-center">
              <button class="btn btn-outline-default" id="doprofile" type="button">保存</button></div>
			
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php } ?>
  
<?php if($_GET["id"]=='order'){///订单管理
			$total_trade   = $wpdb->get_var("SELECT COUNT(ice_id) FROM $wpdb->icealipay WHERE ice_success>0 and ice_user_id=".$user_info->ID);
			$ice_perpage = 10;
			$pages = ceil($total_trade / $ice_perpage);
			$page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
			$offset = $ice_perpage*($page-1);
			$list = $wpdb->get_results("SELECT * FROM $wpdb->icealipay where ice_success=1 and ice_user_id=$user_info->ID order by ice_time DESC limit $offset,$ice_perpage");
?>
<div class="usercontainer">
<div class="card-header card-header-info text-center">
   订单管理
  </div>
  <div class="card-body">
    <table class="table table-hover table-striped">
      <thead>
        <tr>
          <th width="15%">订单号</th>
          <th width="35%">商品名称</th>
          <th width="10%">价格</th>
          <th width="25%">交易时间</th>
          <th width="15%">下载信息</th></tr>
      </thead>
      <tbody>
        <?php
							if($list) {
								foreach($list as $value)
								{
									echo "<tr>\n";
									echo "<td>$value->ice_num</td>";
									echo "<td><a target=_blank href=".get_permalink($value->ice_post).">$value->ice_title</a></td>\n";
									echo "<td>$value->ice_price</td>\n";
									echo "<td>$value->ice_time</td>\n";
									echo "<td><a href='".get_bloginfo('wpurl').'/wp-content/plugins/erphpdown/download.php?url='.$value->ice_url."' target='_blank'><span class='badge badge-pill badge-success'>下载页面</span></a></td>\n";
									echo "</tr>";
								}
							}
							else
							{
								echo '<tr width=100%><td colspan="5" align="center"><center><strong>没有订单</strong></center></td></tr>';
							}
						?>
      </tbody>
    </table>
	<?php mobantu_paging('order',$page,$pages);?>
  </div>
</div>
<?php } ?>				


<?php if($_GET["id"]=='vip'){ /////////////////升级会员?>	
<div class="container">
  <div class="usercontainerinfo">
    <div class="tab-pane active show" id="updatavip">
      <div class=" card-nav-tabs">
        <div class="card-header card-header-info text-center">升级会员</div>
        <div class="card-body">
          <ul class="list-group list-group-flush list my--3 ">
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-auto">
                  <!-- Avatar -->
                  <div class="avatar rounded-circle">
				  <?php echo get_avatar( $user_info->user_email, 50,'','',array('class'=>array(''))); ?> 
                </div>
                </div>
                <div class="col ml--2">
                  <h4 class="mb-0">
                    <span><?php echo esc_attr($user_info->user_login ); ?></span>
                    <span class="vipcol">账户余额：<?php echo $okMoney?>&nbsp;<?php echo get_option('ice_name_alipay');?></span></h4>
                  <span class="text-success">●</span>
                  <small class="vipcoll">当前会员等级：<?php boxmoe_vip()?>&nbsp;&nbsp;<?php $userTypeId=getUsreMemberType(); echo ($userTypeId>0 && $userTypeId<10) ?'到期时间：'.getUsreMemberTypeEndTime() :''?></small></div>
                <div class="col-auto">
                  <a href="?id=addmoney" class="btn btn-sm btn-success">充值</a></div>
              </div>
            </li>
          </ul>
          <form action="" method="post" class="mt30">
            <ul class="list-group list-group-flush" data-toggle="checklist">
              <?php if($ciphp_life_price){?><li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
                <div class="checklist-item checklist-item-purple">
                  <div class="checklist-purple">
                    <h5 class="checklist-title mb-0">
                      <span class="text-purple">
                        <strong>&nbsp;终身会员&nbsp;（<?php echo $ciphp_life_price.get_option('ice_name_alipay')?> ）</strong></span>
                    </h5>
                    <small>
                      <img src="http://h.lolita.blue/wp-content/themes/boxmoe/assets/images/vip/v5.jpg"></small>
                  </div>
                  <div>
                    <div class="custom-control custom-checkbox custom-checkbox-purple">
                      <input class="custom-control-input" name="userType" id="userType10" type="radio" value="10" checked>
                      <label class="custom-control-label" for="userType10"></label>
                    </div>
                  </div>
                </div>
              </li><?php }?>
              <?php if($ciphp_year_price){?><li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
                <div class="checklist-item checklist-item-danger">
                  <div class="checklist-danger">
                    <h5 class="checklist-title mb-0">
                      <span class="text-danger">
                        <strong>&nbsp;年付会员&nbsp;（<?php echo $ciphp_year_price.get_option('ice_name_alipay')?> ）</strong></span>
                    </h5>
                    <small>
                      <img src="http://h.lolita.blue/wp-content/themes/boxmoe/assets/images/vip/v4.jpg"></small>
                  </div>
                  <div>
                    <div class="custom-control custom-checkbox custom-checkbox-danger">
                      <input class="custom-control-input" name="userType" id="userType9"value="9" type="radio">
                      <label class="custom-control-label" for="userType9"></label>
                    </div>
                  </div>
                </div>
              </li><?php }?>
               <?php if($ciphp_quarter_price){?><li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
                <div class="checklist-item checklist-item-warning">
                  <div class="checklist-warning">
                    <h5 class="checklist-title mb-0">
                      <span class="text-warning">
                        <strong>&nbsp;季付会员&nbsp;（<?php echo $ciphp_quarter_price.get_option('ice_name_alipay')?> ）</strong></span>
                    </h5>
                    <small>
                      <img src="http://h.lolita.blue/wp-content/themes/boxmoe/assets/images/vip/v3.jpg"></small>
                  </div>
                  <div>
                    <div class="custom-control custom-checkbox custom-checkbox-warning">
                      <input class="custom-control-input" name="userType" id="userType8" value="8" type="radio">
                      <label class="custom-control-label" for="userType8"></label>
                    </div>
                  </div>
                </div>
              </li><?php }?>
              <?php if($ciphp_month_price){?><li class="checklist-entry list-group-item flex-column align-items-start py-4 px-4">
                <div class="checklist-item checklist-item-golden">
                  <div class="checklist-golden">
                    <h5 class="checklist-title mb-0">
                      <span class="text-golden">
                        <strong>&nbsp;月付会员&nbsp;（<?php echo $ciphp_month_price.get_option('ice_name_alipay')?> ）</strong></span> 
                    </h5>
                    <small>
                      <img src="http://h.lolita.blue/wp-content/themes/boxmoe/assets/images/vip/v2.jpg"></small>
                  </div>
                  <div>
                    <div class="custom-control custom-checkbox custom-checkbox-golden">
                      <input class="custom-control-input" name="userType" id="userType7" value="7" type="radio">
                      <label class="custom-control-label" for="userType7"></label>
                    </div>
                  </div>
                </div>
              </li><?php }?>
            </ul>
            <input type="submit" name="Submit" value="升级会员" style="text-align: center;margin-left: 450px;" class="btn btn-outline-danger mt20 mb20" onClick="return confirm('确认升级会员?');" />
          </form>
        </div>
      </div>				
<?php }?>

<?php if($_GET["id"]=='addmoney'){ /////////////////充值?>	
<div class="container">
  <div class="usercontainerinfo">
<div class="tab-pane active show" id="pay">
<div class=" card-nav-tabs">
<div class="card-header card-header-info text-center">
   充值中心
  </div>
<div class="card-body">
          <ul class="list-group list-group-flush list my--3 ">
            <li class="list-group-item">
              <div class="row align-items-center">
                <div class="col-auto">
                  <!-- Avatar -->
                  <div class="avatar rounded-circle">
				  <?php echo get_avatar( $user_info->user_email, 50,'','',array('class'=>array(''))); ?> 
                </div>
                </div>
                <div class="col ml--2">
                  <h4 class="mb-0">
                    <span><?php echo esc_attr($user_info->user_login ); ?></span>
					<small class="vipcoll">&nbsp;&nbsp;&nbsp;消费<?php echo get_option('ice_name_alipay');?>：<?php echo intval($userMoney->ice_get_money)?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;剩余<?php echo get_option('ice_name_alipay');?>：<?php echo $okMoney?></small>
                    </h4>
                  <span class="text-success">●</span>
                  <small class="vipcoll">当前会员等级：<?php boxmoe_vip()?>&nbsp;&nbsp;<?php $userTypeId=getUsreMemberType(); echo ($userTypeId>0 && $userTypeId<10) ?'到期时间：'.getUsreMemberTypeEndTime() :''?></small>
				  </div>
              </div>
            </li>
          </ul>		  
<div class="row mt20">
<script type="text/javascript">
					function checkFm(){
						if(document.getElementById("ice_money").value=="")
						{
							alert('请输入金额');
							return false;
						}
					}
					function checkFm2(){
						if(document.getElementById("epdcardnum").value=="")
						{
							alert('请输入金额');
							return false;
						}
					}
					function checkFm3(){
						if(document.getElementById("epdmycrednum").value=="")
						{
							alert('请输入兑换的金额');
							return false;
						}
					}
					</script>			
<div class="col-md-12">
 <div class="checklist-item checklist-item-success">
                    <div class="checklist-info">
                      <h5 class="checklist-title mb-0">在线充值</h5>
                      <small>充值说明：<span class="badge badge-warning">1 元 = <?php echo get_option('ice_proportion_alipay').' '.get_option('ice_name_alipay')?></span>请根据需求充值</small>
                    </div>
 </div>
                <form action="" method="post" onsubmit="return checkFm();">
                        <table class="form-table">
                            <tbody><tr>
                				<td>
								<div class="col-md-12 mt10 mb10">
                				<input type="text" id="ice_money" name="ice_money" class="form-control" placeholder="请输入一个整数金额" required="required">
                				</div>
								<?php if(get_option('ice_weixin_mchid')){?> 
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype4" name="paytype"  value="4" class="custom-control-input">
								<label class="custom-control-label" for="paytype4">微信</label>
								</div>
                                <?php }?>
                                <?php if(get_option('ice_ali_partner')){?> 
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype1" name="paytype"  value="1" class="custom-control-input">
								<label class="custom-control-label" for="paytype1">支付宝</label>
								</div>
                                <?php }?>
                                <?php if(get_option('erphpdown_f2fpay_id')){?> 
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype5" name="paytype"  value="5" class="custom-control-input" >
								<label class="custom-control-label" for="paytype5">支付宝</label>
								</div>
								<?php }?>
								<?php if(get_option('erphpdown_xhpay_appid31')){?>
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype18" name="paytype" value="18" class="custom-control-input">
								<label class="custom-control-label" for="paytype18">微信</label>
								</div>   
								<?php }?>
								<?php if(get_option('erphpdown_xhpay_appid32')){?>
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype17" name="paytype" value="17" class="custom-control-input">
								<label class="custom-control-label" for="paytype17">支付宝</label>
								</div>      
								<?php }?>
				                <?php if(get_option('erphpdown_codepay_appid')){?>
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype13" name="paytype" value="13" class="custom-control-input">
								<label class="custom-control-label" for="paytype13"checked>支付宝</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype14" name="paytype" value="14" class="custom-control-input">
								<label class="custom-control-label" for="paytype14" >微信</label>
								</div>
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype15" name="paytype" value="15" class="custom-control-input">
								<label class="custom-control-label" for="paytype15">QQ钱包</label>
								</div>   
				                <?php }?>
				                <?php if(get_option('erphpdown_paypy_key')){?> 
									<?php if(!get_option('erphpdown_paypy_wxpay')){?>
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype7" name="paytype"  value="7" class="custom-control-input">
								<label class="custom-control-label" for="paytype7">微信</label>
								</div>
									<?php }?>    
									<?php if(!get_option('erphpdown_paypy_alipay')){?>
									<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype8" name="paytype"  value="8" class="custom-control-input">
								<label class="custom-control-label" for="paytype8">支付宝</label>
								</div> 
								<?php }?> 
								<?php }?> 
                                <?php if(get_option('ice_payapl_api_uid')){?>
								<div class="custom-control custom-radio custom-control-inline custom-checkbox-purple">
								<input type="radio" id="paytype2" name="paytype"  value="2" class="custom-control-input">
								<label class="custom-control-label" for="paytype2">PayPal($美元)汇率：
                                 (<?php echo get_option('ice_payapl_api_rmb')?>)</label>
								</div> 								
                                 <?php }?> 
							 </td>
                            </tr>

                    </tbody></table>
                        <br> 
                        <table> <tbody><tr>
                        <td><p class="submit">
                            <input type="submit" name="Submit" value="在线充值" class="btn btn-outline-success">
                            </p>
                        </td>
                
                        </tr> 
                        
                        </tbody></table>
                
               </form> 
			   </div>
 <?php if(function_exists("checkDoCardResult")){?>			   
 <div class="col-md-12 mb30 mt30">
 <div class="checklist-item checklist-item-success">
                    <div class="checklist-info">
                      <h5 class="checklist-title mb-0">充值卡充值</h5>
                      <small>充值说明：<span class="badge badge-warning">1 元 = <?php echo get_option('ice_proportion_alipay').' '.get_option('ice_name_alipay')?></span>请根据需求充值，充值卡密金额分别为<span class="badge badge-success">10元</span> <span class="badge badge-success">30元</span> <span class="badge badge-success">50元</span> <span class="badge badge-success">100元</span></small>
                    </div>
 </div>


                    <ul class="user-meta mt20">
<div id="viptip" class="mb20"></div>							
					<form action="" method="post" onsubmit="return checkFm2();">	
					<li class="col-md-6"><label>充值卡号</label><input type="text" id="epdcardnum" name="epdcardnum" class="form-control" required="required"> </li>
					<li class="col-md-6"><label>充值卡密</label><input type="text" id="epdcardpass" name="epdcardpass" class="form-control" required="required"></li>
                   
					<div class="col-md-9 mt10">
					<input type="hidden" name="action" value="card"><input type="submit" value="充值卡充值" class="btn btn-outline-success">  <a class="btn btn-info" href="#">淘宝购买充值卡</a></div> 
					</form>
					</ul>
</div>
 	</form>
                <?php }?>               

				

</div>
</div></div></div>







</div>
      </div>
<?php }?>



<?php if($_GET["id"]=='recharge'){///充值记录
				$totallists = $wpdb->get_var("SELECT count(*) FROM $wpdb->icemoney WHERE ice_success=1 and ice_user_id=".$user_info->ID);
				$ice_perpage = 10;
				$pages = ceil($totallists / $ice_perpage);
				$page=isset($_GET['pp']) ?intval($_GET['pp']) :1;
				$offset = $ice_perpage*($page-1);
				$lists = $wpdb->get_results("SELECT * FROM $wpdb->icemoney where ice_success=1 and ice_user_id=".$user_info->ID." order by ice_time DESC limit $offset,$ice_perpage");
?>		
<div class="usercontainer">
<div class="card-header card-header-info text-center">
   充值记录
  </div>
<div class="card-body">
<table class="table table-hover table-striped">
					<thead>
						<tr>			
                <th width="35%">充值时间</th>
                <th width="25%">充值金额</th>
				<th width="20%">充值方式</th>
                
						</tr>
					</thead>
					<tbody>
						<?php
							if($lists) {
								foreach($lists as $value)
								{
									echo "<tr>\n";
									echo "<td>$value->ice_time</td>";
									echo "<td>$value->ice_money</td>\n";
									if(intval($value->ice_note)==0)
									{
										echo "<td>在线充值</td>\n";
									}elseif(intval($value->ice_note)==1)
									{
										echo "<td>后台充值</td>\n";
									}
									elseif(intval($value->ice_note)==2)
									{
										echo "<td>转账收</td>\n";
									}
									elseif(intval($value->ice_note)==3)
									{
										echo "<td>转账付</td>\n";
									}
									elseif(intval($value->ice_note)==6)
					               {
						            echo "<td>充值卡</td>\n";
					                }								
									
									echo "</tr>";
								}
							}
							else
							{
								echo '<tr width=100%><td colspan="3" align="center"><center><strong>没有记录！</strong></center></td></tr>';
							}
						?>
					</tbody>
				</table>
				<?php mobantu_paging('recharge',$page,$pages);?>



</div>
</div>
<?php } ?>	
<?php if($_GET["id"]=='pass'){///修改密码?>	
<div class="container">
<div class="usercontainerinfo">
<div class="card-header card-header-info text-center">
   修改密码<div id="result"></div>
  </div>
<div class="card-body">

<div id="changepass">
				<div class="alert alert-success">为了确保安全，密码最好是由“字母+字符+数字”组成！</div>
				<div class="row justify-content-center">
				<div class="col-md-6">
				<div class="profile-form">
					<form action="" method="post">
                    <dl class="dl-horizontal"  style="display: none;">
						<dt><label class="pt10">用户名</label></dt> 
						<dd>
							<input type="text" id="mm_username" name="log" value="<?php echo esc_attr( $user_info->user_login ); ?>" class="form-control" disabled>
						</dd>
					</dl>
					<dl class="dl-horizontal">
						<dt><label class="pt10">新密码</label></dt>
						<dd>
							<input type="password" id="mm_pass_new" name="mm_pass_new" value="" class="form-control">
						</dd>
					</dl>
					<dl class="dl-horizontal">
						<dt><label class="pt10">重复密码</label></dt>
						<dd>
							<input type="password" id="mm_pass_new2" name="mm_pass_new2" value="" class="form-control">
						</dd>
					</dl>
					<dl class="dl-horizontal mt10">
						<dd>
							<input type="button" id="dopassword" value="保存修改" class="btn btn-outline-danger text-center" />
						</dd>
					</dl>
					</form>
				</div>
				</div>
				</div>
			</div>
</div>
</div>
</div>
<?php } ?>
	</div><!-- row -->
	</div><!-- card-body -->
	</div><!-- card -->	
    </div>
      </section>
	  <div class="modal fade" id="tipsnode" tabindex="-1" role="dialog" aria-labelledby="tipsnodemoda" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tipsnodemoda">提醒</h5>
      </div>
      <div class="modal-body">
       <div id="tip1"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>	  
<?php }else{ ?> 
<section class="section section-about">
<div class="container">
          <div class="section-head">
            <span>会员中心</span>
           </div>
<div class="row">
<div class="col-lg-10 col-md-10 ml-auto mr-auto">	
	
<div class="alert alert-warning" role="alert">
    <span class="alert-icon"><i class="fa fa-bell"></i></span>
    <span class="alert-text"><strong>提示：</strong> 会员中心必须配套Erphpdown插件使用，检测网站未启用或者未安装该插件！<a href="#" style="font-weight: bold;color: #fff;font-size: 16px;">详细点击查看说明</a></span>
</div>
</div>
</div>
</div>
</section>
<?php } ?>
<?php } ?>
<?php get_footer(); ?>
