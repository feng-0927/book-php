<?php
include_once("includes/init.php");
include_once("common.php");
header("Content-Type:text/html;charset=utf-8");

$cateid = isset($_GET['cateid']) ? $_GET['cateid'] : 0;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$action = isset($_GET['action']) ? $_GET['action'] : "";

$limit = 20;
$start = ($page-1)*$limit;


//上拉加载
if($action == "page")
{
  $booklist =$db->select()->from("book")->where("cateid = $cateid")->limit($start,$limit)->all();

  $count = $db->select("COUNT(id) AS c")->from("book")->where("cateid = $cateid")->find();

  $result = array("booklist"=>$booklist,"count"=>$count);
  
  echo json_encode($result);
  exit;
}

if($action == "reset")
{
  //直接查询书籍
  $booklist =$db->select()->from("book")->where("cateid = $cateid")->limit($start,$limit)->all();
  echo json_encode($booklist);
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
  <?php include_once('meta.php');?>
  <link rel="stylesheet" href="<?php echo HOME_ASSETS;?>/plugin/mescroll/mescroll.min.css" />
  <script src="<?php echo HOME_ASSETS;?>/plugin/mescroll/mescroll.min.js"></script>


  <!-- 模板引擎插件 -->
  <script src="<?php echo HOME_ASSETS;?>/plugin/templatejs/template.js"></script>
  <style type="text/css">
    .mescroll{
      position: fixed;
      top: 284px;
      bottom: 0;
      height: auto; /*如设置bottom:50px,则需height:auto才能生效*/
    }

    @media screen and (max-width: 639px) {
      .mescroll {
        top: 145px;
      }
    }
  </style>
</head>

<body>
  <div id="warmp" class="warmp">
      <?php include_once('header.php');?>
      
      <div class="dh"><a href="index.php">首页</a> > 数据列表：</div>
      <div id="mescroll" class="mescroll list-index">
        <ul id="articlelist" class=articlelist></ul>
      </div>
  </div>

  <?php include_once("menu.php");?>

</body>
</html>
<script src="<?php echo HOME_PATH;?>/js/index.js"></script>
<script id="tpl" type="text/html">
  <%for(var i = 0; i < list.length; i++) {%>
    <li>
        <a href="chapterlist.php?bookid=<%:=list[i].id%>">
          <%:=list[i].title%>
        </a>
    </li>
  <%}%>
</script>
<script>
  var mescroll = new MeScroll("mescroll",{
    //设置下拉刷新回调
    down:{
      callback: downCallback,
    },

    //设置上拉加载
    up:{
      callback: upCallback,
      page: {
        num: 0, //当前页 默认0,回调之前会加1; 即callback(page)会从1开始
        size: 10 //每页数据条数,默认10
      },
      use : false , 
      delay : 500 
    }
  });

  //下拉刷新的回调函数 (数据清空)
  function downCallback()
  {
    $.ajax({
				url: 'booklist.php?action=reset&cateid=<?php echo $cateid;?>&page=1',
        dataType:"json",
				success: function(data) {
          var tpl = document.getElementById('tpl').innerHTML;
          var str = template(tpl, {list: data});
          $("#articlelist").html("");
          $("#articlelist").html(str);
          mescroll.resetUpScroll();
					mescroll.endSuccess(); //无参. 注意结束下拉刷新是无参的
				},
				error: function(data) {
					//联网失败的回调,隐藏下拉刷新的状态
					mescroll.endErr();
				}
			});
  }

  //上拉加载 (增加数据)
  function upCallback(page)
  {
    var pageNum = page.num; // 页码, 默认从1开始 如何修改从0开始 ?
    $.ajax({
      url: `booklist.php?action=page&page=${pageNum}&cateid=<?php echo $cateid;?>`,
      dataType:"json",
      success: function(data) {
        var curPageData = data.booklist; // 接口返回的当前页数据列表
        var totalSize = data.count.c; // 接口返回的总数据量

        var tpl = document.getElementById('tpl').innerHTML;
        var str = template(tpl, {list: curPageData});
        $("#articlelist").append(str);
        // mescroll.endSuccess(); //无参. 注意结束下拉刷新是无参的

        //方法二(推荐): 后台接口有返回列表的总数据量 totalSize
        //必传参数(当前页的数据个数, 总数据量)
        mescroll.endBySize(curPageData.length, totalSize);
        
      },
      error: function(e) {
        //联网失败的回调,隐藏下拉刷新和上拉加载的状态
        mescroll.endErr();
      }
    });
  }
</script>