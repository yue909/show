<?php

use think\Db;
// *  array转xmls
// */
function arrayToXml($arr){
    $xml = "<xml>";
    foreach ($arr as $key => $val) {
    if (is_numeric($val)) {
    $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
    } else
    $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
    }
    $xml .= "</xml>";
    return $xml;
}
// xml转array
function xmlToArray2($xml) {
    $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $array_data;
}
//get请求 返回json格式
function getHttp($url) {
    $ch=curl_init();
    //设置传输地址
    curl_setopt($ch, CURLOPT_URL, $url);
    //设置以文件流形式输出
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    //接收返回数据
    $data=curl_exec($ch);
    curl_close($ch);
    $jsonInfo=json_decode($data,true);
    return $jsonInfo;
}

//post请求
function postHttp($url,$json) {
    $ch=curl_init();
    //设置传输地址
    curl_setopt($ch, CURLOPT_URL, $url);
    //设置以文件流形式输出
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //设置已post方式请求
 	curl_setopt($ch, CURLOPT_POST, 1);
 	//设置post文件
	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $data=curl_exec($ch);
    curl_close($ch);
    $jsonInfo=json_decode($data,true);
    return $jsonInfo;

}

//get
function httpGet($url) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

//post
function httpPost($url, $data) {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_TIMEOUT, 50);
    // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
    // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_URL, $url);

    if ($data){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }

    $res = curl_exec($curl);
    curl_close($curl);

    return $res;
}

//短信接口
// function sendSMS($phone, $code) {
//     $ch = curl_init();
//     $req  = array(
//         'code' => 0,
//         'msg' => 'success'
//     );
//     // 必要参数
//     $apikey = C('_SMS_KEY_');
//     $mobile = $phone;
//     $text = str_replace("#code#", $code, C('_SMS_TPL_'));
//     // 发送短信
//     $data = array('text' => $text, 'apikey' => $apikey, 'mobile' => $mobile);
//     curl_setopt($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
//     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
//     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//     $json_data = curl_exec($ch);
//     //如果curl发生错误，返回错误
//     if(curl_error($ch) != ""){
//         $req  = array(
//             'code' => -1,
//             'msg' => 'Curl error: ' . curl_error($ch)
//         );
//         return $req;
//     }
//     //解析返回结果（json格式字符串）
//     $array = json_decode($json_data, true);
//     if ($array['code'] !== 0) {
//         $req = array(
//             'code' => $array['code'],
//             'msg' => $array['msg']
//         );
//         return $req;
//     } else {
//         return $req;
//     }
// }

//luosimao验证
function captchaVerified($response) {
    $url  = 'https://captcha.luosimao.com/api/site_verify';
    $data = array(
        // 'api_key'  => C('_LUOSIMAO_KEY_'),
        'api_key'  => '9a2bce2050022bf18e9e812a154ae205',
        'response' => $response
    );
    $req  = array(
        'code' => 0,
        'msg' => 'success'
    );
    $ch   = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $json_data = curl_exec($ch);
    //如果curl发生错误，返回错误
    if(curl_error($ch) != ""){
        $req  = array(
            'code' => -1,
            'msg' => 'Curl error：' . curl_error($ch)
        );
        return $req;
    }
    //解析返回结果（json格式字符串）
    $array = json_decode($json_data, true);
    if ($array['res'] == 'success') {
        return $req;
    } else {
        $req  = array(
            'code' => $array['error'],
            'msg' => $array['msg']
        );
        return $req;
    }
}

//jssdk
function wx_share_init($url) {
    $wxconfig = array();
    vendor('wxSDK.class#jssdk');
    $appid = C('_APPID_'); //appid
    $appsecret = C('_APPSECRET_'); //appsecret
    $jssdk = new JSSDK($appid, $appsecret, $url);
    $wxconfig = $jssdk->GetSignPackage();
    return $wxconfig;
}

//wx access_token
function wx_access_token() {
    $wxconfig = array();
    vendor('wxSDK.class#jssdk');
    $appid = C('_APPID_'); //appid
    $appsecret = C('_APPSECRET_'); //appsecret
    $jssdk = new JSSDK($appid, $appsecret, '');
    $token = $jssdk->getAccessToken();
    return $token;
}

//小程序解密
function wx_miniapp_decode($appid, $sessionKey, $encryptedData, $iv) {
    vendor('wxSDK.class#wxBizDataCrypt');
    $data = array();
    $pc = new WXBizDataCrypt($appid, $sessionKey);
    $code = $pc->decryptData($encryptedData, $iv, $data);
    $req = array(
        'code' => $code,
        'data' => $data
    );
    return $req;
}

