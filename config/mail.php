<?php
return [

    'driver' => 'smtp',

    'host' => 'smtp.sendgrid.net',

    'port' => '2525',

    "from" => array(
        "address" => "noreply@stocklyeretailer.com",
        "name" => "Stockly ERetailer"
    ),

    'encryption' => 'tls',

    'username' => 'apikey',

    'password' => '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',

    'sendmail' => '/usr/sbin/sendmail -bs',

    'pretend' => false,

    'stream' => [
        'ssl' => [
            'allow_self_signed' => true,
            'verify_peer' => false,
            'verify_peer_name' => false,
        ],
    ],

];
