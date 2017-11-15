<?php

namespace sms;



use sms\Message\REST;

class Message
{
    //主账号 ---- ACCOUNT SID
    private $accountSid;
    //主账号 ---- AUTH TOKEN
    private $accountToken;
    //应用Id ---- APP ID
    private $appId;
    //生产环境 ---- https://app.cloopen.com:8883
    private $serverIP;
    //端口 ---- 8883
    private $serverPort;
    //REST版本号
    private $softVersion;

    public function __construct()
    {
        $this -> accountSid = $GLOBALS['config']['accountSid'];
        $this -> accountToken = $GLOBALS['config']['accountToken'];
        $this -> appId = $GLOBALS['config']['appId'];
        $this -> serverPort = $GLOBALS['config']['serverPort'];
        $this -> serverIP = $GLOBALS['config']['serverIP'];
        $this -> softVersion = $GLOBALS['config']['softVersion'];
    }
    /**
     * 发送模板短信
     * @param to 手机号码集合,用英文逗号分开
     * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
     * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
     */
    function sendTemplateSMS($to,$datas,$tempId)
    {
        // 初始化REST SDK

        $rest = new REST($this->serverIP,$this->serverPort,$this->softVersion);
        $rest->setAccount($this->accountSid,$this->accountToken);
        $rest->setAppId($this->appId);

        // 发送模板短信
        echo "Sending TemplateSMS to $to <br/>";
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL ) {
            echo "result error!";
            return;
        }
        if($result->statusCode!=0) {
            echo "error code :" . $result->statusCode . "<br>";
            echo "error msg :" . $result->statusMsg . "<br>";
            //TODO 添加错误处理逻辑
            return [
                'code'  =>  $result->statusCode,
                'msg'  =>  $result->statusMsg
            ];
        }else{
            echo "Sendind TemplateSMS success!<br/>";
            // 获取返回信息
            $smsmessage = $result->TemplateSMS;
            echo "dateCreated:".$smsmessage->dateCreated."<br/>";
            echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
            //TODO 添加成功处理逻辑
            return true;
        }
    }
}