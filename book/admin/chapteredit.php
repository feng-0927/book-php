<?php
include_once("../includes/init.php");
include_once("common.php");

$chapterid = isset($_GET['chapterid']) ? $_GET['chapterid'] : 0;

$chapter = $db->select()->from("chapter")->where(['id'=>$chapterid])->find();

if(!$chapter)
{
  show('该文章记录不存在，请重新选择','chapterlist.php');
  exit;
}

if($_POST)
{
  $name = isset($_POST['name']) ? trim($_POST['name']) : '';
  
  $chaptercheck = $db->select()->from("chapter")->where("name = '$name' AND id != $chapterid")->find();

  //当文章存在的时候
  if($chaptercheck)
  {
    show("该文章已经存在了，请重新修改","chapteredit.php?chapterid=$chapterid");
    exit;
  }

  $data = [
    "name"=>$name,
    'content'=>trim($_POST['content']),
    'register_time'=>strtotime($_POST['register_time']),   //2019-09-12
    'bookid'=>trim($_POST['bookid']),
  ];

  //插入数据库
  if($db->update("chapter",$data,"id = $chapterid"))
  {
    show('编辑文章成功','chapterlist.php');
    exit;
  }else{
    show('编辑文章失败');
    exit;
  }
}


//查询文章分类
$booklist = $db->select("id,title")->from("book")->all();
$chapterlist = $db->select("id")->from("chapter")->all();
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
            <h1 class="page-title">添加文章</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">首页</a> <span class="divider">/</span></li>
            <li class="active">添加</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='chapterlist.php'"><i class="icon-list"></i> 返回文章列表</button>
                  <div class="btn-group">
                  </div>
                </div>

                <div class="well">
                    <div id="myTabContent" class="tab-content">
                      <div class="tab-pane active in" id="home">
                        <form method="post" enctype="multipart/form-data">
                            <label>书籍列表</label>
                            <select required name="bookid" class="input-xlarge">
                              <option value="">请选择</option>
                              <?php foreach($booklist as $item){?>
                              <option <?php echo $chapter['bookid']==$item['id'] ? "selected":"";?> value="<?php echo $item['id'];?>"><?php echo $item['title'];?></option>
                              <?php }?>
                            </select>
                            <label>文章标题</label>
                            <input type="text" class="input-xxlarge" name="name" required placeholder="请输入文章标题" value="<?php echo $chapter['name'];?>" />
                            <label>文章内容</label>
                            <input type="text" value="<?php echo $chapter['content'];?>" class="input-xxlarge" name="content" required />
                            <label>更新时间</label>
                            <input type="date" value="<?php echo date('Y-m-d',$chapter['register_time']);?>" class="input-xxlarge" name="register_time" required />
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

