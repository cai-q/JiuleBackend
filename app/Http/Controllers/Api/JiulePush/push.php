<?php
/**
 * Created by PhpStorm.
 * User: 37036_000
 * Date: 2015/10/14
 * Time: 21:13
 */


header("Content-Type: text/html; charset=utf-8");

require_once(dirname(__FILE__) . '/' . 'IGt.Push.php');

define('APPKEY','PHD9JWXNy89kmYY9NF7V92');
define('APPID','7t2rQy5B0w9sXNZN6JJf2');
define('MASTERSECRET','Gt19kYh3N88tMRODZp4rH2');
define('HOST','http://sdk.open.api.igexin.com/apiex.htm');
define('CID','');
//define('CID2','请输入ClientID');
define('ALIAS',$_GET['userid']);


$igt = new IGeTui(HOST,APPKEY,MASTERSECRET);

//消息模版：
// 1.TransmissionTemplate:透传功能模板
// 2.LinkTemplate:通知打开链接功能模板
// 3.NotificationTemplate：通知透传功能模板
// 4.NotyPopLoadTemplate：通知弹框下载功能模板

//$template = IGtNotyPopLoadTemplateDemo();
//$template = IGtLinkTemplateDemo();
//$template = IGtNotificationTemplateDemo();
//$template = IGtTransmissionTemplateDemo();

$template =  new IGtNotificationTemplate();
$template->set_appId(APPID);                      //应用appid
$template->set_appkey(APPKEY);                    //应用appkey
$template->set_transmissionType(1);               //透传消息类型
$template->set_transmissionContent("测试离线");   //透传内容
$template->set_title($_GET["title"]);                     //通知栏标题
$template->set_text($_GET["content"]);        //通知栏内容
$template->set_logo("logo.png");                  //通知栏logo
$template->set_logoURL("http://wwww.igetui.com/logo.png"); //通知栏logo链接
$template->set_isRing(true);                      //是否响铃
$template->set_isVibrate(true);                   //是否震动
$template->set_isClearable(true);                 //通知栏是否可清除

//个推信息体
$message = new IGtSingleMessage();

$message->set_isOffline(true);//是否离线
$message->set_offlineExpireTime(3600*12*1000);//离线时间
$message->set_data($template);//设置推送消息类型
$message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
//接收方
$target = new IGtTarget();
$target->set_appId(APPID);
//$target->set_clientId(CID);
$target->set_alias(ALIAS);

$rep = $igt->pushMessageToSingle($message,$target);
