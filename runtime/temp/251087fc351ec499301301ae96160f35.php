<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\common\login.html";i:1524725177;}*/ ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>后台登录</title>
  <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <!-- <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" /> -->
    <meta http-equiv="Cache-Control" content="no-siteapp" />

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
    <link rel="stylesheet" href="/static/admin/css/font.css">
  <link rel="stylesheet" href="/static/admin/css/xadmin.css">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="/static/admin/lib/layui/layui.js" charset="utf-8"></script>
    <script type="text/javascript" src="/static/admin/js/xadmin.js"></script>
    <!-- 螺丝帽必备js -->
    <script src="//captcha.luosimao.com/static/dist/api.js"></script>
    <!-- 粒子js -->
    <!-- <script src="/static/admin/js/Particleground.js"></script> -->
    <script>
        $(document).ready(function() {
          //粒子背景特效
          $('body').particleground({
            dotColor: '#5cbdaa',
            lineColor: '#5cbdaa'
          });
        });
    </script>
    <style type="text/css">canvas{z-index:-1;position:absolute;}body{height:100%;background:#16a085;overflow:hidden;}</style>
</head>
<body class="login-bg">
    
    <div class="login">
        <div class="message">管理员登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form"  id="login">
            <input name="name" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" <?php if(!(empty($usermember) || (($usermember instanceof \think\Collection || $usermember instanceof \think\Paginator ) && $usermember->isEmpty()))): ?>value="<?php echo $usermember; ?>"<?php endif; ?> >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <div class="l-captcha" data-site-key="87ec1d15021c65eeb5ef3d0d75b3358a" data-width='100%'></div>
            <hr class="hr15">
             <div class="layui-form-item">
              <input type="checkbox" lay-skin="primary" title="记住账号" name="remember" value="1" <?php if(!(empty($usermember) || (($usermember instanceof \think\Collection || $usermember instanceof \think\Paginator ) && $usermember->isEmpty()))): ?>checked=""<?php endif; ?>><div class="layui-unselect layui-form-checkbox" lay-skin="primary"><span>记住账号?</span><i class="layui-icon"></i></div>
             </div>
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <input value="重置验证码" lay-filter="reset" style="width:100%;background-color:#414653;margin-top:3px;" type="button" onclick="LUOCAPTCHA.reset()">
            <hr class="hr20" >
        </form>
    </div>

     <script>
        layui.use(['layer', 'form'], function() {
            var layer = layui.layer,
                $ = layui.jquery,
                form = layui.form;
            $(window).on('load', function() {
                form.on('submit(login)', function(data) {
                    $.ajax({
                        url:"<?php echo url('admin/common/login'); ?>",
                        data:$('#login').serialize(),
                        type:'post',
                        async: false,
                        success:function(res) {
                          //alert(res.msg);
                            layer.msg(res.msg,{offset: '50px',anim: 1});
                            if(res.code == 1) {
                                setTimeout(function() {
                                    location.href = res.url;
                                }, 1500);
                            } else {
                                LUOCAPTCHA.reset();
                            }
                        }
                    })
                    return false;
                });
            });
        });



    </script>
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
</body>
</html>