<?php

namespace MsGraphSendmail;

use Exception;
use Swift_Mime_SimpleMessage;
use Illuminate\Mail\Transport\Transport;
use Dcblogdev\MsGraph\Facades\MsGraphAdmin;
use Illuminate\Support\Facades\Log;

class MailTransport extends Transport
{
    /**
     * {@inheritdoc}
     */
    public function send(Swift_Mime_SimpleMessage $message, &$failedRecipients = null)
    {
        // TODO: 重新实现 connect() 逻辑
        request()->merge(['tenant' => true]);

        if (!MsGraphAdmin::isConnected()) {
            MsGraphAdmin::connect();
        }

        $this->beforeSendPerformed($message);

        if (config('msgraph.debug')) {
            Log::debug('sending email', [
                'to' => $message->getTo(),
                'subject' => $message->getSubject(),
                'body' => $message->getBody(),
            ]);
        }

        $res = MsGraphAdmin::emails()
            ->userid(config('msgraph.mailSender'))
            ->to(array_keys($message->getTo()))
            ->subject($message->getSubject())
            ->body($message->getBody())
            ->send();

        if (isset($res->error)) {
            Log::error('error in response', [$res]);
            throw new Exception('邮件发送失败，请联系管理人员');
        }

        if (config('msgraph.debug')) {
            Log::debug('email sent', [$res]);
        }

        $this->sendPerformed($message);
        return $this->numberOfRecipients($message);
    }
}