//rc4加解密
function rc4_code($pwd, $data) {
    $key[] ="";
    $box[] ="";

    $pwd_length = strlen($pwd);
    $data_length = strlen($data);

    for ($i = 0; $i < 256; $i++)
    {
        $key[$i] = ord($pwd[$i % $pwd_length]);
        $box[$i] = $i;
    }

    for ($j = $i = 0; $i < 256; $i++)
    {
        $j = ($j + $box[$i] + $key[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $data_length; $i++)
    {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;

        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;

        $k = $box[(($box[$a] + $box[$j]) % 256)];
        $cipher .= chr(ord($data[$i]) ^ $k);
    }

    return $cipher;
}

//安全URL编码
function base64_encode_new($data) {
    return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode(serialize($data)));
}

//安全URL解码
function base64_decode_new($string) {
    $data = str_replace(array('-', '_'), array('+', '/'), $string);
    $mod4 = strlen($data) % 4;
    ($mod4) && $data .= substr('====', $mod4);
    return unserialize(base64_decode($data));
}

//rc4对称加密&base64编码
function rc4_base64_encode($str) {
    return base64_encode_new(rc4_code(C('CODE_KEY'), $str));
}

//rc4对称解密&base64解码
function rc4_base64_decode($str) {
    return rc4_code(C('CODE_KEY'), base64_decode_new($str));
}

/*//log记录
function __log($str) {
    $data = file_get_contents(__DIR__ . '/log.txt');
    file_put_contents(__DIR__ . '/log.txt', "====" . date('Y-m-d H:i:s', time()) . "====\n" .  $str . "\n\n" . $data);
}*/

//

//随机名称
function randName() {
    $nicheng_tou = array('快乐的','冷静的','醉熏的','潇洒的','糊涂的','积极的','冷酷的','深情的','粗暴的','温柔的','可爱的','愉快的','义气的','认真的','威武的','帅气的','传统的','潇洒的','漂亮的','自然的','专一的','听话的','昏睡的','狂野的','等待的','搞怪的','幽默的','魁梧的','活泼的','开心的','高兴的','超帅的','留胡子的','坦率的','直率的','轻松的','痴情的','完美的','精明的','无聊的','有魅力的','丰富的','繁荣的','饱满的','炙热的','暴躁的','碧蓝的','俊逸的','英勇的','健忘的','故意的','无心的','土豪的','朴实的','兴奋的','幸福的','淡定的','不安的','阔达的','孤独的','独特的','疯狂的','时尚的','落后的','风趣的','忧伤的','大胆的','爱笑的','矮小的','健康的','合适的','玩命的','沉默的','斯文的','香蕉','苹果','鲤鱼','鳗鱼','任性的','细心的','粗心的','大意的','甜甜的','酷酷的','健壮的','英俊的','霸气的','阳光的','默默的','大力的','孝顺的','忧虑的','着急的','紧张的','善良的','凶狠的','害怕的','重要的','危机的','欢喜的','欣慰的','满意的','跳跃的','诚心的','称心的','如意的','怡然的','娇气的','无奈的','无语的','激动的','愤怒的','美好的','感动的','激情的','激昂的','震动的','虚拟的','超级的','寒冷的','精明的','明理的','犹豫的','忧郁的','寂寞的','奋斗的','勤奋的','现代的','过时的','稳重的','热情的','含蓄的','开放的','无辜的','多情的','纯真的','拉长的','热心的','从容的','体贴的','风中的','曾经的','追寻的','儒雅的','优雅的','开朗的','外向的','内向的','清爽的','文艺的','长情的','平常的','单身的','伶俐的','高大的','懦弱的','柔弱的','爱笑的','乐观的','耍酷的','酷炫的','神勇的','年轻的','唠叨的','瘦瘦的','无情的','包容的','顺心的','畅快的','舒适的','靓丽的','负责的','背后的','简单的','谦让的','彩色的','缥缈的','欢呼的','生动的','复杂的','慈祥的','仁爱的','魔幻的','虚幻的','淡然的','受伤的','雪白的','高高的','糟糕的','顺利的','闪闪的','羞涩的','缓慢的','迅速的','优秀的','聪明的','含糊的','俏皮的','淡淡的','坚强的','平淡的','欣喜的','能干的','灵巧的','友好的','机智的','机灵的','正直的','谨慎的','俭朴的','殷勤的','虚心的','辛勤的','自觉的','无私的','无限的','踏实的','老实的','现实的','可靠的','务实的','拼搏的','个性的','粗犷的','活力的','成就的','勤劳的','单纯的','落寞的','朴素的','悲凉的','忧心的','洁净的','清秀的','自由的','小巧的','单薄的','贪玩的','刻苦的','干净的','壮观的','和谐的','文静的','调皮的','害羞的','安详的','自信的','端庄的','坚定的','美满的','舒心的','温暖的','专注的','勤恳的','美丽的','腼腆的','优美的','甜美的','甜蜜的','整齐的','动人的','典雅的','尊敬的','舒服的','妩媚的','秀丽的','喜悦的','甜美的','彪壮的','强健的','大方的','俊秀的','聪慧的','迷人的','陶醉的','悦耳的','动听的','明亮的','结实的','魁梧的','标致的','清脆的','敏感的','光亮的','大气的','老迟到的','知性的','冷傲的','呆萌的','野性的','隐形的','笑点低的','微笑的','笨笨的','难过的','沉静的','火星上的','失眠的','安静的','纯情的','要减肥的','迷路的','烂漫的','哭泣的','贤惠的','苗条的','温婉的','发嗲的','会撒娇的','贪玩的','执着的','眯眯眼的','花痴的','想人陪的','眼睛大的','高贵的','傲娇的','心灵美的','爱撒娇的','细腻的','天真的','怕黑的','感性的','飘逸的','怕孤独的','忐忑的','高挑的','傻傻的','冷艳的','爱听歌的','还单身的','怕孤单的','懵懂的');

    $nicheng_wei = array('嚓茶','凉面','便当','毛豆','花生','可乐','灯泡','哈密瓜','野狼','背包','眼神','缘分','雪碧','人生','牛排','蚂蚁','飞鸟','灰狼','斑马','汉堡','悟空','巨人','绿茶','自行车','保温杯','大碗','墨镜','魔镜','煎饼','月饼','月亮','星星','芝麻','啤酒','玫瑰','大叔','小伙','哈密瓜，数据线','太阳','树叶','芹菜','黄蜂','蜜粉','蜜蜂','信封','西装','外套','裙子','大象','猫咪','母鸡','路灯','蓝天','白云','星月','彩虹','微笑','摩托','板栗','高山','大地','大树','电灯胆','砖头','楼房','水池','鸡翅','蜻蜓','红牛','咖啡','机器猫','枕头','大船','诺言','钢笔','刺猬','天空','飞机','大炮','冬天','洋葱','春天','夏天','秋天','冬日','航空','毛衣','豌豆','黑米','玉米','眼睛','老鼠','白羊','帅哥','美女','季节','鲜花','服饰','裙子','白开水','秀发','大山','火车','汽车','歌曲','舞蹈','老师','导师','方盒','大米','麦片','水杯','水壶','手套','鞋子','自行车','鼠标','手机','电脑','书本','奇迹','身影','香烟','夕阳','台灯','宝贝','未来','皮带','钥匙','心锁','故事','花瓣','滑板','画笔','画板','学姐','店员','电源','饼干','宝马','过客','大白','时光','石头','钻石','河马','犀牛','西牛','绿草','抽屉','柜子','往事','寒风','路人','橘子','耳机','鸵鸟','朋友','苗条','铅笔','钢笔','硬币','热狗','大侠','御姐','萝莉','毛巾','期待','盼望','白昼','黑夜','大门','黑裤','钢铁侠','哑铃','板凳','枫叶','荷花','乌龟','仙人掌','衬衫','大神','草丛','早晨','心情','茉莉','流沙','蜗牛','战斗机','冥王星','猎豹','棒球','篮球','乐曲','电话','网络','世界','中心','鱼','鸡','狗','老虎','鸭子','雨','羽毛','翅膀','外套','火','丝袜','书包','钢笔','冷风','八宝粥','烤鸡','大雁','音响','招牌','胡萝卜','冰棍','帽子','菠萝','蛋挞','香水','泥猴桃','吐司','溪流','黄豆','樱桃','小鸽子','小蝴蝶','爆米花','花卷','小鸭子','小海豚','日记本','小熊猫','小懒猪','小懒虫','荔枝','镜子','曲奇','金针菇','小松鼠','小虾米','酒窝','紫菜','金鱼','柚子','果汁','百褶裙','项链','帆布鞋','火龙果','奇异果','煎蛋','唇彩','小土豆','高跟鞋','戒指','雪糕','睫毛','铃铛','手链','香氛','红酒','月光','酸奶','银耳汤','咖啡豆','小蜜蜂','小蚂蚁','蜡烛','棉花糖','向日葵','水蜜桃','小蝴蝶','小刺猬','小丸子','指甲油','康乃馨','糖豆','薯片','口红','超短裙','乌冬面','冰淇淋','棒棒糖','长颈鹿','豆芽','发箍','发卡','发夹','发带','铃铛','小馒头','小笼包','小甜瓜','冬瓜','香菇','小兔子','含羞草','短靴','睫毛膏','小蘑菇','跳跳糖','小白菜','草莓','柠檬','月饼','百合','纸鹤','小天鹅','云朵','芒果','面包','海燕','小猫咪','龙猫','唇膏','鞋垫','羊','黑猫','白猫','万宝路','金毛','山水','音响');

    $tou_num = rand(0,331);

    $wei_num = rand(0,325);

    $nicheng = $nicheng_tou[$tou_num].$nicheng_wei[$wei_num];

    return $nicheng;
}

//元转分
function yuanToFen($i) {
    return $i * 100;
}

//分转元
function fenToYuan($i) {
    return intval($i);
    //return number_format(intval($i) / 100, 2, '.', '');
}

//元转分
function admin_yuanToFen($i) {
    return $i * 100;
}

//分转元
function admin_fenToYuan($i) {
    return number_format(intval($i) / 100, 2, '.', '');
}

//毫转元
function haoToYuan($i) {
    return number_format(intval($i) / 10000, 4, '.', '');
}

//版权声明
function copyrightNotice() {
    $html = '
    <link rel="stylesheet" type="text/css" href="https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/common/css/qqalert.css">
    <div style="font-size: 10px;color: #717171;padding-top: 18px;position: initial;padding-bottom: 18px;">
        <center>版权声明：本文源于网络，版权归原作者所有，如侵权请<span style="color: #55b2fd;" onclick="contactUs()">联系我们</span>删除</center>
    </div>
    <script>
        function contactUs() {
            alertQQUI("客服QQ号码：2195635021", "联系我们", "", "");
        }
        function alertQQUI(i,e,t,d){var l=document.getElementById("ui-dialog");return e=e||"温馨提示",i=i||"",d=d||"确定",null==l&&document.body.insertAdjacentHTML("beforeEnd",\'<div id="ui-dialog"><div class="ui-dialog show"><div class="ui-dialog-cnt" id="qq-alert"><div style="position: absolute;top: 2%;width: 25px;height: 25px;background: url(https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/common/close.png);background-size: contain;right: 1%;z-index: 99;" onclick="$(' . "\'#ui-dialog\'" . ').hide();"></div><header class="ui-dialog-hd ui-border-b"></header><div class="ui-dialog-bd"></div><div class="ui-dialog-ft"><button class="qq-button" type="button" data-role="button"></button></div></div></div><div>\'),l=document.getElementById("ui-dialog"),l.querySelectorAll(".ui-dialog-hd")[0].innerHTML=e,l.querySelectorAll(".ui-dialog-bd")[0].innerHTML=i,l.querySelectorAll(".qq-button")[0].innerHTML=d,l.querySelectorAll(".qq-button")[0].onclick=function(){l.style.display="none","function"==typeof t&&t()},l.style.display="block",!1}
    </script>
    ';
    return $html;
}

//虚拟数据
function virtualenlightening()
{
    //获取今天时间时间戳
    $beginToday = mktime(0,0,0,date('m'),date('d'),date('Y'));
    //虚拟数据数组
    $virtual = array(
        ['username' => "九卿臣",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515679013810257.jpg",
        'count' => 446,
        'money_total' => '4758369',
        'time' => 1515641740
        ],
        ['username' => "孤央",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515640298.jpg",
        'count' => 408,
        'money_total' => '3974890',
        'time' => 1515641740
        ],
        ['username' => "青冘",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515679013528597.jpg",
        'count' => 401,
        'money_total' => '3970067',
        'time' => 1515641740
        ],
        ['username' => "沉秋",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515661088783319.jpg",
        'count' => 378,
        'money_total' => '3894578',
        'time' => 1515641740
        ],
        ['username' => "酒自斟",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515679014767868.jpg",
        'count' => 359,
        'money_total' => '3547320',
        'time' => 1515641740
        ],
        ['username' => "孤傲王者",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515679014690028.jpg",
        'count' => 309,
        'money_total' => '3079742',
        'time' => 1515641740
        ],
        ['username' => "孤独",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515661089136325.jpg",
        'count' => 290,
        'money_total' => '2889455',
        'time' => 1515641740
        ],
        ['username' => "小芳",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515679013424602.jpg",
        'count' => 242,
        'money_total' => '2437579',
        'time' => 1515641740
        ],
        ['username' => "特里斯",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515661088197444.jpg",
        'count' => 167,
        'money_total' => '1597864',
        'time' => 1515641740
        ],
        ['username' => "卡戴珊",
        'avatar' => "https://new-weizhuan.oss-cn-shenzhen.aliyuncs.com/ueditor/1515661088253267.jpg",
        'count' => 129,
        'money_total' => '1304576',
        'time' => 1515641740
        ]
    );
    foreach ($virtual as $key => $value) {
        $virtual[$key]['count'] = intval(($beginToday - $value['time']) / 84600) * 3 + $virtual[$key]['count'];
        $virtual[$key]['money_total'] = intval(($beginToday - $value['time']) / 84600) * 333  + $virtual[$key]['money_total'];
    }
    return $virtual;
}

/*
 *content: 根据数组某个字段进行排序
 * $arr    需要排序的数组
 * $field  数组里的某个字段
 * sort    1为正序排序  2为倒序排序
 * time :  2016年12月21日19:02:33
*/
function f_order($arr,$field,$sort){
    $order = array();
    foreach($arr as $kay => $value){
        $order[] = $value[$field];
    }
    if($sort==1){
        array_multisort($order,SORT_ASC,$arr);
    }else{
        array_multisort($order,SORT_DESC,$arr);
    }
    return $arr;
}


function geturl($id)
{
	if ($id) {
		$geturl = \think\Db::name("attachment")->where(['id' => $id])->find();
		if($geturl['status'] == 1) {
			//审核通过
			return $geturl['filepath'];
		} elseif($geturl['status'] == 0) {
			//待审核
			return '/uploads/xitong/beiyong1.jpg';
		} else {
			//不通过
			return '/uploads/xitong/beiyong2.jpg';
		} 
    }
    return false;
}


/**
 * [SendMail 邮件发送]
 * @param [type] $address  [description]
 * @param [type] $title    [description]
 * @param [type] $message  [description]
 * @param [type] $from     [description]
 * @param [type] $fromname [description]
 * @param [type] $smtp     [description]
 * @param [type] $username [description]
 * @param [type] $password [description]
 */
function SendMail($address)
{
    vendor('phpmailer.PHPMailerAutoload');
    //vendor('PHPMailer.class#PHPMailer');
    $mail = new \PHPMailer();          
     // 设置PHPMailer使用SMTP服务器发送Email
    $mail->IsSMTP();                
    // 设置邮件的字符编码，若不指定，则为'UTF-8'
    $mail->CharSet='UTF-8';         
    // 添加收件人地址，可以多次使用来添加多个收件人
    $mail->AddAddress($address); 

    $data = \think\Db::name('emailconfig')->where('email','email')->find();
            $title = $data['title'];
            $message = $data['content'];
            $from = $data['from_email'];
            $fromname = $data['from_name'];
            $smtp = $data['smtp'];
            $username = $data['username'];
            $password = $data['password'];   
    // 设置邮件正文
    $mail->Body=$message;           
    // 设置邮件头的From字段。
    $mail->From=$from;  
    // 设置发件人名字
    $mail->FromName=$fromname;  
    // 设置邮件标题
    $mail->Subject=$title;          
    // 设置SMTP服务器。
    $mail->Host=$smtp;
    // 设置为"需要验证" ThinkPHP 的config方法读取配置文件
    $mail->SMTPAuth=true;
    //设置html发送格式
    $mail->isHTML(true);           
    // 设置用户名和密码。
    $mail->Username=$username;
    $mail->Password=$password; 
    // 发送邮件。
    return($mail->Send());
}


/**
 * 阿里大鱼短信发送
 * @param [type] $appkey    [description]
 * @param [type] $secretKey [description]
 * @param [type] $type      [description]
 * @param [type] $name      [description]
 * @param [type] $param     [description]
 * @param [type] $phone     [description]
 * @param [type] $code      [description]
 * @param [type] $data      [description]
 */
function SendSms($param,$phone)
{
    // 配置信息
    import('dayu.top.TopClient');
    import('dayu.top.TopLogger');
    import('dayu.top.request.AlibabaAliqinFcSmsNumSendRequest');
    import('dayu.top.ResultSet');
    import('dayu.top.RequestCheckUtil');

    //获取短信配置
    $data = \think\Db::name('smsconfig')->where('sms','sms')->find();
            $appkey = $data['appkey'];
            $secretkey = $data['secretkey'];
            $type = $data['type'];
            $name = $data['name'];
            $code = $data['code'];
    
    $c = new \TopClient();
    $c ->appkey = $appkey;
    $c ->secretKey = $secretkey;
    
    $req = new \AlibabaAliqinFcSmsNumSendRequest();
    //公共回传参数，在“消息返回”中会透传回该参数。非必须
    $req ->setExtend("");
    //短信类型，传入值请填写normal
    $req ->setSmsType($type);
    //短信签名，传入的短信签名必须是在阿里大于“管理中心-验证码/短信通知/推广短信-配置短信签名”中的可用签名。
    $req ->setSmsFreeSignName($name);
    //短信模板变量，传参规则{"key":"value"}，key的名字须和申请模板中的变量名一致，多个变量之间以逗号隔开。
    $req ->setSmsParam($param);
    //短信接收号码。支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，一次调用最多传入200个号码。
    $req ->setRecNum($phone);
    //短信模板ID，传入的模板必须是在阿里大于“管理中心-短信模板管理”中的可用模板。
    $req ->setSmsTemplateCode($code);
    //发送
    

    $resp = $c ->execute($req);
}


/**
 * 替换手机号码中间四位数字
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function hide_phone($str){
    $resstr = substr_replace($str,'****',3,4);  
    return $resstr;  
}




/**
 * tpshop
 * ============================================================================
 * 网站地址: http://www.showoow.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用 .
 * 不允许对程序代码以任何形式任何目的的再发布。
 * 采用TP5助手函数可实现单字母函数db等,也可Db::name方式,可双向兼容
 */
/**
 * tpshop检验登陆
 * @param
 * @return bool
 */
function is_login(){
    if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0){
        return $_SESSION['admin_id'];
    }else{
        return false;
    }
}
/**
 * 获取用户信息
 * @param $user_id_or_name  用户id 邮箱 手机 第三方id
 * @param int $type  类型 0 user_id查找 1 邮箱查找 2 手机查找 3 第三方唯一标识查找
 * @param string $oauth  第三方来源
 * @return mixed
 */
function get_user_info($user_id_or_name, $type = 0, $oauth = '')
{
   
    $map = array();
    if ($type == 0)
        $map['user_id'] = $user_id_or_name;
    if ($type == 1)
        $map['email'] = $user_id_or_name;
    if ($type == 2)
        $map['mobile'] = $user_id_or_name;
    
    if ($type == 3 || $type == 4) {
            //获取用户信息
            $column = ($type ==3) ? 'openid' : 'unionid';
            $thirdUser = M('OauthUsers')->where([$column=>$user_id_or_name, 'oauth'=>$oauth])->find();
            $map['user_id'] = $thirdUser['user_id'];
     }    
    $user = Db::name('user')->where($map)->find();
    return $user;
}

/**
 * 更新会员等级,折扣，消费总额
 * @param $user_id  用户ID
 * @return boolean
 */
function update_user_level($user_id){
    $level_info = Db::name('user_level')->order('level_id')->select();
    $total_amount = Db::name('order')->master()->where("user_id=:user_id AND pay_status=1 and order_status not in (3,5)")->bind(['user_id'=>$user_id])->sum('order_amount+user_money');
    if($level_info){
        foreach($level_info as $k=>$v){
            if($total_amount >= $v['amount']){
                $level = $level_info[$k]['level_id'];
                $discount = $level_info[$k]['discount']/100;
            }
        }
        $user = session('user');
        $updata['total_amount'] = $total_amount;//更新累计修复额度
        //累计额度达到新等级，更新会员折扣
        if(isset($level) && $level>$user['level']){
            $updata['level'] = $level;
            $updata['discount'] = $discount;
        }
        Db::name('user')->where("user_id", $user_id)->save($updata);
    }
}

/**
 *  商品缩略图 给于标签调用 拿出商品表的 original_img 原始图来裁切出来的
 * @param type $goods_id  商品id
 * @param type $width     生成缩略图的宽度
 * @param type $height    生成缩略图的高度
 */
function goods_thum_images($goods_id, $width, $height)
{
    if (empty($goods_id)) return '';
    
    //判断缩略图是否存在
    $path = "public/upload/goods/thumb/$goods_id/";
    $goods_thumb_name = "goods_thumb_{$goods_id}_{$width}_{$height}";

    // 这个商品 已经生成过这个比例的图片就直接返回了
    if (is_file($path . $goods_thumb_name . '.jpg')) return '/' . $path . $goods_thumb_name . '.jpg';
    if (is_file($path . $goods_thumb_name . '.jpeg')) return '/' . $path . $goods_thumb_name . '.jpeg';
    if (is_file($path . $goods_thumb_name . '.gif')) return '/' . $path . $goods_thumb_name . '.gif';
    if (is_file($path . $goods_thumb_name . '.png')) return '/' . $path . $goods_thumb_name . '.png';

    $original_img = M('Goods')->cache(true, 3600)->where("goods_id", $goods_id)->value('original_img');
    if (empty($original_img)) {
        return '/public/images/icon_goods_thumb_empty_300.png';
    }
    
    $ossClient = new \app\common\logic\OssLogic;
    if (($ossUrl = $ossClient->getGoodsThumbImageUrl($original_img, $width, $height))) {
        return $ossUrl;
    }

    $original_img = '.' . $original_img; // 相对路径
    if (!is_file($original_img)) {
        return '/public/images/icon_goods_thumb_empty_300.png';
    }

    try {
        vendor('topthink.think-image.src.Image');
        if(strstr(strtolower($original_img),'.gif'))
        {
                vendor('topthink.think-image.src.image.gif.Encoder');
                vendor('topthink.think-image.src.image.gif.Decoder');
                vendor('topthink.think-image.src.image.gif.Gif');               
        }           
        $image = \think\Image::open($original_img);

        $goods_thumb_name = $goods_thumb_name . '.' . $image->type();
        // 生成缩略图
        !is_dir($path) && mkdir($path, 0777, true);
        // 参考文章 http://www.mb5u.com/biancheng/php/php_84533.html  改动参考 http://www.thinkphp.cn/topic/13542.html
        $image->thumb($width, $height, 2)->save($path . $goods_thumb_name, NULL, 100); //按照原图的比例生成一个最大为$width*$height的缩略图并保存
        //图片水印处理
        $water = tpCache('water');
        if ($water['is_mark'] == 1) {
            $imgresource = './' . $path . $goods_thumb_name;
            if ($width > $water['mark_width'] && $height > $water['mark_height']) {
                if ($water['mark_type'] == 'img') {
                    //检查水印图片是否存在
                    $waterPath = "." . $water['mark_img'];
                    if (is_file($waterPath)) {
                        $quality = $water['mark_quality'] ?: 80;
                        $waterTempPath = dirname($waterPath).'/temp_'.basename($waterPath);
                        $image->open($waterPath)->save($waterTempPath, null, $quality);
                        $image->open($imgresource)->water($waterTempPath, $water['sel'], $water['mark_degree'])->save($imgresource);
                        @unlink($waterTempPath);
                    }
                } else {
                    //检查字体文件是否存在,注意是否有字体文件
                    $ttf = './hgzb.ttf';
                    if (file_exists($ttf)) {
                        $size = $water['mark_txt_size'] ?: 30;
                        $color = $water['mark_txt_color'] ?: '#000000';
                        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
                            $color = '#000000';
                        }
                        $transparency = intval((100 - $water['mark_degree']) * (127/100));
                        $color .= dechex($transparency);
                        $image->open($imgresource)->text($water['mark_txt'], $ttf, $size, $color, $water['sel'])->save($imgresource);
                    }
                }
            }
        }
        $img_url = '/' . $path . $goods_thumb_name;

        return $img_url;
    } catch (think\Exception $e) {

        return $original_img;
    }
}

/**
 * 商品相册缩略图
 */
function get_sub_images($sub_img, $goods_id, $width, $height)
{
    //判断缩略图是否存在
    $path = "public/upload/goods/thumb/$goods_id/";
    $goods_thumb_name = "goods_sub_thumb_{$sub_img['img_id']}_{$width}_{$height}";
    
    //这个缩略图 已经生成过这个比例的图片就直接返回了
    if (is_file($path . $goods_thumb_name . '.jpg')) return '/' . $path . $goods_thumb_name . '.jpg';
    if (is_file($path . $goods_thumb_name . '.jpeg')) return '/' . $path . $goods_thumb_name . '.jpeg';
    if (is_file($path . $goods_thumb_name . '.gif')) return '/' . $path . $goods_thumb_name . '.gif';
    if (is_file($path . $goods_thumb_name . '.png')) return '/' . $path . $goods_thumb_name . '.png';

    $ossClient = new \app\common\logic\OssLogic;
    if (($ossUrl = $ossClient->getGoodsAlbumThumbUrl($sub_img['image_url'], $width, $height))) {
        return $ossUrl;
    }
    
    $original_img = '.' . $sub_img['image_url']; //相对路径
    if (!is_file($original_img)) {
        return '/public/images/icon_goods_thumb_empty_300.png';
    }

    try {
        vendor('topthink.think-image.src.Image');
        if(strstr(strtolower($original_img),'.gif'))
        {
            vendor('topthink.think-image.src.image.gif.Encoder');
            vendor('topthink.think-image.src.image.gif.Decoder');
            vendor('topthink.think-image.src.image.gif.Gif');
        }
        $image = \think\Image::open($original_img);

        $goods_thumb_name = $goods_thumb_name . '.' . $image->type();
        // 生成缩略图
        !is_dir($path) && mkdir($path, 0777, true);
        // 参考文章 http://www.mb5u.com/biancheng/php/php_84533.html  改动参考 http://www.thinkphp.cn/topic/13542.html
        $image->thumb($width, $height, 2)->save($path . $goods_thumb_name, NULL, 100); //按照原图的比例生成一个最大为$width*$height的缩略图并保存
        //图片水印处理
        $water = tpCache('water');
        if ($water['is_mark'] == 1) {
            $imgresource = './' . $path . $goods_thumb_name;
            if ($width > $water['mark_width'] && $height > $water['mark_height']) {
                if ($water['mark_type'] == 'img') {
                    //检查水印图片是否存在
                    $waterPath = "." . $water['mark_img'];
                    if (is_file($waterPath)) {
                        $quality = $water['mark_quality'] ?: 80;
                        $waterTempPath = dirname($waterPath).'/temp_'.basename($waterPath);
                        $image->open($waterPath)->save($waterTempPath, null, $quality);
                        $image->open($imgresource)->water($waterTempPath, $water['sel'], $water['mark_degree'])->save($imgresource);
                        @unlink($waterTempPath);
                    }
                } else {
                    //检查字体文件是否存在,注意是否有字体文件
                    $ttf = './hgzb.ttf';
                    if (file_exists($ttf)) {
                        $size = $water['mark_txt_size'] ?: 30;
                        $color = $water['mark_txt_color'] ?: '#000000';
                        if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color)) {
                            $color = '#000000';
                        }
                        $transparency = intval((100 - $water['mark_degree']) * (127/100));
                        $color .= dechex($transparency);
                        $image->open($imgresource)->text($water['mark_txt'], $ttf, $size, $color, $water['sel'])->save($imgresource);
                    }
                }
            }
        }
        $img_url = '/' . $path . $goods_thumb_name;

        return $img_url;
    } catch (think\Exception $e) {

        return $original_img;
    }
}

