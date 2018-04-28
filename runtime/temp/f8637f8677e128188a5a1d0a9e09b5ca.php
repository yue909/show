<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:81:"D:\phpstudy\PHPTutorial\WWW\show\public/../application/admin\view\user\index.html";i:1524811915;}*/ ?>
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
        <li class="layui-this">会员管理</li>
        <li><a href="<?php echo url('admin/user/publish'); ?>" class="a_menu">新增会员</a></li>
      </ul>
    </div> 
      <form class="layui-form serch" action="<?php echo url('admin/user/index'); ?>" method="post">
        <div class="layui-form-item" style="float: left;">
          <div class="layui-input-inline">
            <input type="text" name="keywords" lay-verify="title" autocomplete="off" placeholder="请输入关键词" class="layui-input layui-btn-sm">
          </div>
          <div class="layui-input-inline">
            <div class="layui-inline">
                <select name="article_cate_id" lay-search="">
                  <option value="">会员等级</option>
                  <?php if(is_array($info['level']) || $info['level'] instanceof \think\Collection || $info['level'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['level'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $vo['level_id']; ?>" <?php if(!(empty($where['user_level']) || (($where['user_level'] instanceof \think\Collection || $where['user_level'] instanceof \think\Paginator ) && $where['user_level']->isEmpty()))): ?> selected="" <?php endif; ?>><?php echo $vo['level_name']; ?></option>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
          </div>

          <div class="layui-input-inline">
            <div class="layui-inline">
                <select name="article_cate_id" lay-search="">
                  <option value="">注册类型</option>
                  <?php if(is_array($info['rank']) || $info['rank'] instanceof \think\Collection || $info['rank'] instanceof \think\Paginator): $i = 0; $__LIST__ = $info['rank'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                  <option value="<?php echo $vo['rank_id']; ?>"><?php echo $vo['rank_name']; ?></option>
                  <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
          </div>

          <div class="layui-input-inline">
            <div class="layui-inline">
              <div class="layui-input-inline">
                <input type="text" class="layui-input" id="create_time" placeholder="注册时间" name="reg_time">
              </div>
            </div>
          </div>
          <button class="layui-btn layui-btn-danger layui-btn-sm" lay-submit="" lay-filter="serch">立即提交</button>
        </div>
      </form>
      <a href="<?php echo url('admin/user/export_user'); ?>" style="float: right;"><button class="layui-btn layui-btn-sm layui-btn-normal" lay-submit="" lay-filter="export" id='export'>导出会员</button></a>
    <table class="layui-table" lay-size="sm">
      <colgroup>
        <col width="30">
        <col width="150">
        <col width="150">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="100">
        <col width="80">
        <col width="100">
      </colgroup>
      <thead>
        <tr>
          <th>ID</th>
          <th>用户名</th>
          <th>昵称</th>
          <th>头像</th>
          <th>手机</th>
          <th>邮箱</th>
          <th>QQ</th>
          <th>会员等级</th>
          <th>注册类型</th>
          <th>登录ip</th>
          <th>注册时间</th>
          <th>是否分销商</th>
          <th>会员折扣</th>
          <th>操作</th>
        </tr> 
      </thead>
      <tbody>
        <?php if(is_array($user) || $user instanceof \think\Collection || $user instanceof \think\Paginator): $i = 0; $__LIST__ = $user;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
        <tr>
          <td><?php echo $vo['user_id']; ?></td>
          <td><?php echo $vo['username']; ?></td>
          <td><?php echo $vo['nickname']; ?></td>
          <td><a href="<?php echo geturl($vo['thumb']); ?>" class="tooltip"><img src="<?php echo geturl($vo['thumb']); ?>" width="20" height="20"></a></td>
          <td><?php echo $vo['mobile']; ?></td>
          <td><?php echo $vo['email']; ?></td>
          <td><?php echo $vo['qq']; ?></td>
          <td><?php echo $vo['level_name']; ?></td>
          <td><?php echo $vo['rank_name']; ?></td>
          <td><?php echo $vo['loginip']; ?></td>
          <td><?php echo date("Y-m-d",$vo['reg_time']); ?></td>
          <td><?php echo $vo['district']; ?></td>
          <td><?php echo $vo['discount']; ?></td>
          <td class="operation-menu">
            <div class="layui-btn-group">
              <a href="<?php echo url('admin/user/publish',['user_id'=>$vo['user_id']]); ?>" class="layui-btn layui-btn-xs a_menu layui-btn-primary" style="margin-right: 0;font-size:12px;"><i class="layui-icon"  title='编辑'></i></a>
               <a href="<?php echo url('admin/user/address',['user_id'=>$vo['user_id']]); ?>" class="layui-btn layui-btn-xs layui-btn-primary address" id="<?php echo $vo['user_id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon" title='收货地址'></i></a>
               <a href="<?php echo url('admin/user/orders',['user_id'=>$vo['user_id']]); ?>" class="layui-btn layui-btn-xs layui-btn-primary orders" id="<?php echo $vo['user_id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon" title='订单'></i></a>
               <a href="<?php echo url('admin/user/withdrawals',['user_id'=>$vo['user_id']]); ?>" class="layui-btn layui-btn-xs layui-btn-primary orders" id="<?php echo $vo['user_id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon" title='提现记录'></i></a>
               <a href="<?php echo url('admin/user/orders',['user_id'=>$vo['user_id']]); ?>" class="layui-btn layui-btn-xs layui-btn-primary orders" id="<?php echo $vo['user_id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon" title='其他'></i></a>
               <a href="javascript:;" class="layui-btn layui-btn-xs layui-btn-primary delete" id="<?php echo $vo['user_id']; ?>" style="margin-right: 0;font-size:12px;"><i class="layui-icon" title='删除'></i></a>
            </div>
          </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
    <div style="padding:0 20px;"><?php echo $user->render(); ?></div> 

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
