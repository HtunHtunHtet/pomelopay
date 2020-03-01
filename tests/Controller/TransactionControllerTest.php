<?php
	
	
	namespace App\Tests\Controller;
	
	use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
	
	class TransactionControllerTest extends WebTestCase
	{
		public function testIndex()
		{
			
			$client = static::createClient([],[
				'PHP_AUTH_USER' => 'ryanhhh91@gmail.com',
				'PHP_AUTH_PW'   => 'ryan123'
			]);
			$client->request('GET', '/transaction/');
			
			
			//expected to see "View Transactions" header at the page.
			$this->assertContains('View Transactions',$client->getResponse()->getContent(), 'Enable to load the page');
		}
		
		public function testCreateTransaction ()
		{
			$client = static::createClient([],[
				'PHP_AUTH_USER' => 'ryanhhh91@gmail.com',
				'PHP_AUTH_PW'   => 'ryan123'
			]);
			
			$crawler = $client->request('GET', '/transaction/create');
			
			$form = $crawler->selectButton('Submit') ->form();
			
			$form['transaction[currency]'] -> select('S$');
			//$form['transaction[amount]'] = 'test';
			$form['transaction[amount]'] = '10.00';
			$form['transaction[status]'] ->select ('processing');
			$client->submit($form);
			
			$this->assertTrue($client->getResponse()->isRedirect('/transaction/'));
		}
		
		public function testUpdateTransaction ()
		{
			$client = static::createClient([],[
				'PHP_AUTH_USER' => 'ryanhhh91@gmail.com',
				'PHP_AUTH_PW'   => 'ryan123'
			]);
			
			
			
			//change {id} of the  update base on database transationId;
			$crawler = $client->request('GET', '/transaction/1/update');
			$form = $crawler->selectButton('Submit') ->form();
			$form['transaction[currency]'] -> select('S$');
			//$form['transaction[amount]'] = 'test';
			$form['transaction[amount]'] = '10.00';
			$form['transaction[status]'] ->select ('processing');
			$client->submit($form);
			
			$this->assertTrue($client->getResponse()->isRedirect('/transaction/'));
			
		}
		
		
		public function testDeleteTransaction ()
		{
			$client = static::createClient([],[
				'PHP_AUTH_USER' => 'ryanhhh91@gmail.com',
				'PHP_AUTH_PW'   => 'ryan123'
			]);
			
			$crawler = $client->request('GET', '/transaction/');
			$form = $crawler->selectButton('Submit')->form();
			
			
			//change the transaction value that is inside database
			$form['transactionIdHidden'] = '2';
			$client->submit($form);
			
			$this->assertTrue($client->getResponse()->isRedirect('/transaction/'));
		}
	}