/**
 * 刷新商品库存, 如果商品有设置规格库存, 则商品总库存 等于 所有规格库存相加
 * @param type $goods_id  商品id
 */
function refresh_stock($goods_id){
    $count = Db::name("SpecGoodsPrice")->where("goods_id", $goods_id)->count();
    if($count == 0) return false; // 没有使用规格方式 没必要更改总库存

    $store_count = Db::name("SpecGoodsPrice")->where("goods_id", $goods_id)->sum('store_count');
    Db::name("Goods")->where("goods_id", $goods_id)->save(array('store_count'=>$store_count)); // 更新商品的总库存
}

/**
 * 根据 order_goods 表扣除商品库存
 * @param $order|订单对象或者数组
 * @throws \think\Exception
 */
function minus_stock($order){
    $orderGoodsArr = Db::name('OrderGoods')->master()->where("order_id", $order['order_id'])->select();
    foreach($orderGoodsArr as $key => $val)
    {
        // 有选择规格的商品
        if(!empty($val['spec_key']))
        {   // 先到规格表里面扣除数量 再重新刷新一个 这件商品的总数量
            $SpecGoodsPrice = new \app\common\model\SpecGoodsPrice();
            $specGoodsPrice = $SpecGoodsPrice::get(['goods_id' => $val['goods_id'], 'key' => $val['spec_key']]);
            $specGoodsPrice->where(['goods_id' => $val['goods_id'], 'key' => $val['spec_key']])->setDec('store_count', $val['goods_num']);
            refresh_stock($val['goods_id']);
        }else{
            $specGoodsPrice = null;
            Db::name('Goods')->where("goods_id", $val['goods_id'])->setDec('store_count',$val['goods_num']); // 直接扣除商品总数量
        }
        Db::name('Goods')->where("goods_id", $val['goods_id'])->setInc('sales_sum',$val['goods_num']); // 增加商品销售量
        //更新活动商品购买量
        if ($val['prom_type'] == 1 || $val['prom_type'] == 2) {
            $GoodsPromFactory = new \app\common\logic\GoodsPromFactory();
            $goodsPromLogic = $GoodsPromFactory->makeModule($val, $specGoodsPrice);
            $prom = $goodsPromLogic->getPromModel();
            if ($prom['is_end'] == 0) {
                $tb = $val['prom_type'] == 1 ? 'flash_sale' : 'group_buy';
                Db::name($tb)->where("id", $val['prom_id'])->setInc('buy_num', $val['goods_num']);
                Db::name($tb)->where("id", $val['prom_id'])->setInc('order_num');
            }
        }
    }
}

