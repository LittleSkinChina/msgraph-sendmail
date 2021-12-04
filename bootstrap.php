<?php

return function () {
    $msgraph = require __DIR__.'/config/msgraph.php';
    config(['msgraph' => $msgraph]);

    app()->register(Dcblogdev\MsGraph\MsGraphServiceProvider::class);

    config(['mail.mailers.msgraph' => [
        'transport' => 'msgraph',
    ]]);
    app('mail.manager')->extend('msgraph', function () {
        return new MsGraphSendmail\MailTransport();
    });
};
