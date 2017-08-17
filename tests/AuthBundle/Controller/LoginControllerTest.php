<?php

namespace AuthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLogin()
    {
//        $client = static::createClient();
//
//        $crawler = $client->request('GET', '/login');
//        $client->submit('login_form',[
//            '_username' => 'admin',
//            '_password' => '123'
//        ]);
//        $crawler = $client->request('POST', '/login');

        $client = static::createClient();
        $username = 'admin';
        $password = '123';

        $crawler = $client->request('POST', '/login', array(
            '_username' => $username,
            '_password' => $password,
        ));

//        $form = $crawler->filter('ibox-content')->form();
//
//        $crawler = $client
//            ->submit($form,
//                array(
//                    '_username' => $username,
//                    '_password' => $password,
//                )
//            );
    }

}
