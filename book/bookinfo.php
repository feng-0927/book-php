<?php
include_once("includes/init.php");
include_once("common.php");

//书籍id
$bookid = isset($_GET['bookid']) ? $_GET['bookid'] : 0;

//分页模式需要用到id
$id = isset($_GET['id']) ? $_GET['id'] : 0;

$ids = isset($_GET['ids']) ? $_GET['ids'] : 0;
//当前动作
$action = isset($_GET['action']) ? $_GET['action'] : "page";
//上一页或下一页
$act = isset($_GET['act']) ? $_GET['act'] : '';

//分页
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 1;

function get_file_content($bookinfo) {
  //读取内容
  $bookinfo_path = HOME_ASSETS . $bookinfo['content'];
  $content = is_file($bookinfo_path) ? file_get_contents($bookinfo_path) : "";

  if(empty($content)) {
    show("该章节无内容", "booklist.php?cateid={$bookid}");
    exit;
  }
  return json_decode($content, true);
}

if($action == 'down') {
  //下拉模式
  if($act == 'reset') {
    //查询当前章节  

    $bookinfo = $db -> select() -> from("chapter") -> where("bookid = $bookid and id >= $id") -> orderBy("id") -> find();

    //读取内容
    $json = get_file_content($bookinfo);

    $data = array(
      'name' => $bookinfo['name'],
      'content' => $json['content']
    );

    echo json_encode($data); die;
  }

  if($act == 'next') {
    // $id += 1;
    // $db -> select("id") -> from("chapter") -> where("bookid = $bookid and id > $id") -> orderBy("id") -> find();
    $bookinfo = $db -> select() -> from("chapter") -> where("bookid = $bookid and id >= $id") -> limit($page, $limit) -> find();

    //读取内容
    $json = get_file_content($bookinfo);

    $count = $db -> select("count(*) as c") -> from("chapter") -> where("bookid = $bookid and id >= $id") -> find();

    $data = array(
      'name' => $bookinfo['name'],
      'content' => $json['content'],
      'count' => $count['c']
    );
    echo json_encode($data); die;
  } 
} 

//分页模式
$prev = $db -> select("id") -> from("chapter") -> where("bookid = $bookid and id < $id") -> orderBy("id", "desc") -> find();
$next = $db -> select("id") -> from("chapter") -> where("bookid = $bookid and id > $id") -> orderBy("id") -> find();

$where = array(
  'bookid' => $bookid,
  'id' => $id
);
$bookinfo = $db -> select() -> from("chapter") -> where($where) -> orderBy("id", "desc") -> find();
$json = get_file_content($bookinfo); 
?>
<!DOCTYPE html>
<html>
<head>
  <?php include_once('meta.php');?>
  <?php if($action != 'page') { ?>
  <link rel="stylesheet" href="<?php echo HOME_ASSETS; ?>/plugin/mescroll/mescroll.min.css">
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
  <?php } ?>
</head>

<body>
  <div id="nav-over"></div>
  <div id="warmp" class="warmp">
      <?php include_once('header.php');?>
      
      <div class="dh"><a href="index.php">首页</a> > <font color=#999999><strong class="titles">
        <?php echo $bookinfo['name']; ?>
      </strong></font>
        <?php if($action == 'page') { ?>
          <a onclick="my()" href="bookinfo.php?action=down&id=<?php echo $id; ?>&ids=<?php echo $ids; ?>&bookid=<?php echo $bookid; ?>" style="float: right;padding-right: 15px;">滚动阅读</a>
        <?php }else{ ?>
          <a href="bookinfo.php?id=<?php echo $id; ?>&bookid=<?php echo $bookid; ?>" style="float: right;padding-right: 15px;">分页阅读</a>
        <?php } ?>
      </div>
	    <article class="article mescroll" id="mescroll">
        <?php if($action == 'page') { ?>
  		    <h1 class="hd"><?php echo $json['title']; ?></h1>
          <div class="article-con">
             <p>
                 <?php echo $json['content']; ?>
             </p>
          </div>
        <?php }else{ ?>
          <div class="article-cons"></div>
        <?php } ?>
      </article>
    
    <!-- 如果是分页模式就显示 -->
    <?php if($action == 'page') { ?>
    	<div class="pagelist">
        <?php if($prev) { ?>
          <li><a href="bookinfo.php?id=<?php echo $prev['id']; ?>&bookid=<?php echo $bookid; ?>">上一章</a></li>
        <?php } ?>
        <?php if($next) { ?>
          <li><a href="bookinfo.php?id=<?php echo $next['id']; ?>&bookid=<?php echo $bookid; ?>">下一章</a></li>
        <?php }?>
      </div>
    <?php } ?>

  </div>

  <?php include_once("menu.php");?>
  
  <script id="tpl" type="text/html">
    <h1 class="hd"><%=name%></h1>
    <div class="article-con">
       <p><%=content%></p>
    </div>
  </script>
