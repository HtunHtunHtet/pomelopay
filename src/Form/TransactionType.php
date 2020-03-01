<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Transaction;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('currency', ChoiceType::class,[
		        'required'      => true,
		        'choices'        => [
			        '--- Select Currency ---'                   => '',
			        Transaction::CURRENCY_EURO        => Transaction::CURRENCY_EURO,
			        Transaction::CURRENCY_SINGAPORE   => Transaction::CURRENCY_SINGAPORE,
			        Transaction::CURRENCY_US          => Transaction::CURRENCY_US
		        ],
		        'constraints'   => [
			        new NotBlank([
				        'message' => 'Please enter currency'
			        ])
		        ]
	        ])
	        
	        ->add('amount', MoneyType::class,[
	        	'currency'      => false,
		        //'divisor'       => 100,
		        'label'         => 'Amount',
		        'required'      => true,
		        'mapped'        => true,
		        'constraints'   => [
			        new NotBlank([
				        'message' => 'Please enter amount'
			        ])
		        ]
	        ])
	        
            ->add('status' ,  ChoiceType::class,[
            	'label'     => 'status',
	            'required'  => true,
	            'choices'   =>  [
		            '--- Select Status ---'      => '',
		            Transaction::STATUS_DECLINED => Transaction::STATUS_DECLINED,
		            Transaction::STATUS_FAILED   => Transaction::STATUS_FAILED,
		            Transaction::STATUS_PROCESSING => Transaction::STATUS_PROCESSING,
		            Transaction::STATUS_TRANSFERRED => Transaction::STATUS_TRANSFERRED
	            ]
	            
            ])
            /*->add('company', EntityType::class, [
            	'class' => Company::class,
	            'query_builder' => function (EntityRepository $er){
            	    $er ->createQueryBuilder('c')
		                ->orderBy('c.name','ASC');
	            },
	            'choice_label' => function ($company) {
            	        return $company->getName();
	            },
	            'required'      => true,
	            'mapped'        => true,
	            'label'         => 'Company'
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
