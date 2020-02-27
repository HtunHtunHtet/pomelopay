<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CompanyController
 * @package App\Controller
 * @Route ("/company")
 */

class CompanyController extends AbstractController
{
	
	/**
	 * @Route("/", name="view_company")
	 */
    public function index()
    {
        return $this->render('company/index.html.twig', [
            'controller_name' => 'CompanyController',
        ]);
    }
	
	/**
	 * @Route ("/create", name = "create_company")
	 * @param  Request $request
	 *
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function createCompany (Request $request)
    {
    	$company = new Company();
    	$form    = $this->createForm(CompanyType::class,$company);
	
	    $form->handleRequest($request);
	    
	    if($form->isSubmitted() && $form->isValid()){
	    	$entity_manager = $this->getDoctrine()->getManager();
	    	$company->setName($form->get('name')->getData());
	    	$company->setTaxNumber($form->get('tax_number')->getData());
		    $address = [
		    	'block' => $form->get('block_no')->getData(),
			    'floor' => $form->get('floor_no')->getData(),
			    'unit'  => $form->get('unit_no')->getData(),
			    'street' => $form->get('street_name')->getData(),
			    'postal' => $form->get('postal_code')->getData()
		    ];
		    $company->setAddress($address);
		    $entity_manager->persist ($company);
		    $entity_manager->flush();
		    $this->addFlash('success','Company Successfully Added');
		    
		    //redirect back to view page
		    return $this->redirectToRoute('view_company');
	    }
	    
	    return $this->render('company/create.html.twig', [
		    'companyForm' => $form->createView()
	    ]);
    }
}
