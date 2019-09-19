<?php
include_once("../includes/init.php");
include_once("common.php");

$websiteid = isset($_GET['websiteid']) ? $_GET['websiteid'] : 0;

$website = $db->select()->from("website")->where(['id'=>$websiteid])->find();

if(!$website)
{
  show('该采集节点记录不存在，请重新选择','websitelist.php');
  exit;
}

if($_POST)
{
  $name = isset($_POST['name']) ? trim($_POST['name']) : '';
  
  $websitecheck = $db->select()->from("website")->where("name = '$name' AND id != $websiteid")->find();

  //当网站名称存在的时候
  if($websitecheck)
  {
    show("该采集节点已经存在了，请重新修改","websiteedit.php?websiteid=$websiteid");
    exit;
  }

  $data = [
    "name"=>$name,
    'register_time'=>strtotime($_POST['register_time']),   //2019-09-12 strtotime 转换成时间戳
    'code'=>trim($_POST['code']),
  ];

  //插入数据库
  if($db->update("website",$data,"id = $websiteid"))
  {
    show('编辑采集节点成功','websitelist.php');
    exit;
  }else{
    show('编辑采集节点失败');
    exit;
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
            <h1 class="page-title">编辑采集节点</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">编辑</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='websitelist.php'"><i class="icon-list"></i> 返回节点列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                      <form method="post" enctype="multipart/form-data">
                            <label>网站名称</label>
                            <input type="text" name="name" value="<?php echo $website['name'];?>" class="input-xxlarge" required placeholder="请输入网站名称">
                            <label>节点的程序文件路径</label>
                            <input type="text" name="code" value="<?php echo $website['code'];?>" class="input-xxlarge" required placeholder="请输入节点的程序文件路径" <?php echo $website['code'];?>>
                            <label>执行时间点</label>
                            <input type="date" name="register_time" value="<?php echo date('Y-m-d',$website['register_time']);?>" class="input-xxlarge" required>
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

