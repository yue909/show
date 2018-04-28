<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\admin\admincate.html";i:1524455443;}*/ ?>
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
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="/static/public/layui/layui.js"></script>
</head>

<body style="padding:10px;">
  <div class="tplay-body-div">
    <div class="layui-tab">
      <ul class="layui-tab-title">
        <li class="layui-this">角色管理</li>
        <li><a href="<?php echo url('admin/admin/adminCatePublish'); ?>" class="a_menu">新增角色</a></li>
      </ul>
    </div>
    <form class="layui-form serch" action="<?php echo url('admin/admin/admincate'); ?>" method="post">
        <div class="layui-form-item" style="float: left;">
          <div class="layui-input-inline">
            <input type="text" name="keywords" lay-verify="title" autocomplete="off" placeholder="请输入关键词" class="layui-input layui-btn-sm">
          </div>
          <div class="layui-input-inline">
            <div class="layui-inline">
              <div class="layui-input-inline">
                <input type="text" class="layui-input" id="create_time" placeholder="创建时间" name="create_time">
              </div>
            </div>
          </div>
          <button class="layui-btn layui-btn-danger layui-btn-sm" lay-submit="" lay-filter="serch">立即提交</button>
        </div>
      </form>
    <table class="layui-table" lay-size="sm">
      <colgroup>
        <col width="50">
        <col width="100">
        <col width="150">
        <col width="150">
        <col width="150">
        <col width="300">
        <col width="100">
      </colgroup>
      <thead>
        <tr>
          <th>ID</th>
          <th>角色名称</th>
          <th>权限预览</th>
          <th>创建时间</th>
          <th>最后修改时间</th>
          <th>备注</th>
          <th>操作</th>
        </tr> 
      </thead>
      <tbody>
        <?php if(is_array($cate) || $cate instanceof \think\Collection || $cate instanceof \think\Paginator): $i = 0; $__LIST__ = $cate;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
          <td><?php echo $vo['id']; ?></td>
          <td><?php echo $vo['name']; ?></td>
          <td><a href="<?php echo url('admin/admin/preview',['id'=>$vo['id']]); ?>" class="preview" style="margin-right: 0;font-size:12px;">点击查看</a></td>
          <td><?php echo $vo['create_time']; ?></td>
          <td><?php echo $vo['update_time']; ?></td>
          <td><?php echo $vo['desc']; ?></td>
          <td class="operation-menu">
            <div class="layui-btn-group">
              <a href="<?php echo url('admin/admin/adminCatePublish',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-xs a_menu layui-btn-primary" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
              <a class="layui-btn layui-btn-xs layui-btn-primary delete" id="<?php echo $vo['id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
    <div style="padding:0 20px;"><?php echo $cate->render(); ?></div>
            
    <script type="text/javascript">

    $('.delete').click(function(){
      var id = $(this).attr('id');
      layer.confirm('确定要删除?', function(index) {
        $.ajax({
          url:"<?php echo url('admin/admin/adminCateDelete'); ?>",
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
    <script type="text/javascript">
    layui.use('layer', function(){
      var layer = layui.layer;

      $('.preview').click(function(){
        var url = $(this).attr('href');
        layer.open({
          type:2,
          content:url,
          area: ['550px', '400px']
        });
        return false;
      })
    });

  // 时间渲染选项
    layui.use('laydate', function(){
      var laydate = layui.laydate;     
      //常规用法
      laydate.render({
        elem: '#create_time'
        });
    });
    
// form 表单渲染
    layui.use('form', function(){
    var form = layui.form;
  
   //各种基于事件的操作，下面会有进一步介绍
    });

    </script>
  </div>
</body>
</html>
