<?php


return array(

    //微信appID
    'app_id'        => 'wx3ecce2fc1e001c46',

    //微信appSecret
    'app_secret'    => '5680feea37de8d1bea7938ef875422de',

    //微信服务器有效性验证
    'check_token'   =>  'muye_token',

    //消息加解密密钥
    'sign_string'   => '5w9fQoieZADO8cXOz53RT3OL09dYPptmgP3srfP5w3l',

    //api
    'api'  => [
        //获取token
        'get_access_token' => 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s',

        //生成菜单43
        'create_menu'      => 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s',

        //自定义菜单
        'conditional_menu' => 'https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=%s',

        //查询授权
        'get_authorization' => 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=%s#wechat_redirect',
    ],

    'link'  => [

    ],

    'media'  => [

    ],
);