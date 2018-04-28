<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\user\level.html";i:1524813223;}*/ ?>
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
        <li class="layui-this">会员等级</li>
        <li><a href="<?php echo url('admin/user/levelpublish'); ?>" class="a_menu">新增会员等级</a></li>
      </ul>
    </div> 
   
    <table class="layui-table" lay-size="sm">
      <colgroup>
        <col width="50">
        <col width="300">
        <col width="100">
        <col width="150">
        <col width="100">
   
      </colgroup>
      <thead>
        <tr>
          <th>ID</th>
          <th>名称</th>
          <th>最低金额</th>
          <th>折扣</th>
          <th>操作</th>
        </tr> 
      </thead>
      <tbody>
        <form class="layui-form" id="admin">
        <?php if(is_array($level) || $level instanceof \think\Collection || $level instanceof \think\Paginator): $i = 0; $__LIST__ = $level;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
          <td><?php echo $vo['level_id']; ?></td>
          <td><?php echo $vo['level_name']; ?></td>      
          <td><?php echo $vo['amount']; ?></td>      
          <td><?php echo $vo['discount']; ?></td>       
          <td class="operation-menu">
            <div class="layui-btn-group">
              <a href="<?php echo url('admin/user/levelpublish',['level_id'=>$vo['level_id']]); ?>" class="layui-btn layui-btn-xs a_menu layui-btn-primary" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
              <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-primary delete" id="<?php echo $vo['level_id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon"></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
     <!-- <button class="layui-btn layui-btn-sm" lay-submit lay-filter="admin">更新排序</button> -->
    </form>
    <div style="padding:0 20px;"><?php echo $level->render(); ?></div>
<!-- 排序  -->
<!--<script>
      layui.use(['layer', 'form'], function() {
          var layer = layui.layer,
              $ = layui.jquery,
              form = layui.form;
          $(window).on('load', function() {
              form.on('submit(admin)', function(data) {
                  $.ajax({
                      url:"<?php echo url('admin/user/linkorders'); ?>",
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
  </script> -->
    <script type="text/javascript">

    $('.delete').click(function(){
      var id = $(this).attr('id');
      layer.confirm('确定要删除?', function(index) {
        $.ajax({
          url:"<?php echo url('admin/user/leveldelete'); ?>",
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
    <!-- 是否显示 -->
    <script type="text/javascript">

    // $('.is_show').click(function(){
    //   var val = $(this).attr('data-val');
    //   var id = $(this).attr('data-id');
    //   var i = $(this).find('i');
    //   var the = $(this);
    //   if(val == 1){
    //     var is_show = 0;
    //   } else {
    //     var is_show = 1;
    //   }
    //   $.ajax({
    //     type:"post",
    //     url:"<?php echo url('admin/article/linkshow'); ?>",
    //     data:{is_show:is_show,id:id},
    //     success:function(res){
          
    //       if(res.code == 1) {
    //         show();
    //       } else {
    //         layer.msg(res.msg);
    //       }
    //     }
    //   })

    //   function show(){
    //     if(val == 1){
    //       i.attr("class","fa fa-toggle-off");
    //       the.attr('data-val',0);
    //     } else {
    //       i.attr("class","fa fa-toggle-on");
    //       the.attr('data-val',1);
    //     }
    //   }
    // })

// 状态
    // $('.status').click(function(){
    //   var val = $(this).attr('data-val');
    //   var id = $(this).attr('data-id');
    //   var i = $(this).find('i');
    //   var the = $(this);
    //   if(val == 1){
    //     var status = 0;
    //   } else {
    //     var status = 1;
    //   }
    //   $.ajax({
    //     type:"post",
    //     url:"<?php echo url('admin/article/status'); ?>",
    //     data:{status:status,id:id},
    //     success:function(res){
          
    //       if(res.code == 1) {
    //         tostatus();
    //       } else {
    //         layer.msg(res.msg);
    //       }
    //     }
    //   })

    //   function tostatus(){
    //     if(val == 1){
    //       i.attr("class","fa fa-toggle-off");
    //       the.attr('data-val',0);
    //     } else {
    //       i.attr("class","fa fa-toggle-on");
    //       the.attr('data-val',1);
    //     }
    //   }
    // })

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
