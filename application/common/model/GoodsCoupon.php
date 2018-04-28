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

namespace app\common\model;

use think\Db;
use think\Model;

class GoodsCoupon extends Model
{
    public function goods()
    {
        return $this->hasOne('Goods','goods_id','goods_id');
    }
    public function goodsCategory()
    {
        return $this->hasOne('GoodsCategory','id','goods_category_id');
    }
}
