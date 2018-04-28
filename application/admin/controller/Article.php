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
use app\admin\controller\Permissions;
use app\admin\model\Article as articleModel;
use app\admin\model\ArticleCate as cateModel;
class Article extends Permissions
{
    public function index()
    {
        $model = new articleModel();
        $post = $this->request->param();
        if (isset($post['keywords']) and !empty($post['keywords'])) {
            $where['name'] = ['like', '%' . $post['keywords'] . '%'];
        }
        if (isset($post['article_cate_id']) and $post['article_cate_id'] > 0) {
            $where['article_cate_id'] = $post['article_cate_id'];
        }

        if (isset($post['admin_id']) and $post['admin_id'] > 0) {
            $where['admin_id'] = $post['admin_id'];
        }
        
        if (isset($post['status']) and ($post['status'] == 1 or $post['status'] === '0')) {
            $where['status'] = $post['status'];
        }

        if (isset($post['is_top']) and ($post['is_top'] == 1 or $post['is_top'] === '0')) {
            $where['is_top'] = $post['is_top'];
        }
 
        if(isset($post['create_time']) and !empty($post['create_time'])) {
            $min_time = strtotime($post['create_time']);
            $max_time = $min_time + 24 * 60 * 60;
            $where['create_time'] = [['>=',$min_time],['<=',$max_time]];
        }
        
        $articles = empty($where) ? $model->order('create_time desc')->paginate(20) : $model->where($where)->order('create_time desc')->paginate(20,false,['query'=>$this->request->param()]);

        //$articles = $article->toArray();
        //添加最后修改人的name
        foreach ($articles as $key => $value) {
            $articles[$key]['edit_admin'] = Db::name('admin')->where('id',$value['edit_admin_id'])->value('nickname');
        }
        $this->assign('articles',$articles);
        $info['cate'] = Db::name('article_cate')->select();
        $info['admin'] = Db::name('admin')->select();
        $this->assign('info',$info);
        return $this->fetch();
    }


