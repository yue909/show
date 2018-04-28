<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\menu\index.html";i:1524448109;}*/ ?>
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
  <style type="text/css">

    /* tooltip */
    #tooltip{
      position:absolute;
      border:1px solid #ccc;
      background:#333;
      padding:2px;
      display:none;
      color:#fff;
    }
</style>
</head>
<body style="padding:10px;">
  <div class="tplay-body-div"> 

  <div class="layui-tab">
    <ul class="layui-tab-title">
      <li class="layui-this">系统菜单管理</li>
      <li><a href="<?php echo url('admin/menu/publish'); ?>" class="a_menu">添加新菜单</a></li>
    </ul>
  </div>
  <table class="layui-table" lay-size="sm">
    <colgroup>
      <col width="50">
      <col width="50">
      <col width="250">
      <col width="100">
      <col width="100">
      <col width="100">
      <col width="300">
      <col width="100">
      <col width="100">
      <col width="150">
      <col width="100">
    </colgroup>
    <thead>
      <tr>
        <th>排序</th>
        <th>编号</th>
        <th>名称</th>
        <th>模块</th>
        <th>控制器</th>
        <th>方法</th>
        <th>备注</th>
        <th>类型</th>
        <th>状态</th>
        <th>创建时间</th>
        <th>操作</th>
      </tr> 
    </thead>
    <tbody>
        <form class="layui-form" id="admin">
      <?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): $i = 0; $__LIST__ = $menus;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
      <tr>
        <td><input type="text" name="orders[]" value="<?php echo $vo['orders']; ?>" style="width: 20px;" class="orders"><input type="hidden" name="id[]" value="<?php echo $vo['id']; ?>"></td>
        <td><?php echo $vo['id']; ?></td>
        <td><span style="font-weight:500;"><?php echo $vo['str']; ?></span><?php echo $vo['name']; ?></td>
        <td><?php echo $vo['module']; ?></td>
        <td><?php echo $vo['controller']; ?></td>
        <td><?php echo $vo['function']; ?></td>
        <td><?php echo $vo['description']; ?></td>
        <td><?php if($vo['type'] == '1'): ?>权限节点<?php else: ?>普通节点<?php endif; ?></td>
        <td><?php if($vo['is_display'] == '1'): ?>显示在左侧菜单<?php else: ?>只做为操作节点<?php endif; ?></td>
        <td><?php echo $vo['create_time']; ?></td>
        <td class="operation-menu">
          <div class="layui-btn-group">
            <a href="<?php echo url('admin/menu/publish',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-xs a_menu layui-btn-primary" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
            <a href="<?php echo url('admin/menu/publish',['pid'=>$vo['id']]); ?>" class="layui-btn layui-btn-xs a_menu layui-btn-primary" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
            <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-primary delete" id="<?php echo $vo['id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
          </div>
        </td>
      </tr>
      <?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
  </table>
  <button class="layui-btn layui-btn-sm" lay-submit lay-filter="admin">更新排序</button>
    </form>

  <script type="text/javascript">

  $('.delete').click(function(){
    var id = $(this).attr('id');
    layer.confirm('确定要删除?', function(index) {
      $.ajax({
        url:"<?php echo url('admin/menu/delete'); ?>",
        data:{id:id},
        success:function(res) {
          layer.msg(res.msg);
          if(res.code == 1) {
            setTimeout(function(){
              location.href = res.url;
            },1500)
          }
        }
      })
    })
  })
  </script>

  <script>
    layui.use(['layer', 'form'], function() {
        var layer = layui.layer,
            $ = layui.jquery,
            form = layui.form;
        $(window).on('load', function() {
            form.on('submit(admin)', function(data) {
                $.ajax({
                    url:"<?php echo url('admin/menu/orders'); ?>",
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
