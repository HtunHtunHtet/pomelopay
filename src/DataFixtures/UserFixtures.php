<?php

namespace App\DataFixtures;

use App\Entity\Company;
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
       $user = new User();
       $company = new Company();
       
       $user ->setRoles(['ROLE_USER']);
	   $user ->setEmail('ryanhhh91@gmail.com');
	   $user ->setPassword($this->passwordEncoder->encodePassword(
		    $user, 'easypeasylemonsqueezy'
	    ));
	   
	   
	   $company ->setUser($user);
	   $company ->setName('Pomelopay');
	   $company ->setTaxNumber('TAX-001');
	   $company ->setAddress([
	   	                'block' => '416',
		                'floor' => '14',
		                'unit'  => '995',
		                'street' => 'Yishun Street',
		                'postal' => '560416',
				   ]);
	   
	   $manager ->persist($company);
	   $manager ->persist($user);
	   $manager->flush();
    }
}
