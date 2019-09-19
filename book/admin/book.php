<?php
include_once("common.php");
header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set("Asia/Shanghai");

if($_POST)
{

  $url = isset($_POST['url']) ? trim($_POST['url']) : false;
  $nodeurl = isset($_POST['nodeurl']) ? trim($_POST['nodeurl']) : false;
  $bookid = isset($_POST['bookid']) ? trim($_POST['bookid']) : 0;
  // var_dump($nodeurl);die;
  if(!$url)
  {
    show('采集地址不对','book.php');
    exit;
  }

  // $str = file_get_contents("demo.txt");
  $str = file_get_contents($url);
  include_once($nodeurl);

  if(is_array($chapterList) && count($chapterList) > 0)
  {
    $affectRow = $db->addAll("chapter",$chapterList);
    show("该书籍新增了{$affectRow}章内容","index.php");
    exit;
  }else{
    show("当前采集节点无数据","index.php");
    exit;
  }

}

$booklist = $db->select()->from("book")->all();
$websitelist = $db->select()->from("website")->all();
// var_dump($websitelist);die;

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once('meta.php');?>
  </head>

  <body> 

    <!-- 引入头部 -->
    <?php include_once('header.php');?>
    
    <?php include_once('menu.php');?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">采集管理</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.html">Home</a> <span class="divider">/</span></li>
            <li class="active">Index</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='list.html'"><i class="icon-list"></i> 返回书籍列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post">
                            <label>书籍名称</label>
                            <select name="bookid" class="input-xlarge" required>
                              <option value="">请选择</option>
                              <?php foreach($booklist as $item){?>
                                <option value="<?php echo $item['id'];?>"><?php echo $item['title'];?></option>
                              <?php }?>
                            </select>
                            <label>选择采集节点</label>
                            <select name="nodeurl" class="input-xlarge" required>
                              <option value="">请选择</option>
                              <?php foreach($websitelist as $item){?>
                                <option value="<?php echo $item['code'];?>"><?php echo $item['name'];?></option>
                                <?php $item['code']?>
                              <?php }?>
                            </select>
                            <label>采集地址</label>
                            <input type="text" name="url" required value="" class="input-xxlarge" placeholder="请输入采集地址" />
                            <label></label>
                            <input class="btn btn-primary" type="submit" value="提交" />
                        </form>
                      </div>
                  </div>
                </div>
                
                <footer>
                    <hr>
                    <p>&copy; 2017 <a href="#" target="_blank">copyright</a></p>
                </footer>
                    
            </div>
        </div>
    </div>
    
    <?php include_once('footer.php');?>

  </body>
</html>


