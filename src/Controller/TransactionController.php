<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\TransactionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Class TransactionController
 * @package App\Controller
 * @Route ("/transaction")
 */


class TransactionController extends AbstractController
{
	/**
	 * @Route("/", name="view_transaction")
	 */
    public function index()
    {
    	
    	//find all transactions
    	$transactions = $this->getDoctrine()->getRepository(Transaction::class)->findAll();
    	
	    return $this->render( 'transaction/index.html.twig', [
		    'transactions' => $transactions
	    ] );
    }
	
	/**
	 * @Route ("/create", name = "create_transaction")
	 *
	 * @param  Request $request
	 * @return \Symfony\Component\HttpFoundation\Response
	 */
    public function createTransaction(Request $request) : Response
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
    
    
    private function handleTransactionForm ( $form , $transaction , $request)
    {
    	$form->handleRequest($request);
	
	    if($form->isSubmitted() && $form->isValid()) {
		    $entity_manager = $this->getDoctrine()->getManager();
		    $amount         = (float) $form->get('amount')->getData();
		    $amount         = number_format($amount,2,'.','');
		    
		    $transaction  ->setCurrency($form->get('currency')->getData());
		    $transaction  ->setStatus($form->get('status')->getData());
		    $transaction  ->setCompany($form->get('company')->getData());
		    $transaction  ->setAmount($amount);
		    $entity_manager ->persist($transaction);
		    $entity_manager ->flush();
		    return true;
	    }
	    
	    return false;
    }
    
    
    
}