/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject   邮件标题
 * @param string $content   邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to,$subject='',$content=''){
    vendor('phpmailer.PHPMailerAutoload'); ////require_once vendor/phpmailer/PHPMailerAutoload.php';
    //判断openssl是否开启
    $openssl_funcs = get_extension_funcs('openssl');
    if(!$openssl_funcs){
        return array('status'=>-1 , 'msg'=>'请先开启openssl扩展');
    }
    $mail = new PHPMailer;
    $config = tpCache('smtp');
    $mail->CharSet  = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //调试输出格式
    //$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp_server'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];

    if($mail->Port == 465) $mail->SMTPSecure = 'ssl';// 使用安全协议
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //用户名
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if(is_array($to)){
        foreach ($to as $v){
            $mail->addAddress($v);
        }
    }else{
        $mail->addAddress($to);
    }

    $mail->isHTML(true);// send as HTML
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';
    //添加附件
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    if (!$mail->send()) {
        return array('status'=>-1 , 'msg'=>'发送失败: '.$mail->ErrorInfo);
    } else {
        return array('status'=>1 , 'msg'=>'发送成功');
    }
}

/**
 * 检测是否能够发送短信
 * @param unknown $scene
 * @return multitype:number string
 */
function checkEnableSendSms($scene)
{

    $scenes = config('SEND_SCENE');
    $sceneItem = $scenes[$scene];
    if (!$sceneItem) {
        return array("status" => -1, "msg" => "场景参数'scene'错误!");
    }
    $key = $sceneItem[2];
    $sceneName = $sceneItem[0];
    $config = tpCache('sms');
    $smsEnable = $config[$key];

    if (!$smsEnable) {
        return array("status" => -1, "msg" => "['$sceneName']发送短信被关闭'");
    }
    //判断是否添加"注册模板"
    $size = Db::name('sms_template')->where("send_scene", $scene)->count('tpl_id');
    if (!$size) {
        return array("status" => -1, "msg" => "请先添加['$sceneName']短信模板");
    }

    return array("status"=>1,"msg"=>"可以发送短信");
}

// /**
//  * 发送短信逻辑
//  * @param unknown $scene
//  */
// function sendSms($scene, $sender, $params,$unique_id=0)
// {
//     $smsLogic = new \app\common\logic\SmsLogic;
//     return $smsLogic->sendSms($scene, $sender, $params, $unique_id);
// }

/**
 * 查询快递
 * @param $postcom  快递公司编码
 * @param $getNu  快递单号
 * @return array  物流跟踪信息数组
 */
function queryExpress($postcom , $getNu) {
    /*    $url = "http://wap.kuaidi100.com/wap_result.jsp?rand=".time()."&id={$postcom}&fromWeb=null&postid={$getNu}";
        //$resp = httpRequest($url,'GET');
        $resp = file_get_contents($url);
        if (empty($resp)) {
            return array('status'=>0, 'message'=>'物流公司网络异常，请稍后查询');
        }
        preg_match_all('/\\<p\\>&middot;(.*)\\<\\/p\\>/U', $resp, $arr);
        if (!isset($arr[1])) {
            return array( 'status'=>0, 'message'=>'查询失败，参数有误' );
        }else{
            foreach ($arr[1] as $key => $value) {
                $a = array();
                $a = explode('<br /> ', $value);
                $data[$key]['time'] = $a[0];
                $data[$key]['context'] = $a[1];
            }
            return array( 'status'=>1, 'message'=>'1','data'=> array_reverse($data));
        }*/
    $url = "https://m.kuaidi100.com/query?type=".$postcom."&postid=".$getNu."&id=1&valicode=&temp=0.49738534969422676";
    $resp = httpRequest($url,"GET");
    return json_decode($resp,true);
}

/**
 * 获取某个商品分类的 儿子 孙子  重子重孙 的 id
 * @param type $cat_id
 */