    public function publish()
    {
    	//获取菜单id
    	$id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
    	$model = new articleModel();
        $cateModel = new cateModel();
		//是正常添加操作
		if($id > 0) {
    		//是修改操作
    		if($this->request->isPost()) {
    			//是提交操作
    			$post = $this->request->post();
    			//验证  唯一规则： 表名，字段名，排除主键值，主键名
	            $validate = new \think\Validate([
	                ['title', 'require', '标题不能为空'],
	                ['article_cate_id', 'require', '请选择分类'],
                    ['thumb', 'require', '请上传缩略图'],
                    ['content', 'require', '文章内容不能为空'],
	            ]);
	            //验证部分数据合法性
	            if (!$validate->check($post)) {
	                $this->error('提交失败：' . $validate->getError());
	            }
	            //验证菜单是否存在
	            $article = $model->where('id',$id)->find();
	            if(empty($article)) {
	            	return $this->error('id不正确');
	            }
                //设置修改人
                $post['edit_admin_id'] = Session::get('admin');
	            if(false == $model->allowField(true)->save($post,['id'=>$id])) {
	            	return $this->error('修改失败');
	            } else {
                    addlog($model->id);//写入日志
	            	return $this->success('修改成功','admin/article/index');
	            }
    		} else {
    			//非提交操作
    			$article = $model->where('id',$id)->find();
    			$cates = $cateModel->select();
    			$cates_all = $cateModel->catelist($cates);
    			$this->assign('cates',$cates_all);
    			if(!empty($article)) {
    				$this->assign('article',$article);
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
    			//验证  唯一规则： 表名，字段名，排除主键值，主键名
	            $validate = new \think\Validate([
	                ['title', 'require', '标题不能为空'],
                    ['article_cate_id', 'require', '请选择分类'],
                    ['thumb', 'require', '请上传缩略图'],
                    ['content', 'require', '文章内容不能为空'],
	            ]);
	            //验证部分数据合法性
	            if (!$validate->check($post)) {
	                $this->error('提交失败：' . $validate->getError());
	            }
                //设置创建人
                $post['admin_id'] = Session::get('admin');
                //设置修改人
                $post['edit_admin_id'] = $post['admin_id'];
	            if(false == $model->allowField(true)->save($post)) {
	            	return $this->error('添加失败');
	            } else {
                    addlog($model->id);//写入日志
	            	return $this->success('添加成功','admin/article/index');
	            }
    		} else {
    			//非提交操作
    			$cate = $cateModel->select();
    			$cates = $cateModel->catelist($cate);
    			$this->assign('cates',$cates);
    			return $this->fetch();
    		}
    	}
    	
    }


    public function delete()
    {
    	if($this->request->isAjax()) {
    		$id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
            if(false == Db::name('article')->where('id',$id)->delete()) {
                return $this->error('删除失败');
            } else {
                addlog($id);//写入日志
                return $this->success('删除成功','admin/article/index');
            }
    	}
    }


    public function is_top()
    {
        if($this->request->isPost()){
            $post = $this->request->post();
            if(false == Db::name('article')->where('id',$post['id'])->update(['is_top'=>$post['is_top']])) {
                return $this->error('设置失败');
            } else {
                addlog($post['id']);//写入日志
                return $this->success('设置成功','admin/article/index');
            }
        }
    }


    public function status()
    {
        if($this->request->isPost()){
            $post = $this->request->post();
            if(false == Db::name('article')->where('id',$post['id'])->update(['status'=>$post['status']])) {
                return $this->error('设置失败');
            } else {
                addlog($post['id']);//写入日志
                return $this->success('设置成功','admin/article/index');
            }
        }
    }


    // 友情链接
    public function link(){       
        $res =Db::name('friend_link')->alias('fl')->join('s_attachment sa','sa.id=fl.link_logo','left')->order('link_id')->paginate(20);
        $this->assign('res',$res);// 赋值数据集
        return $this->fetch();
    }

  // 新增、修改
    public function linkPublish(){
        $id = input('link_id/d');
        $model =  Db::name("friend_link");
        //提交操作
        if($this->request->isPost())
        {    
            $data = input('post.');
            $validate = new \think\Validate([
                ['link_name', 'require', '名称不能为空'],
                ['link_url', 'require|activeUrl', '链接格式不正确'],
            ]);
            //验证部分数据合法性
            if (!$validate->check($data)) {
                $this->error('提交失败：' . $validate->getError());
            }
            //修改
            $data['target']='1';
            $data['is_show']='on'? '1':0;
            // return $data;
            if($id){             
               $model->update($data);
            }else{ //添加
                $data['target']='1';
                $id = $model->insert($data);
            }
            addlog($id);
            return $this->success("操作成功!!!",'admin/article/link');
            // exit;
        } 
         
        if($id){
            //进入编辑页面
            // return $id;
            $link = $model->where("link_id" , $id)->find(); 
            $this->assign("link" , $link );
        }

        return $this->fetch();
    }

      //是否显示
    public function linkShow(){

        if($this->request->isPost()){
            $post = $this->request->post();
            if(false == Db::name('friend_link')->where('link_id',$post['id'])->update(['is_show'=>$post['is_show']])) {
                return $this->error('设置失败');
            } else {
                addlog($post['id']);//写入日志
                return $this->success('设置成功','admin/article/link');
            }
        }
    }
    //删除
    public function linkDel(){
       
       if($this->request->isAjax()) {
            $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
            if(false == Db::name('friend_link')->where('link_id',$id)->delete()) {
                return $this->error('删除失败');
            }else{
                addlog($id);//写入日志
                return $this->success('删除成功');
            }
        }
       
    }
    // 排序
    public function linkorders(){
        if($this->request->isPost()) {
            $post = $this->request->post();
            $i = 0;
            foreach ($post['id'] as $k => $val) {
                $order = Db::name('friend_link')->where('link_id',$val)->value('orderby');
                if($order != $post['orderby'][$k]) {
                    if(false == Db::name('friend_link')->where('link_id',$val)->update(['orderby'=>$post['orderby'][$k]])) {
                        return $this->error('更新失败');
                    } else {
                        $i++;
                    }
                }
            }
            addlog();//写入日志
            return $this->success('成功更新'.$i.'个数据','admin/article/link');
        }
    }
}   
