<?php
namespace Nexus\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CharacterAdmin extends Admin
{
    protected $translationDomain = 'SonataCustomAdmin'; // default is 'messages'

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $avatar_folder = $container->get('kernel')->getRootdir().'/../web/images/NexusCharacter/';
        foreach (glob($avatar_folder."*.png", GLOB_BRACE) as $filename) {
            $avatar[basename($filename)] = basename($filename);
        }
        $formMapper
            ->add('user', null, array(
                    'class'                 => 'Application\Sonata\UserBundle\Entity\User',
                    'label'                 => 'admin.characters.username',
                    'translation_domain'    => 'SonataCustomAdmin',                  
                ))
            ->add('name', null, array(
                    'label'                 => 'admin.characters.name',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('experience', null, array(
                    'label'                 => 'admin.characters.experience',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('health', null, array(
                    'label'                 => 'admin.characters.health',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('attackSpeed', null, array(
                    'label'                 => 'admin.characters.attack_speed',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('avatar', 'choice', array(
                    'label'                     => 'admin.characters.avatar',
                    'choices'                   => $avatar,
                    'attr'                      => array('class' => 'avatar hide'),
                    'translation_domain'        =>  'SonataCustomAdmin',
                ))                                                  
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user', null, array(
                    'class'                 => 'Application\Sonata\UserBundle\Entity\User',
                    'label'                 => 'admin.characters.username',
                    'translation_domain'    => 'SonataCustomAdmin',    
                ))
            ->add('name', null, array(
                    'label'                 => 'admin.characters.name',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('experience', null, array(
                    'label'                 => 'admin.characters.experience',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('level', null, array(
                    'label'                 => 'admin.characters.level',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('health', null, array(
                    'label'                 => 'admin.characters.health',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('attackSpeed', null, array(
                    'label'                 => 'admin.characters.attack_speed',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('power', null, array(
                    'label'                 => 'admin.characters.power',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))    
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('user', null, array(
                    'label'                 => 'admin.characters.username',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('id', null, array(
                    'label'                 => 'admin.characters.id',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))            
            ->addIdentifier('name', null, array(
                    'label'                 => 'admin.characters.name',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('experience', null, array(
                    'label'                 => 'admin.characters.experience',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('level', null, array(
                    'label'                 => 'admin.characters.level',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('health', null, array(
                    'label'                 => 'admin.characters.health',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('attackSpeed', null, array(
                    'label'                 => 'admin.characters.attack_speed',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('power', null, array(
                    'label'                 => 'admin.characters.power',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('avatar', null, array(
                    'label'                 => 'admin.characters.avatar',
                    'template'              => 'NexusAdminBundle:CharacterAdmin:list.html.twig',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))       
        ;
    }
}
?>