// function getCatGrandson ($cat_id)
// {
//     $GLOBALS['catGrandson'] = array();
//     $GLOBALS['category_id_arr'] = array();
//     // 先把自己的id 保存起来
//     $GLOBALS['catGrandson'][] = $cat_id;
//     // 把整张表找出来
//     $GLOBALS['category_id_arr'] = Db::name('GoodsCategory')->cache(true,TPSHOP_CACHE_TIME)->value('id,parent_id');
//     // 先把所有儿子找出来
//     $son_id_arr = Db::name('GoodsCategory')->where("parent_id", $cat_id)->cache(true,TPSHOP_CACHE_TIME)->value('id',true);
//     foreach($son_id_arr as $k => $v)
//     {
//         getCatGrandson2($v);
//     }
//     return $GLOBALS['catGrandson'];
// }

/**
 * 获取某个文章分类的 儿子 孙子  重子重孙 的 id
 * @param type $cat_id
 */
// function getArticleCatGrandson ($cat_id)
// {
//     $GLOBALS['ArticleCatGrandson'] = array();
//     $GLOBALS['cat_id_arr'] = array();
//     // 先把自己的id 保存起来
//     $GLOBALS['ArticleCatGrandson'][] = $cat_id;
//     // 把整张表找出来
//     $GLOBALS['cat_id_arr'] = Db::name('ArticleCat')->value('cat_id,parent_id');
//     // 先把所有儿子找出来
//     $son_id_arr = Db::name('ArticleCat')->where("parent_id", $cat_id)->value('cat_id',true);
//     foreach($son_id_arr as $k => $v)
//     {
//         getArticleCatGrandson2($v);
//     }
//     return $GLOBALS['ArticleCatGrandson'];
// }

/**
 * 递归调用找到 重子重孙
 * @param type $cat_id
 */
// function getCatGrandson2($cat_id)
// {
//     $GLOBALS['catGrandson'][] = $cat_id;
//     foreach($GLOBALS['category_id_arr'] as $k => $v)
//     {
//         // 找到孙子
//         if($v == $cat_id)
//         {
//             getCatGrandson2($k); // 继续找孙子
//         }
//     }
// }


/**
 * 递归调用找到 重子重孙
 * @param type $cat_id
 */
// function getArticleCatGrandson2($cat_id)
// {
//     $GLOBALS['ArticleCatGrandson'][] = $cat_id;
//     foreach($GLOBALS['cat_id_arr'] as $k => $v)
//     {
//         // 找到孙子
//         if($v == $cat_id)
//         {
//             getArticleCatGrandson2($k); // 继续找孙子
//         }
//     }
// }

/**
 * 查看某个用户购物车中商品的数量
 * @param type $user_id
 * @param type $session_id
 * @return type 购买数量
 */
// function cart_goods_num($user_id = 0,$session_id = '')
// {
// //    $where = " session_id = '$session_id' ";
// //    $user_id && $where .= " or user_id = $user_id ";
//     // 查找购物车数量
// //    $cart_count =  M('Cart')->where($where)->sum('goods_num');
//     $cart_count = Db::name('cart')->where(function ($query) use ($user_id, $session_id) {
//         $query->where('session_id', $session_id);
//         if ($user_id) {
//             $query->whereOr('user_id', $user_id);
//         }
//     })->sum('goods_num');
//     $cart_count = $cart_count ? $cart_count : 0;
//     return $cart_count;
// }

/**
 * 获取商品库存
 * @param type $goods_id 商品id
 * @param type $key  库存 key
 */
function getGoodNum($goods_id,$key)
{
     if (!empty($key)){
        return Db::name("SpecGoodsPrice")
                        ->alias("s")
                        ->join('_Goods_ g ','s.goods_id = g.goods_id','LEFT')
                        ->where(['g.goods_id' => $goods_id, 'key' => $key ,"is_on_sale"=>1])->value('s.store_count');
    }else{ 
        return Db::name("Goods")->where(array("goods_id"=>$goods_id , "is_on_sale"=>1))->value('store_count');
    }
}

/**
 * 获取缓存或者更新缓存
 * @param string $config_key 缓存文件名称
 * @param array $data 缓存数据  array('k1'=>'v1','k2'=>'v3')
 * @return array or string or bool
 */
// function tpCache($config_key,$data = array()){
//     $param = explode('.', $config_key);
//     if(empty($data)){
//         //如$config_key=shop_info则获取网站信息数组
//         //如$config_key=shop_info.logo则获取网站logo字符串
//         $config = F($param[0],'',TEMP_PATH);//直接获取缓存文件
//         if(empty($config)){
//             //缓存文件不存在就读取数据库
//             $res = D('config')->where("inc_type",$param[0])->select();
//             if($res){
//                 foreach($res as $k=>$val){
//                     $config[$val['name']] = $val['value'];
//                 }
//                 F($param[0],$config,TEMP_PATH);
//             }
//         }
//         if(count($param)>1){
//             return $config[$param[1]];
//         }else{
//             return $config;
//         }
//     }else{
//         //更新缓存
//         $result =  D('config')->where("inc_type", $param[0])->select();
//         if($result){
//             foreach($result as $val){
//                 $temp[$val['name']] = $val['value'];
//             }
//             foreach ($data as $k=>$v){
//                 $newArr = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
//                 if(!isset($temp[$k])){
//                     M('config')->add($newArr);//新key数据插入数据库
//                 }else{
//                     if($v!=$temp[$k])
//                         M('config')->where("name", $k)->save($newArr);//缓存key存在且值有变更新此项
//                 }
//             }
//             //更新后的数据库记录
//             $newRes = D('config')->where("inc_type", $param[0])->select();
//             foreach ($newRes as $rs){
//                 $newData[$rs['name']] = $rs['value'];
//             }
//         }else{
//             foreach($data as $k=>$v){
//                 $newArr[] = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
//             }
//             M('config')->insertAll($newArr);
//             $newData = $data;
//         }
//         return F($param[0],$newData,TEMP_PATH);
//     }
// }

/**
 * 记录帐户变动
 * @param   int     $user_id        用户id
 * @param   float   $user_money     可用余额变动
 * @param   int     $pay_points     消费积分变动
 * @param   string  $desc    变动说明
 * @param   float   distribut_money 分佣金额
 * @param int $order_id 订单id
 * @param string $order_sn 订单sn
 * @return  bool
 */
// function accountLog($user_id, $user_money = 0,$pay_points = 0, $desc = '',$distribut_money = 0,$order_id = 0 ,$order_sn = ''){
//     /* 插入帐户变动记录 */
//     $account_log = array(
//         'user_id'       => $user_id,
//         'user_money'    => $user_money,
//         'pay_points'    => $pay_points,
//         'change_time'   => time(),
//         'desc'   => $desc,
//         'order_id' => $order_id,
//         'order_sn' => $order_sn
//     );
//     /* 更新用户信息 */
// //    $sql = "UPDATE __PREFIX__users SET user_money = user_money + $user_money," .
// //        " pay_points = pay_points + $pay_points, distribut_money = distribut_money + $distribut_money WHERE user_id = $user_id";
//     $update_data = array(
//         'user_money'        => ['exp','user_money+'.$user_money],
//         'pay_points'        => ['exp','pay_points+'.$pay_points],
//         'distribut_money'   => ['exp','distribut_money+'.$distribut_money],
//     );
//     if(($user_money+$pay_points+$distribut_money) == 0)
//         return false;
//     $update = Db::name('users')->where('user_id',$user_id)->update($update_data);
//     if($update){
//         Db::name('account_log')->add($account_log);
//         return true;
//     }else{
//         return false;
//     }
// }

/**
 * 订单操作日志
 * 参数示例
 * @param type $order_id  订单id
 * @param type $action_note 操作备注
 * @param type $status_desc 操作状态  提交订单, 付款成功, 取消, 等待收货, 完成
 * @param type $user_id  用户id 默认为管理员
 * @return boolean
 */
// function logOrder($order_id,$action_note,$status_desc,$user_id = 0)
// {
//     $status_desc_arr = array('提交订单', '付款成功', '取消', '等待收货', '完成','退货');
//     // if(!in_array($status_desc, $status_desc_arr))
//     // return false;

//     $order = Db::name('order')->master()->where("order_id", $order_id)->find();
//     $action_info = array(
//         'order_id'        =>$order_id,
//         'action_user'     =>0,
//         'order_status'    =>$order['order_status'],
//         'shipping_status' =>$order['shipping_status'],
//         'pay_status'      =>$order['pay_status'],
//         'action_note'     => $action_note,
//         'status_desc'     =>$status_desc, //''
//         'log_time'        =>time(),
//     );
//     return Db::name('order_action')->add($action_info);
// }

/*
 * 获取地区列表
 */
function get_region_list(){
    return Db::name('region')->cache(true)->value('id,name');
}
/*
 * 获取用户地址列表
 */
function get_user_address_list($user_id){
    $lists = Db::name('user_address')->where(array('user_id'=>$user_id))->select();
    return $lists;
}

/*
 * 获取指定地址信息
 */
function get_user_address_info($user_id,$address_id){
    $data = Db::name('user_address')->where(array('user_id'=>$user_id,'address_id'=>$address_id))->find();
    return $data;
}
/*
 * 获取用户默认收货地址
 */
function get_user_default_address($user_id){
    $data = Db::name('user_address')->where(array('user_id'=>$user_id,'is_default'=>1))->find();
    return $data;
}
/**
 * 获取订单状态的 中文描述名称
 * @param type $order_id  订单id
 * @param type $order     订单数组
 * @return string
 */
// function orderStatusDesc($order_id = 0, $order = array())
// {
//     if(empty($order))
//         $order = Db::name('Order')->where("order_id", $order_id)->find();

