<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:82:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\index\index.html";i:1524129229;s:72:"D:\phpstudy\PHPTutorial\WWW\show\application\admin\view\public\base.html";i:1524793695;}*/ ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
  <title>欢迎光临后台管理中心</title>

	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/admin/css/font.css">
    <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <!-- <link rel="stylesheet" href="/static/admin/lib/layui/css/layui.css"> -->
  	<link rel="stylesheet" href="/static/public/font-awesome/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
</head>
<body>

    <!-- 顶部开始 -->
       <div class="container">
        <div class="logo"><a href="index/index.html"><?php echo $name; if($admin_cate_id == '1'): ?>超級管理員<?php else: ?>普通管理員<?php endif; ?></a></div>
        <div class="left_open">
            <i title="展开左侧栏" class="fa fa-arrow-left"></i>
        </div>
        <ul class="layui-nav left fast-add" lay-filter="">
          <li class="layui-nav-item" >
            <a href="javascript:;" ><i title="添加信息" class="fa fa-plus"></i></a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a  href="javascript:void()" onclick="x_admin_show('资讯','<?php echo url("goods/publish"); ?>')"><i class="iconfont">&#xe6a2;</i>商品</a></dd>
              <dd><a  href="javascript:void()" onclick="x_admin_show('图片','<?php echo url("article/publish"); ?>')"><i class="iconfont">&#xe6a8;</i>文章</a></dd>
              <dd><a  href="javascript:void()" onclick="x_admin_show('用户','<?php echo url("user/publish"); ?>')"><i class="iconfont">&#xe6b8;</i>用户</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item"><a id="clear" title="清空缓存" ><i class="fa fa-university" aria-hidden="true"></i></a></li>
          <li class="layui-nav-item"><a class="kit-item" data-target="refresh" title="刷新当前页" id="refresh"><i class="fa fa-refresh" aria-hidden="true"></i></a></li>
        </ul>
        <ul class="layui-nav right" lay-filter="">
          <li class="layui-nav-item">
            <a href="javascript:;"><?php echo $name; ?></a>
            <dl class="layui-nav-child"> <!-- 二级菜单 -->
              <dd><a  href="javascript:void()" onclick="x_admin_show('个人信息','<?php echo url("admin/personal"); ?>','800','600')">个人信息</a></dd>
              <!-- <dd><a  href="javascript:void()" onclick="x_admin_show('切换帐号','')">切换帐号</a></dd> -->
              <dd><a href="javascript:;" id='logout' >退出</a></dd>
            </dl>
          </li>
          <li class="layui-nav-item to-index"><a href="/"><i class="fa fa-home fa-fw" title='前台首页'></i></a></li>
        </ul>

    </div>
    <!-- 顶部结束 -->

    <!-- 中部开始 -->
    <!-- 左侧菜单开始 -->

    <div class="left-nav">
      <div id="side-nav">
        <ul id="nav">
          <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?>
            <li class="">
                <a href="javascript:;">
                    <i class="fa <?php echo $data['icon']; ?>"></i>
                    <cite><?php echo $data['name']; ?></cite>
                    <i class="iconfont nav_right">&#xe697;</i>
                </a>  
                <ul class="sub-menu">
                    <!-- 三级菜单 -->
                    <?php if(!(empty($data['list']) || (($data['list'] instanceof \think\Collection || $data['list'] instanceof \think\Paginator ) && $data['list']->isEmpty()))): if(is_array($data['list']) || $data['list'] instanceof \think\Collection || $data['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $data['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;if(!(empty($vo['list']) || (($vo['list'] instanceof \think\Collection || $vo['list'] instanceof \think\Paginator ) && $vo['list']->isEmpty()))): ?>
                    <li>
                        <a href="javascript:;">
                            <i class="fa <?php echo $vo['icon']; ?>"></i>
                            <cite> <?php echo $vo['name']; ?></cite>
                            <i class="iconfont nav_right">&#xe697;</i>
                        </a>
                        <ul class="sub-menu">
                           <?php if(is_array($vo['list']) || $vo['list'] instanceof \think\Collection || $vo['list'] instanceof \think\Paginator): $i = 0; $__LIST__ = $vo['list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$co): $mod = ($i % 2 );++$i;?>
                            <li>
                                <a _href="<?php echo $co['url']; ?>">
                                    <i class="fa <?php echo $co['icon']; ?>"></i>
                                    <cite><?php echo $co['name']; ?></cite>
                                    
                                </a>
                            </li >
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                            
                        </ul>
                    </li>
                   <?php else: ?>
                      <li>
                         <a _href="<?php echo $vo['url']; ?>">
                           <i class="fa <?php echo $vo['icon']; ?>"></i>
                            <cite><?php echo $vo['name']; ?></cite>
                          </a>
                      </li >
                    <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
                </ul>
              </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
    </div>
    <!-- 左侧菜单结束 -->
    <!-- 右侧主体开始 -->
     <div class="page-content">
      <div class="layui-tab tab" lay-filter="xbs_tab" lay-allowclose="false">
        <ul class="layui-tab-title">
          <li>我的桌面</li>
        </ul>
        <div class="layui-tab-content">
          <div class="layui-tab-item layui-show">
              <iframe src="<?php echo url('main/index'); ?>" frameborder="0" scrolling="yes" class="x-iframe"></iframe>
          </div>
        </div>
      </div>
    </div>

    <div class="page-content-bg"></div>
    <!-- 右侧主体结束 -->
    <!-- 中部结束 -->
    <!-- 底部开始 -->
     <div class="footer">
        <div class="copyright">Copyright ©2018 showadmin v3.0 All Rights Reserved</div>  
    </div>
    <!-- 底部结束 -->
    <script>
    //百度统计可去掉
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "https://hm.baidu.com/hm.js?b393d153aeb26b46e9431fabaf0f6190";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
    </script>

     <script type="text/javascript">  
          $('#clear').on('click', function() {
              var the = $(this).find('i');
              the.attr("class","fa fa-spinner");
              $.ajax({
                url:"<?php echo url('admin/common/clear'); ?>"
                ,success:function(res) {
                
                  if(res.code == 1) {
                      setTimeout(function(){
                          layer.msg('清除缓存成功');
                          $('#clear i').attr("class","fa fa-institution");
                          $('#clear').parent('li').attr('class','layui-nav-item');
                      },1000)
                  }
                }
              })
          });
      </script> 

      <script type="text/javascript">
           $('#logout').click(function(){
              layer.confirm('真的要退出?',{icon: 3, title:'提示',anim: 2}, function(index){
                  $.ajax({
                    url:"<?php echo url('admin/common/logout'); ?>"
                    ,success:function(res) {
                      layer.msg(res.msg,{offset: '300px',anim: 4});
                      if(res.code == 1) {
                          setTimeout(function(){
                              location.href = res.url;
                          },2000)
                      }
                    }
                  })
              }) 
            })
      </script>
        <!-- 刷新 -->
      <script type="text/javascript">
           $('#refresh').click(function(){
             var the = $(this).find('i');
              the.attr("class","fa fa-spinner");
              setTimeout(function(){
                  var url = $('.layui-show').find('.x-iframe').attr('src');
                  $('.layui-show').find('.x-iframe').attr('src',url+'?v' + Date.parse(new Date()));
                  layer.msg('刷新成功'); 
                  $('#refresh i').attr("class","fa fa-refresh");
                  $('#refresh').parent('li').attr('class','layui-nav-item');
                  },1000)
            })
      </script>

</body>
</html>