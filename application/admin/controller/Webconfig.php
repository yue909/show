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

use app\admin\controller\Permissions;
use \think\Db;
class Webconfig extends Permissions
{
    public function index()
    {
        $web_config = Db::name('webconfig')->where('web','web')->find();
        $this->assign('web_config',$web_config);
        return $this->fetch();
    }

    public function publish()
    {
    	if($this->request->isPost()) {
            $post = $this->request->post();
            //验证  唯一规则： 表名，字段名，排除主键值，主键名
            $validate = new \think\Validate([
                ['name', 'require', '网站名称不能为空'],
                ['file_type', 'require', '上传类型不能为空'],
                ['file_size','require','上传大小不能为空'],
            ]);
            //验证部分数据合法性
            if (!$validate->check($post)) {
                $this->error('提交失败：' . $validate->getError());
            }

            if(empty($post['is_log'])) {
                $post['is_log'] = 0;
            } else {
                $post['is_log'] = $post['is_log'];
            }

            if(false == Db::name('webconfig')->where('web','web')->update($post)) {
                return $this->error('提交失败');
            } else {
                addlog();
                return $this->success('提交成功','admin/webconfig/index');
            }
        }
    }

   
    // 城市
    public function region(){

        $parent_id = input('parent_id',0);
        if($parent_id == 0){
            $parent = array('id'=>0,'name'=>"中国省份地区",'level'=>0);
        }else{
            $parent = db('region')->where("id" ,$parent_id)->find();
        }
        $names = $this->getParentRegionList($parent_id);
        if(count($names) > 0){
            $names = array_reverse($names);
            $parent_path = implode($names, '>');
        }
        $region = db('region')->where("parent_id" , $parent_id)->select();
        $this->assign('parent',$parent);
        $this->assign('parent_path',$parent_path);
        $this->assign('region',$region);
        return $this->fetch();
    }

    /**
     * 寻找Region_id的父级字段, $column可自己指定
     * @param $parent_id
     * @return array
     */
    function getParentRegionList($parent_id){
        $names = array();
        $region =  db('region')->where(array('id'=>$parent_id))->find();
        array_push($names,$region['name']);
        if($region['parent_id'] != 0){
            $nregion = $this->getParentRegionList($region['parent_id']);
            if(!empty($nregion)){
                $names = array_merge($names, $nregion);
            }
        }
        return $names;
    }
    
    // 添加新的地区 
    public function regionHandle(){
    $data = input('post.');
    $id = input('id');
    $referurl =  isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U("Tools/region");
    if(empty($id)){
        $data['level'] = $data['level']+1;
        if(empty($data['name'])){
            $this->error("请填写地区名称", $referurl);
        }else{
            $res = db('region')->where("parent_id = ".$data['parent_id']." and name='".$data['name']."'")->find();
            if(empty($res)){
                db('region')->cache(true)->add($data);
                $this->success("操作成功", $referurl);
            }else{
                $this->error("该区域下已有该地区,请不要重复添加", $referurl);
            }
        }
    }else{
        db('region')->where("id=$id or parent_id=$id")->cache(true)->delete();
        $this->success("操作成功", $referurl);
    }
}
    
}
