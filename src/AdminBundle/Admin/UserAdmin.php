<?php
namespace AdminBundle\Admin;

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

class UserAdmin extends Admin
{

    /**
     * @param string $name
     * @param null $object
     * @return bool
     */

    private $security;

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('login_as', "../../login-as/" . $this->getRouterIdParameter());
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('firstName', 'text', array(
                    'label' => 'firstName'
                ))
                ->add('lastName', 'text', array(
                    'label' => 'lastName'
                ))
                ->add('email', 'text', array(
                    'label' => 'E-mail'
                ))
            ->end()
            ->with('Change Password')
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password fields must match.',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => false,
                    'first_options'  => array('label' => 'Password', 'attr' => array('placeholder' => 'enter new password')),
                    'second_options' => array('label' => 'Repeat Password', 'attr' => array('placeholder' => 'repeat new password')),
                    'mapped' => false,
                    'constraints' => array(
                        new Length(array(
                            'min' => 6,
                            'minMessage' => 'Password should be 6 letters minimum'
                        )),
                    ),
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
            ->add('email')
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
            ->add('email', null, array(
                'label' => 'e-mail',
            ))
            ->add('_action', 'actions', array(
                'actions' => array(
                    'edit' => array(),
                    'delete' => array(),
                    'login_as' => array(
                        'template' => 'AdminBundle:CRUD:list__action_login_as.html.twig'
                    )
                )
            ))
        ;
    }
    /**
     * @param User $object
     */
    public function preUpdate($object)
    {
        $this->changePassword($object);
    }
    /**
     * @param User $account
     */
    private function changePassword(User $account)
    {
        $form = $this->getForm();
        if ($form['plainPassword']->getData()) {
            $encoder = new MessageDigestPasswordEncoder('sha512', true, 10);
            $password = $encoder->encodePassword($form['plainPassword']->getData(), $account->getSalt());
            $account->setPassword($password);
        }

    }

    public function setSecurityTokenStorage(TokenStorage $securityTokenStorage){
        //$this->security = $securityTokenStorage;
    }

    public function getAdminId(){
        //return $this->security->getToken()->getUser()->getId();
    }
}