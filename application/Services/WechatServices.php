<?php

namespace app\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use EasyWeChat\Factory;
class WechatServices
{  
   private $config = [
        'app_id' => 'wx638deb836f37a30d',
        'secret' => 'cff8a76191b23970c55c83c8a98e7d22',
        // 下面为可选项
        // 指定 API 调用返回结果的类型：array(default)/collection/object/raw/自定义类名
        'response_type' => 'array',
        'log' => [
            'level' => 'debug',
            'file' => __DIR__.'/wechat.log',
        ],
    ];
    private $app;
   

    public function __construct(){
        $this->app = Factory::miniProgram($this->config);
    }

    public function getWeiOpenId(string $code){
        return $this->app->auth->session($code);
    }

    public function decryptData($session, $iv, $encryptedData){
        return $this->app->encryptor->decryptData($session, $iv, $encryptedData);
    }
   
}
?>