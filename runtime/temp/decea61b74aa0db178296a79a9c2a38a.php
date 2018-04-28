<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:87:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\urlsconfig\index.html";i:1524448156;}*/ ?>
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
        <li class="layui-this">URL美化管理</li>
        <li><a href="<?php echo url('admin/urlsconfig/publish'); ?>" class="a_menu">新增美化</a></li>
      </ul>
    </div>
    <table class="layui-table" lay-size="sm">
      <colgroup>
        <col width="50">
        <col width="150">
        <col width="100">
        <col width="350">
        <col width="150">
        <col width="100">
        <col width="100">
      </colgroup>
      <thead>
        <tr>
          <th>编号</th>
          <th>美化前</th>
          <th>美化后</th>
          <th>备注</th>
          <th>创建时间</th>
          <th>状态</th>
          <th>操作</th>
        </tr> 
      </thead>
      <tbody>
        <?php if(is_array($urlconfig) || $urlconfig instanceof \think\Collection || $urlconfig instanceof \think\Paginator): $i = 0; $__LIST__ = $urlconfig;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
          <td><?php echo $vo['id']; ?></td>
          <td><?php echo $vo['url']; ?></td>
          <td><?php echo $vo['aliases']; ?></td>
          <td><?php echo $vo['desc']; ?></td>
          <td><?php echo $vo['create_time']; ?></td>
          <td><?php if($vo['status'] == 1): ?><span class="layui-badge">启用</span><?php else: ?><span class="layui-badge layui-bg-gray">禁用</span><?php endif; ?></td>
          <td class="operation-menu">
            <div class="layui-btn-group">
              <a class="layui-btn layui-btn-xs a_menu layui-btn-primary" href="<?php echo url('admin/urlsconfig/publish',['id'=>$vo['id']]); ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
              <a class="layui-btn layui-btn-xs layui-btn-primary status" <?php if($vo['status'] == 1): ?>data-id="0"<?php else: ?>data-id="1"<?php endif; ?> id="<?php echo $vo['id']; ?>" style="margin-right: 0;font-size:12px;" ><i class="fa <?php if($vo['status'] == 1): ?>fa-toggle-on<?php else: ?>fa-toggle-off<?php endif; ?>"></i></a>
              <a class="layui-btn layui-btn-xs delete layui-btn-primary" id="<?php echo $vo['id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
    <div style="padding:0 20px;"><?php echo $urlconfig->render(); ?></div>
            
    
    <script type="text/javascript">

    $('.delete').click(function(){
      var id = $(this).attr('id');
      layer.confirm('确定要删除?', function(index) {
        $.ajax({
          url:"<?php echo url('admin/urlsconfig/delete'); ?>",
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
      

      $('.status').click(function(){
        var id = $(this).attr('id');
        var status = $(this).attr('data-id');
        layer.confirm('确定要设置?', function(index) {
          $.ajax({
            url:"<?php echo url('admin/urlsconfig/status'); ?>",
            type:'post',
            data:{id:id,status:status},
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

    }); 
    </script>
  </div>
</body>
</html>
