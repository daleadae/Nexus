<?php
namespace Nexus\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ExperienceAdmin extends Admin
{
    protected $translationDomain = 'SonataCustomAdmin'; // default is 'messages'

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('level', null, array(
                    'label'                 => 'admin.experience.level',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('experience', null, array(
                    'label'                 => 'admin.experience.experience',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))                                               
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('level', null, array(
                    'label'                 => 'admin.experience.level',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('experience', null, array(
                    'label'                 => 'admin.experience.experience',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('level', null, array(
                    'label'                 => 'admin.experience.level',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('experience', null, array(
                    'label'                 => 'admin.experience.experience',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))   
        ;
    }
}
?>