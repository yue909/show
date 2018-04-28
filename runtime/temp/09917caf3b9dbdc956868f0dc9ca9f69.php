<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:83:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\user\address.html";i:1524741081;}*/ ?>
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
        <li class="layui-this">地址管理</li>
        <li><a href="<?php echo url('admin/user/addressPublish',['user_id'=>$uid]); ?>" class="a_menu">新增地址</a></li>
      </ul>
    </div> 
    <table class="layui-table" lay-size="sm">
      <colgroup>
        <col width="30">
        <col width="150">
        <col width="150">
        <col width="150">
        <col width="300">
        <col width="100">

      </colgroup>
      <thead>
        <tr>
          <th>ID</th>
          <th>收货人</th>
          <th>手机</th>
          <th>邮箱</th>
          <th>收货地址</th>
          <th>操作</th>
        </tr> 
      </thead>
      <tbody>
        <?php if(is_array($address) || $address instanceof \think\Collection || $address instanceof \think\Paginator): $i = 0; $__LIST__ = $address;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
          <td><?php echo $vo['address_id']; ?></td>
          <td><?php echo $vo['consignee']; ?></td>
          <td><?php echo $vo['mobile']; ?></td>
          <td><?php echo $vo['email']; ?></td>
          <td><?php echo $vo['country']; ?><?php echo $vo['province']; ?><?php echo $vo['city']; ?><?php echo $vo['district']; ?><?php echo $vo['twon']; ?></td>        
          <td class="operation-menu">
            <div class="layui-btn-group">
              <a href="<?php echo url('admin/user/publish',['user_id'=>$vo['user_id']]); ?>" class="layui-btn layui-btn-xs a_menu layui-btn-primary" style="margin-right: 0;font-size:12px;"><i class="layui-icon"  title='编辑'></i></a>
               <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-primary delete" id="<?php echo $vo['user_id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon" title='删除'></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
    <div style="padding:0 20px;"><?php echo $address->render(); ?></div> 

    <script type="text/javascript">

    $('.delete').click(function(){
      var id = $(this).attr('id');
      layer.confirm('确定要删除?', function(index) {
        $.ajax({
          url:"<?php echo url('admin/user/delete'); ?>",
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

    <!--  <script type="text/javascript">

      $('#export').click(function(){
        var id = $(this).attr('id');
        layer.confirm('确定要导出吗?', function(index) {
          $.ajax({
            url:"<?php echo url('admin/user/export_user'); ?>",
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
    </script> -->
    <script type="text/javascript">

    // $('.is_top').click(function(){
    //   var val = $(this).attr('data-val');
    //   var id = $(this).attr('data-id');
    //   var i = $(this).find('i');
    //   var the = $(this);
    //   if(val == 1){
    //     var is_top = 0;
    //   } else {
    //     var is_top = 1;
    //   }
    //   $.ajax({
    //     type:"post",
    //     url:"<?php echo url('admin/article/is_top'); ?>",
    //     data:{is_top:is_top,id:id},
    //     success:function(res){
          
    //       if(res.code == 1) {
    //         top();
    //       } else {
    //         layer.msg(res.msg);
    //       }
    //     }
    //   })

    //   function top(){
    //     if(val == 1){
    //       i.attr("class","fa fa-toggle-off");
    //       the.attr('data-val',0);
    //     } else {
    //       i.attr("class","fa fa-toggle-on");
    //       the.attr('data-val',1);
    //     }
    //   }
    // })


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
