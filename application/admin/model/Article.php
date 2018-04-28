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



namespace app\admin\model;

use \think\Model;
class Article extends Model
{
	public function cate()
    {
        //关联分类表
        return $this->belongsTo('ArticleCate');
    }

    public function admin()
    {
        //关联角色表
        return $this->belongsTo('Admin');
    }
}
