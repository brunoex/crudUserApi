<?php 

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApiTest extends WebTestCase
{
    public function testCreateAndListApiUser()
    {
        $client = static::createClient();
        $client->request('POST', '/api/create', [], [], [], file_get_contents(__DIR__ .'/data/test.xml'));
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);

        $client->request('GET', '/api');
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);

        $match = false;
        if(preg_match('#test@tester.com#', $client->getResponse()->getContent())){
            $match = true;
        }
        if(preg_match('#error#', $client->getResponse()->getContent())){
            $match = false;
        }
      
        $this->assertTrue($match);
    }

    public function testCreateDeleteAndListApiUser()
    {
        $client = static::createClient();
        $client->request('POST', '/api/create', [], [], [], file_get_contents(__DIR__ .'/data/test.xml'));
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);

        $client->request('DELETE', '/api/delete', [], [], [], file_get_contents(__DIR__ .'/data/test.xml'));
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);

        $client->request('GET', '/api');
        $this->assertEquals($client->getResponse()->getStatusCode(), 200);

        $match = false;
        if(preg_match('#test@tester.com#', $client->getResponse()->getContent())){
            $match = true;
        }
        if(preg_match('#error#', $client->getResponse()->getContent())){
            $match = true;
        }
      
        $this->assertNotTrue($match);
    }
}