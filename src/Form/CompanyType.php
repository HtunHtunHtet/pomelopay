<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CompanyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
	        ->add('name', TextType::class,[
		        'label'         => 'Company Name',
		        'required'      => true,
		        'constraints'   => [
			        new NotBlank([
				        'message' => 'Please enter company name'
			        ])
		        ]
	        ])
	        
	        ->add('tax_number', TextType::class,[
		        'label'         => 'Tax Number',
		        'required'      => true,
		        'constraints'   => [
			        new NotBlank([
				        'message' => 'Please enter Tax Number'
			        ])
		        ]
	        ])
	
	        ->add('block_no', TextType::class,[
		        'label'         => 'Block No/House No.',
		        'required'      => true,
		        'mapped'        => false,
		        'constraints'   => [
			        new NotBlank([
				        'message' => 'Please enter block number'
			        ])
		        ]
	        ])
	
	        ->add('floor_no', TextType::class,[
		        'label'         => 'Floor No.',
		        'required'      => true,
		        'mapped'        => false,
		        'constraints'   => [
			        new NotBlank([
				        'message' => 'Please enter floor number'
			        ])
		        ]
	        ])
	
	        ->add('unit_no', TextType::class,[
		        'label'         => 'Unit No',
		        'required'      => true,
		        'mapped'        => false,
		        'constraints'   => [
			        new NotBlank([
				        'message' => 'Please enter unit number'
			        ])
		        ]
	        ])
	
	        ->add('street_name', TextType::class,[
		        'label'         => 'Street Name',
		        'required'      => true,
		        'mapped'        => false,
		        'constraints'   => [
			        new NotBlank([
				        'message' => 'Please enter street name'
			        ])
		        ]
	        ])
	
	        ->add('postal_code', TextType::class,[
		        'label'         => 'Postal Code',
		        'required'      => true,
		        'mapped'        => false,
		        'constraints'   => [
			        new NotBlank([
				        'message' => 'Please enter postal code'
			        ])
		        ]
	        ])
	        
	        
	        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}