//     // 货到付款
//     if($order['pay_code'] == 'cod')
//     {
//         if(in_array($order['order_status'],array(0,1)) && $order['shipping_status'] == 0)
//             return 'WAITSEND'; //'待发货',
//     }
//     else // 非货到付款
//     {
//         if($order['pay_status'] == 0 && $order['order_status'] == 0)
//             return 'WAITPAY'; //'待支付',
//         if($order['pay_status'] == 1 &&  in_array($order['order_status'],array(0,1)) && $order['shipping_status'] == 0)
//             return 'WAITSEND'; //'待发货',
//         if($order['pay_status'] == 1 &&  $order['shipping_status'] == 2 && $order['order_status'] == 1)
//             return 'PORTIONSEND'; //'部分发货',
//     }
//     if(($order['shipping_status'] == 1) && ($order['order_status'] == 1))
//         return 'WAITRECEIVE'; //'待收货',
//     if($order['order_status'] == 2)
//         return 'WAITCCOMMENT'; //'待评价',
//     if($order['order_status'] == 3)
//         return 'CANCEL'; //'已取消',
//     if($order['order_status'] == 4)
//         return 'FINISH'; //'已完成',
//     if($order['order_status'] == 5)
//         return 'CANCELLED'; //'已作废',
//     return 'OTHER';
// }

/**
 * 获取订单状态的 显示按钮
 * @param type $order_id  订单id
 * @param type $order     订单数组
 * @return array()
 */
// function orderBtn($order_id = 0, $order = array())
// {
//     if(empty($order))
//         $order = Db::name('Order')->where("order_id", $order_id)->find();
//     /**
//      *  订单用户端显示按钮
//     去支付     AND pay_status=0 AND order_status=0 AND pay_code ! ="cod"
//     取消按钮  AND pay_status=0 AND shipping_status=0 AND order_status=0
//     确认收货  AND shipping_status=1 AND order_status=0
//     评价      AND order_status=1
//     查看物流  if(!empty(物流单号))
//      */
//     $btn_arr = array(
//         'pay_btn' => 0, // 去支付按钮
//         'cancel_btn' => 0, // 取消按钮
//         'receive_btn' => 0, // 确认收货
//         'comment_btn' => 0, // 评价按钮
//         'shipping_btn' => 0, // 查看物流
//         'return_btn' => 0, // 退货按钮 (联系客服)
//     );


//     // 货到付款
//     if($order['pay_code'] == 'cod')
//     {
//         if(($order['order_status']==0 || $order['order_status']==1) && $order['shipping_status'] == 0) // 待发货
//         {
//             $btn_arr['cancel_btn'] = 1; // 取消按钮 (联系客服)
//         }
//         if($order['shipping_status'] == 1 && $order['order_status'] == 1) //待收货
//         {
//             $btn_arr['receive_btn'] = 1;  // 确认收货
//             $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
//         }
//     }
//     // 非货到付款
//     else
//     {
//         if($order['pay_status'] == 0 && $order['order_status'] == 0) // 待支付
//         {
//             $btn_arr['pay_btn'] = 1; // 去支付按钮
//             $btn_arr['cancel_btn'] = 1; // 取消按钮
//         }
//         if($order['pay_status'] == 1 && in_array($order['order_status'],array(0,1)) && $order['shipping_status'] == 0) // 待发货
//         {
// //            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
//             $btn_arr['cancel_btn'] = 1; // 取消按钮
//         }
//         if($order['pay_status'] == 1 && $order['order_status'] == 1  && $order['shipping_status'] == 1) //待收货
//         {
//             $btn_arr['receive_btn'] = 1;  // 确认收货
// //            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
//         }
//     }
//     if($order['order_status'] == 2)
//     {
//         $btn_arr['comment_btn'] = 1;  // 评价按钮
//         $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
//     }
//     if($order['shipping_status'] != 0 && in_array($order['order_status'], [1,2,4]))
//     {
//         $btn_arr['shipping_btn'] = 1; // 查看物流
//     }
//     if($order['shipping_status'] == 2  && $order['order_status'] == 1) // 部分发货
//     {
// //        $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
//     }
    
//     if($order['pay_status'] == 1  && shipping_status && $order['order_status'] == 4) // 已完成(已支付, 已发货 , 已完成)
//     {
//             $btn_arr['return_btn'] = 1; // 退货按钮
//     }
    
//     if($order['order_status'] == 3 && ($order['pay_status'] == 1 || $order['pay_status'] == 4)){
//         $btn_arr['cancel_info'] = 1; // 取消订单详情
//     }

//     return $btn_arr;
// }

/**
 * 给订单数组添加属性  包括按钮显示属性 和 订单状态显示属性
 * @param type $order
 */
// function set_btn_order_status($order)
// {
//     $order_status_arr = config('ORDER_STATUS_DESC');
//     $order['order_status_code'] = $order_status_code = orderStatusDesc(0, $order); // 订单状态显示给用户看的
//     $order['order_status_desc'] = $order_status_arr[$order_status_code];
//     $orderBtnArr = orderBtn(0, $order);
//     return array_merge($order,$orderBtnArr); // 订单该显示的按钮
// }


/**
 * 支付完成修改订单
 * @param $order_sn 订单号
 * @param array $ext 额外参数
 * @return bool|void
 */
// function update_pay_status($order_sn,$ext=array())
// {
//     if(stripos($order_sn,'recharge') !== false){
//         //用户在线充值
//         $order = Db::name('recharge')->where(['order_sn' => $order_sn, 'pay_status' => 0])->find();
//         if (!$order) return false;// 看看有没已经处理过这笔订单  支付宝返回不重复处理操作
//         Db::name('recharge')->where("order_sn",$order_sn)->save(array('pay_status'=>1,'pay_time'=>time()));
//         accountLog($order['user_id'],$order['account'],0,'会员在线充值');
//     }else{
//         // 如果这笔订单已经处理过了
//         $count = Db::name('order')->master()->where("order_sn = :order_sn and pay_status = 0 OR pay_status = 2")->bind(['order_sn'=>$order_sn])->count();   // 看看有没已经处理过这笔订单  支付宝返回不重复处理操作
//         if($count == 0) return false;
//         // 找出对应的订单
//         $order = Db::name('order')->master()->where("order_sn",$order_sn)->find();
//         //预售订单
//         if ($order['order_prom_type'] == 4) {
//             $orderGoodsArr = Db::name('OrderGoods')->where(array('order_id'=>$order['order_id']))->find();
//             // 预付款支付 有订金支付 修改支付状态  部分支付
//             if($order['total_amount'] != $order['order_amount'] && $order['pay_status'] == 0){
//                 //支付订金
//                 Db::name('order')->where("order_sn", $order_sn)->save(array('order_sn'=> date('YmdHis').mt_rand(1000,9999) ,'pay_status' => 2, 'pay_time' => time(),'paid_money'=>$order['order_amount']));
//                 Db::name('goods_activity')->where(array('act_id'=>$order['order_prom_id']))->setInc('act_count',$orderGoodsArr['goods_num']);
//             }else{
//                 //全额支付 无订金支付 支付尾款
//                 Db::name('order')->where("order_sn", $order_sn)->save(array('pay_status' => 1, 'pay_time' => time()));
//                 $pre_sell = M('goods_activity')->where(array('act_id'=>$order['order_prom_id']))->find();
//                 $ext_info = unserialize($pre_sell['ext_info']);
//                 //全额支付 活动人数加一
//                 if(empty($ext_info['deposit'])){
//                     Db::name('goods_activity')->where(array('act_id'=>$order['order_prom_id']))->setInc('act_count',$orderGoodsArr['goods_num']);
//                 }
//             }
//         } else {
//             // 修改支付状态  已支付
//             $updata = array('pay_status'=>1,'pay_time'=>time());
//             if(isset($ext['transaction_id'])) $updata['transaction_id'] = $ext['transaction_id'];
//             Db::name('order')->where("order_sn", $order_sn)->save($updata);
// //             if(is_weixin()){
// //              $wx_user = M('wx_user')->find();
// //              $jssdk = new \app\common\logic\JssdkLogic($wx_user['appid'],$wx_user['appsecret']);
// //              $order['goods_name'] = M('order_goods')->where(array('order_id'=>$order['order_id']))->value('goods_name');
// //              $jssdk->send_template_message($order);//发送微信模板消息提醒
// //             }
//         }

//         // 减少对应商品的库存.注：拼团类型为抽奖团的，先不减库存
//         if(tpCache('shopping.reduce') == 2) {
//             if ($order['order_prom_type'] == 6) {
//                 $team = \app\common\model\TeamActivity::get($order['order_prom_id']);
//                 if ($team['team_type'] != 2) {
//                     minus_stock($order);
//                 }
//             } else {
//                 minus_stock($order);
//             }
//         }
//         // 给他升级, 根据order表查看消费记录 给他会员等级升级 修改他的折扣 和 总金额
//         update_user_level($order['user_id']);
//         // 记录订单操作日志
//         if(array_key_exists('admin_id',$ext)){
//             logOrder($order['order_id'],$ext['note'],'付款成功',$ext['admin_id']);
//         }else{
//             logOrder($order['order_id'],'订单付款成功','付款成功',$order['user_id']);
//         }
//         //分销设置
//         Db::name('rebate_log')->where("order_id" ,$order['order_id'])->save(array('status'=>1));
//         // 成为分销商条件
//         $distribut_condition = tpCache('distribut.condition');
//         if($distribut_condition == 1)  // 购买商品付款才可以成为分销商
//             Db::name('users')->where("user_id", $order['user_id'])->save(array('is_distribut'=>1));
//         //虚拟服务类商品支付
//         if($order['order_prom_type'] == 5){
//             $OrderLogic = new \app\common\logic\OrderLogic();
//             $OrderLogic->make_virtual_code($order);
//         }
//         if ($order['order_prom_type'] == 6) {
//             $TeamOrderLogic = new \app\common\logic\TeamOrderLogic();
//             $team = \app\common\model\TeamActivity::get($order['order_prom_id']);
//             $TeamOrderLogic->setTeam($team);
//             $TeamOrderLogic->doOrderPayAfter($order);
//         }
//          //发票生成
//         $Invoice = new \app\admin\logic\InvoiceLogic();
//         $Invoice->create_Invoice($order);
        
