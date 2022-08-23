<?php

$appId = 'wx665a466993146c68'; //对应自己的appId
$appSecret = '051453e44563adf6518f88e9c2c91ad9'; //对应自己的appSecret
$wxgzhurl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appId . "&secret=" . $appSecret;
$access_token_Arr = https_request($wxgzhurl);
$access_token = json_decode($access_token_Arr, true);
$ACCESS_TOKEN = $access_token['access_token']; //ACCESS_TOKEN


// 什么时候恋爱的(格式别错)
$lovestart = strtotime('2020-05-20');
$end = time();
$love = ceil(($end - $lovestart) / 86400);

// 下一个生日是哪一天(格式别错)
$birthdaystart = strtotime('2023-07-20');
$end = time();
$diff_days = ($birthdaystart - $end);
$birthday = (int)($diff_days/86400);
$birthday = str_replace("-", "", $birthday);


$tianqiurl = 'https://v0.yiketianqi.com/api?unescape=1&version=v61&appid=37741454&appsecret=3M3gpy0P&cityid=101180916';
$tianqiapi = https_request($tianqiurl);
$tianqi = json_decode($tianqiapi, true);

$qinghuaqiurl = 'https://v2.alapi.cn/api/qinghua?token=3kumy5U58tAbkmMn'; 
$qinghuaapi = https_request($qinghuaqiurl);
$qinghua = json_decode($qinghuaapi, true);


// 你自己的一句话
$yjh = '你的老公田世纪永远爱你'; //可以留空 也可以写上一句

$touser = 'oaXz16Ke5NNzcckeaqSD-Qcv9j44';  //这个填你女朋友的openid
$data = array(
    'touser' => $touser,
    'template_id' => "SIoT8U04Ci5oriFNprRgyZJyXzPakRp8hfPiYJfy6x8", //改成自己的模板id，在微信后台模板消息里查看
    'data' => array(
        'first' => array(
            'value' => $yjh,
            'color' => "#000"
        ),
        'keyword1' => array(
            'value' => $tianqi['wea'],
            'color' => "#000"
        ),
        'keyword2' => array(
            'value' => $tianqi['tem_day'],
            'color' => "#000"
        ),
        'keyword3' => array(
            'value' => $love . '天',
            'color' => "#000"
        ),
        'keyword4' => array(
            'value' => $birthday . '天',
            'color' => "#000"
        ),
        'remark' => array(
            'value' => $qinghua['data']['content'],
            'color' => "#f00"
        ),
    )
);

// 下面这些就不需要动了————————————————————————————————————————————————————————————————————————————————————————————
$json_data = json_encode($data);
$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $ACCESS_TOKEN;
$res = https_request($url, urldecode($json_data));
$res = json_decode($res, true);

if ($res['errcode'] == 0 && $res['errcode'] == "ok") {
    echo "发送成功！<br/>";
}else {
        echo "发送失败！请检查代码！！！<br/>";
}
function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)) {
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
