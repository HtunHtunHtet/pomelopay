<?php

namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Transaction;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
	
	private $passwordEncoder;
	
	public function __construct(UserPasswordEncoderInterface $passwordEncoder)
	{
		$this->passwordEncoder = $passwordEncoder;
	}
	
	
	public function load(ObjectManager $manager)
    {
    	
      $users = [
      	            0 => [
      	                'user' => [
      	                	'role' => ['ROLE_USER'],
	                        'email' =>'ryanhhh91@gmail.com',
	                        'password' => 'ryan123'
                        ],
	                    
	                    'company' => [
	                    	'name' => 'Cuba doo',
		                    'tax'  => 'TAX-001',
		                    'block'=> '416',
		                    'floor' => '14',
		                    'unit' => '995',
		                    'street' => 'Yishun Street',
		                    'postal' => '560416'
	                    ],
	                    
	                    'transaction' => [
	                    	0 => [
	                    		'amount' => '10',
			                    'status' => 'processing',
			                    'currency' => 'S$'
		                    ],
		                    1 => [
			                    'amount' => '20',
			                    'status' => 'transferred',
			                    'currency' => 'US$'
		                    ]
	                    ]
                    ],
  
                    2 => [
	                    'user' => [
		                    'role' => ['ROLE_USER'],
		                    'email' =>'simon@pomelopay.com',
		                    'password' => 'simon123'
	                    ],
	  
	                    'company' => [
		                    'name' => 'Pomelopay',
		                    'tax'  => 'TAX-002',
		                    'block'=> '123',
		                    'floor' => '08',
		                    'unit' => '189',
		                    'street' => 'Raffle Place ',
		                    'postal' => '510412'
	                    ],
	
	                    'transaction' => [
		                    0 => [
			                    'amount' => '40',
			                    'status' => 'processing',
			                    'currency' => 'S$'
		                    ],
		                    1 => [
			                    'amount' => '10',
			                    'status' => 'transferred',
			                    'currency' => 'US$'
		                    ]
	                    ]
	                    
                    ]
                ];
      
      $this->process($users  , $manager);
    }
    
    private function process ( $users , $manager)
    {
    	foreach ($users as $data) {
		    $user = new User();
		    $company = new Company();
		  
		    
		    $user ->setRoles($data['user']['role']);
		    $user ->setEmail($data['user']['email']);
		    $user ->setPassword($this->passwordEncoder->encodePassword(
			    $user, $data['user']['password']
		    ));
		
		
		    $company ->setUser($user);
		    $company ->setName($data['company']['name']);
		    $company ->setTaxNumber($data['company']['tax']);
		    $company ->setAddress([
			    'block' => $data['company']['block'],
			    'floor' => $data['company']['floor'],
			    'unit'  => $data['company']['unit'],
			    'street' => $data['company']['street'],
			    'postal' => $data['company']['postal'],
		    ]);
		    
		    
		    $transactions = $data['transaction'];
		    
		    foreach ( $transactions as $tran) {
			    $transaction = new Transaction();
			    $transaction ->setCompany($company);
			    $transaction ->setAmount($tran['amount']);
			    $transaction ->setStatus($tran['status']);
			    $transaction ->setCurrency($tran['currency']);
			    $manager ->persist($transaction);
		    }
		    
		
		    $manager ->persist($company);
		    $manager ->persist($user);
		    $manager->flush();
	    }
    }
}
