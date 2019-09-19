<?php
include_once("../includes/init.php");
include_once("common.php");

$adminid = isset($_GET['adminid']) ? $_GET['adminid'] : 0;

$admin = $db->select()->from("admin")->where(['id'=>$adminid])->find();

if(!$admin)
{
  show('该用户记录不存在，请重新选择','adminlist.php');
  exit;
}

if($_POST)
{
  $username = isset($_POST['username']) ? trim($_POST['username']) : '';
  
  $admincheck = $db->select()->from("admin")->where("username = '$username' AND id != $adminid")->find();

  //当用户存在的时候
  if($admincheck)
  {
    show("该用户已经存在了，请重新修改","adminedit.php?adminid=$adminid");
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
      @is_file(ASSETS_PATH.$admin['avatar']) && @unlink(ASSETS_PATH.$admin['avatar']);
      //获取上传的文件名
      $data['avatar'] = $uploads->savefile();
    }else{
      //显示错误信息
      show($uploads->getMessage());
      exit;
    }
  }

  //插入数据库
  if($db->update("admin",$data,"id = $adminid"))
  {
    show('编辑用户成功','adminlist.php');
    exit;
  }else{
    show('编辑用户失败');
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
            <h1 class="page-title">编辑用户</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">编辑</li>
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
                            <input type="text" name="username" value="<?php echo $admin['username'];?>" class="input-xxlarge" required placeholder="请输入用户名">
                            <label>密码</label>
                            <input type="text" name="password" value="<?php echo $admin['password'];?>" class="input-xxlarge" required placeholder="请输入密码">
                            <label>密码盐</label>
                            <input type="text" name="salt" value="" class="input-xxlarge" required placeholder="请输入密码盐" <?php echo $admin['salt'];?>>
                            <label>头像</label>
                            <input type="file" name="avatar" value="" class="input-xxlarge" required>
                            <?php if(!empty($book['avatar'])){?>
                              <div class="book_thumb">
                                <img class="img-responsive" src="<?php echo ASSETS_PATH.$book['avatar'];?>" />
                              </div>
                            <?php }else{?>
                              <div class="book_avatar">
                                <img class="img-responsive" src="<?php echo ADMIN_PATH.'/images/cover.png';?>" />
                              </div>
                            <?php }?>
                            <label>邮箱</label>
                            <input type="email" name="email" value="" class="input-xxlarge" required placeholder="请输入邮箱" <?php echo $admin['email'];?>>
                            <label>时间戳</label>
                            <input type="date" name="register_time" value="<?php echo date('Y-m-d',$admin['register_time']);?>" class="input-xxlarge" required>
                            <!-- <label>文章内容</label> -->
                            <!-- <textarea value="Smith" rows="3" class="input-xxlarge"></textarea> -->
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

