<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('title', TextType::class, array(
            'label' => 'Название',
            'attr' => array('class' => 'field'))
        );
        $builder->add('price', TextType::class, array(
            'label' => 'Бюджет', 
            'attr' => array('class' => 'field w50'))
        );
        $builder->add('price', TextType::class, array(
            'label' => 'Бюджет', 
            'attr' => array('class' => 'field w50'))
        );
        $builder->add('text', TextareaType::class, array(
            'label' => 'Опишите ваше задание',
             'attr' => array('class' => 'field'))
        );
        $builder->add('category', EntityType::class, array(
            'label' => 'Специализация задания',
            'class' => 'AppBundle\Entity\JobCategory',
            'attr' => array('class' => 'field'))
        );
        $builder->add('submit', SubmitType::class, array(
            'label' => 'Опубликовать',
            'attr' => array('class' => 'button'))
        );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => '\AppBundle\Entity\Job'
        ));
    }
}