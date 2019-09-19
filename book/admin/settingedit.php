<?php
include_once("../includes/init.php");
include_once("common.php");

$setting = $db->select()->from("setting")->where()->all();
if($_POST)
{
  $copyright = isset($_POST['copyright']) ? trim($_POST['copyright']) : '';
  $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : '';
  $name = isset($_POST['name']) ? trim($_POST['name']) : '';
  $logo = isset($_POST['logo']) ? trim($_POST['logo']) : '';

  $data = [
    'copy'=>trim($_POST['copyright']),
    'keywords'=>trim($_POST['keyword']),
    'webname'=>trim($_POST['name']),
  ];
  
  // var_dump($data['copy']);die;

  //判断是否有文件上传
  if($uploads->isFile())
  {
    //判断文件是否上传成功
    if($uploads->upload())
    {
      @is_file(ASSETS_PATH.$setting[3]["valuess"]) && @unlink(ASSETS_PATH.$setting[3]["valuess"]);
      //获取上传的文件名
      $data['logo'] = $uploads->savefile();
    }else{
      //显示错误信息
      show($uploads->getMessage());
      exit;
    }
  };

  if($copyright != ""){
      //插入数据库
      if($db->updates("setting",$data))
      {
        show('编辑设置项成功','settingedit.php');
        exit;
      }else{
        show('编辑设置项成功');
        exit;
      }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once('meta.php');?>
    <link rel="stylesheet" href="<?php echo ASSETS_PATH?>/plugin/kindeditor/themes/default/default.css" />
    <script src="<?php echo ASSETS_PATH?>/plugin/kindeditor/kindeditor-min.js"></script>
    <script src="<?php echo ASSETS_PATH?>/plugin/kindeditor/lang/zh_CN.js"></script>
    <script>
			var editor;
			KindEditor.ready(function(K) {
				editor = K.create('textarea[name="content"]', {
					allowFileManager : true
				});
			});
		</script>
  </head>

  <body> 

    
    <?php include_once('header.php');?>

    <?php include_once('menu.php');?>

    <div class="content">
        <div class="header">
            <h1 class="page-title">编辑设置项</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">编辑</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                      <form method="post" enctype="multipart/form-data">
                            <label>网站版权</label>
                            <input type="text" name="copyright" value="<?php echo $setting[0]["valuess"];?>" class="input-xxlarge" required placeholder="请输入内容">
                            <label>网站关键字搜索</label>
                            <input type="text" name="keyword" value="<?php echo $setting[1]["valuess"];?>" class="input-xxlarge" required placeholder="请输入内容">
                            <label>网站名称</label>
                            <input type="text" name="name" value="<?php echo $setting[2]["valuess"];?>" class="input-xxlarge" required placeholder="请输入内容">
                            <label>网站LOGO</label>
                            <input type="file" value="" class="input-xxlarge" name="logo">
                            <?php if(!empty($setting[3]["valuess"])) {?>
                              <div class="book_thumb">
                                <img class="img-responsive" src="<?php echo ASSETS_PATH.$setting[3]["valuess"]?>" alt="">
                              </div>
                            <?php }else{?>
                              <div class="book_thumb">
                                <img src="<?php echo ADMIN_PATH.'/images/one.ico';?>" alt="">
                              </div>
                            <?php }?>
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
    
    
  </body>
</html>
<?php include_once('footer.php');?>

