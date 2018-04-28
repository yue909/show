<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\smsconfig\publish.html";i:1524623532;}*/ ?>
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
        <li><a href="<?php echo url('admin/smsconfig/index'); ?>" class="a_menu">短信配置管理</a></li>
        <li class="layui-this">新增短信配置</li>
      </ul>
    </div> 
    <div style="margin-top: 20px;">
    </div>
    <form class="layui-form" id="admin">

       <div class="layui-form-item">
        <label class="layui-form-label">sms</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="sms" lay-verify="title" autocomplete="off" placeholder="请输入sms" class="layui-input" type="text" <?php if(!(empty($sms['sms']) || (($sms['sms'] instanceof \think\Collection || $sms['sms'] instanceof \think\Paginator ) && $sms['sms']->isEmpty()))): ?>value="<?php echo $sms['sms']; ?>"<?php endif; ?>>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">appkey</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="appkey" lay-verify="title" autocomplete="off" placeholder="请输入appkey" class="layui-input" type="text" <?php if(!(empty($sms['appkey']) || (($sms['appkey'] instanceof \think\Collection || $sms['appkey'] instanceof \think\Paginator ) && $sms['appkey']->isEmpty()))): ?>value="<?php echo $sms['appkey']; ?>"<?php endif; ?>>
        </div>
      </div>
    

      <div class="layui-form-item">
        <label class="layui-form-label">secretkey</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="secretkey" autocomplete="off" placeholder="请输入secretkey" class="layui-input" type="text" <?php if(!(empty($sms['secretkey']) || (($sms['secretkey'] instanceof \think\Collection || $sms['secretkey'] instanceof \think\Paginator ) && $sms['secretkey']->isEmpty()))): ?>value="<?php echo $sms['secretkey']; ?>"<?php endif; ?>>
        </div>
      </div>

      <?php if(!(empty($sms) || (($sms instanceof \think\Collection || $sms instanceof \think\Paginator ) && $sms->isEmpty()))): ?>
      <input type="hidden" name="id" value="<?php echo $sms['id']; ?>">
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
      layui.use(['layer', 'form'], function() {
          var layer = layui.layer,
              $ = layui.jquery,
              form = layui.form;
          $(window).on('load', function() {
              form.on('submit(admin)', function(data) {

                  $.ajax({
                      url:"<?php echo url('admin/smsconfig/publish'); ?>",
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