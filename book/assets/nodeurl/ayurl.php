<?php 
  // var_dump($str);die;
  $listReg = "/<div class=\"list\">\s*<div class=\"row\"><div.*>(.*)<\/div>\s*<\/div><\/div>/imsU";
  preg_match($listReg,$str,$res);
  
  $lilist = $res[1];
  $liReg = "/<a.*href=\"(.*)\".*>(.*)<\/a>/misU";
  preg_match_all($liReg,$lilist,$result);
  $urllist = $result[1];
  // var_dump($urllist);
  // echo("<br>");
  $titlelist = $result[2];
  // var_dump($titlelist);die;
  // var_dump($result);
// die;
//http://www.bjkgjlu.com
  $chapterList = [];

  foreach($urllist as $key=>$item)
  {
    $item = "http://www.bjkgjlu.com" . $item;
    $str = file_get_contents($item);
    $contentReg = "/<div\s*class=\"chapter_content\"\s*.*>(.*)<\/div>/imsU";
    preg_match($contentReg,$str,$text);
    $content = strip_tags($text[1]);
    $title = $titlelist[$key];
    $arr = array("title"=>$titlelist[$key],"content"=>strip_tags($content));
    // var_dump($arr);die;
    $json = json_encode($arr);
    //保存文件
    $time = date("Ymd");
    $path = APP_PATH."/assets/book/$time";
    if(!is_dir($path))
    {
      mkdir($path,0777,true);
    }
    $filename = $Strings->randomStr(20,false).".json";
    $length = @file_put_contents($path."/".$filename,$json);
    if($length > 0)
    {
      $chapterList[] = array(
        "register_time"=>time(),
        "title"=>$title,
        "content"=>"/book/$time/$filename",
        "bookid"=>$bookid
      );
    }
  }
?>