//         //用户支付, 发送短信给商家
//         $res = checkEnableSendSms("4");
//         if(!$res || $res['status'] !=1) return ;

//         $sender = tpCache("shop_info.mobile");
//         if(empty($sender))return;
//         $params = array('order_id'=>$order['order_id']);
//         sendSms("4", $sender, $params);
//     }

// }

/**
 * 订单确认收货
 * @param $id 订单id
 * @param int $user_id
 * @return array
 */
// function confirm_order($id,$user_id = 0){
//     $where['order_id'] = $id;
//     if($user_id){
//         $where['user_id'] = $user_id;
//     }
//     $order = Db::name('order')->where($where)->find();
//     if($order['order_status'] != 1)
//         return array('status'=>-1,'msg'=>'该订单不能收货确认');
//     if(empty($order['pay_time']) || $order['pay_status'] != 1){
//         return array('status'=>-1,'msg'=>'商家未确定付款，该订单暂不能确定收货');
//     }
//     $data['order_status'] = 2; // 已收货
//     $data['pay_status'] = 1; // 已付款
//     $data['confirm_time'] = time(); // 收货确认时间
//     if($order['pay_code'] == 'cod'){
//         $data['pay_time'] = time();
//     }
//     $row = M('order')->where(array('order_id'=>$id))->save($data);
//     if(!$Db::name)
//         return array('status'=>-3,'msg'=>'操作失败');

//     order_give($order);// 调用送礼物方法, 给下单这个人赠送相应的礼物
//     //分销设置
//     Db::name('rebate_log')->where("order_id", $id)->save(array('status'=>2,'confirm'=>time()));
//     return array('status'=>1,'msg'=>'操作成功','url'=>U('Order/order_detail',['id'=>$id]));
// }

/**
 * 下单赠送活动：优惠券，积分
 * @param $order|订单数组
 */
// function order_give($order)
// {
//     //促销优惠订单商品
//     $prom_order_goods = Db::name('order_goods')->where(['order_id' => $order['order_id'], 'prom_type' => 3])->select();
//     //获取用户会员等级
// //    $user_level = M('users')->where(['user_id' => $order['user_id']])->value('level');
//     foreach ($prom_order_goods as $goods) {
//         //查找购买商品送优惠券活动
//         $prom_goods = Db::name('prom_goods')->where(['id' => $goods['prom_id'], 'type' => 3])->find();
//         if ($prom_goods) {
//             //查找购买商品送优惠券模板
//             $goods_coupon = Db::name('coupon')->where(['id' => $prom_goods['expression']])->find();
// //            if ($goods_coupon && !empty($prom_goods['group'])) {
//             if ($goods_coupon) {
//                 // 用户会员等级是否符合送优惠券活动
// //                if (in_array($user_level, explode(',', $prom_goods['group']))) {
//                     //优惠券发放数量验证，0为无限制。发放数量-已领取数量>0
//                     if ($goods_coupon['createnum'] == 0 ||
//                             ($goods_coupon['createnum'] > 0 && ($goods_coupon['createnum'] - $goods_coupon['send_num']) > 0)
//                     ) {
//                         $data = array('cid' => $goods_coupon['id'], 'get_order_id'=>$order['order_id'],'type' => $goods_coupon['type'], 'uid' => $order['user_id'], 'send_time' => time());
//                         Db::name('coupon_list')->add($data);
//                         // 优惠券领取数量加一
//                         Db::name('Coupon')->where("id", $goods_coupon['id'])->setInc('send_num');
//                     }
// //                }
//             }
//         }
//     }
//     //查找订单满额促销活动
//     $prom_order_where = [
//         'type' => ['gt', 1],
//         'end_time' => ['gt', $order['pay_time']],
//         'start_time' => ['lt', $order['pay_time']],
//         'money' => ['elt', $order['goods_price']]
//     ];
//     $prom_orders = Db::name('prom_order')->where($prom_order_where)->order('money desc')->select();
//     $prom_order_count = count($prom_orders);
//     // 用户会员等级是否符合送优惠券活动
//     for ($i = 0; $i < $prom_order_count; $i++) {
// //        if (in_array($user_level, explode(',', $prom_orders[$i]['group']))) {
//             $prom_order = $prom_orders[$i];
//             if ($prom_order['type'] == 3) {
//                 //查找订单送优惠券模板
//                 $order_coupon = Db::name('coupon')->where("id", $prom_order['expression'])->find();
//                 if ($order_coupon) {
//                     //优惠券发放数量验证，0为无限制。发放数量-已领取数量>0
//                     if ($order_coupon['createnum'] == 0 ||
//                         ($order_coupon['createnum'] > 0 && ($order_coupon['createnum'] - $order_coupon['send_num']) > 0)
//                     ) {
//                         $data = array('cid' => $order_coupon['id'], 'get_order_id'=>$order['order_id'],'type' => $order_coupon['type'], 'uid' => $order['user_id'], 'send_time' => time());
//                         Db::name('coupon_list')->add($data);
//                         Db::name('Coupon')->where("id", $order_coupon['id'])->setInc('send_num'); // 优惠券领取数量加一
//                     }
//                 }
//             }
//             //购买商品送积分
//             if ($prom_order['type'] == 2) {
//                 accountLog($order['user_id'], 0, $prom_order['expression'], "订单活动赠送积分");
//             }
//             break;
// //        }
//     }
//     $points = Db::name('order_goods')->where("order_id", $order['order_id'])->sum("give_integral * goods_num");
//     $points && accountLog($order['user_id'], 0, $points, "下单赠送积分", 0, $order['order_id'], $order['order_sn']);
// }


/**
 * 查看订单是否满足条件参加活动
 * @param $order_amount
 * @return array
 */
// function get_order_promotion($order_amount)
// {
// //    $parse_type = array('0'=>'满额打折','1'=>'满额优惠金额','2'=>'满额送倍数积分','3'=>'满额送优惠券','4'=>'满额免运费');
//     $now = time();
//     $prom = Db::name('prom_order')->where("type<2 and end_time>$now and start_time<$now and money<=$order_amount")->order('money desc')->find();
//     $res = array('order_amount' => $order_amount, 'order_prom_id' => 0, 'order_prom_amount' => 0);
//     if ($prom) {
//         if ($prom['type'] == 0) {
//             $res['order_amount'] = round($order_amount * $prom['expression'] / 100, 2);//满额打折
//             $res['order_prom_amount'] = round($order_amount - $res['order_amount'], 2);
//             $res['order_prom_id'] = $prom['id'];
//         } elseif ($prom['type'] == 1) {
//             $res['order_amount'] = $order_amount - $prom['expression'];//满额优惠金额
//             $res['order_prom_amount'] = $prom['expression'];
//             $res['order_prom_id'] = $prom['id'];
//         }
//     }
//     return $res;
// }

/**
 * 计算订单金额
 * @param int $user_id 用户id
 * @param $order_goods 购买的商品
 * @param string $shipping_code 物流code
 * @param int $shipping_price 物流费用, 如果传递了物流费用 就不在计算物流费
 * @param int $province 省份
 * @param int $city 城市
 * @param int $district 县
 * @param int $pay_points 积分
 * @param int $user_money 余额
 * @param int $coupon_id 优惠券
 * @return array
 */
// function calculate_price($user_id = 0, $order_goods, $shipping_code = '', $shipping_price = 0, $province = 0, $city = 0, $district = 0, $pay_points = 0, $user_money = 0, $coupon_id = 0)
// {
//     $couponLogic = new \app\common\logic\CouponLogic();
//     $goodsLogic = new app\common\logic\GoodsLogic();
//     $user = Db::name('users')->where("user_id", $user_id)->find();// 找出这个用户
//     $result=[];
//     if (empty($order_goods)){
//         return array('status' => -9, 'msg' => '商品列表不能为空', 'result' => '');
//     }
//     $use_percent_point = tpCache('shopping.point_use_percent') / 100;     //最大使用限制: 最大使用积分比例, 例如: 为50时, 未50% , 那么积分支付抵扣金额不能超过应付金额的50%
//     /*判断能否使用积分
//      1..积分低于point_min_limit时,不可使用
//      2.在不使用积分的情况下, 计算商品应付金额
//      3.原则上, 积分支付不能超过商品应付金额的50%, 该值可在平台设置
//      @{ */
//     $point_rate = tpCache('shopping.point_rate'); //兑换比例: 如果拥有的积分小于该值, 不可使用
//     $min_use_limit_point = tpCache('shopping.point_min_limit'); //最低使用额度: 如果拥有的积分小于该值, 不可使用
    
//     if ($min_use_limit_point > 0 && $pay_points > 0 && $pay_points < $min_use_limit_point) {
//         return array('status' => -1, 'msg' => "您使用的积分必须大于{$min_use_limit_point}才可以使用", 'result' => ''); // 返回结果状态
//     }
//     // 计算该笔订单最多使用多少积分
//     if(($use_percent_point !=1 ) && $pay_points > $result['order_integral']) {
//         return array('status'=>-1,'msg'=>"该笔订单, 您使用的积分不能大于{$result['order_integral']}",'result'=>'积分'); // 返回结果状态
//     }

//     if(($pay_points > 0 && $use_percent_point == 0) ||  ($pay_points >0 && $result['order_integral']==0)){
//         return array('status' => -1, 'msg' => "该笔订单不能使用积分", 'result' => '积分'); // 返回结果状态
//     }

//     if ($pay_points && ($pay_points > $user['pay_points']))
//         return array('status' => -5, 'msg' => "你的账户可用积分为:" . $user['pay_points'], 'result' => ''); // 返回结果状态
//     if ($user_money && ($user_money > $user['user_money']))
//         return array('status' => -6, 'msg' => "你的账户可用余额为:" . $user['user_money'], 'result' => ''); // 返回结果状态

