<?php
include_once("../includes/init.php");
include_once("common.php");
date_default_timezone_set("Asia/Shanghai");

$bookid = isset($_GET['bookid']) ? $_GET['bookid'] : 1;


if($_POST)
{
  $chapterid = isset($_POST['chapterid']) ? $_POST['chapterid'] : 0;
  $chapterid = implode(",",$chapterid);

  $chapterdelete = $db->select()->from("chapter")->where("id IN($chapterid)")->all();

  $affect = $db->delete("chapter","id IN($chapterid)");
  if($affect)
  {
    show("删除文章{$affect}条","chapterlist.php");
    exit;
  }else{
    show("删除文章失败","chapterlist.php");
    exit;
  }

}

//当前页码数
$page = isset($_GET['page']) ? $_GET['page'] : 1;

//总条数
$count = $db->select("COUNT(id) AS c")->from("chapter")->where("chapter.bookid='$bookid'")->find();

//每页显示多少条
$limit = 2;

//中间的页码数
$size = 6;

//调用分页函数，生成分页字符串
$pageStr = page($page,$count['c'],$limit,$size,'yellow');

//偏移量
$start = ($page-1)*$limit;

//查询数据
$chapterlist = $db->select("chapter.*,book.title")->from("chapter")->join("book","chapter.bookid = book.id")->where("chapter.bookid='$bookid'")->orderby("chapter.id","desc")->limit($start,$limit)->all();

//查询文章分类
$booklist = $db->select("id,title")->from("book")->all();
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
            <h1 class="page-title">文章列表</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='chapteradd.php'"><i class="icon-plus"></i>添加文章</button>
                </div>
                <div class="well">
                    <form method="post">
                      <table class="table">
                        <thead>
                          <tr>
                            <label>书籍列表</label>
                              <select id="sel" name="bookid" class="input-xlarge">
                                <option value="">请选择</option>
                                <?php foreach($booklist as $item){?>
                                <option <?php echo $bookid==$item['id'] ? "selected":"";?> value="<?php echo $item['id'];?>"><?php echo $item['title'];?></option>
                                <?php }?>
                              </select>
                          </tr>
                          <tr>
                            <th><input type="checkbox" name="delete" id="delete" /></th>
                            <th>文章标题</th>
                            <th>内容</th>
                            <th>所属书籍</th>
                            <th>更新时间</th>
                            <th style="width: 50px;">操作</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach($chapterlist as $item){?>
                          <tr>
                            <td><input type="checkbox" class="items" name="chapterid[]" value="<?php echo $item['id'];?>" /></td>
                            <td><?php echo $item['name']?></td>
                            <td><?php echo $item['content']?></td>
                            <td><?php echo $item['title']?></td>
                            <td><?php echo date("Y-m-d",$item['register_time']);?></td>
                            <td>
                                <a href="chapteredit.php?chapterid=<?php echo $item['id'];?>"><i class="icon-pencil"></i></a>
                                <a href="#myModal" onclick="del(<?php echo $item['id'];?>)" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                            </td>
                          </tr>
                          <?php }?>
                          <tr>
                            <td colspan="20" style="text-align:left;">
                              <button type="submit">批量删除</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </form>
                </div>
                <div class="pagination">
                    <?php echo $pageStr;?>
                </div>
                
                <form method="post">
                <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">Delete Confirmation</h3>
                    </div>
                    <div class="modal-body">
                        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="chapterid" name="chapterid[]" value="0" />
                        <button type="button" class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </div>
                </form>

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
<script>
  function del(chapterid)
  {
    $("#chapterid").val(chapterid);
  }
  var sel=document.getElementById("sel");
  sel.onchange=function(){
      location=("chapterlist.php?bookid="+sel.options[sel.selectedIndex].value+"");
  }
</script>