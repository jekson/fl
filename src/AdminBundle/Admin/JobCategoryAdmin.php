<?php
namespace AdminBundle\Admin;

use AppBundle\Entity\JobCategory;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class JobCategoryAdmin extends AbstractAdmin
{

    /**
     * @param string $name
     * @param null $object
     * @return bool
     */

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name', 'text', array(
                    'label' => 'name'
                ))
                 ->add('parent', 'sonata_type_model', array(
                    'label' => 'Parent',
                    'class' => 'AppBundle\Entity\JobCategory',
                    'required' => false,
                    'btn_add' => false,
                ))
                ->add('url', 'text', array(
                    'label' => 'Url'
                ))
                ->add('description', 'textarea', array(
                    'label' => 'Description'
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
            ->add('name')
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
            ->add('name', null, array(
                'label' => 'Name'
            ))
            ->add('url', null, array(
                'label' => 'Url'
            ))
            ->add('parent', null, array(
                'label' => 'Parent'
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