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


namespace app\common\logic;
use think\Model;


/**
 * 拼单逻辑类
 */
class TeamFoundLogic extends Model
{
    protected $teamFound;//团长模型
    protected $team;//拼团模型
    /**
     * 设置拼团模型
     * @param $team
     */
    public function setTeam($team)
    {
        $this->team = $team;
    }
    /**
     * 设置团长模型
     * @param $teamFound
     */
    public function setTeamFound($teamFound)
    {
        $this->teamFound = $teamFound;
    }

    /**
     * 检查该单是否可以拼
     * @return array
     */
    public function TeamFoundIsCanFollow()
    {
        if($this->teamFound['team_id'] != $this->team['team_id']){
            return ['status' => 0, 'msg' => '该拼单数据不存在或已失效', 'result' => ''];
        }
        if($this->teamFound['join'] >= $this->teamFound['need']){
            return ['status' => 0, 'msg' => '该单已成功结束', 'result' => ''];
        }
        if(time() - $this->teamFound['found_time'] > $this->team['time_limit']){
            return ['status' => 0, 'msg' => '该拼单已过期', 'result' => ''];
        }
        return ['status' => 1, 'msg' => '能拼', 'result' => ''];
    }
}