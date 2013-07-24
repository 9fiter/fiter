<?php

namespace Fiter\DefaultBundle\Admin;
 
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
 
class UsuarioAdmin extends Admin{

	protected function configureListFields(ListMapper $mapper){
        $mapper
        ->addIdentifier('nombre', null)
            ->add('id')
            ->add('username')
            //->add('usernameCanonical')
            ->add('email')
            //->add('emailCanonical')
            ->add('enabled')
            //->add('salt')
            //->add('password')
            //->add('plainPassword', 'text')
            ->add('lastLogin')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            //->add('groups', 'sonata_type_model', array('required' => false))
            ->add('locked')
            ->add('expired')
            ->add('expiresAt')
            ->add('roles')
            ->add('credentialsExpired')
            
            
            //->add('imagen', 'file', array('required' => false));
            //->add('path')
        ;
    }
    protected function configureDatagridFilters(DatagridMapper $mapper){
        $mapper
            ->add('id')
            ->add('username') 
            ->add('email')  
            ->add('lastLogin')    
            ->add('roles') 

        ;
    }
    protected function configureFormFields(FormMapper $mapper){
        $mapper
            ->with('General')
                ->add('username')
                ->add('email')
                ->add('plainPassword', 'text')
            ->end()
            // ->with('Groups')
            //      ->add('groups', 'sonata_type_model', array('required' => false))
            // ->end()
            ->with('Management')
                //->add('roles', 'sonata_security_roles', array( 'multiple' => true))
                ->add('locked', null, array('required' => false))
                ->add('expired', null, array('required' => false))
                ->add('enabled', null, array('required' => false))
                ->add('credentialsExpired', null, array('required' => false))
            ->end()

            // ->add('username')
            // ->add('usernameCanonical')
            // ->add('email')
            // ->add('emailCanonical')
            // ->add('enabled')
            // ->add('salt')
            // ->add('password')
            // ->add('plainPassword', 'text')
            // ->add('lastLogin')
            // ->add('confirmationToken')
            // ->add('passwordRequestedAt')
            // ->add('groups', 'sonata_type_model', array('required' => false))
            // ->add('locked')
            // ->add('expired')
            // ->add('expiresAt')
            // ->add('roles')
            // ->add('credentialsExpired')
            
        ;
    }
    public function preUpdate($user)
    {
        $this->getUserManager()->updateCanonicalFields($user);
        $this->getUserManager()->updatePassword($user);
    }

    public function setUserManager(UserManagerInterface $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @return UserManagerInterface
     */
    public function getUserManager()
    {
        return $this->userManager;
    }
}
