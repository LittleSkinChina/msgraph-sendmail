<?php

namespace MsGraphSendmail;

use Dcblogdev\MsGraph\Facades\MsGraphAdmin;
use Illuminate\Support\Arr;

class Configuration
{
    public function render()
    {
        // TODO: 重新实现 connect() 逻辑
        request()->merge(['tenant' => true]);

        if (!MsGraphAdmin::isConnected()) {
            MsGraphAdmin::connect();
        }

        $res = MsGraphAdmin::get('users/'.config('msgraph.mailSender'));
        $userInfo = Arr::only($res, ['id', 'displayName', 'mail', 'userPrincipalName']);
        $userInfoReadable = print_r($userInfo, true);

        return view('MsGraphSendmail::config', compact('userInfo', 'userInfoReadable'));
    }
}
