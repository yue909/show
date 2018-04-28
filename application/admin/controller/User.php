<?php
// +----------------------------------------------------------------------
// | Tplay [ WE ONLY DO WHAT IS NECESSARY ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://showoow.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yue < 994927909@qq.com >
// +----------------------------------------------------------------------


namespace app\admin\controller;
use \think\Cache;
use \think\Controller;
use think\Loader;
use think\Db;
use \think\Cookie;
use \think\Session;
use app\admin\model\User as UsModel;
use app\admin\controller\Permissions;
class User extends Permissions {

    public function index(){
        $model = new UsModel();
        $post = $this->request->param();
        $where = array();
        if (isset($post['keywords']) and !empty($post['keywords'])) {
            $where['username|nickname|mobile|qq'] = ['like', '%' . $post['keywords'] . '%'];
        }
        if (isset($post['mobile']) and $post['mobile'] > 0) {
            $where['mobile'] = $post['mobile'];
        }
        
        if (isset($post['user_level']) and ($post['user_level'] == 1 or $post['user_level'] === '0')) {
            $where['user_level'] = $post['user_level'];
        }

        if (isset($post['user_rank']) and ($post['user_rank'] == 1 or $post['user_rank'] === '0')) {
            $where['user_rank'] = $post['user_rank'];
        }
    
        if(isset($post['reg_time']) and !empty($post['reg_time'])) {
            $min_time = strtotime($post['reg_time']);
            $max_time = $min_time + 24 * 60 * 60;
            $where['reg_time'] = [['>=',$min_time],['<=',$max_time]];
               // dump($where['reg_time']) ;
        }

        $user = empty($where) ? $model->join('s_user_level sl','s_user.level_id=sl.level_id','left')->join('s_user_rank sr','s_user.rank_id=sr.rank_id','left')->order('reg_time desc')->paginate(20) : $model->where($where)->join('s_user_level sl','s_user.level_id=sl.level_id','left')->join('s_user_rank sr','s_user.rank_id=sr.rank_id','left')->order('reg_time desc')->paginate(20,false,['query'=>$this->request->param()]);

        // dump( $user);die;
        //$articles = $article->toArray();
        //添加最后修改人的name
        // foreach ($articles as $key => $value) {
        //     $articles[$key]['edit_admin'] = Db::name('admin')->where('id',$value['edit_admin_id'])->value('nickname');
        // }
        $this->assign('user',$user);
        $info['level'] = Db::name('user_level')->select();
        $info['rank'] = Db::name('user_rank')->select();
        $this->assign('info',$info);
        return $this->fetch();
    }