//     $goods_id_arr = get_arr_column($order_goods, 'goods_id');
//     $goods_arr = Db::name('goods')->where("goods_id in(" . implode(',', $goods_id_arr) . ")")->cache(true,TPSHOP_CACHE_TIME)
//         ->value('goods_id,weight,market_price,is_free_shipping,exchange_integral,shop_price'); // 商品id 和重量对应的键值对
//     $goods_weight=$goods_price=$cut_fee=$anum=$coupon_price= 0;  //定义一些变量
//     foreach ($order_goods as $key => $val) {
//         // 如果传递过来的商品列表没有定义会员价
//         if (!array_key_exists('member_goods_price', $val)) {
//             $user['discount'] = $user['discount'] ? $user['discount'] : 1; // 会员折扣 不能为 0
//             $order_goods[$key]['member_goods_price'] = $val['member_goods_price'] = $val['goods_price'] * $user['discount'];
//         }
//         //如果商品不是包邮的
//         if ($goods_arr[$val['goods_id']]['is_free_shipping'] == 0)
//             $goods_weight += $goods_arr[$val['goods_id']]['weight'] * $val['goods_num']; //累积商品重量 每种商品的重量 * 数量
//         //计算订单可用积分
//         if($goods_arr[$val['goods_id']]['exchange_integral']>0){
//             //商品设置了积分兑换就用商品本身的积分。
//             $result['order_integral'] +=  $goods_arr[$val['goods_id']]['exchange_integral'];
//         }else{
//             //没有就按照会员价与平台设置的比例来计算。
//             $result['order_integral'] +=  ceil($order_goods[$key]['member_goods_price'] * $use_percent_point);
//         }
//         $order_goods[$key]['goods_fee'] = $val['goods_num'] * $val['member_goods_price'];    // 小计
//         $order_goods[$key]['store_count'] = getGoodNum($val['goods_id'], $val['spec_key']); // 最多可购买的库存数量
//         if ($order_goods[$key]['store_count'] <= 0 || $order_goods[$key]['store_count'] < $order_goods[$key]['goods_num'])
//             return array('status' => -10, 'msg' => $order_goods[$key]['goods_name'] .','.$val['spec_key_name']. "库存不足,请重新下单", 'result' => '');

//         $goods_price += $order_goods[$key]['goods_fee']; // 商品总价
//         $cut_fee += $val['goods_num'] * $val['market_price'] - $val['goods_num'] * $val['member_goods_price']; // 共节约
//         $anum += $val['goods_num']; // 购买数量
//     }
//     // 优惠券处理操作
//     if ($coupon_id && $user_id) {
//         $coupon_price = $couponLogic->getCouponMoney($user_id, $coupon_id); // 下拉框方式选择优惠券
//     }
//     // 处理物流
//     if ($shipping_price == 0) {
//         $freight_free = tpCache('shopping.freight_free'); // 全场满多少免运费
//         if ($freight_free > 0 && $goods_price >= $freight_free) {
//             $shipping_price = 0;
//         } else {
//             $shipping_price = $goodsLogic->getFreight($shipping_code, $province, $city, $district, $goods_weight);
//         }
//     }

//     $order_amount = $goods_price + $shipping_price - $coupon_price; // 应付金额 = 商品价格 + 物流费 - 优惠券
//     $user_money = ($user_money > $order_amount) ? $order_amount : $user_money;  // 余额支付余额不能大于应付金额，原理等同于积分
//     $order_amount = $order_amount - $user_money;  //余额支付抵应付金额 （如果未付完，剩余多少没付）

//     // 积分支付 100 积分等于 1块钱
//     if($pay_points  > floor($order_amount * $point_rate)){
//         $pay_points = floor($order_amount * $point_rate);
//     }

//     $integral_money = ($pay_points / $point_rate);
//     $order_amount = $order_amount - $integral_money; //  积分抵消应付金额 （如果未付完，剩余多少没付）

//     $total_amount = $goods_price + $shipping_price;  //订单总价

//     // 订单满额优惠活动
//     $order_prom = get_order_promotion($goods_price);
//     //订单总价  应付金额  物流费  商品总价 节约金额 共多少件商品 积分  余额  优惠券
//     $result = array(
//         'total_amount' => $total_amount, // 订单总价
//         'order_amount' => round($order_amount-$order_prom['order_prom_amount'], 2), // 应付金额(要减去优惠的钱)
//         'shipping_price' => $shipping_price, // 物流费
//         'goods_price' => $goods_price, // 商品总价
//         'cut_fee' => $cut_fee, // 共节约多少钱
//         'anum' => $anum, // 商品总共数量
//         'integral_money' => $integral_money,  // 积分抵消金额
//         'user_money' => $user_money, // 使用余额
//         'coupon_price' => $coupon_price,// 优惠券抵消金额
//         'order_prom_id' => $order_prom['order_prom_id'],
//         'order_prom_amount' => $order_prom['order_prom_amount'],
//         'order_goods' => $order_goods, // 商品列表 多加几个字段原样返回
//     );
//     return array('status' => 1, 'msg' => "计算价钱成功", 'result' => $result); // 返回结果状态
// }

/**
 * 获取商品一二三级分类
 * @return type
 */
// function get_goods_category_tree(){
//     $tree = $arr = $result = array();
//     $cat_list = Db::name('goods_category')->cache(true)->where("is_show = 1")->order('sort_order')->select();//所有分类
//     if($cat_list){
//         foreach ($cat_list as $val){
//             if($val['level'] == 2){
//                 $arr[$val['parent_id']][] = $val;
//             }
//             if($val['level'] == 3){
//                 $crr[$val['parent_id']][] = $val;
//             }
//             if($val['level'] == 1){
//                 $tree[] = $val;
//             }
//         }

//         foreach ($arr as $k=>$v){
//             foreach ($v as $kk=>$vv){
//                 $arr[$k][$kk]['sub_menu'] = empty($crr[$vv['id']]) ? array() : $crr[$vv['id']];
//             }
//         }

//         foreach ($tree as $val){
//             $val['tmenu'] = empty($arr[$val['id']]) ? array() : $arr[$val['id']];
//             $result[$val['id']] = $val;
//         }
//     }
//     return $result;
// }

/**
 * 写入静态页面缓存
 */
// function write_html_cache($html){
//     $html_cache_arr = C('HTML_CACHE_ARR');
//     $request = think\Request::instance();
//     $m_c_a_str = $request->module().'_'.$request->controller().'_'.$request->action(); // 模块_控制器_方法
//     $m_c_a_str = strtolower($m_c_a_str);
//     //exit('write_html_cache写入缓存<br/>');
//     foreach($html_cache_arr as $key=>$val)
//     {
//         $val['mca'] = strtolower($val['mca']);
//         if($val['mca'] != $m_c_a_str) //不是当前 模块 控制器 方法 直接跳过
//             continue;

//         //if(!is_dir(RUNTIME_PATH.'html'))
//             //mkdir(RUNTIME_PATH.'html');
//         //$filename =  RUNTIME_PATH.'html'.DIRECTORY_SEPARATOR.$m_c_a_str;
//         $filename =  $m_c_a_str;
//         // 组合参数  
//         if(isset($val['p']))
//         {
//             foreach($val['p'] as $k=>$v)
//                 $filename.='_'.$_GET[$v];
//         }
//         $filename.= '.html';
//         \think\Cache::set($filename,$html);
//         //file_put_contents($filename, $html);
//     }
// }

/**
 * 读取静态页面缓存
 */
// function read_html_cache(){
//     $html_cache_arr = C('HTML_CACHE_ARR');
//     $request = think\Request::instance();
//     $m_c_a_str = $request->module().'_'.$request->controller().'_'.$request->action(); // 模块_控制器_方法
//     $m_c_a_str = strtolower($m_c_a_str);
//     //exit('read_html_cache读取缓存<br/>');
//     foreach($html_cache_arr as $key=>$val)
//     {
//         $val['mca'] = strtolower($val['mca']);
//         if($val['mca'] != $m_c_a_str) //不是当前 模块 控制器 方法 直接跳过
//             continue;

//         //$filename =  RUNTIME_PATH.'html'.DIRECTORY_SEPARATOR.$m_c_a_str;
//         $filename =  $m_c_a_str;
//         // 组合参数        
//         if(isset($val['p']))
//         {
//             foreach($val['p'] as $k=>$v)
//                 $filename.='_'.$_GET[$v];
//         }
//         $filename.= '.html';
//         $html = \think\Cache::get($filename);
//         if($html)
//         {
//             //echo file_get_contents($filename);
//             echo \think\Cache::get($filename);
//             exit();
//         }
//     }
// }

/**
 * 获取完整地址
 */
function getTotalAddress($province_id, $city_id, $district_id, $twon_id, $address='')
{
    static $regions = null;
    if (!$regions) {
        $regions = Db::name('region')->cache(true)->value('id,name');
    }
    $total_address  = $regions[$province_id] ?: '';
    $total_address .= $regions[$city_id] ?: '';
    $total_address .= $regions[$district_id] ?: '';
    $total_address .= $regions[$twon_id] ?: '';
    $total_address .= $address ?: '';
    return $total_address;
}

/**
 * 商品库存操作日志
 * @param int $muid 操作 用户ID
 * @param int $stock 更改库存数
 * @param array $goods 库存商品
 * @param string $order_sn 订单编号
 */
// function update_stock_log($muid, $stock = 1, $goods, $order_sn = '')
// {
//     $data['ctime'] = time();
//     $data['stock'] = $stock;
//     $data['muid'] = $muid;
//     $data['goods_id'] = $goods['goods_id'];
//     $data['goods_name'] = $goods['goods_name'];
//     $data['goods_spec'] = empty($goods['spec_key_name']) ? '' : $goods['spec_key_name'];
//     $data['order_sn'] = $order_sn;
//     Db::name('stock_log')->add($data);
// }

/**
 * 订单支付时, 获取订单商品名称
 * @param unknown $order_id
 * @return string|Ambigous <string, unknown>
 */
// function getPayBody($order_id){

//     if(empty($order_id))return "订单ID参数错误";
//     $goodsNames =  Db::name('OrderGoods')->where('order_id' , $order_id)->column('goods_name');
//     $gns = implode($goodsNames, ',');
//     $payBody = getSubstr($gns, 0, 18);
//     return $payBody;
// }