<?php
/**
 * Created by Virgil
 * Date: 3/3/2016
 * Time: 6:38 AM
 */

namespace AppBundle\Tests\Controller\Api;


class ProgrammerControllerTest extends \PHPUnit_Framework_TestCase
{
    public function testPOST ()
    {
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

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertTrue($response->hasHeader('Location'));
        $finishedData = json_decode($response->getBody(true), true);
        $this->assertArrayHasKey('nickname', $finishedData);
    }

}