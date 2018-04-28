<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:90:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\article\linkpublish.html";i:1524645591;}*/ ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="/static/public/layui/css/layui.css"  media="all">
  <link rel="stylesheet" href="/static/public/font-awesome/css/font-awesome.min.css" media="all" />
  <link rel="stylesheet" href="/static/admin/css/admin.css"  media="all">
  <script src="/static/public/layui/layui.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>
<body style="padding:10px;">
  <div class="tplay-body-div">
    <div class="layui-tab">
      <ul class="layui-tab-title">
        <li><a href="<?php echo url('admin/article/link'); ?>" class="a_menu">链接管理</a></li>
        <li class="layui-this">新增链接</li>
      </ul>
    </div> 
    <div style="margin-top: 20px;">
    </div>
    <form class="layui-form" id="admin">
      
      <div class="layui-form-item">
        <label class="layui-form-label">名称</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="link_name" lay-verify="title" autocomplete="off" placeholder="请输入名称" class="layui-input" type="text" <?php if(!(empty($link['link_name']) || (($link['link_name'] instanceof \think\Collection || $link['link_name'] instanceof \think\Paginator ) && $link['link_name']->isEmpty()))): ?>value="<?php echo $link['link_name']; ?>"<?php endif; ?>>
        </div>
      </div>


      <div class="layui-form-item">
        <label class="layui-form-label">链接地址</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="link_url" autocomplete="off" placeholder="链接地址：http://www.baidu.com" class="layui-input" type="text" <?php if(!(empty($link['link_url']) || (($link['link_url'] instanceof \think\Collection || $link['link_url'] instanceof \think\Paginator ) && $link['link_url']->isEmpty()))): ?>value="<?php echo $link['link_url']; ?>"<?php endif; ?>>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">排序</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="orderby" autocomplete="off" placeholder="默认50" class="layui-input" type="text" <?php if(!(empty($link['orderby']) || (($link['orderby'] instanceof \think\Collection || $link['orderby'] instanceof \think\Paginator ) && $link['orderby']->isEmpty()))): ?> value="<?php echo $link['orderby']; ?>"<?php else: ?> value="50" <?php endif; ?>>
        </div>
      </div>
      <div class="layui-form-item">
        <label class="layui-form-label">是否显示</label>
        <div class="layui-input-block">
          <input type="checkbox" checked="" name="is_show" lay-skin="switch" lay-filter="switchTest" lay-text="ON|OFF"><div class="layui-unselect layui-form-switch layui-form-onswitch" lay-skin="_switch"><em>1</em><i></i></div>
        </div>
      </div>
      
      <div class="layui-upload" id="upload-thumb">
        <label class="layui-form-label">缩略图</label>
        <button type="button" class="layui-btn" id="thumb">上传图片</button>
        <div class="layui-upload-list">
          <label class="layui-form-label"></label>
          <img class="layui-upload-img" id="demo1" width="150" height="150" <?php if(!(empty($link['link_logo']) || (($link['link_logo'] instanceof \think\Collection || $link['link_logo'] instanceof \think\Paginator ) && $link['link_logo']->isEmpty()))): ?>src="<?php echo geturl($link['link_logo']); ?>"<?php endif; ?>><?php if(!(empty($link['link_logo']) || (($link['link_logo'] instanceof \think\Collection || $link['link_logo'] instanceof \think\Paginator ) && $link['link_logo']->isEmpty()))): ?><input type="hidden" name="link_logo" value="<?php echo $link['link_logo']; ?>"><?php endif; ?>
          <p id="demoText"></p>
        </div>
      </div>

      <?php if(!(empty($link) || (($link instanceof \think\Collection || $link instanceof \think\Paginator ) && $link->isEmpty()))): ?>
      <input type="hidden" name="link_id" value="<?php echo $link['link_id']; ?>">
      <?php endif; ?>
      <div class="layui-form-item">
        <div class="layui-input-block">
          <button class="layui-btn" lay-submit lay-filter="admin">立即提交</button>
          <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
      </div>
      
    </form>


    <script src="/static/public/layui/layui.js"></script>
   
    <!-- <script>
        var message;
        layui.config({
            base: '/static/admin/js/',
            version: '1.0.1'
        }).use(['app', 'message'], function() {
            var app = layui.app,
                $ = layui.jquery,
                layer = layui.layer;
            //将message设置为全局以便子页面调用
            message = layui.message;
            //主入口
            app.set({
                type: 'iframe'
            }).init();
        });
    </script> -->
    <script>
    layui.use('upload', function(){
      var upload = layui.upload;
      //执行实例
      var uploadInst = upload.render({
        elem: '#thumb' //绑定元素
        ,url: "<?php echo url('common/upload'); ?>" //上传接口
        ,data:{use:'link_logo'}
        ,done: function(res){
          //上传完毕回调
          if(res.code == 2) {
            $('#demo1').attr('src',res.src);
            $('#upload-thumb').append('<input type="hidden" name="link_logo" value="'+ res.id +'">');
          } else {
            layer.msg(res.msg);
          }
        }
        ,error: function(){
          //请求异常回调
          //演示失败状态，并实现重传
          var demoText = $('#demoText');
          demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-mini demo-reload">重试</a>');
          demoText.find('.demo-reload').on('click', function(){
            uploadInst.upload();
          });
        }
      });
    });
    </script>
    <script>
      layui.use(['layer', 'form'], function() {
          var layer = layui.layer,
              $ = layui.jquery,
              form = layui.form;
          $(window).on('load', function() {
              form.on('submit(admin)', function(data) {
                  $.ajax({
                      url:"<?php echo url('admin/article/linkPublish'); ?>",
                      data:$('#admin').serialize(),
                      type:'post',
                      async: false,
                      success:function(res) {
                        console.log(res);
                          if(res.code == 1) {
                              layer.alert(res.msg, function(index){
                                location.href = res.url;
                              })
                          } else {
                              layer.msg(res.msg);
                          }
                      }
                  })
                  return false;
              });
          });
      });
    </script>

  </div>
</body>
</html>