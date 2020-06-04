<?php
if( boxmoe_com('smtpmail') ) {
add_action('phpmailer_init', 'mail_smtp');
function mail_smtp( $phpmailer ) {
$phpmailer->FromName = ''.boxmoe_com('fromnames').''; //发件人
$phpmailer->Host = ''.boxmoe_com('smtphost').''; //修改为你使用的SMTP服务器
$phpmailer->Port = ''.boxmoe_com('smtpprot').''; //SMTP端口，开启了SSL加密
$phpmailer->Username = ''.boxmoe_com('smtpusername').''; //邮箱账户   
$phpmailer->Password = ''.boxmoe_com('smtppassword').''; //输入你对应的邮箱密码，这里使用了*代替
$phpmailer->From = ''.boxmoe_com('smtpusername').''; //你的邮箱   
$phpmailer->SMTPAuth = true;   
$phpmailer->SMTPSecure = ''.boxmoe_com('smtpsecure').''; //tls or ssl （port=25留空，465为ssl）
$phpmailer->IsSMTP();
}
}




























?>