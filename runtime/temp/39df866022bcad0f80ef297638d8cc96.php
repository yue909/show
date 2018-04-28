<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:88:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\articlecate\index.html";i:1524621628;}*/ ?>
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
        <li class="layui-this">分类管理</li>
        <li><a href="<?php echo url('admin/articlecate/publish'); ?>" class="a_menu">新增分类</a></li>
      </ul>
    </div>
    <table class="layui-table" lay-size="sm">
      <colgroup>
        <col width="50">
        <col width="150">
        <col width="500">
        <col width="200">
        <col width="100">
      </colgroup>
      <thead>
        <tr>
          <th>编号</th>
          <th>名称</th>
          <th>描述</th>
          <th>创建时间</th>
          <th>操作</th>
        </tr> 
      </thead>
      <tbody>
        <?php if(is_array($cates) || $cates instanceof \think\Collection || $cates instanceof \think\Paginator): $i = 0; $__LIST__ = $cates;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
          <td><?php echo $vo['id']; ?></td>
          <td><span style="font-weight:500;"><?php echo $vo['str']; ?></span><?php echo $vo['name']; ?></td>
          <td><?php echo $vo['description']; ?></td>
          <td><?php echo $vo['create_time']; ?></td>
          <td class="operation-menu">
            <div class="layui-btn-group">
              <a href="<?php echo url('admin/articlecate/publish',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-xs a_menu layui-btn-primary" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
              <a href="<?php echo url('admin/articlecate/publish',['pid'=>$vo['id']]); ?>" class="layui-btn layui-btn-xs a_menu layui-btn-primary" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
              <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-primary delete" id="<?php echo $vo['id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
            
    <script type="text/javascript">
      $('.delete').click(function(){
        var id = $(this).attr('id');
        layer.confirm('确定要删除?', function(index) {
          $.ajax({
            url:"<?php echo url('admin/articlecate/delete'); ?>",
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
