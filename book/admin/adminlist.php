<?php 
include_once("common.php");
date_default_timezone_set("Asia/Shanghai");
header("Content-Type:text/html;charset=utf-8");

if($_POST)
{
  $adminid = isset($_POST['adminid']) ? $_POST['adminid'] : 0;
  $adminid = implode(",",$adminid);

  $admindelete = $db->select("avatar")->from("admin")->where("id IN($adminid)")->all();

  $affect = $db->delete("admin","id IN($adminid)");
  if($affect)
  {
    if($bookdelete)
    {
      foreach($bookdelete as $item)
      {
        @is_file(ASSETS_PATH.$item['avatar']) && @unlink(ASSETS_PATH.$item['avatar']);
      }
    }
    show("删除书籍{$affect}条","adminlist.php");
    exit;
  }else{
    show("删除书籍失败","adminlist.php");
    exit;
  }

}

//当前页码数
$page = isset($_GET['page']) ? $_GET['page'] : 1;

//总条数
$count = $db->select("COUNT(id) AS c")->from("admin")->find();

//每页显示多少条
$limit = 2;

//中间的页码数
$size = 5;

//调用分页函数，生成分页字符串
$pageStr = page($page,$count['c'],$limit,$size,'yellow');

//偏移量
$start = ($page-1)*$limit;

//查询数据
$adminlist = $db->select()->from("admin")->orderby("admin.id","desc")->limit($start,$limit)->all();

// print_r($adminlist);die;
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once("meta.php")?>
  </head>
  <body> 
    <?php include_once("header.php")?>
    
    <?php include_once("menu.php")?>
    <div class="content">
        <div class="header">
            <h1 class="page-title">管理员列表</h1>
        </div>
        <ul class="breadcrumb">
            <li><a href="index.php">后台首页</a> <span class="divider">/</span></li>
            <li class="active">列表</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                <div class="btn-toolbar">
                    <button class="btn btn-primary" onClick="location='adminadd.php'"><i class="icon-plus"></i>管理员</button>
                </div>
                <div class="well">
                <form method="post">
                    <table class="table">
                      <thead>
                        <tr>
                          <th><input type="checkbox" name="delete" id="delete"></th>
                          <th>用户名</th>
                          <th>发布时间</th>
                          <th>头像</th>
                          <th style="width: 50px;">操作</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($adminlist as $item) {?>
                        <tr>
                          <td><input type="checkbox" name="adminid[]" class="items" value="<?php echo $item['id']?>"></td>
                          <td><?php echo $item["username"]?></td>
                          <td><?php echo date("Y-m-d",$item["register_time"]);?></td>
                          <?php if(!empty($item['avatar'])){?>
                              <td>
                                <div class="book_thumb">
                                  <img class="img-responsive" src="<?php echo ASSETS_PATH.$item['avatar'];?>" />
                                </div>
                              </td>
                            <?php }else{?>
                              <td>
                                <div class="book_thumb">
                                  <img class="img-responsive" src="<?php echo ADMIN_PATH.'/images/cover.png';?>" />
                                </div>
                              </td>
                            <?php }?>
                          <td>
                              <a href="adminedit.php?adminid=<?php echo $item['id'];?>"><i class="icon-pencil"></i></a>
                              <a href="#myModal" onclick="del(<?php echo $item['id'];?>)" role="button" data-toggle="modal"><i class="icon-remove"></i></a>
                          </td>
                        </tr>
                        <?php }?>
                        <tr>
                          <td colspan="20" style="text-align:left;">
                            <button type="sumbit">批量删除</button>
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
                        <input type="hidden" id="adminid" name="adminid[]" value="0" />
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
    
    <?php include_once('footer.php')?>
    
  </body>
</html>
<script>
  function del(adminid)
  {
    $("#adminid").val(adminid);
  }
</script>


