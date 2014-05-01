<?php
namespace Nexus\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class FightAdmin extends Admin
{
    protected $translationDomain = 'SonataCustomAdmin'; // default is 'messages'

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('edit');
        $collection->remove('create');
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('result', null, array(
                    'label'                 => 'admin.fight.result',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('damageDone', null, array(
                    'label'                 => 'admin.fight.damage_done',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('damageTaken', null, array(
                    'label'                 => 'admin.fight.damage_taken',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))                                              
        ;
    }


    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('result', null, array(
                    'label'                 => 'admin.fight.result',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('damageDone', null, array(
                    'label'                 => 'admin.fight.damage_done',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('damageTaken', null, array(
                    'label'                 => 'admin.fight.damage_taken',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('result', null, array(
                    'label'                 => 'admin.fight.result',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('damageDone', null, array(
                    'label'                 => 'admin.fight.damage_done',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('damageTaken', null, array(
                    'label'                 => 'admin.fight.damage_taken',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('date', null, array(
                    'label'                 => 'admin.fight.date',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))  
        ;
    }
}
?>