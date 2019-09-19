<?php 
include_once("common.php");
date_default_timezone_set("Asia/Shanghai");

if($_POST)
{
  $name = isset($_POST['name']) ? trim($_POST['name']) : '';
  
  $website = $db->select()->from("website")->where("name = '$name'")->find();

  //当用户存在的时候
  if($website)
  {
    show("该用户已经存在了，请重新添加","websiteadd.php");
    exit;
  }

  $data = [
    "name"=>$name,
    'register_time'=>strtotime($_POST['register_time']),   //2019-09-12 strtotime 转换成时间戳
    'code'=>trim($_POST['code']),
  ];

  //插入数据库
  if($db->add("website",$data))
  {
    show('添加用户成功','websitelist.php');
    exit;
  }else{
    show('添加用户失败');
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once("meta.php")?>
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
    <?php include_once("header.php")?>
    <?php include_once("menu.php")?>
    <div class="content">
        <div class="header">
            <h1 class="page-username">添加采集节点</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">添加</li>
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
                            <input type="text" name="name" value="" class="input-xxlarge" required placeholder="请输入网站名称">
                            <label>节点的程序文件路径</label>
                            <input type="text" name="code" value="" class="input-xxlarge" required placeholder="请输入节点的程序文件路径">
                            <label>执行时间点</label>
                            <input type="date" name="register_time" value="" class="input-xxlarge" required>
                            <label></label>
                            <input class="btn btn-primary" type="submit" value="提交" />
                        </form>
                      </div>
                  </div>
                </div>

                <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h3 id="myModalLabel">Delete Confirmation</h3>
                  </div>
                  <div class="modal-body">
                    
                    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
                  </div>
                  <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                    <button class="btn btn-danger" data-dismiss="modal">Delete</button>
                  </div>
                </div>
                
                <footer>
                    <hr>
                    <p>&copy; 2017 <a href="#" target="_blank">copyright</a></p>
                </footer>
                    
            </div>
        </div>
    </div>
    
    <script src="<?php echo ADMIN_PATH;?>/lib/bootstrap/js/bootstrap.js"></script>
  </body>
</html>
<?php include_once('footer.php');?>


