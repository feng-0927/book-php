<?php 
include_once("common.php");
date_default_timezone_set("Asia/Shanghai");

if($_POST)
{
  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  
  $admin = $db->select()->from("admin")->where("username = '$username'")->find();

  //当用户存在的时候
  if($admin)
  {
    show("该用户已经存在了，请重新添加","adminadd.php");
    exit;
  }

  $data = [
    "username"=>$username,
    'password'=>trim($_POST['password']),
    'register_time'=>strtotime($_POST['register_time']),   //2019-09-12 strtotime 转换成时间戳
    'salt'=>trim($_POST['salt']),
    'email'=>trim($_POST['email']),
  ];

  //判断是否有文件上传
  if($uploads->isFile())
  {
    //判断文件是否上传成功
    if($uploads->upload())
    {
      //获取上传的文件名
      $data['avatar'] = $uploads->savefile();
    }else{
      //显示错误信息
      show($uploads->getMessage());
      exit;
    }
  }

  //插入数据库
  if($db->add("admin",$data))
  {
    show('添加用户成功','adminlist.php');
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
            <h1 class="page-username">添加用户</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">添加</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='adminlist.php'"><i class="icon-list"></i> 返回用户列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post" enctype="multipart/form-data">
                            <label>用户名</label>
                            <input type="text" name="username" value="" class="input-xxlarge" required placeholder="请输入用户名">
                            <label>密码</label>
                            <input type="text" name="password" value="" class="input-xxlarge" required placeholder="请输入密码">
                            <label>密码盐</label>
                            <input type="text" name="salt" value="" class="input-xxlarge" required placeholder="请输入密码盐">
                            <label>头像</label>
                            <input type="file" name="avatar" value="" class="input-xxlarge" required>
                            <label>邮箱</label>
                            <input type="email" name="email" value="" class="input-xxlarge" required placeholder="请输入邮箱">
                            <label>时间戳</label>
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
    <script type="text/javascript">
        // $("[rel=tooltip]").tooltip();
        // $(function() {
        //     $('.demo-cancel-click').click(function(){return false;});
        // });
    </script>
    
  </body>
</html>
<?php include_once('footer.php');?>


