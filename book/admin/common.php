<?php
include_once("../includes/init.php");
checkLogin();  //判断管理员是否存在

$copy = $db->select("valuess")->from("setting")->where("title = '网站版权'")->find();

$keywords = $db->select("valuess")->from("setting")->where("title = '网站关键字搜索'")->find();

$webname = $db->select("valuess")->from("setting")->where("title = '网站名称'")->find();

$logo = $db->select("valuess")->from("setting")->where("title = '网站LOGO'")->find();
?>