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
class AdminCate extends Model
{
	public function admin()
    {
        //关联管理员表
        return $this->hasOne('Admin');
    }
}
