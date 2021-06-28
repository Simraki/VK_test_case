<?php

return [
    'leaderboard' => [
        'filename' => 'leaders.txt'
    ],
    'api' => [
        'v' => '1.0',
        'url' => (!empty($_SERVER['HTTPS']) ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST']."/"
    ]
];
