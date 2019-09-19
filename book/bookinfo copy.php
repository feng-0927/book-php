<?php
include_once("includes/init.php");
include_once("common.php");
header("Content-Type:text/html;charset=utf-8");
date_default_timezone_set("Asia/Shanghai");

//文章id
$chaid = isset($_GET['chaid']) ? $_GET['chaid'] : 0;
//书籍id
$bookid = isset($_GET['bookid']) ? $_GET['bookid'] : 0;
//阅读状态
$action = isset($_GET['action']) ? $_GET['action'] : "pages";
//加载状态
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$act = isset($_GET['act']) ? $_GET['act'] : "";

$limit = 20;
$start = ($page-1)*$limit;

if($action = 'down')
{
  //上拉加载
  if($action == "page")
  {
    //查询当前章节
    $bookinfo = $db->select()->from("chapter")->where("id = $chaid")->find();

    if(!$bookinfo)
    {
      show("无章节数据",'bookilist.php');
      exit;
    }
  
    //读取内容
    $content = is_file(HOME_ASSETS.$bookinfo['content']) ? file_get_contents(HOME_ASSETS.$bookinfo['content']) : "";
  
    if(empty($content))
    {
      show("该章节无内容","bookinfo.php");
      exit;
    }

    $count = $db->select("count(*) as c") ->from("chapter")->where("bookid = $bookid")->find();

    $result = array("bookinfo"=>$content,"count"=>$count);
    
    echo json_encode($result);
    exit;
  }

  if($action == "reset")
  {
    //查询当前章节
    $bookinfo = $db->select()->from("chapter")->where("id = $chaid")->find();

    if(!$bookinfo)
    {
      show("无章节数据",'bookilist.php');
      exit;
    }
  
    //读取内容
    $content = is_file(HOME_ASSETS.$bookinfo['content']) ? file_get_contents(HOME_ASSETS.$bookinfo['content']) : "";
  
    if(empty($content))
    {
      show("该章节无内容","bookinfo.php");
      exit;
    }
    echo json_encode($content);
    exit;
  }
}else{
    $bookinfo = $db->select()->from("chapter")->where("id = $chaid")->find();

    if(!$bookinfo)
    {
      show("无章节数据",'bookilist.php');
      exit;
    }

    //读取内容
    $content = is_file(HOME_ASSETS.$bookinfo['content']) ? file_get_contents(HOME_ASSETS.$bookinfo['content']) : "";

    if(empty($content))
    {
      show("该章节无内容","bookinfo.php");
      exit;
    }

    $json = json_decode($content,true);
}
//分页功能
//上一页
$prev = $db->select("id,bookid")->from('chapter')->where("id < $chaid AND bookid=$bookid")->orderby("id","desc")->find();
//下一页
$next = $db->select("id,bookid")->from('chapter')->where("id > $chaid AND bookid=$bookid")->orderby("id","asc")->find();
?>
<!DOCTYPE html>
<html>

<head>
  <?php include_once('meta.php');?>
  <link rel="stylesheet" href="<?php echo HOME_ASSETS;?>/plugin/mescroll/mescroll.min.css" />
  <script src="<?php echo HOME_ASSETS;?>/plugin/mescroll/mescroll.min.js"></script>


  <!-- 模板引擎插件 -->
  <script src="<?php echo HOME_ASSETS;?>/plugin/templatejs/template.js"></script>

  <style>
    .mescroll{
			position: fixed;
			top: 144px;
			bottom: 0;
			height: auto; /*如设置bottom:50px,则需height:auto才能生效*/
		}
  </style>
</head>
<body>
<div id="nav-over"></div>
<div id="warmp" class="warmp">
	<?php include_once('header.php');?>
	
	<div class="dh">
    <a href="index.php">首页</a> > 
    <font color=#999999><strong><?php echo $json['title'];?></strong></font>
    <?php if($action == "pages"){?>
      <a style="float:right;" href="bookinfo.php?chaid=<?php echo $chaid;?>&action=down&bookid=<?php echo $bookid;?>">下拉阅读</a>
    <?php }else{ ?>
      <a style="float:right;" href="bookinfo.php?chaid=<?php echo $chaid;?>&action=pages&bookid=<?php echo $bookid;?>">分页阅读</a>
    <?php }?>
  </div>
	<article class="article mescroll" id="mescroll">
    <?php if($action == 'down') {?>      
      <div class="article-con"></div>
    <?php }else{?>
      <h1 class="hd"><?php echo $json['title'];?></h1>
      <div class="article-con">
        <?php echo $json['content'];?>
      </div>
    <?php }?>
	</article>
	<!-- <article class="article">
		<h1 class="hd"><?php echo $json['title'];?></h1>
		<div class="article-con">
			<?php echo $json['content'];?>
		</div>
	</article> -->
	<!-- <div class="pagelist">
    <?php if($prev){?>
      <li><a href="bookinfo.php?chaid=<?php echo $prev['id'];?>&&bookid=<?php echo $prev['bookid'];?>">上一页</a></li>
    <?php }else{?>
      <li><a href="javascript:void(0)">无上一页</a></li>
    <?php }?>
    <?php if($next){?>
      <li><a href="bookinfo.php?chaid=<?php echo $next['id'];?>&&bookid=<?php echo $next['bookid'];?>">下一页</a></li>
    <?php }else{?>
      <li><a href="javascript:void(0)">无下一页</a></li>
    <?php }?>
  </div> -->

</div>

<?php include_once("menu.php");?>

</body>
</html>
<script src="<?php echo HOME_PATH;?>/js/index.js"></script>
<script id="tpl" type="text/html">
  <%for(var i = 0; i < list.length; i++) {%>
    <h1 class="hd"><%:=list[i].title%></h1>
    <div class="article-con">
       <p><%:=list[i].content%></p>
    </div>
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
  {//chaid=145&&bookid=1
    $.ajax({
				url: 'bookinfo.php?act=reset&cateid=<?php echo $cateid;?>&page=1&bookid=<?php echo $bookid;?>',
        dataType:"json",
				success: function(data) {
          var tpl = document.getElementById('tpl').innerHTML;
          var str = template(tpl, {list: data});
          $(".article-con").html("");
          $(".article-con").html(str);
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
      url: `bookinfo.php?act=page&page=${pageNum}&cateid=<?php echo $cateid;?>&bookid=<?php echo $bookid;?>`,
      dataType:"json",
      success: function(data) {
        var curPageData = data.content; // 接口返回的当前页数据列表
        var totalSize = data.count.c; // 接口返回的总数据量

        var tpl = document.getElementById('tpl').innerHTML;
        var str = template(tpl, {list: curPageData});
        $(".article-con").append(str);
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