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

use \think\Db;
use \think\Session;
use \app\admin\controller\Permissions;
use app\admin\model\Smsconfig as smsModel;

class Smsconfig extends Permissions
{
    public function index()
    {
        $data = Db::name('smsconfig')->select();
        $this->assign('data',$data);
        return $this->fetch();
    }

    //修改和删除 短信配置
    public function publish()
    {
    	//获取菜单id
        $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
        $model = new smsModel();
        //是正常修改操作
        if($id > 0) {
            //是修改操作
            if($this->request->isPost()) {
                //是提交操作
                $post = $this->request->post();
                //验证  唯一规则： 表名，字段名，排除主键值，主键名
                $validate = new \think\Validate([
                    ['sms', 'require', 'sms不能为空'],
                    ['appkey', 'require', 'appkey不能为空'],
                    ['secretkey', 'require', 'secretkey不能为空'],
                ]);
                //验证部分数据合法性
                if (!$validate->check($post)) {
                    $this->error('提交失败：' . $validate->getError());
                }
                //验证菜单是否存在
                $sms = $model->where('id',$id)->find();
                if(empty($sms)) {
                    return $this->error('id不正确');
                }
                //设置修改人
                // $post['edit_admin_id'] = Session::get('admin');
                //allowField 过滤非数据表的字段
                if(false == $model->allowField(true)->save($post,['id'=>$id])) {
                    return $this->error('修改失败');
                } else {
                    addlog($model->id);//写入日志
                    return $this->success('修改成功','admin/smsconfig/index');
                }
            } else {
                //非提交操作 //分配数据
                $sms = $model->where('id',$id)->find();
                // $cates = $cateModel->select();
                // $cates_all = $cateModel->catelist($cates);
                // $this->assign('cates',$cates_all);
                if(!empty($sms)) {
                    $this->assign('sms',$sms);
                    return $this->fetch();
                } else {
                    return $this->error('id不正确');
                }
            }
        } else {
            //是新增操作
            if($this->request->isPost()) {
                //是提交操作
                $post = $this->request->post();
                 // return $post;
                //验证  唯一规则： 表名，字段名，排除主键值，主键名
                $validate = new \think\Validate([
                    ['sms', 'require', 'sms不能为空'],
                    ['appkey', 'require', 'appkey不能为空'],
                    ['secretkey', 'require', 'secretkey不能为空'],
                ]);
                //验证部分数据合法性
                if (!$validate->check($post)) {
                    $this->error('提交失败：' . $validate->getError());
                }
                //设置创建人
                $post['admin_id'] = Session::get('admin');
                //设置修改人
                $post['edit_admin_id'] = $post['admin_id'];
                if(false ==$model->allowField(true)->save($post)) {
                    return $this->error('添加失败');
                } else {
                    addlog($model->id);//写入日志
                    return $this->success('添加成功','admin/smsconfig/index');
                }
            } else {
                // 非提交操作
                // $sms = $model->where('id',$id)->find();
                // $this->assign('cates',$cates);
                // return $this->error('非法操作');.
                return $this->fetch();
            }
        }

    }


    //删除短信配置
    public function delete()
    {
        if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;

            if(false == Db::name('smsconfig')->where('id',$id)->delete()) {
                return $this->error('删除失败');
            }else{
                addlog($id);//写入日志
                return $this->success('删除成功','admin/smsconfig/index');
            }
        }
    }

    // 测试短信发送
    public function smsto()
    {
        //return $this->error('hehe');
        if($this->request->isPost()) {
            $post = $this->request->post();
            //验证  唯一规则： 表名，字段名，排除主键值，主键名
            $validate = new \think\Validate([
                ['phone', 'require|length:11,11|number', '手机号码不能为空|手机号码格式不正确|手机号码格式不正确'],
            ]);
            //验证部分数据合法性
            if (!$validate->check($post)) {
                $this->error('提交失败：' . $validate->getError());
            }

            $phone = (string)$post['phone'];

            $param = '{"name":"用户"}';

            $smsto = SendSms($param,$phone);
            
            if(!empty($smsto)) {
                return $this->error('发送失败');
            } else {
                $phone = hide_phone($phone);
                addlog($phone);//写入日志
                return $this->success('短信发送成功');
            }
        } else {
            return $this->fetch();
        }
    }



    //  短信模板
     public function smsTemp(){
        
        $smsTpls = db('sms_template')->select();
        $this->assign('smsTplList',$smsTpls);
        
        return $this->fetch();
       
    }

    // 新增、修改模板
     public  function smstempPublish(){
        
        $id = input('id/d');
        $model =  Db::name("sms_template");
        
        if($this->request->isPost())
        {    
            $data = input('post.');

            $validate = new \think\Validate([
                ['sms_sign', 'require', 'sms_sign不能为空'],
                ['sms_tpl_code', 'require', 'asms_tpl_code不能为空'],
                ['tpl_content', 'require', 'tpl_content不能为空'],
            ]);
            //验证部分数据合法性
            if (!$validate->check($data)) {
                $this->error('提交失败：' . $validate->getError());
            }

            if($id){
              
               $model->update($data);
            }else{
                $data['add_time']=time();
                $id = $model->insert($data);
            }
            addlog($id);
            return $this->success("操作成功!!!",'admin/smsconfig/smstemp');
            // exit;
        } 
         
        if($id){
            //进入编辑页面
            $smsTemplate = $model->where("tpl_id" , $id)->find(); 
            $this->assign("smsTpl" , $smsTemplate );
        }
        return $this->fetch();
    }
    
    /**
     * 删除短信模板
     */
   public function smstempDel(){
       
       if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
            if(false == Db::name('sms_template')->where('tpl_id',$id)->delete()) {
                return $this->error('删除失败');
            }else{
                addlog($id);//写入日志
                return $this->success('删除成功','admin/smsconfig/smstemp');
            }
        }
       
   }
}
