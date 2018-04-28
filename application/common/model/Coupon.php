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
use app\common\logic\FlashSaleLogic;
use app\common\logic\GroupBuyLogic;

class Coupon extends Model
{
    public function goodsCoupon()
    {
        return $this->hasMany('GoodsCoupon','coupon_id','id');
    }
    public function store(){
        return $this->hasOne('Store','store_id','store_id');
    }

    /**
     * 是否快到期|一天间隔
     * @param $value
     * @param $data
     * @return mixed
     */
    public function getIsExpiringAttr($value,$data)
    {
        if (($data['use_end_time'] - time()) < (60 * 60 * 24 * 1)) {
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 是否到期
     * @param $value
     * @param $data
     * @return bool
     */
    public function getIsExpireAttr($value,$data){
        if ((time() - $data['use_end_time']) > 0) {
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 格式化时间
     * @param $value
     * @param $data
     * @return bool|string
     */
    public function getUseStartTimeFormatDotAttr($value,$data){
        return date('Y.m.d', $data['use_start_time']);
    }
    /**
     * 格式化时间
     * @param $value
     * @param $data
     * @return bool|string
     */
    public function getUseEndTimeFormatDotAttr($value,$data){
        return date('Y.m.d', $data['use_end_time']);
    }

    /**
     * 是否被领完
     * @param $value
     * @param $data
     * @return bool|string
     */
    public function getIsLeadEndAttr($value, $data)
    {
        if ($data['createnum'] <= $data['send_num'] && $data['createnum'] != 0) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * 使用范围描述：0全店通用1指定商品可用2指定分类商品可用
     * @param $value
     * @param $data
     * @return int
     */
    public function getUseTypeTitleAttr($value, $data)
    {
        if ($data['use_type'] == 1) {
            return '指定商品';
        } elseif($data['use_type'] == 2) {
            return '指定分类商品';
        }else{
            return '全店通用';
        }
    }
}
