<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\user\publish.html";i:1524790862;}*/ ?>
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
        <li><a href="<?php echo url('admin/user/index'); ?>" class="a_menu">会员管理</a></li>
        <li class="layui-this">新增会员</li>
      </ul>
    </div> 
    <div style="margin-top: 20px;">
    </div>
    <form class="layui-form" id="admin">
      
      <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="username" lay-verify="title" autocomplete="off" placeholder="请输入用户名" class="layui-input" type="text" <?php if(!(empty($user['username']) || (($user['username'] instanceof \think\Collection || $user['username'] instanceof \think\Paginator ) && $user['username']->isEmpty()))): ?>value="<?php echo $user['username']; ?>"<?php endif; ?>>
        </div>
      </div>


      <div class="layui-form-item">
        <label class="layui-form-label">昵称</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="nickname" autocomplete="off" placeholder="昵称" class="layui-input" type="text" <?php if(!(empty($user['nickname']) || (($user['nickname'] instanceof \think\Collection || $user['nickname'] instanceof \think\Paginator ) && $user['nickname']->isEmpty()))): ?> value="<?php echo $user['nickname']; ?>"<?php endif; ?>>
        </div>
      </div>
      
       <div class="layui-form-item">
        <label class="layui-form-label">密码</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="password" autocomplete="off" placeholder="密码" class="layui-input" type="text" <?php if(!(empty($user['password']) || (($user['password'] instanceof \think\Collection || $user['password'] instanceof \think\Paginator ) && $user['password']->isEmpty()))): ?> value="<?php echo $user['password']; ?>"<?php endif; ?>>
        </div>
      </div>
      
      <div class="layui-form-item">
        <label class="layui-form-label">邮箱</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="email" autocomplete="off" placeholder="邮箱" class="layui-input" type="text" <?php if(!(empty($user['email']) || (($user['email'] instanceof \think\Collection || $user['email'] instanceof \think\Paginator ) && $user['email']->isEmpty()))): ?> value="<?php echo $user['email']; ?>"<?php endif; ?>>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">电话</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="mobile" autocomplete="off" placeholder="电话" class="layui-input" type="text" <?php if(!(empty($user['mobile']) || (($user['mobile'] instanceof \think\Collection || $user['mobile'] instanceof \think\Paginator ) && $user['mobile']->isEmpty()))): ?> value="<?php echo $user['mobile']; ?>"<?php endif; ?>>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">QQ</label>
        <div class="layui-input-block" style="max-width:600px;">
          <input name="qq" autocomplete="off" placeholder="QQ" class="layui-input" type="text" <?php if(!(empty($user['qq']) || (($user['qq'] instanceof \think\Collection || $user['qq'] instanceof \think\Paginator ) && $user['qq']->isEmpty()))): ?> value="<?php echo $user['qq']; ?>"<?php endif; ?>>
        </div>
      </div>

      <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">描述</label>
        <div class="layui-input-block" style="max-width:600px;">
          <textarea placeholder="人生格言" class="layui-textarea" name="bio"><?php if(!(empty($user['bio']) || (($user['bio'] instanceof \think\Collection || $user['bio'] instanceof \think\Paginator ) && $user['bio']->isEmpty()))): ?> <?php echo $user['bio']; endif; ?> </textarea>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">会员等级</label>
        <div class="layui-input-block" style="max-width:600px;">
          <select name="level_id" lay-filter="aihao">
            <option value="">请选择分类</option>
            <?php if(is_array($info['level']) || $info['level'] instanceof \think\Collection || $info['level'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['level'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['level_id']; ?>" <?php if(!(empty($user['level_id']) || (($user['level_id'] instanceof \think\Collection || $user['level_id'] instanceof \think\Paginator ) && $user['level_id']->isEmpty()))): if($user['level_id'] == $vo['level_id']): ?> selected=""<?php endif; endif; ?>><?php echo $vo['level_name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
        </div>
      </div>

      <div class="layui-form-item">
        <label class="layui-form-label">会员类型</label>
        <div class="layui-input-block" style="max-width:600px;">
          <select name="rank_id" lay-filter="aihao">
            <option value="">请选择分类</option>
            <?php if(is_array($info['rank']) || $info['rank'] instanceof \think\Collection || $info['rank'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['rank'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <option value="<?php echo $vo['rank_id']; ?>" <?php if(!(empty($user['rank_id']) || (($user['rank_id'] instanceof \think\Collection || $user['rank_id'] instanceof \think\Paginator ) && $user['rank_id']->isEmpty()))): if($user['rank_id'] == $vo['rank_id']): ?> selected=""<?php endif; endif; ?>><?php echo $vo['rank_name']; ?></option>
            <?php endforeach; endif; else: echo "" ;endif; ?>
          </select>
        </div>
      </div>
      
      <div class="layui-form-item layui-form-text">
        <label class="layui-form-label">内容</label>
        <div class="layui-input-block" style="max-width:1000px;">
          <textarea placeholder="请输入内容" class="layui-textarea" name="bio" id="" style="border:0;padding:0"><?php if(!(empty($user['bio']) || (($user['bio'] instanceof \think\Collection || $user['bio'] instanceof \think\Paginator ) && $user['bio']->isEmpty()))): ?><?php echo $user['bio']; endif; ?></textarea>
        </div>
      </div>

      <div class="layui-upload" id="upload-thumb">
        <label class="layui-form-label">缩略图|头像</label>
        <button type="button" class="layui-btn" id="thumb">上传图片</button>
        <div class="layui-upload-list">
          <label class="layui-form-label"></label>
          <img class="layui-upload-img" id="demo1" width="150" height="150" <?php if(!(empty($user['thumb']) || (($user['thumb'] instanceof \think\Collection || $user['thumb'] instanceof \think\Paginator ) && $user['thumb']->isEmpty()))): ?> src="<?php echo geturl($user['thumb']); ?>"<?php endif; ?>> <?php if(!(empty($user['thumb']) || (($user['thumb'] instanceof \think\Collection || $user['thumb'] instanceof \think\Paginator ) && $user['thumb']->isEmpty()))): ?><input type="hidden" name="thumb" value="<?php echo $user['thumb']; ?>"><?php endif; ?>
          <p id="demoText"></p>
        </div>
      </div>
      <?php if(!(empty($user) || (($user instanceof \think\Collection || $user instanceof \think\Paginator ) && $user->isEmpty()))): ?>
      <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
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
        ,data:{use:'article_thumb'}
        ,done: function(res){
          //上传完毕回调
          if(res.code == 2) {
            $('#demo1').attr('src',res.src);
            $('#upload-thumb').append('<input type="hidden" name="thumb" value="'+ res.filepath +'">');
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
                      url:"<?php echo url('admin/user/publish'); ?>",
                      data:$('#admin').serialize(),
                      type:'post',
                      async: false,
                      success:function(res) {
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