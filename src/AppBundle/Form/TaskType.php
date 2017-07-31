<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TaskType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('task')->add('dueDate')
          ->add('agreeTerms', CheckboxType::class, array('mapped' => false))
          ->add('agreeTerms', ChoiceType::class, array('mapped' => false))
          ->add('att', ChoiceType::class, array(
              'mapped' => false,
              'choices'  => array(
                  'Maybe' => null,
                  'Yes' => true,
                  'No' => false,
              )));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
      
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'task';
    }


}
