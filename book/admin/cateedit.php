<?php
include_once("../includes/init.php");
include_once("common.php");

$cateid = isset($_GET['cateid']) ? $_GET['cateid'] : 0;

$cate = $db->select()->from("cate")->where(['id'=>$cateid])->find();

if(!$cate)
{
  show('该分类记录不存在，请重新选择','catelist.php');
  exit;
}

if($_POST)
{
  $name = isset($_POST['name']) ? trim($_POST['name']) : '';
  
  $catecheck = $db->select()->from("cate")->where("name = '$name' AND id != $cateid")->find();

  //当分类存在的时候
  if($catecheck)
  {
    show("该分类已经存在了，请重新修改","cateedit.php?cateid=$cateid");
    exit;
  }

  $data = [
    "name"=>$name,
  ];

  //插入数据库
  if($db->update("cate",$data,"id = $cateid"))
  {
    show('编辑分类成功','catelist.php');
    exit;
  }else{
    show('编辑分类失败');
    exit;
  }
}


//查询分类分类
$catelist = $db->select()->from("cate")->all();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once('meta.php');?>
  </head>

  <body> 

    
    <?php include_once('header.php');?>

    <?php include_once('menu.php');?>

    <div class="content">
        <div class="header">
            <h1 class="page-name">添加分类</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">首页</a> <span class="divider">/</span></li>
            <li class="active">编辑</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='catelist.php'"><i class="icon-list"></i> 返回分类列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post">
                            <label>分类标题</label>
                            <input type="text" class="input-xxlarge" name="name" required placeholder="请输入分类标题" value="<?php echo $cate['name'];?>" />
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

