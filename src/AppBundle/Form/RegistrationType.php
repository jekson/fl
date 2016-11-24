<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {        $builder->remove('username');
        /*        $builder->add('title', 'choice', array(
            'choices' => array('Mr','Ms','Mrs','Dr')
        ));*/
        $builder->add('firstName');
        $builder->add('lastName');
        //$builder->add('country', 'country');
        //$builder->add('placeOfBirth', 'country');
        //$builder->add('countryOfNationality', 'country');
        //$builder->add('taxResidency', 'country');
        //$builder->add('dateOfBirth', 'birthday');
        /*
        $builder->add('passportIssueDate', 'date', array(
            'years' => range(date('Y'), date('Y')+15),
        ));
        $builder->add('passportExpiryDate', 'date', array(
            'years' => range(date('Y'), date('Y')+15),
        ));
        $builder->add('isUsaTax', 'choice', array(
            'choices' => array('','Yes','No'),
            'label' => 'Are You A US Citizen Or A US Resident For Tax Purposes',
        ));
        */
        $builder->add('phone');

    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}