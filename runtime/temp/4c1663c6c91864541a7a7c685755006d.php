<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:86:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\smsconfig\index.html";i:1524626628;}*/ ?>
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
        <li class="layui-this">短信配置管理</li>
        <li><a href="<?php echo url('admin/smsconfig/publish'); ?>" class="a_menu">新增短信配置</a></li>
      </ul>
    </div> 
 
    <table class="layui-table" lay-size="sm">
      <colgroup>
        <col width="50">
        <col width="300">
        <col width="50">
        <col width="100">
        <col width="100">
      </colgroup>
      <thead>
        <tr>
          <th>ID</th>
          <th>类型</th>
          <th>appkey</th>
          <th>secretkey</th>
          <th>操作</th>
        </tr> 
      </thead>
      <tbody>
        <?php if(is_array($data) || $data instanceof \think\Collection || $data instanceof \think\Paginator): $k = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?>
        <tr>
          <td><?php echo $k; ?></td>
          <td><?php echo $vo['sms']; ?></td>
          <td><?php echo $vo['appkey']; ?></td>
          <td><?php echo $vo['secretkey']; ?></td>
          <td class="operation-menu">
            <div class="layui-btn-group">
              <a href="<?php echo url('admin/smsconfig/publish',['id'=>$vo['id']]); ?>" class="layui-btn layui-btn-xs a_menu layui-btn-primary" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
              <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-primary delete" id="<?php echo $vo['id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
    <div style="padding:0 20px;"></div> 

    <script type="text/javascript">
    $('.delete').click(function(){
      var id = $(this).attr('id');
      layer.confirm('确定要删除?', function(index) {
        // alert(id);
        $.ajax({
          type: "POST",
          url:"<?php echo url('admin/smsconfig/delete'); ?>",
          data:{id:id},
          success:function(res) {
            // alert(res);
            layer.msg(res.msg);
            if(res.code == 1) {
              setTimeout(function(){
                location.href = res.url;
              },1500)
            }
          },
          error:function(res){
             layer.msg(res.msg);
          }
        })
      })
    })
    </script>
    <script type="text/javascript">

   
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
