<?php
namespace Nexus\AdminBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class WeeklyUpdateAdmin extends Admin
{
    protected $translationDomain = 'SonataCustomAdmin'; // default is 'messages'

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('delete');
        $collection->remove('edit');
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('file', 'file', array(
                    'label'                 => 'admin.weekly_update.file_upload',
                    'translation_domain'    =>  'SonataCustomAdmin',
                    'mapped'                => false,
                ))                                                
        ;
    }

    public function prePersist($weeklyUpdate) {
        $this->manageFileUpload($image);
    }

    public function preUpdate($weeklyUpdate) {
        $this->manageFileUpload($file);
    }

    private function manageFileUpload($weeklyUpdate) {
        if ($weeklyUpdate->getFile()) {
            $weeklyUpdate->refreshUpdated();
        }
    }    

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('character', null, array(
                    'label'                 => 'admin.weekly_update.character',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('armor', null, array(
                    'label'                 => 'admin.weekly_update.armor',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('resist', null, array(
                    'label'                 => 'admin.weekly_update.resist',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('mitigation', null, array(
                    'label'                 => 'admin.weekly_update.mitigation',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('attackSpeed', null, array(
                    'label'                 => 'admin.weekly_update.attack_speed',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('healthLost', null, array(
                    'label'                 => 'admin.weekly_update.health_lost',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('date', null, array(
                    'label'                 => 'admin.weekly_update.date',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))                                                                                                                
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('character', null, array(
                    'label'                 => 'admin.weekly_update.character',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('armor', null, array(
                    'label'                 => 'admin.weekly_update.armor',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('resist', null, array(
                    'label'                 => 'admin.weekly_update.resist',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('mitigation', null, array(
                    'label'                 => 'admin.weekly_update.mitigation',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('attackSpeed', null, array(
                    'label'                 => 'admin.weekly_update.attack_speed',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('healthLost', null, array(
                    'label'                 => 'admin.weekly_update.health_lost',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))
            ->add('date', null, array(
                    'label'                 => 'admin.weekly_update.date',
                    'translation_domain'    =>  'SonataCustomAdmin',
                ))            
        ;
    }
}
?>