    //删除会员
    public function delete()
    {

        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;

            if(false == Db::name('user')->where('user_id',$id)->delete()) {
                return $this->error('删除失败');
            }else{
                addlog($id);//写入日志
                return $this->success('删除成功','admin/user/index');
            }
        }
    }
  

    /*
     * 会员详细信息修改和新增
     */
    public function publish()
    {         
        $id = input('user_id/d');
        $model =  Db::name("user");
        
        if($this->request->isPost())
        {    
            $data = input('post.');

            $validate = new \think\Validate(
              [
                ['username', 'require', '用户名不正确'],
                ['nickname', 'require', '昵称不能为空'],
                ['email', 'email|require', '邮箱格式不正确'],
                ['mobile', 'number|require|length:11', '手机格式不正确'],
              ]);
            //验证部分数据合法性
            if (!$validate->check($data)) {

                $this->error('提交失败：' . $validate->getError());
            }

            if($id){
              if ($model->update($data) || $model->update($data)==0) {
                addlog($id);
                return $this->success("操作成功!!!",'admin/user/index');
              }

            }else{
                $res = $model->where('username',$data['username'])->find();
                if ($res) {
                    return $this->error("用户名已经存在!!!");
                }else{
                   $data['password']=password($data['password']);//密码加密
                  if($model->insert($data)){
                    $id =$model->getLastInsID();
                    addlog($id);
                    return $this->success("操作成功!!!",'admin/user/index');
                  }else{
                    return $this->error('新增失败');
                  }              
                }

            }
            // exit;
        } 
         
        if($id){
            //进入编辑页面

            $user = $model->where("user_id" , $id)->find(); 
            $this->assign("user" , $user);
        }
        $info['level']=Db::name('user_level')->select();
        $info['rank']=Db::name('user_rank')->select();
        $this->assign('info', $info);
        return $this->fetch();
    }

    // 导出会员
    public function export_user()
    {
      $strTable ='<table width="500" border="1">';
      $strTable .= '<tr>';
      $strTable .= '<td style="text-align:center;font-size:12px;width:120px;">会员ID</td>';
      $strTable .= '<td style="text-align:center;font-size:12px;" width="100">会员昵称</td>';
      $strTable .= '<td style="text-align:center;font-size:12px;" width="*">会员等级</td>';
      $strTable .= '<td style="text-align:center;font-size:12px;" width="*">手机号</td>';
      $strTable .= '<td style="text-align:center;font-size:12px;" width="*">邮箱</td>';
      $strTable .= '<td style="text-align:center;font-size:12px;" width="*">注册时间</td>';
      $strTable .= '<td style="text-align:center;font-size:12px;" width="*">最后登陆</td>';
      $strTable .= '<td style="text-align:center;font-size:12px;" width="*">余额</td>';
      $strTable .= '<td style="text-align:center;font-size:12px;" width="*">积分</td>';
      $strTable .= '<td style="text-align:center;font-size:12px;" width="*">累计消费</td>';
      $strTable .= '</tr>';
      $count = Db::name('user')->count();
      $p = ceil($count/5000);
      for($i=0;$i<$p;$i++){
         $start = $i*5000;
         $end = ($i+1)*5000;
         $userList = Db::name('user')->order('user_id')->join('s_user_level sl','sl.level_id=s_user.level_id','left')->limit($start.','.$end)->select();
         if(is_array($userList)){
            foreach($userList as $k=>$val){
               $strTable .= '<tr>';
               $strTable .= '<td style="text-align:center;font-size:12px;">'.$val['user_id'].'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['nickname'].' </td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['level_name'].'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['mobile'].'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['email'].'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.date('Y-m-d H:i',$val['reg_time']).'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.date('Y-m-d H:i',$val['last_login']).'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['user_money'].'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['pay_points'].' </td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['total_amount'].' </td>';
               $strTable .= '</tr>';
            }
            unset($userList);
         }
      }
      $strTable .='</table>';
      downloadExcel($strTable,'user_'.$i);
      exit();
    }

    /**
     * 用户收货地址查看
     */
    public function address()
    { 
        $uid = input('user_id/d');
        $address = Db::name('user_address')->where('user_id',$uid)->paginate();
        $regionList = get_region_list();
        $this->assign('uid',$uid);
        $this->assign('regionList',$regionList);
        $this->assign('address',$address);
        return $this->fetch();
    }

    
    /**
     * 账户资金记录
     */
    public function account_log(){
        $user_id = I('get.id');
        //获取类型
        $type = I('get.type');
        //获取记录总数
        $count = M('account_log')->where(array('user_id'=>$user_id))->count();
        $page = new Page($count);
        $lists  = M('account_log')->where(array('user_id'=>$user_id))->order('change_time desc')->limit($page->firstRow.','.$page->listRows)->select();

        $this->assign('user_id',$user_id);
        $this->assign('page',$page->show());
        $this->assign('lists',$lists);
        return $this->fetch();
    }

    /**
     * 账户资金调节
     */
    public function account_edit(){
        $user_id = I('user_id');
        if(!$user_id > 0) $this->ajaxReturn(['status'=>0,'msg'=>"参数有误"]);
        $user = M('users')->field('user_id,user_money,frozen_money,pay_points,is_lock')->where('user_id',$user_id)->find();
        if(IS_POST){
            $desc = I('post.desc');
            if(!$desc)
                $this->ajaxReturn(['status'=>0,'msg'=>"请填写操作说明"]);
            //加减用户资金
            $m_op_type = I('post.money_act_type');
            $user_money = I('post.user_money/f');
            $user_money =  $m_op_type ? $user_money : 0-$user_money;
            //加减用户积分
            $p_op_type = I('post.point_act_type');
            $pay_points = I('post.pay_points/d');
            $pay_points =  $p_op_type ? $pay_points : 0-$pay_points;
            //加减冻结资金
            $f_op_type = I('post.frozen_act_type');
            $revision_frozen_money = I('post.frozen_money/f');
            if( $revision_frozen_money != 0){    //有加减冻结资金的时候
                $frozen_money =  $f_op_type ? $revision_frozen_money : 0-$revision_frozen_money;
                $frozen_money = $user['frozen_money']+$frozen_money;    //计算用户被冻结的资金
                if($f_op_type==1 and $revision_frozen_money > $user['user_money'])
                {
                    $this->ajaxReturn(['status'=>0,'msg'=>"用户剩余资金不足！！"]);
                }
                if($f_op_type==0 and $revision_frozen_money > $user['frozen_money'])
                {
                    $this->ajaxReturn(['status'=>0,'msg'=>"冻结的资金不足！！"]);
                }
                $user_money = $f_op_type ? 0-$revision_frozen_money : $revision_frozen_money ;    //计算用户剩余资金
                M('users')->where('user_id',$user_id)->update(['frozen_money' => $frozen_money]);
            }
            if(accountLog($user_id,$user_money,$pay_points,$desc,0))
            {
                $this->ajaxReturn(['status'=>1,'msg'=>"操作成功",'url'=>U("Admin/User/account_log",array('id'=>$user_id))]);
            }else{
                $this->ajaxReturn(['status'=>-1,'msg'=>"操作失败"]);
            }
            exit;
        }
        $this->assign('user_id',$user_id);
        $this->assign('user',$user);
        return $this->fetch();
    }
    //???
    public function recharge(){
      $timegap = urldecode(I('timegap'));
      $nickname = I('nickname');
      $map = array();
      if($timegap){
         $gap = explode(',', $timegap);
         $begin = $gap[0];
         $end = $gap[1];
         $map['ctime'] = array('between',array(strtotime($begin),strtotime($end)));
      }
      if($nickname){
         $map['nickname'] = array('like',"%$nickname%");
      }     
      $count = M('recharge')->where($map)->count();
      $page = new Page($count);
      $lists  = M('recharge')->where($map)->order('ctime desc')->limit($page->firstRow.','.$page->listRows)->select();
      $this->assign('page',$page->show());
        $this->assign('pager',$page);
      $this->assign('lists',$lists);
      return $this->fetch();
    }

    // 会员等级
    public function level(){
      $level = Db::name('user_level')->paginate(15);
      $this->assign('level',$level);
      return $this->fetch();
    }

    /**
     * 会员等级添加编辑
     */
    public function levelPublish()
    {
        $id = input('level_id/d');
        $model =  Db::name("user_level");       
        if($this->request->isPost())
        {    
            $data = input('post.');
            $validate = new \think\Validate(
              [
                ['level_name', 'require', '用户名不正确'],
                ['amount', 'require', '最低金额不能为空'],
                ['discount', 'require', '折扣不正确'],
              ]);
            //验证部分数据合法性
            if (!$validate->check($data)) {

                $this->error('提交失败：' . $validate->getError());
            }

            if($id){
              if ($model->update($data) || $model->update($data)==0) {
                addlog($id);
                return $this->success("操作成功!!!",'admin/user/level');
              }

            }else{
                $res = $model->where('level_name',$data['level_name'])->find();
                if ($res) {
                    return $this->error("用名字已经存在!!!");
                }else{
                   // $data['password']=password($data['password']);//密码加密
                  if($model->insert($data)){
                    $id =$model->getLastInsID();
                    addlog($id);
                    return $this->success("操作成功!!!",'admin/user/level');
                  }else{
                    return $this->error('新增失败');
                  }              
                }
            }          
        }         
        if($id){
            //进入编辑页面
            $level = $model->where("level_id" , $id)->find(); 
            $this->assign("level" , $level);
        }
        return $this->fetch();
    }

    // 删除会员等级
    public function levelDelete()
    {

        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;

            if(false == Db::name('user_level')->where('level_id',$id)->delete()) {
                return $this->error('删除失败');
            }else{
                addlog($id);//写入日志
                return $this->success('删除成功','admin/user/level');
            }
        }
    }
    /**
     * 分销树状关系
     */
    public function ajax_distribut_tree()
    {
          $list = Db::name('user')->where("first_leader = 1")->select();
          return $this->fetch();
    }

    /**
     *
     * @time 2016/08/31
     * @author dyr
     * 发送站内信
     */
    public function sendMessage()
    {
        $user_id_array = I('get.user_id_array');
        $users = array();
        if (!empty($user_id_array)) {
            $users = M('users')->field('user_id,nickname')->where(array('user_id' => array('IN', $user_id_array)))->select();
        }
        $this->assign('users',$users);
        return $this->fetch();
    }

    /**
     * 发送系统消息
     * @author dyr
     * @time  2016/09/01
     */
    public function doSendMessage()
    {
        $call_back = I('call_back');//回调方法
        $text= I('post.text');//内容
        $type = I('post.type', 0);//个体or全体
        $admin_id = session('admin_id');
        $users = I('post.user/a');//个体id
        $message = array(
            'admin_id' => $admin_id,
            'message' => $text,
            'category' => 0,
            'send_time' => time()
        );

        if ($type == 1) {
            //全体用户系统消息
            $message['type'] = 1;
            M('Message')->add($message);
        } else {
            //个体消息
            $message['type'] = 0;
            if (!empty($users)) {
                $create_message_id = M('Message')->add($message);
                foreach ($users as $key) {
                    M('user_message')->add(array('user_id' => $key, 'message_id' => $create_message_id, 'status' => 0, 'category' => 0));
                }
            }
        }
        echo "<script>parent.{$call_back}(1);</script>";
        exit();
    }

    /**
     *
     * @time 2016/09/03
     * @author dyr
     * 发送邮件
     */
    public function sendMail()
    {
        $user_id_array = I('get.user_id_array');
        $users = array();
        if (!empty($user_id_array)) {
            $user_where = array(
                'user_id' => array('IN', $user_id_array),
                'email' => array('neq', '')
            );
            $users = Db::name('user')->field('user_id,nickname,email')->where($user_where)->select();
        }
        $this->assign('smtp', tpCache('smtp'));
        $this->assign('users', $users);
        return $this->fetch();
    }

    /**
     * 发送邮箱
     * @author dyr
     * @time  2016/09/03
     */
    public function doSendMail()
    {
        $call_back = I('call_back');//回调方法
        $message = I('post.text');//内容
        $title = I('post.title');//标题
        $users = I('post.user/a');
        $email= I('post.email');
        if (!empty($users)) {
            $user_id_array = implode(',', $users);
            $users = M('users')->field('email')->where(array('user_id' => array('IN', $user_id_array)))->select();
            $to = array();
            foreach ($users as $user) {
                if (check_email($user['email'])) {
                    $to[] = $user['email'];
                }
            }
            $res = send_email($to, $title, $message);
            echo "<script>parent.{$call_back}({$res['status']});</script>";
            exit();
        }
        if($email){
            $res = send_email($email, $title, $message);
            echo "<script>parent.{$call_back}({$res['status']});</script>";
            exit();
        }
    }

    /**
     * 提现申请记录
     */
    public function withdrawals()
    {
        $this->get_withdrawals_list();
        return $this->fetch();
    }
    
    public function get_withdrawals_list($status=''){
      $user_id = input('user_id/d');
      // $realname = input('realname');
      // $bank_card = input('bank_card');
      // $create_time = input('create_time');
      $create_time = str_replace("+"," ",$create_time);
      $create_time2 = $create_time  ? $create_time  : date('Y-m-d',strtotime('-1 year')).' - '.date('Y-m-d',strtotime('+1 day'));
      $create_time3 = explode(' - ',$create_time2);
      $this->assign('start_time',$create_time3[0]);
      $this->assign('end_time',$create_time3[1]);
      $where['w.create_time'] =  array(array('gt', strtotime(strtotime($create_time3[0])), array('lt', strtotime($create_time3[1]))));
      $status = empty($status) ? input('status') : $status;
      if(empty($status) || $status === '0'){
         $where['w.status'] =  array('lt',1);
      }
      if($status === '0' || $status > 0) {
         $where['w.status'] = $status;
      }
      $user_id && $where['u.user_id'] = $user_id;
      $realname && $where['w.realname'] = array('like','%'.$realname.'%');
      $bank_card && $where['w.bank_card'] = array('like','%'.$bank_card.'%');
      $export = input('export');
      if($export == 1){
         $strTable ='<table width="500" border="1">';
         $strTable .= '<tr>';
         $strTable .= '<td style="text-align:center;font-size:12px;width:120px;">申请人</td>';
         $strTable .= '<td style="text-align:center;font-size:12px;" width="100">提现金额</td>';
         $strTable .= '<td style="text-align:center;font-size:12px;" width="*">银行名称</td>';
         $strTable .= '<td style="text-align:center;font-size:12px;" width="*">银行账号</td>';
         $strTable .= '<td style="text-align:center;font-size:12px;" width="*">开户人姓名</td>';
         $strTable .= '<td style="text-align:center;font-size:12px;" width="*">申请时间</td>';
         $strTable .= '<td style="text-align:center;font-size:12px;" width="*">提现备注</td>';
         $strTable .= '</tr>';
         $remittanceList = Db::name('withdrawals')->alias('w')->field('w.*,u.nickname')->join('s_user u', 'u.user_id = w.user_id', 'INNER')->where($where)->order("w.id desc")->select();
         if(is_array($remittanceList)){
            foreach($remittanceList as $k=>$val){
               $strTable .= '<tr>';
               $strTable .= '<td style="text-align:center;font-size:12px;">'.$val['nickname'].'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['money'].' </td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['bank_name'].'</td>';
               $strTable .= '<td style="vnd.ms-excel.numberformat:@">'.$val['bank_card'].'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['realname'].'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.date('Y-m-d H:i:s',$val['create_time']).'</td>';
               $strTable .= '<td style="text-align:left;font-size:12px;">'.$val['remark'].'</td>';
               $strTable .= '</tr>';
            }
         }
         $strTable .='</table>';
         unset($remittanceList);
         downloadExcel($strTable,'remittance');
         exit();
      }
      $count = Db::name('withdrawals')->alias('w')->join('s_user u', 'u.user_id = w.user_id', 'INNER')->where($where)->count();
      $Page  = new Page($count,20);
      $list = Db::name('withdrawals')->alias('w')->field('w.*,u.nickname')->join('s_user u', 'u.user_id = w.user_id', 'INNER')->where($where)->order("w.id desc")->paginate();
      $this->assign('create_time',$create_time2);
      $show  = $list->render();
      $this->assign('show',$show);
      $this->assign('list',$list);
      C('TOKEN_ON',false);
    }
    
    /**
     * 删除申请记录
     */
    public function delWithdrawals()
    {
        $model = Db::name("withdrawals");
        if($model->where('id',input('id'))->delete()){
           $return_arr = array('status' => 1,'msg' => '操作成功','url' =>'admin/user/level',);
           addlog($model->getLastInsID());
        }else{
          $return_arr = array('status' => -1,'msg' => '删除失败','url'=>'');

        }
        return json($return_arr);
    }

    /**
     * 修改编辑 申请提现
     */
    public  function editWithdrawals(){        
       $id = I('id');
       $model = M("withdrawals");
       $withdrawals = $model->find($id);
       $user = M('users')->where("user_id = {$withdrawals[user_id]}")->find();     
       if($user['nickname'])        
           $withdrawals['user_name'] = $user['nickname'];
       elseif($user['email'])        
           $withdrawals['user_name'] = $user['email'];
       elseif($user['mobile'])        
           $withdrawals['user_name'] = $user['mobile'];            
       
       $this->assign('user',$user);
       $this->assign('data',$withdrawals);
       return $this->fetch();
    }  

    /**
     *  处理会员提现申请
     */
    public function withdrawals_update(){
      $id = I('id/a');
        $data['status']=$status = I('status');
      $data['remark'] = I('remark');
        if($status == 1) $data['check_time'] = time();
        if($status != 1) $data['refuse_time'] = time();
        $r = M('withdrawals')->where('id in ('.implode(',', $id).')')->update($data);
      if($r){
         $this->ajaxReturn(array('status'=>1,'msg'=>"操作成功"),'JSON');
      }else{
         $this->ajaxReturn(array('status'=>0,'msg'=>"操作失败"),'JSON');
      }     
    }
    // 用户申请提现
    public function transfer(){
      $id = I('selected/a');
      if(empty($id))$this->error('请至少选择一条记录');
      $atype = I('atype');
      if(is_array($id)){
         $withdrawals = M('withdrawals')->where('id in ('.implode(',', $id).')')->select();
      }else{
         $withdrawals = M('withdrawals')->where(array('id'=>$id))->select();
      }
      $alipay['batch_num'] = 0;
      $alipay['batch_fee'] = 0;
      foreach($withdrawals as $val){
         $user = M('users')->where(array('user_id'=>$val['user_id']))->find();
         if($user['user_money'] < $val['money'])
         {
            $data = array('status'=>-2,'remark'=>'账户余额不足');
            M('withdrawals')->where(array('id'=>$val['id']))->save($data);
            $this->error('账户余额不足');
         }else{
            $rdata = array('type'=>1,'money'=>$val['money'],'log_type_id'=>$val['id'],'user_id'=>$val['user_id']);
            if($atype == 'online'){
         header("Content-type: text/html; charset=utf-8");
          exit("请联系TPshop官网客服购买高级版支持此功能");
            }else{
               accountLog($val['user_id'], ($val['money'] * -1), 0,"管理员处理用户提现申请");//手动转账，默认视为已通过线下转方式处理了该笔提现申请
               $r = M('withdrawals')->where(array('id'=>$val['id']))->save(array('status'=>2,'pay_time'=>time()));
               expenseLog($rdata);//支出记录日志
            }
         }
      }
      if($alipay['batch_num']>0){
         //支付宝在线批量付款
         include_once  PLUGIN_PATH."payment/alipay/alipay.class.php";
         $alipay_obj = new \alipay();
         $alipay_obj->transfer($alipay);
      }
      $this->success("操作成功!",U('remittance'),3);
    }
    
    /**
     *  转账汇款记录
     */
    public function remittance(){
      $status = I('status',1);
      $this->assign('status',$status);
      $this->get_withdrawals_list($status);
        return $this->fetch();
    }

        /**
     * 签到列表
     * @date 2017/09/28
     */
    public function signList() {       
    header("Content-type: text/html; charset=utf-8");
exit("请联系TPshop官网客服购买高级版支持此功能");
    }
    
    
    /**
     * 会员签到 ajax
     * @date 2017/09/28
     */
    public function ajaxsignList() {
    header("Content-type: text/html; charset=utf-8");
      exit("请联系TPshop官网客服购买高级版支持此功能");
    }
    
    /**
     * 签到规则设置 
     * @date 2017/09/28
     */
    public function signRule() {
    header("Content-type: text/html; charset=utf-8");
    exit("请联系TPshop官网客服购买高级版支持此功能");
    }
}