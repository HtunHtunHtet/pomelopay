<?php

namespace App\Controller;

use App\Entity\Company;
use App\Form\CompanyType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class CompanyController
 * @package App\Controller
 * @Route ("/company")
 * @IsGranted("ROLE_USER")
 */

class CompanyController extends AbstractController
{
	
	/**
	 * @Route("/", name="view_company")
	 */
    public function index()
    {
    	//get all companies
	    $companies = $this->getDoctrine()->getRepository(Company::class)->findAll();
	    
        return $this->render('company/index.html.twig', [
           'companies' => $companies
        ]);
    }
	
	/**
	 * @Route ("/create", name = "create_company")
	 *
	 * @param  Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function createCompany (Request $request) : Response
    {
    	$company = new Company();
    	$form    = $this->createForm(CompanyType::class,$company);
    	
	    $isSubmitted = $this->handleCompanyForm($form, $company , $request);
	    if ($isSubmitted) {
		    $this->addFlash('success','Company Successfully Added');
		
		    //redirect back to view page
		    return $this->redirectToRoute('view_company');
	    }
	    
	    return $this->render('company/create.html.twig', [
		    'companyForm' => $form->createView()
	    ]);
    }
	
	/**
	 * @Route("/{id}/update", name = "update_company")
	 *
	 * @param  Request $request
	 * @param  $id
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function updateCompany (Request $request , $id ) : Response
    {
        $company = $this->getDoctrine()->getRepository(Company::class)->find($id);
	
	    if(!$company)
		    throw $this->createNotFoundException('Unable To find Company Entity');
	
	    $form    = $this->createForm(CompanyType::class,$company);
	    
	    $isSubmitted = $this->handleCompanyForm($form, $company, $request);
	    
	    if($isSubmitted) {
		    $this->addFlash('success','Company Successfully Updated');
		
		    //redirect back to view page
		    return $this->redirectToRoute('view_company');
	    }
	
	    return $this->render('company/update.html.twig', [
		    'companyForm' => $form->createView(),
		    'companyEntity' => $company
	    ]);
    }
    
    private function handleCompanyForm( $form , $company , $request)
    {
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
		    return true;
	    }
	    	return false;
	    
    }
}