</body>
</html>
<script src="<?php echo HOME_PATH;?>/js/index.js"></script>
<script src="<?php echo HOME_ASSETS;?>/plugin/templatejs/template.js"></script>
<script>
    function my(){
      alert("滚动模式，请下拉获取数据");
    }
</script>
<?php if($action == 'down') { ?>
<script type="text/javascript" src="<?php echo HOME_ASSETS; ?>/plugin/mescroll/mescroll.min.js"></script>
<script type="text/javascript">
    var mescroll = new MeScroll("mescroll",{
      //设置下拉刷新回调
      down:{
        callback: downCallback,//下拉刷新的回调,别写成downCallback(),多了括号就自动执行方法了
        auto: false
      },

      //设置上拉加载
      up:{
        <?php if($next){?>
        callback: upCallback,
        <?php }?>
        page: {
          num : 0, //当前页 默认0,回调之前会加1; 即callback(page)会从1开始
          size: 1 //每页数据条数,默认10
        },
        auto : false,
        isBoth : true
        // use : false , 
        // delay : 500
      }
    });

    //下拉刷新的回调
    function downCallback() {
      $.ajax({
        url: 'bookinfo.php?id=<?php echo $id; ?>&bookid=<?php echo $bookid; ?>&action=down&act=reset',
        dataType: "json",
        success: function(data) {
          //联网成功的回调,隐藏下拉刷新的状态;
          mescroll.endSuccess(); 

          var tpl = document.getElementById('tpl').innerHTML;
          var html = template(tpl, { content: data.content, name: data.name });
          $('.titles').html("");
          $(".titles").html(data.name);
          $('.article-cons').html("");
          $(".article-cons").html(html);
          //重置为第一页
          // mescroll.resetUpScroll();
        },
        error: function(data) {
          //联网失败的回调,隐藏下拉刷新的状态
          mescroll.endErr();
        }
      });
    }
    
    //上拉加载的回调 page = {num:1, size:10}; num:当前页 默认从1开始, size:每页数据条数,默认10
    function upCallback(page) {
      var pageNum = page.num; // 页码, 默认从1开始 如何修改从0开始 
      $.ajax({
        url: `bookinfo.php?id=<?php echo $id; ?>&bookid=<?php echo $bookid; ?>&action=down&act=next&page=${pageNum}`,
        dataType: 'json',
        success: function(data) {
          var name = data.name;
          var content = data.content; // 接口返回的当前页数据列表
          var count = data.count; 

          //方法二(推荐): 后台接口有返回列表的总数据量 totalSize
          mescroll.endBySize(1, count-1);

          var tpl = document.getElementById('tpl').innerHTML;
          var html = template(tpl, { content: content, name: name});

          //设置标题和内容
          $(".name").html(name);
          $(".article-cons").append(html);

          //加载数据回到顶部
          // $(".mescroll-totop").click();
        },
        error: function(e) {
          //联网失败的回调,隐藏下拉刷新和上拉加载的状态
          mescroll.endErr();
        }
      });
    }
</script>
<?php } ?>