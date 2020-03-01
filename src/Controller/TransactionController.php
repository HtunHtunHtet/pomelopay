<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class TransactionController
 * @package App\Controller
 * @Route ("/transaction")
 * @IsGranted("ROLE_USER")
 */
class TransactionController extends AbstractController
{
	/**
	 * @Route("/", name="view_transaction")
	 */
    public function index()
    {
    	
	    $currentCompany = $this->getUser()->getCompany();
    	$transactions = $this->getDoctrine()->getRepository(Transaction::class)->findBy(['company' =>$currentCompany]);
    	
	    return $this->render( 'transaction/index.html.twig', [
		    'transactions' => $transactions
	    ] );
    }
	
	/**
	 * @Route ("/create", name = "create_transaction")
	 * @param  Request $request
	 * @return Response
	 */
    public function createTransaction(Request $request)
    {
        $transaction  = new Transaction();
	    $form    = $this->createForm(TransactionType::class,$transaction);
	    
	    $isSubmitted = $this->handleTransactionForm( $form , $transaction, $request);
	    
	    if ($isSubmitted) {
	    	$this->addFlash('success', 'Transaction Successfully Added!');
	    	
	    	return $this->redirectToRoute('view_transaction');
	    }
	    
	    return $this->render('transaction/create.html.twig' , [
	    	'transactionForm' => $form->createView()
	    ]);
	    
    }
	
	
	/**
	 * @Route ("/{id}/update", name = "update_transaction")
	 * @param Request $request
	 * @param $id
	 * @return Response
	 */
    
    public function updateTransaction ( Request $request , $id )
    {
    	
    	$transaction  = $this->getDoctrine()->getRepository(Transaction::class)->find($id);
    	
    	if(!$transaction)
    		throw $this->createNotFoundException('Unable to find transaction Entity');
    	
    	$form = $this->createForm(TransactionType::class,$transaction);
    	
    	$isSubmitted = $this->handleTransactionForm($form, $transaction, $request);
    	
    	if($isSubmitted) {
    		$this->addFlash('success','Transaction Successfully Updated.');
    		
    		return $this->redirectToRoute('view_transaction');
	    }
    	
    	return $this->render ('transaction/update.html.twig', [
    		'transactionForm' => $form->createView(),
		    'transactionEntity'   => $transaction
	    ]);
    
    }
	/**
	 * @Route ("/delete", name = "delete_transaction")
	 * @param Request $request
	 * @return Response
	 */
    public function deleteTransaction ( Request $request )
    {
    	$id = $request->get('transactionIdHidden');
    	$transaction = $this->getDoctrine()->getRepository(Transaction::class)->find($id);
	
	    if(!$transaction)
		    throw $this->createNotFoundException('Unable to find transaction Entity');
	    
	    $em = $this->getDoctrine()->getManager();
	    $em ->remove($transaction);
	    $em ->flush();
    	
	    $this->addFlash('success','Transaction Successfully deleted.');
	    
	    //TODO: Logging
	
	    return $this->redirectToRoute('view_transaction');
    }
    
    
    private function handleTransactionForm ( $form , $transaction , $request)
    {
    	$form->handleRequest($request);
    	$company = $this->getUser()->getCompany();
	
	    if($form->isSubmitted() && $form->isValid()) {
		    $entity_manager = $this->getDoctrine()->getManager();
		    $amount         = (float) $form->get('amount')->getData();
		    $amount         = number_format($amount,2,'.','');
		    
		    $transaction  ->setCurrency($form->get('currency')->getData());
		    $transaction  ->setStatus($form->get('status')->getData());
		    $transaction  ->setCompany($company);
		    $transaction  ->setAmount($amount);
		    $entity_manager ->persist($transaction);
		    $entity_manager ->flush();
		    return true;
	    }
	    
	    return false;
    }
    
    
    
}
