<?php
    require __DIR__.'/vendor/autoload.php';

    $client = new \GuzzleHttp\Client([
        'base_url' => 'http://localhost:8000',
        'defaults' => [
            'exceptions' => false
        ]
    ]);

$nickname = 'ObjectOrienter'.rand(0, 999);
$data = array(
    'nickname' => $nickname,
    'avatarNumber' => 5,
    'tagLine' => 'a test dev!'
);


// 1) Create a programmer resource
$response = $client->post('/web/app_dev.php/api/programmers',[
    'body' => json_encode($data)
]);

echo $response;
echo "\n\n";

// 2) GET a programmer resource
$programmerUrl = $response->getHeader('Location');
$response = $client->get($programmerUrl);

echo $response;
echo "\n\n";

// 3) GET all programmers
$response = $client->get('/web/app_dev.php/api/programmers');

echo $response;
echo "\n\n";