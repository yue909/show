<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\user\levelpublish.html";i:1524809383;}*/ ?>
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
        <li><a href="<?php echo url('admin/user/level'); ?>" class="a_menu">会员等级</a></li>
        <li class="layui-this">新增会员等级</li>
      </ul>
    </div> 
    <div style="margin-top: 20px;">
    </div>
    <form class="layui-form" id="admin">
      
      <div class="layui-form-item">
        <label class="layui-form-label">名称</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="level_name" lay-verify="title" autocomplete="off" placeholder="请输入名称" class="layui-input" type="text" <?php if(!(empty($level['level_name']) || (($level['level_name'] instanceof \think\Collection || $level['level_name'] instanceof \think\Paginator ) && $level['level_name']->isEmpty()))): ?> value="<?php echo $level['level_name']; ?>" <?php endif; ?>>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">最低金额</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="amount" lay-verify="title" autocomplete="off" placeholder="请输入最低金额" class="layui-input" type="text" <?php if(!(empty($level['amount']) || (($level['amount'] instanceof \think\Collection || $level['amount'] instanceof \think\Paginator ) && $level['amount']->isEmpty()))): ?> value="<?php echo $level['amount']; ?>" <?php endif; ?>>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">折扣</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="discount" lay-verify="title" autocomplete="off" placeholder="请输入折扣" class="layui-input" type="text" <?php if(!(empty($level['discount']) || (($level['discount'] instanceof \think\Collection || $level['discount'] instanceof \think\Paginator ) && $level['discount']->isEmpty()))): ?> value="<?php echo $level['discount']; ?>" <?php endif; ?>>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="describe" lay-verify="title" autocomplete="off" placeholder="请输入描述" class="layui-input" type="text" <?php if(!(empty($level['describe']) || (($level['describe'] instanceof \think\Collection || $level['describe'] instanceof \think\Paginator ) && $level['describe']->isEmpty()))): ?> value="<?php echo $level['describe']; ?>" <?php endif; ?>>
        </div>
      </div>

      <?php if(!(empty($level) || (($level instanceof \think\Collection || $level instanceof \think\Paginator ) && $level->isEmpty()))): ?>
      <input type="hidden" name="level_id" value="<?php echo $level['level_id']; ?>">
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
                      url:"<?php echo url('admin/user/levelPublish'); ?>",
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