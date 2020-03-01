<?php
	
	
	namespace App\Tests\Controller;
	
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	
	class DefaultControllerTest extends WebTestCase
	{
		public function testIndex()
		{
			$client = static::createClient([],[
				'PHP_AUTH_USER' => 'ryanhhh91@gmail.com',
				'PHP_AUTH_PW'   => 'ryan123'
			]);
			$client->request('GET', '');
			
			
			//expected to see Hello at the page.
			$this->assertContains('Hello!',$client->getResponse()->getContent());
		}
	}