<?php
namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Formulár pre dotazník.
 * @package Blogger\BlogBundle\Form
 */
class EnquiryType extends AbstractType
{
        /**
         * Vytvorí formulár.
         * @param FormBuilderInterface $builder konštruktér formulára
         */
	public function buildForm(FormBuilderInterface $builder)
	{
		$builder->add('name');
		$builder->add('email','email');
		$builder->add('subject');
		$builder->add('body','textarea');
	}
        
        /**
         * Získa názov formulára pre dotazník.
         * @return string názov formulára pre dotazník.
         */
	public function getName()
	{
		return 'contact';
	}
}