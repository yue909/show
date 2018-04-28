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
use think\Model;
class Goods extends Model {
    public function FlashSale()
    {
        return $this->hasOne('FlashSale','id','prom_id');
    }

    public function PromGoods()
    {
        return $this->hasOne('PromGoods','id','prom_id')->cache(true,10);
    }
    public function GroupBuy()
    {
        return $this->hasOne('GroupBuy','id','prom_id');
    }
    public function getDiscountAttr($value, $data)
    {
        if ($data['market_price'] == 0) {
            $discount = 10;
        } else {
            $discount = round($data['shop_price'] / $data['market_price'], 2) * 10;
        }
        return $discount;
    }
}
