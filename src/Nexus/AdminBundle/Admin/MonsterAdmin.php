<?php
namespace Nexus\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class MonsterAdmin extends Admin
{
    protected $translationDomain = 'SonataCustomAdmin'; // default is 'messages'

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $avatar_folder = $container->get('kernel')->getRootdir().'/../web/images/NexusMonster/';
        foreach (glob($avatar_folder."*.png", GLOB_BRACE) as $filename) {
            $avatar[basename($filename)] = basename($filename);
        }        
        $formMapper
            ->add('name', null, array(
                    'label'                 => 'admin.monster.name',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('avatar', 'choice', array(
                    'label'                 => 'admin.monster.avatar',
                    'choices'                   => $avatar,
                    'attr'                      => array('class' => 'avatar hide'),                    
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))                                               
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, array(
                    'label'                 => 'admin.monster.name',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name', null, array(
                    'label'                 => 'admin.monster.name',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('avatar', null, array(
                    'label'                 => 'admin.monster.avatar',
                    'template'              => 'NexusAdminBundle:CharacterAdmin:list.html.twig',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))   
        ;
    }
}
?>