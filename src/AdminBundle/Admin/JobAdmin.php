<?php
namespace AdminBundle\Admin;

use AppBundle\Entity\Job;
use AppBundle\Entity\User;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class JobAdmin extends Admin
{


    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('title', 'text', array(
                    'label' => 'Title'
                ))
                ->add('user', 'sonata_type_model', array(
                    'label' => 'User',
                    'class' => 'AppBundle\Entity\User',
                    'btn_add' => false
                ))
                ->add('type', 'sonata_type_model', array(
                    'label' => 'Type',
                    'btn_add' => false
                ))
                ->add('price', 'text', array(
                    'label' => 'Price'
                ))
                ->add('Text', 'textarea', array(
                    'label' => 'Text'
                ))
                ->add('onlyPro', 'checkbox', array(
                    'label' => 'Only pro'
                ))
            ->end()
        ;
    }
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('title')
        ;
    }
    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array(
                'label' => 'ID'
            ))
            ->add('title', null, array(
                'label' => 'Title'
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

}