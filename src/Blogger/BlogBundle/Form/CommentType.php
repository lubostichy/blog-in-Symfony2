<?php

namespace Blogger\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Formulár pre komentár.
 * @package Blogger\BlogBundle\Form
 */
class CommentType extends AbstractType
{
    /**
     * Vytvorí formulár.
     * @param FormBuilderInterface $builder konštruktér formulára
     */
    public function buildForm(FormBuilderInterface $builder)
    {
        $builder
            ->add('user')
            ->add('comment')
        ;
    }
    
    /**
     * Nastaví preddefinované možnosti.
     * @param OptionsResolverInterface $resolver rozhoduje o možnostiach
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Blogger\BlogBundle\Entity\Comment'
        ));
    }

    /**
     * Získa názov formulára pre komentár.
     * @return string názov formulára pre komentár
     */
    public function getName()
    {
        return 'blogger_blogbundle_comment';
    }
}
